<?php

class M_role extends CI_Model
{
	private $table_name;
	private $return;
	var $column_order = array('name', 'description');
	var $column_search = array('cart_id', 'cart_number', 'cart_date', 'cart_payment_method', 'cart_confirmed_bank_name', 'cart_confirmed', 'cart_status', 'cart_customer_name');
	var $order = array('cart_id' => 'desc'); // default order

	function __construct() {
		parent::__construct();
		$this->table_name = 'user_role';
		$this->return = FALSE;
	}

	private function _get_datatables_query() {
		$this->db->select('*');
		$this->db->from($this->table_name);

		$i = 0;

		foreach ($this->column_search as $item) { // loop column
			if ($_POST['search']['value']) { // if datatable send POST for search
				if ($i === 0) { // first loop
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		if (isset($_POST['order'])) { // here order processing
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables($user_id = NUll, $status = NULL) {
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		if (!empty($user_id)) {
			$this->db->where('cart_user_id', $user_id);
		}
		if (!empty($status)) {
			$this->db->where('cart_confirmed', strtoupper(strtolower($status)));
		}
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($user_id = Null) {
		$this->_get_datatables_query();
		if (!empty($user_id)) {
			$this->db->where('cart_user_id', $user_id);
		}
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($user_id = Null) {
		if (!empty($user_id)) {
			$this->db->where('cart_user_id', $user_id);
		}
		$this->db->from($this->table_name);
		return $this->db->count_all_results();
	}

	function getByOrderCode($number_id) {
//	$this->db->where('cart_number', $number_id);
//	$query = $this->db->get($this->table_name, 1);
//	if ($query->num_rows() == 1) {
//	  return $query->row_array();
//	}
		$sql = "SELECT mininos_cart.*,
			mininos_propinsi.id as id_rajaongkir,
			mininos_propinsi.`name` AS propinsi,
			mininos_kota.`name` AS kota,
			mininos_kota.id as id_city_rajaongkir,
			mininos_kecamatan.`name` AS kecamatan,
			mininos_kecamatan.id as id_district_rajaongkir
			FROM mininos_cart ";
		$join = " INNER JOIN";
		if ($number_id == 'MINORDER-2017/May-00269') {
			$join = " LEFT OUTER JOIN ";
		}
		$sql .= "INNER JOIN mininos_propinsi ON mininos_propinsi.id = mininos_cart.cart_shipping_province
" . $join . " mininos_kota ON mininos_kota.id = mininos_cart.cart_shipping_city
" . $join . " mininos_kecamatan ON mininos_kecamatan.id = mininos_cart.cart_shipping_district
WHERE mininos_cart.cart_number = '" . $number_id . "'";
		$q = $this->db->query($sql)->result_array();
		if ($number_id == 'MINORDER-2017/May-00403') {
//	  echo $sql;
		}
		return $q[0];
	}

	function getByOrderId($number_order) {
		$this->db->select('mininos_posts.post_title as product_name, 
                           mininos_posts.post_featured_images as product_image,
                           mininos_cart_detail.cart_qty as qty,
                           mininos_cart_detail.cart_product_size,
                           mininos_cart_detail.cart_product_color,
                           mininos_cart_detail.cart_price as price,
                           mininos_cart_detail.cart_subtotal,
                           mininos_cart.cart_subtotal as total');
		$this->db->join('mininos_cart', 'mininos_cart.cart_number = mininos_cart_detail.cart_number', 'inner');
		$this->db->join('mininos_posts', 'mininos_posts.ID = mininos_cart_detail.cart_product_id', 'inner');
		$this->db->where('mininos_cart_detail.cart_number', $number_order);
		$this->db->order_by('mininos_cart_detail.cart_number', 'DESC');
		$this->db->group_by('mininos_cart_detail.cart_detail_id');
		$query = $this->db->get('mininos_cart_detail')->result_array();
		if (sizeof($query) > 0) {
			return $query;
		}
	}

}

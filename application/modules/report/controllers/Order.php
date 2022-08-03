<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Order extends MX_Controller
{

	private $view;
	private $userInfo;
	private $pageUrl;
	private $pageTitle;
	private $cardTitle;
	private $assetDir;
	private $searchFrom;
	private $searchTo;

	public function __construct()
	{
		parent::__construct();
		$this->cardTitle = 'Report Filter';
		$this->data['cardTitle'] = $this->cardTitle;

		$this->pageTitle = 'Report :: Order';
		$this->data['page_title'] = $this->pageTitle;

		$this->userInfo = $this->userInfo();
		$this->userInfo = $this->userInfo["user"];

		$this->data['pageurl'] = 'report/order';

		$this->pageUrl = $this->data['pageurl'];
		$this->assetDir = $this->jsModules . $this->data['pageurl'] . DIRECTORY_SEPARATOR;

		$this->load->model('Mvreportheader');

		//do_debug($this->userInfo);
	}

	public function index()
	{
		$css = array();
		$js = array('js/modules/report/order/index.js');

		$this->view = $this->viewPage . 'index';
		render_view($this->view, $this->data, $css, $js);
	}

	public function searchField($search, $operator = "AND", $all = 0)
	{
		$where = array();

		if ($all > 0) {
			$where[] = "branch_id = '" . $this->userInfo->counterid . "' ";
		}
		if (!empty($search)) {
			foreach ($search as $k => $v) {
				if (isset($v)) {
					$equalsException = array('work_status', 'payment_status');
					if (gettype($v) == "integer" || in_array($k, $equalsException)) {
						$where[] = " " . $k . " = '" . $v . "' ";
					} else {
						$dateRange = explode("#", $k);
						if (sizeof($dateRange) > 0 && $k=='dateRange#order_date') {
							$dateBlank = $v == "'' AND '' ";
							if (!$dateBlank) {
								$where[] = " DATE(" . $dateRange[1] . ") BETWEEN " . $v . " ";
							}
						} else {
							$where[] = " " . $k . " LIKE '%" . $v . "%' ";
						}
					}
				}
			}
		}
		return implode($operator, $where);
	}
	private function getRekap($where = null){
		$sql = "SELECT * FROM laporan_akhir";
		$where = $this->searchField($where, "AND", $this->userInfo->counterid);
		$list = $this->db->query($sql .' WHERE '. $where)->result();
		return $list;
	}
	public function get_data()
	{
		$invNumber = $this->input->post('searchInvNumber');
		$customer = $this->input->post('searchCustomer');
		$workStatus = $this->input->post('searchWStatus');
		$paymentStatus = $this->input->post('searchPStatus');
		$searchFrom = $this->input->post('searchFrom');
		$searchTo = $this->input->post('searchTo');
		$cSearch = array();
//		do_debug($workStatus);
		if (isset($invNumber) && $invNumber != "") {
			$cSearch = array_merge($cSearch, array("order_no" => $invNumber));
		}
		if (isset($customer) && $customer != "") {
			$cSearch = array_merge($cSearch, array("cust_name" => $customer));
		}
		if (isset($workStatus) && $workStatus != "*") {
			$cSearch = array_merge($cSearch, array("work_status" => $workStatus));
		}
		if (isset($paymentStatus) && $paymentStatus != "*") {
			$cSearch = array_merge($cSearch, array("payment_status" => $paymentStatus));
		}
		if (isset($searchFrom) && $searchFrom != "*") {
			$cSearch = array_merge($cSearch, array("dateRange#order_date" => "'" . $searchFrom . "' AND '" . $searchTo . "' "));
		}

		$rekap = $this->getRekap($cSearch);

		//do_debug($cSearch);
		$where = $this->searchField($cSearch, "AND", $this->userInfo->counterid);
		$list = $this->Mvreportheader->get_datatables($where);

		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = '<a target="_blank" class="print_order" ' . $this->buildDataAttr($field) . ' href="' . base_url()  . 'transaction/order/print_order/' . $field->id . '" title="Print" >' . $field->order_no . '</a>';
			$row[] = formatDate(DT_FORMAT_FOR_STR, $field->order_date);
			$row[] = $field->cust_detail;
			$row[] = $field->total_item;
			$row[] = $field->down_payment;
			$row[] = $field->total_after_discount;
			$row[] = $field->payment_status;
			$row[] = $field->work_status;
			$row[] = $field->employee;


			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Mvreportheader->count_all($where),
			"recordsFiltered" => $this->Mvreportheader->count_filtered($where),
			"data" => $data,
			"rekapitulasi"=>getRekapitulasi($rekap, $this->searchFrom)
		);
		echo json_encode($output);
	}

	public function buildDataAttr($arr)
	{
		$data_attribute = "";
		foreach ($arr as $key => $value) {
			$data_attribute .= ' data-' . $key . '="' . $value . '" ';
		}
		return $data_attribute;
	}


}

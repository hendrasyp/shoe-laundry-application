<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');


class Modal extends MX_Controller
{

	private $view;
	private $userInfo;

	public function __construct()
	{
		parent::__construct();
		$this->userInfo = $this->userInfo();
		$this->userInfo = $this->userInfo["user"];

	}

	public function index()
	{

	}

	function customer_search_modal_get_data()
	{
		$this->load->model('Mvuserlist');
		$list = null;

		$where = "roleid != 1";

		$list = $this->Mvuserlist->get_datatables($where);

		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$paramButton = array(
				"class" => "btn-primary select_search_customer",
				"href" => "javascript:void(0)",
				"title" => "Select Customer",
				"icon" => "fa-check",
				"attr" => $this->buildDataAttr($field)

			);
			$no++;
			$row = array();
			$row[] = $no;
			//$row[] = '<a class="btn btn-sm btn-danger delete_user" ' . $this->buildDataAttr($field) . ' href="javascript:void(0)" title="Hapus" ><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			$row[] = renderActionButton($paramButton);
			$row[] = $field->name;
			$row[] = $field->phone;
			$row[] = $field->email;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Mvuserlist->count_all($where),
			"recordsFiltered" => $this->Mvuserlist->count_filtered($where),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function customer_search_modal()
	{
		$search = $this->input->post("search_username");
		$this->data['search'] = $search;

		$this->view = $this->viewPage . 'customer-search-modal';
		render_modal($this->view, $this->data);
	}

    public function pickup_all_order()
    {
        $this->data['orderId'] = $this->input->post("orderId");
        $this->data['orderNo'] = $this->input->post("orderNo");

        $this->view = $this->viewPage . 'pick_all_order';
        render_modal($this->view, $this->data);
    }

	function service_search_modal_get_data()
	{
		$this->load->model('Mservice');
		$list = null;

		$where = "isextra = '" . $this->input->post("is_extra") . "'";

		$list = $this->Mservice->get_datatables($where);

		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$paramButton = array(
				"class" => "btn-primary select_search_service",
				"href" => "javascript:void(0)",
				"title" => "",
				"icon" => "fa-check",
				"attr" => $this->buildDataAttr($field)

			);
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = renderActionButton($paramButton);
			$row[] = $field->typename;
			$row[] = formatCurrency($field->typeprice);
			$row[] = $field->typedescription;
			$row[] = $field->estimate_day;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Mservice->count_all($where),
			"recordsFiltered" => $this->Mservice->count_filtered($where),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function service_search_modal()
	{
		$this->view = $this->viewPage . 'service-search-modal';
		$this->data["detail_id"] = $this->input->get('did');
		$this->data["header_id"] = $this->input->get('hid');
		$this->data["is_extra"] = $this->input->get('e');

		$sId = $this->input->get('service_id');
		if (isset($sId) && $sId > 0) {
			$this->data["service_id"] = $sId;
			$dbdetail = new Commondb();
			$order_detail = $dbdetail
				->condition(
					array(
						'header_id' => $this->data["header_id"],
						'id' => $this->data["detail_id"],
						'service_id' => $this->data["service_id"]
					)
				)
				->table_name(V_ORDER_DETAIL)
				->limit_offset(-1, 0)
				->do_read();
			$this->data["itemDetail"] = $order_detail[0];
		} else {
			$this->data["service_id"] = 0;
		}


		render_modal($this->view, $this->data);
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

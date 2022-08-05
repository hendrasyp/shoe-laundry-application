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

	public function __construct()
	{
		parent::__construct();
		$this->cardTitle = 'Order Filter';
		$this->data['cardTitle'] = $this->cardTitle;

		$this->pageTitle = 'Order Management';
		$this->data['page_title'] = $this->pageTitle;

		$this->userInfo = $this->userInfo();
		$this->userInfo = $this->userInfo["user"];

		$this->data['pageurl'] = 'transaction/order';

		$this->pageUrl = $this->data['pageurl'];
		$this->assetDir = $this->jsModules . $this->data['pageurl'] . DIRECTORY_SEPARATOR;

		$this->load->model('Mvorderheader');
		//do_debug($this->userInfo);
	}

	public function index()
	{
		$css = array();
		$js = array('js/modules/transaction/order/index.js');

		$this->view = $this->viewPage . 'index';
		render_view($this->view, $this->data, $css, $js);
	}

	public function searchField($search, $operator = "AND", $all = 0)
	{
		$where = array();

		if ($all > 0) {
			$where[] = "counter_id = '" . $this->userInfo->counterid . "' ";
		}
		if (!empty($search)) {
			foreach ($search as $k => $v) {
				if (isset($v)) {
					if (gettype($v) == "integer") {
						$where[] = " " . $k . " = '" . $v . "' ";
					} else {
						$where[] = " " . $k . " LIKE '%" . $v . "%' ";
					}
				}
			}
		}
		return implode($operator, $where);
	}

	/* 	URUTAN ORDER
	*	1. Simpan header sebagai DRAFT
	*	2. Save Order Detail
	*/
	public function add_customer()
	{
		$toInsert = array();
		$lastId = 0;
		$insert = false;
		$input = $this->input->post();
		$toInsert = array(
			'order_no' => $this->generateNoFaktur("S-" . $this->userInfo->initial),
			'order_date' => dateToday(),
			'cust_id' => $input['cust_id'],
			'order_status' => $input['order_status'],
			'user_id' => $input['user_id'],
			'pickup_id' => 1,
			'counter_id' => $input['counter_id']
		);
		$insert = $this
			->common_model
			->table_name(TABLE_ORDER_HEADER)
			->data_request($toInsert)
			->do_insert('lastid');
		$lastId = $insert;

		$response = array('message' => 'success', 'result' => $input, 'order_id' => $lastId);
		if ($insert == false) {
			$response = array('message' => 'error', 'message_details' => 'Terdapat kesalahan saat update.');
		}
		echo json_encode($response);
	}

	public function add()
	{
		//do_debug($this->userInfo->initial,true);
		$id = null;
		$this->data['custList'] = loadCustList($this->userInfo->counterid);
		$this->data['loginInfo'] = $this->userInfo;
		$this->data['noFaktur'] = $this->generateNoFaktur("S-" . $this->userInfo->initial);
		$this->data['orderDate'] = dateToday("d/m/Y");
		$this->data['orderUrl'] = base_url('transaction/order');

		$this->view = $this->viewPage . 'add';

		$css = array();
		$js = array('js/modules/transaction/order/edit.js');
		render_view($this->view, $this->data, $css, $js);
	}

	public function edit($id)
	{
		$this->data['custList'] = loadCustList($this->userInfo->counterid);
		$this->data['loginInfo'] = $this->userInfo;
		$this->data['noFaktur'] = $this->generateNoFaktur();
		$this->data['orderDate'] = dateToday("d/m/Y");
		$this->data['orderData'] = $this->get_order($id);
		$this->data['orderUrl'] = base_url('transaction/order');

		$this->view = $this->viewPage . 'add';

		$css = array();
		$js = array('js/modules/transaction/order/edit.js');
		render_view($this->view, $this->data, $css, $js);
	}

	public function save_order_customer()
	{
		$toInsert = array();
		$lastId = 0;
		$insert = false;
		$input = $this->input->post();
		if (!empty($input['order_id'])) {
			$toInsert = array(
				'cust_id' => $input['cust_id']
			);
			$insert = $this
				->common_model
				->table_name(TABLE_ORDER_HEADER)
				->data_request($toInsert)->condition(array('id' => $input['order_id']))->do_update();
			$lastId = $input['order_id'];
		} else {
			$toInsert = array(
				'order_no' => $this->generateNoFaktur(),
				'order_date' => dateToday(),
				'cust_id' => $input['cust_id'],
				'order_status' => $input['order_status'],
				'user_id' => $input['user_id'],
				'pickup_id' => 1,
				'counter_id' => $input['counter_id']
			);
			$insert = $this
				->common_model
				->table_name(TABLE_ORDER_HEADER)
				->data_request($toInsert)
				->do_insert('lastid');
			$lastId = $insert;
		}
		$result = $this->get_order($lastId);
		$response = array('message' => 'success', 'result' => $input,'header_data'=>$result, 'last_id' => $lastId);
		if ($insert == false) {
			$response = array('message' => 'error', 'message_details' => 'Terdapat kesalahan saat update.');
		}
		echo json_encode($response);
	}

	public function save_order_detail()
	{
		$toInsert = array();
		$lastId = 0;
		$insert = false;
		$input = $this->input->post();
		if ($input['is_extra'] == "No") {
			if (isset($input['current_sid']) && (int)$input['current_sid'] > 0) {
				$toInsert = array(
					'item_name' => $input['item_name'],
					'header_id' => $input['header_id'],
					'service_id' => $input['service_id'],
					'size' => $input['size'],
					'color_insole' => $input['insole'],
					'color_tali' => $input['tali'],
				);
				$insert = $this
					->common_model
					->condition(array(
						'id' => $input['detail_id'],
						'service_id' => $input['current_sid'],
						'header_id' => $input['header_id'],
					))
					->table_name(TABLE_ORDER_DETAIL)
					->data_request($toInsert)
					->do_update();
			} else {
				$toInsert = array(
					'header_id' => $input['header_id'],
					'service_id' => $input['service_id'],
					'work_status' => $input['work_status'],
					'item_name' => $input['item_name'],
					// 'item_description' => $input['item_description'],
					'size' => $input['size'],
					'color_insole' => $input['insole'],
					'color_tali' => $input['tali'],
				);
				$insert = $this
					->common_model
					->table_name(TABLE_ORDER_DETAIL)
					->data_request($toInsert)
					->do_insert('lastid');
			}

		} else {
			$toInsert = array(
				'detail_id' => $input['detail_id'],
				'service_id' => $input['service_id']
			);
			$insert = $this
				->common_model
				->table_name(TABLE_ORDER_DETAIL_EXTRA)
				->data_request($toInsert)
				->do_insert('lastid');
		}


		$lastId = $insert;

		$result = $this->get_order($input['header_id']);

		$response = array('message' => 'success', 'result' => $result, 'last_id' => $lastId);
		if ($insert == false) {
			$response = array('message' => 'error', 'message_details' => 'Terdapat kesalahan saat update.');
		}
		echo json_encode($response);
	}

	public function update_order_detail()
	{
		$toInsert = array();
		$lastId = 0;
		$insert = false;
		$input = $this->input->post();
		$toInsert = array(
			'item_name' => $input['item_name'],
			'header_id' => $input['header_id'],
			'service_id' => $input['service_id'],
			'size' => $input['size'],
			'color_insole' => $input['insole'],
			'color_tali' => $input['tali'],
		);
		$insert = $this
			->common_model
			->condition(array(
				'id' => $input['detail_id'],
				'service_id' => $input['current_sid'],
				'header_id' => $input['header_id'],
			))
			->table_name(TABLE_ORDER_DETAIL)
			->data_request($toInsert)
			->do_update();


		$lastId = $input['detail_id'];

		$result = $this->get_order($input['header_id']);

		$response = array('message' => 'success', 'result' => $result, 'last_id' => $lastId);
		if ($insert == false) {
			$response = array('message' => 'error', 'message_details' => 'Terdapat kesalahan saat update.');
		}
		echo json_encode($response);
	}

	public function order_detail_done()
	{
		$toInsert = array();
		$lastId = 0;
		$insert = false;
		$input = $this->input->post();
		$toInsert = array(
			'work_status' => 1,
			'finish_date' => dateToday()
		);
		$where = array(
			'header_id' => $input['header_id'],
			'service_id' => $input['service_id'],
			'id' => $input['id']
		);
		$insert = $this
			->common_model
			->table_name(TABLE_ORDER_DETAIL)
			->data_request($toInsert)
			->condition($where)->do_update();

		$result = $this->get_order($input['header_id']);

		$unpicked = 0;
		$finished = 0;
		$itemCount = sizeof($result["order_detail"]);
		foreach ($result["order_detail"] as $key => $item) {
			if ($item["pickup_date"] == "") {
				$unpicked++;
			}
			if ($item["finish_date"] != "") {
				$finished++;
			}
		}

		if ($finished > 0 && $finished == $itemCount) {
			$toupdate = array();
			$toupdate["finish_date"] = dateToday();
			$toupdate["order_status"] = 2;
			$dbheader = new Commondb();
			$update = $dbheader
				->common_model
				->table_name(TABLE_ORDER_HEADER)
				->data_request($toupdate)->condition(array('id' => $input['header_id']))->do_update();

		}

		$response = array('message' => 'success', 'result' => $result);
		if ($insert == false) {
			$response = array('message' => 'error', 'message_details' => 'Terdapat kesalahan saat update.');
		}
		echo json_encode($response);
	}

	public function order_detail_unfinish()
	{
		$toInsert = array();
		$lastId = 0;
		$insert = false;
		$input = $this->input->post();
		$toInsert = array(
			'work_status' => 0,
			'finish_date' => null
		);
		$where = array(
			'header_id' => $input['header_id'],
			'service_id' => $input['service_id'],
			'id' => $input['id']
		);
		$insert = $this
			->common_model
			->table_name(TABLE_ORDER_DETAIL)
			->data_request($toInsert)
			->condition($where)->do_update();

		$result = $this->get_order($input['header_id']);

		$unpicked = 0;
		$unfinish = 0;
		foreach ($result["order_detail"] as $key => $item) {
			if ($item["pickup_date"] == "") {
				$unpicked++;
			}
			if ($item["finish_date"] == "") {
				$unfinish++;
			}
		}
		if ($unfinish > 0) {
			$toupdate = array();
			$toupdate["finish_date"] = null;
			$toupdate["order_status"] = 0;
			$dbheader = new Commondb();
			$update = $dbheader
				->common_model
				->table_name(TABLE_ORDER_HEADER)
				->data_request($toupdate)->condition(array('id' => $input['header_id']))->do_update();

		}


		$response = array('message' => 'success', 'result' => $result);
		if ($insert == false) {
			$response = array('message' => 'error', 'message_details' => 'Terdapat kesalahan saat update.');
		}
		echo json_encode($response);
	}

	public function order_detail_taked()
	{
		$toInsert = array();
		$lastId = 0;
		$insert = false;
		$input = $this->input->post();
		$toInsert = array(
			'work_status' => 2,
			'pickup_date' => dateToday()
		);
		$where = array(
			'header_id' => $input['header_id'],
			'service_id' => $input['service_id'],
			'id' => $input['id']
		);
		$insert = $this
			->common_model
			->table_name(TABLE_ORDER_DETAIL)
			->data_request($toInsert)
			->condition($where)->do_update();

		// CEK BERAPA ORDER
		$result = $this->get_order($input['header_id']);
		$orderData = $this->get_order($input['header_id']);
		$unpicked = 0;
		foreach ($orderData["order_detail"] as $key => $item) {
			if ($item["pickup_date"] == "") {
				$unpicked++;
			}
		}
		if ($unpicked == 0) {
			$toupdate = array();
			$toupdate["finish_date"] = dateToday();
			$toupdate["order_status"] = 2;
			$dbheader = new Commondb();
			$update = $dbheader
				->common_model
				->table_name(TABLE_ORDER_HEADER)
				->data_request($toupdate)->condition(array('id' => $input['header_id']))->do_update();

			$order_detail = $this->db->query("UPDATE " . TABLE_ORDER_DETAIL . " SET finish_date='" . dateToday() . "' WHERE header_id='" . $input['header_id'] . "' AND finish_date IS NULL");

		}

		$response = array('message' => 'success', 'result' => $result);
		if ($insert == false) {
			$response = array('message' => 'error', 'message_details' => 'Terdapat kesalahan saat update.');
		}
		echo json_encode($response);
	}

	public function order_detail_reverttake()
	{
		$toInsert = array();
		$lastId = 0;
		$insert = false;
		$input = $this->input->post();
		$toInsert = array(
			'work_status' => 1,
			'pickup_date' => null
		);
		$where = array(
			'header_id' => $input['header_id'],
			'service_id' => $input['service_id'],
			'id' => $input['id']
		);
		$insert = $this
			->common_model
			->table_name(TABLE_ORDER_DETAIL)
			->data_request($toInsert)
			->condition($where)->do_update();

		$result = $this->get_order($input['header_id']);

		$response = array('message' => 'success', 'result' => $result);
		if ($insert == false) {
			$response = array('message' => 'error', 'message_details' => 'Terdapat kesalahan saat update.');
		}
		echo json_encode($response);
	}

	public function get_data()
	{
		$invNumber = $this->input->post('searchInvNumber');
		$customer = $this->input->post('searchCustomer');
		$workStatus = $this->input->post('searchWStatus');
		$paymentStatus = $this->input->post('searchPStatus');
		$cSearch = array();
//		do_debug($workStatus);
		if (isset($invNumber) && $invNumber != "") {
			$cSearch = array_merge($cSearch, array("order_no" => $invNumber));
		}
		if (isset($customer) && $customer != "") {
			$cSearch = array_merge($cSearch, array("cust_name" => $customer));
		}
		if (isset($workStatus) && $workStatus != "*") {
			$cSearch = array_merge($cSearch, array("order_status_id" => (int)$workStatus));
		}
		if (isset($paymentStatus) && $paymentStatus != "*") {
			$cSearch = array_merge($cSearch, array("payment_status_id" => (int)$paymentStatus));
		}

		$where = $this->searchField($cSearch, "AND", $this->userInfo->counterid);
		$list = $this->Mvorderheader->get_datatables($where);

		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = $no;
            $btn = '<a class="btn btn-sm btn-primary" href="' . base_url() . $this->pageUrl . '/edit/' . $field->id . '" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
          <a class="btn btn-sm btn-info print_order" ' . $this->buildDataAttr($field) . ' href="' . base_url() . $this->pageUrl . '/print_order/' . $field->id . '" title="Print" ><i class="glyphicon glyphicon-print"></i> Print</a>
          <a class="btn btn-sm btn-danger delete_order" ' . $this->buildDataAttr($field) . ' href="javascript:void(0)" title="Hapus" ><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            if ($field->pickby != '' && $field->pickby!= null){
                $btn .= '<br/>'. 'Already picked by '.$field->pickby. '<br/>on ' . $field->pickup_date;
            }
			$row[] = $btn;

			$row[] = $field->order_no;
			$row[] = formatDate(DT_FORMAT_FOR_STR, $field->order_date);
			$row[] = $field->cust_name;
			$payment_status_text = "UNPAID";
			if ($field->total_payment > 0 && ($field->total_payment >= $field->total_after_discount)) {
				$payment_status_text = "PAID";
			} else if ($field->total_payment > 0 && ($field->total_payment < $field->total_after_discount)) {
				$payment_status_text = "HALF-PAID";
			} else if ($field->total_payment == 0 && ($field->down_payment > 0)) {
				$payment_status_text = "HALF-PAID";
			}
			$row[] = $payment_status_text;
			$row[] = $field->pickup_name;

			$tmpStatusName = $field->order_status_name;
			if ($field->order_status_id == 0) {
				$tmpStatusName = "In Progress";
			} else if ($field->order_status_id == 2) {
				if ($field->pickup_date == "") {
					$tmpStatusName = "Done. Ready to Pickup";
				} else if ($field->pickup_date != "") {
					$tmpStatusName = "Closed at " . formatDate("d/m/y", $field->pickup_date);
				}
			} else {
				$tmpStatusName = "In Progress";
			}


			$row[] = $tmpStatusName;
			$row[] = "Rp. " . formatCurrency($field->total_after_discount);
			$row[] = $field->employee_name;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Mvorderheader->count_all($where),
			"recordsFiltered" => $this->Mvorderheader->count_filtered($where),
			"data" => $data,
		);
		//$this->output->enable_profiler(TRUE);
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

	public function delete_order($id)
	{
		$input = $this->input->post();
		$args = array(
			'id' => $this->input->post('id')
		);

		$delete = $this
			->common_model
			->condition($args)
			->table_name(TABLE_ORDER_HEADER)
			->do_delete();

		$return = array(
			'message' => 'success',
			'message_detail' => 'success'
		);
		if ($delete == false) {
			$return = array(
				'message' => 'error',
				'message_detail' => 'Tidak bisa menghapus user',
			);
		}
		echo json_encode($return);
	}

	public function clear_unused_order()
	{
		$this->db->query("DELETE FROM order_header WHERE id NOT IN(SELECT header_id FROM order_detail)");
		$return = array(
			'message' => 'success',
			'message_detail' => 'success'
		);
		echo json_encode($return);
	}

	public function clean_order($id)
	{

		$delete = $this
			->common_model
			->table_name(TABLE_ORDER_HEADER)
			->do_empty();

		$return = array(
			'message' => 'success',
			'message_detail' => 'success'
		);
		if ($delete == false) {
			$return = array(
				'message' => 'error',
				'message_detail' => 'Tidak bisa menghapus user',
			);
		}
		echo json_encode($return);
	}

	public function delete_order_detail()
	{
		$input = $this->input->post();
		$args = array(
			'id' => $this->input->post('id'),
			'header_id' => $this->input->post('header_id'),
			'service_id' => $this->input->post('service_id'),
		);

		$delete = $this
			->common_model
			->condition($args)
			->table_name(TABLE_ORDER_DETAIL)
			->do_delete();

		$result = $this->get_order($input['header_id']);

		$return = array(
			'message' => 'success',
			'message_detail' => 'success',
			'result' => $result,
		);
		if ($delete == false) {
			$return = array(
				'message' => 'error',
				'message_detail' => 'Tidak bisa menghapus user',
			);
		}
		echo json_encode($return);
	}

	public function delete_order_extra()
	{
		$input = $this->input->post();
		$args = array(
			'id' => $this->input->post('detail_extra_id'),
			'detail_id' => $this->input->post('detail_id'),
			'service_id' => $this->input->post('service_id'),
		);

		$delete = $this
			->common_model
			->condition($args)
			->table_name(TABLE_ORDER_DETAIL_EXTRA)
			->do_delete();

		$result = $this->get_order($input['header_id']);

		$return = array(
			'message' => 'success',
			'message_detail' => 'success',
			'result' => $result,
		);
		if ($delete == false) {
			$return = array(
				'message' => 'error',
				'message_detail' => 'Tidak bisa menghapus user',
			);
		}
		echo json_encode($return);
	}

	public function save_order()
	{
		$toInsert = array();
		$hist = array();

		$lastId = 0;
		$insert = false;
		$input = $this->input->post();

		$pStatus = 0;
		$dp = 0;
		$totalPayment = 0;

		if ($input["total_after_discount"] == $input["total_payment"]) {
			$pStatus = 2;
			$dp = 0;
			$totalPayment = $input["total_payment"];
		} elseif ($input["total_after_discount"] > $input["total_payment"]) {
			$pStatus = 1;
			$dp = $input["total_payment"];
			$toInsert["order_status"] = 0;
		}
		$toInsert["payment_status"] = $pStatus;
		$toInsert["total_after_discount"] = $input['total_after_discount'];
		$toInsert["total_before_discount"] = $input['total_before_discount'];
		$toInsert["finish_date_estimation"] = $input['finish_date'];
		$toInsert["total_payment"] = $totalPayment;
		$toInsert["payment_date"] = dateToday();
		$toInsert["down_payment"] = $dp;

		$insert = $this
			->common_model
			->table_name(TABLE_ORDER_HEADER)
			->data_request($toInsert)->condition(array('id' => $input['header_id']))->do_update();
		$lastId = $input['header_id'];

		$response = array('message' => 'success', 'result' => $input, 'last_id' => $lastId);
		if ($insert == false) {
			$response = array('message' => 'error', 'message_details' => 'Terdapat kesalahan saat update.');
		}
		echo json_encode($response);
	}

	public function finish_order()
	{
		$input = $this->input->post();
		$header = array();
		$header_id = $input['order_id'];
		$header["finish_date"] = dateToday();
		$header["order_status"] = 2;

		$update = $this
			->common_model
			->table_name(TABLE_ORDER_HEADER)
			->data_request($header)->condition(array('id' => $header_id))->do_update();

		$order_detail = $this->db->query("UPDATE " . TABLE_ORDER_DETAIL . " SET finish_date='" . dateToday() . "' WHERE header_id='" . $header_id . "' AND finish_date IS NULL");

		$response = array('message' => 'success', 'result' => $input, 'last_id' => $header_id);
		if ($update == false) {
			$response = array('message' => 'error', 'message_details' => 'Terdapat kesalahan saat update.');
		}
		echo json_encode($response);
	}

	public function pickup_order()
	{
		$input = $this->input->post();
		$header = array();
		$header_id = $input['order_id'];
		$header["pickup_date"] = dateTodayWithTime();
		$header["pickup_by"] = $input['pickupPerson'];

		$update = $this
			->common_model
			->table_name(TABLE_ORDER_HEADER)
			->data_request($header)->condition(array('id' => $header_id))->do_update();

		$order_detail = $this->db->query("UPDATE " . TABLE_ORDER_DETAIL . " SET pickup_date='" . dateToday() . "' WHERE header_id='" . $header_id . "' AND pickup_date IS NULL");

		$response = array('message' => 'success', 'result' => $input, 'last_id' => $header_id);
		if ($update == false) {
			$response = array('message' => 'error', 'message_details' => 'Terdapat kesalahan saat update.');
		}
		echo json_encode($response);
	}

	public function submit_order()
	{
		$toInsert = array();
		$lastId = 0;
		$insert = false;
		$input = $this->input->post();
		$toInsert = array(
			//'header_id' => $input['header_id'], // formField.getVal('order_id'),
			'payment_status' => $input['payment_status'],
			'total_after_discount' => $input['total_after_discount'],
			'total_before_discount' => $input['total_before_discount'],
			'total_payment' => $input['total_payment'],
			'payment' => $input['payment'],
			'change' => $input['change']
		);
		$insert = $this
			->common_model
			->table_name(TABLE_ORDER_HEADER)
			->data_request($toInsert)->condition(array('id' => $input['header_id']))->do_update();
		$lastId = $input['header_id'];

		$response = array('message' => 'success', 'result' => $input, 'last_id' => $lastId);
		if ($insert == false) {
			$response = array('message' => 'error', 'message_details' => 'Terdapat kesalahan saat update.');
		}
		echo json_encode($response);
	}

	private function get_order($id)
	{
		$dbheader = new Commondb();
		$order_header = $dbheader
			->condition(array('id' => $id))
			->table_name(V_ORDER_HEADER)
			//->limit_offset(-1, 0)
			->do_read();

		$dbdetail = new Commondb();
		$order_detail = $dbdetail
			->condition(array('header_id' => $id))
			->table_name(V_ORDER_DETAIL)
			->limit_offset(-1, 0)
			->do_read();
		$returnResult = array(
			"header" => (array)$order_header[0],
			"order_detail" => $order_detail,
		);

		for ($oDetail = 0; $oDetail < sizeof($order_detail); $oDetail++) {
			$order_detail[$oDetail] = array_merge((array)$order_detail[$oDetail], array("order_extra" => array()));
		}
		for ($idx = 0; $idx < sizeof($order_detail); $idx++) {

			$dbextra = new Commondb();
			$order_extra = $dbextra
				->condition(array('detail_id' => $order_detail[$idx]["id"]))
				->table_name(V_ORDER_DETAIL_EXTRA)
				->limit_offset(-1, 0)
				->do_read();
			$order_detail[$idx]["order_extra"] = $order_extra;
			$returnResult["order_detail"] = $order_detail;
		}
		return $returnResult;
	}

	public function print_order($id)
	{
		$order_info = $this->get_order($id);
		$this->data['order'] = $order_info;
		$this->data['oheader'] = $order_info["header"];
		$this->data['odetail'] = $order_info["order_detail"];
		$this->data['qr'] = generate_qrorder($order_info["header"]['order_no']);

		$mpdf = new \Mpdf\Mpdf([
			'format' => 'A4-P',
			'margin_left' => 0,
			'margin_right' => 0,
			'margin_top' => 0,
			'margin_bottom' => 0,
			'margin_header' => 0,
			'margin_footer' => 0,
		]);

		$mpdf->SetDisplayMode('fullpage', 'two');
		$mpdf->mirrorMargins = 1;

		$mpdf->AddPage('P', // L - landscape, P - portrait
			'', '', '', '',
			10, // margin_left
			10, // margin right
			15, // margin top
			10, // margin bottom
			10, // margin header
			10); // margin footer
		$html = $this->load->view('print_order_new', $this->data, true);
		$mpdf->WriteHTML($html);
		$mpdf->Output('FINVOICE_' . $this->data['oheader']["order_no"], 'I'); // opens in browser
		//$mpdf->Output('invoice.pdf','D'); // it will work as normal download
	}


	public function print_order_debug($id)
	{
		$order_info = $this->get_order($id);
		$this->data['order'] = $order_info;
		$this->data['oheader'] = $order_info["header"];
		$this->data['odetail'] = $order_info["order_detail"];
		$this->data['qr'] = generate_qrorder($order_info["header"]['order_no']);
		$this->load->view('print_order_new', $this->data);
	}

	public function debug_order($id)
	{
		//do_debug($this->get_order($id));
	}


}

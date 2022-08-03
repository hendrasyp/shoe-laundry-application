<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Dashboard extends MX_Controller
{

	private $page_title = "Dashboard";
	private $userInfo;

	public function __construct()
	{
		parent::__construct();
		$this->data['page_title'] = $this->page_title;
		$this->userInfo = $this->userInfo();
		$this->userInfo = $this->userInfo["user"];
	}

	public function index()
	{
		$js = array('js/modules/dashboard.js');
		$this->data['userInfo'] = $this->userInfo;
		$this->data['income_by_payment'] = dashboard_income_by_paystatus();
		$this->data['income_by_works'] = dashboard_income_by_workstatus();
		$this->data['order_masuk'] = dashboard_order_masuk();
		$this->data['order_masuk_by_type'] = $this->db->query('SELECT * FROM v_order_masuk_by_service_type')->result();


		$this->data['in_progress'] = array();
		$this->data['ready_to_pick'] = array();
		$this->data['closed'] = array();

		$this->data['pt_paid'] = array();
		$this->data['pt_half'] = array();
		$this->data['pt_unpaid'] = array();

		$this->data['order_in'] = array();
		$this->data['svc_type_jumlah'] = array();
		$this->data['svc_type'] = array();

		foreach ($this->data['income_by_payment'] as $k => $item){
			if ($item->payment_status == "PAID"){
				$this->data['pt_paid'][] = $item->jan;
				$this->data['pt_paid'][] = $item->feb;
				$this->data['pt_paid'][] = $item->mar;
				$this->data['pt_paid'][] = $item->apr;
				$this->data['pt_paid'][] = $item->may;
				$this->data['pt_paid'][] = $item->jun;
				$this->data['pt_paid'][] = $item->jul;
				$this->data['pt_paid'][] = $item->aug;
				$this->data['pt_paid'][] = $item->sep;
				$this->data['pt_paid'][] = $item->oct;
				$this->data['pt_paid'][] = $item->nov;
				$this->data['pt_paid'][] = $item->dec;
			}
			if ($item->payment_status == "UNPAID"){
				$this->data['pt_unpaid'][] = $item->jan;
				$this->data['pt_unpaid'][] = $item->feb;
				$this->data['pt_unpaid'][] = $item->mar;
				$this->data['pt_unpaid'][] = $item->apr;
				$this->data['pt_unpaid'][] = $item->may;
				$this->data['pt_unpaid'][] = $item->jun;
				$this->data['pt_unpaid'][] = $item->jul;
				$this->data['pt_unpaid'][] = $item->aug;
				$this->data['pt_unpaid'][] = $item->sep;
				$this->data['pt_unpaid'][] = $item->oct;
				$this->data['pt_unpaid'][] = $item->nov;
				$this->data['pt_unpaid'][] = $item->dec;
			}
			if ($item->payment_status == "HALF-PAID"){
				$this->data['pt_half'][] = $item->jan;
				$this->data['pt_half'][] = $item->feb;
				$this->data['pt_half'][] = $item->mar;
				$this->data['pt_half'][] = $item->apr;
				$this->data['pt_half'][] = $item->may;
				$this->data['pt_half'][] = $item->jun;
				$this->data['pt_half'][] = $item->jul;
				$this->data['pt_half'][] = $item->aug;
				$this->data['pt_half'][] = $item->sep;
				$this->data['pt_half'][] = $item->oct;
				$this->data['pt_half'][] = $item->nov;
				$this->data['pt_half'][] = $item->dec;
			}
		}

		foreach ($this->data['income_by_works'] as $k => $item){
			if ($item->work_status == "CLOSED"){
				$this->data['closed'][] = $item->jan;
				$this->data['closed'][] = $item->feb;
				$this->data['closed'][] = $item->mar;
				$this->data['closed'][] = $item->apr;
				$this->data['closed'][] = $item->may;
				$this->data['closed'][] = $item->jun;
				$this->data['closed'][] = $item->jul;
				$this->data['closed'][] = $item->aug;
				$this->data['closed'][] = $item->sep;
				$this->data['closed'][] = $item->oct;
				$this->data['closed'][] = $item->nov;
				$this->data['closed'][] = $item->dec;
			}
			if ($item->work_status == "READY TO PICKUP"){
				$this->data['ready_to_pick'][] = $item->jan;
				$this->data['ready_to_pick'][] = $item->feb;
				$this->data['ready_to_pick'][] = $item->mar;
				$this->data['ready_to_pick'][] = $item->apr;
				$this->data['ready_to_pick'][] = $item->may;
				$this->data['ready_to_pick'][] = $item->jun;
				$this->data['ready_to_pick'][] = $item->jul;
				$this->data['ready_to_pick'][] = $item->aug;
				$this->data['ready_to_pick'][] = $item->sep;
				$this->data['ready_to_pick'][] = $item->oct;
				$this->data['ready_to_pick'][] = $item->nov;
				$this->data['ready_to_pick'][] = $item->dec;
			}
			if ($item->work_status == "IN PROGRESS"){
				$this->data['in_progress'][] = $item->jan;
				$this->data['in_progress'][] = $item->feb;
				$this->data['in_progress'][] = $item->mar;
				$this->data['in_progress'][] = $item->apr;
				$this->data['in_progress'][] = $item->may;
				$this->data['in_progress'][] = $item->jun;
				$this->data['in_progress'][] = $item->jul;
				$this->data['in_progress'][] = $item->aug;
				$this->data['in_progress'][] = $item->sep;
				$this->data['in_progress'][] = $item->oct;
				$this->data['in_progress'][] = $item->nov;
				$this->data['in_progress'][] = $item->dec;
			}
		}

		foreach ($this->data['order_masuk_by_type'] as $k => $item){
			$this->data['svc_type_jumlah'][] = $item->jumlah;
			$this->data['svc_type'][] = "'".$item->service_group."'";
		}


		$this->data['pt_paid'] = implode(",",$this->data['pt_paid']);
		$this->data['pt_half'] = implode(",",$this->data['pt_half']);
		$this->data['pt_unpaid'] = implode(",",$this->data['pt_unpaid']);

		$this->data['in_progress'] = implode(",",$this->data['in_progress']);
		$this->data['ready_to_pick'] = implode(",",$this->data['ready_to_pick']);
		$this->data['closed'] = implode(",",$this->data['closed']);

		$this->data['jenis_layanan'] = implode(",",$this->data['svc_type']);
//		do_debug($this->data['jenis_layanan'],true);
		$this->data['jenis_layanan_jumlah'] = implode(",",$this->data['svc_type_jumlah']);


//		do_debug($this->data['pt_paid'],false);
//		do_debug($this->data['pt_half'],false);
//		do_debug($this->data['income_by_payment'],true);

		$this->data['income_by_works_json'] = json_encode($this->data['income_by_works']);
		$this->data['income_by_payment_json'] = json_encode($this->data['income_by_payment']);
		$this->data['order_masuk_json'] = json_encode($this->data['order_masuk']);

		render_view('dashboard/dashboard/index', $this->data,null,$js);
	}

	public function generateQRCode()
	{

	}

}

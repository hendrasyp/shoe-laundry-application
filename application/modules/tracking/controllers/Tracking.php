<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Tracking extends MX_Controller
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

		$this->data['pageurl'] = 'tracking/order';

		$this->pageUrl = $this->data['pageurl'];
		$this->assetDir = $this->jsModules . $this->data['pageurl'] . DIRECTORY_SEPARATOR;

		$this->load->model('Mvorderheader');
		//do_debug($this->userInfo);
	}

	public function index()
	{
		$nofaktur = trim($this->input->get("inv"));
		$css = array();
		$js = array('js/modules/tracking/order/index.js');
		$dbheader = new Commondb();
		$order_header = $dbheader
			->condition(array('order_no' => $nofaktur))
			->table_name(V_ORDER_HEADER)
			//->limit_offset(-1, 0)
			->do_read();


			$this->data["nofaktur"] = $nofaktur;
		if (sizeof($order_header) > 0) {
			$tmp = $this->get_order($order_header[0]->id);
			$this->data["order"] = array_merge($tmp,array("isEmpty" => false));
		}else{
			$this->data["order"] = array(
				"isEmpty" => true,
				"header" => array(),
				"order_detail" => array(),
			);
		}

		$this->view = $this->viewPage . 'index';
		render_tracking($this->view, $this->data, $css, $js);
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


	public function debug_order($id)
	{
		do_debug($this->get_order($id));
	}


}

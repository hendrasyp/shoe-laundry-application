<?php
$defaultLimit = -1;
$defaultOffset = 0;

function getRekapitulasi($orders, $date = null)
{
	//do_debug($orders,true);
	$overview = array(
		"workstatus" => array(),
		"income" => array(),
		"query" => array(
			"sisa_kasbon" =>
				array_sum(array_map(function ($item) {
					return $item->sisa;
				}, array_filter($orders, function ($var) {
						return ($var->sisa > 0);
					})
				)),
			"lunas_dp" =>
				array_sum(array_map(function ($item) {
					return $item->total_paid;
				}, array_filter($orders, function ($var) {
						return ($var->payment_status == 'PAID' || $var->payment_status == 'UNPAID' || $var->payment_status == 'HALF-PAID');
					})
				)),
			"dp" =>
				array_sum(array_map(function ($item) {
					return $item->total_paid;
				}, array_filter($orders, function ($var) {
						return ($var->payment_status == 'HALF-PAID');
					})
				)),

			"inprogress" => array_filter($orders, function ($var) {
				return ($var->work_status == 'IN PROGRESS');
			}),
			"ready_to_pickup" => array_filter($orders, function ($var) {
				return ($var->work_status == 'READY TO PICKUP');
			}),
			"closed" => array_filter($orders, function ($var) {
				return ($var->work_status == 'CLOSED');
			}),
			"payment_all" =>
				array_sum(array_map(function ($item) {
					return $item->total_after_discount;
				}, array_filter($orders, function ($var) {
						return ($var->payment_status == 'PAID' || $var->payment_status == 'UNPAID' || $var->payment_status == 'HALF-PAID');
					})
				)),
			"payment_paid" => array_sum(array_map(function ($item) {
				return $item->total_paid;
			}, array_filter($orders, function ($var) {
					return ($var->payment_status == 'PAID');
				})
			)),
			"payment_unpaid" => array_sum(array_map(function ($item) {
				return $item->total_after_discount;
			}, array_filter($orders, function ($var) {
					return ($var->payment_status == 'UNPAID');
				})
			)),
			"payment_half" => array_sum(array_map(function ($item) {
				return $item->total_paid;
			}, array_filter($orders, function ($var) {
					return ($var->payment_status == 'HALF-PAID');
				})
			)),
			"payment_receivable" => array_sum(array_map(function ($item) {
				return $item->total_after_discount + $item->total_paid;
			}, array_filter($orders, function ($var) {
					return ($var->payment_status == 'HALF-PAID');
				})
			)),
		),
	);

	$overview["income"]["sisa_kasbon"] = $overview["query"]["sisa_kasbon"];

	$overview["income"]["uangmasuk"] = $overview["query"]["lunas_dp"];
	$overview["income"]["totaldp"] = $overview["query"]["dp"];

	$overview["income"]["all"] = $overview["query"]["payment_all"];
	$overview["income"]["paid"] = $overview["query"]["payment_paid"];
	$overview["income"]["unpaid"] = $overview["query"]["payment_unpaid"];
	$overview["income"]["half_paid"] = $overview["query"]["payment_half"];
	$overview["income"]["receivable"] = $overview["query"]["payment_receivable"];
	$overview["workstatus"]["all_order"] = $orders;
	$overview["workstatus"]["ready_to_pickup"] = $overview["query"]["ready_to_pickup"];
	$overview["workstatus"]["inprogress"] = $overview["query"]["inprogress"];
	$overview["workstatus"]["closed"] = $overview["query"]["closed"];
	// do_debug($overview, true);

//	$this->data['work_order_all'] = sizeof($overview["workstatus"]["all_order"]);
//	$this->data['work_order_inprogress'] = sizeof($overview["workstatus"]["inprogress"]);
//	$this->data['work_order_closed'] = sizeof($overview["workstatus"]["closed"]);
//	$this->data['work_order_ready_to_pickup'] = sizeof($overview["workstatus"]["ready_to_pickup"]);
//
//	$this->data['income_all'] = $overview["income"]["all"];
//	$this->data['income_paid'] = $overview["income"]["paid"];
//	$this->data['income_unpaid'] = $overview["income"]["unpaid"];
//	$this->data['income_half_paid'] = $overview["income"]["half_paid"];
//	$this->data['income_receivable'] = $overview["income"]["receivable"];
	return $overview;
}

function orderByBranch($id)
{
	$db = new Commondb();
	return $db
		->condition(array('branch_id' => $id))
		->table_name(V_REPORT_HEADER)
		->limit_offset(-1, 0)
		->do_read();
}

function dashboard_income_by_paystatus()
{
	$db = new Commondb();
	return $db
		// ->condition(array('branch_id' => $id))
		->table_name('view_income_by_paymentstatus')
		->limit_offset(-1, 0)
		->do_read();
}

function dashboard_income_by_workstatus()
{
	$db = new Commondb();
	return $db
		// ->condition(array('branch_id' => $id))
		->table_name('view_income_by_workstatus')
		->limit_offset(-1, 0)
		->do_read();
}

function dashboard_order_masuk()
{
	$db = new Commondb();
	return $db
		// ->condition(array('branch_id' => $id))
		->table_name('view_order_masuk')
		->limit_offset(-1, 0)
		->do_read();
}

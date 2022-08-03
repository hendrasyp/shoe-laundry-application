$(document).off('click', '#btn_search');
$(document).on('click', '#btn_search', function () {
	var that = vmSearchService;
	vmSearchService.do_search();
});

$(document).off('click', '#btn_export');
$(document).on('click', '#btn_export', function () {
	var that = vmSearchService;
	vmSearchService.do_export();
});

$(document).off('click', '#btn_search_clear');
$(document).on('click', '#btn_search_clear', function () {
	formField.clearAll($('#frm_user_filter'))
	var that = vmSearchService;
	vmSearchService.do_search();
});

$(document).off('click', '.select_search_service');
$(document).on('click', '.select_search_service', function () {
	var data = $(this).info();
	if (is_extra === "No") {
		if (formField.getVal('txt_item_name') === "") {
			kinet.notification.show("Please type Item name", "error", kinet.common.blankString);
			return false;
		}
	}


	if (parseInt(formField.getVal('xServiceId')) > 0) {
		dataUri = orderUrl + 'update_order_detail';
		postData = {
			is_extra: 'No',
			header_id: formField.getVal('order_id'),
			current_sid: formField.getVal('xServiceId'),
			service_id: data.id,
			work_status: 0,
			item_name: formField.getVal('txt_item_name'),
			detail_id: (parseInt(formField.getVal('xServiceId')) > 0) ? detail_id : 0,
			size: formField.getVal('txt_size'),
			insole: formField.getVal('txt_insole'),
			tali: formField.getVal('txt_tali'),
			item_description: kinet.common.blankString,
		};
	}else{
		var dataUri = orderUrl + 'save_order_detail';
		var postData = {
			is_extra: 'No',
			header_id: formField.getVal('order_id'),
			service_id: data.id,
			work_status: 0,
			item_name: formField.getVal('txt_item_name'),
			detail_id: 0,
			size: formField.getVal('txt_size'),
			insole: formField.getVal('txt_insole'),
			tali: formField.getVal('txt_tali'),
			item_description: kinet.common.blankString,
		};
	}


	if (is_extra === "Yes") {
		postData = {
			is_extra: 'Yes',
			header_id: formField.getVal('order_id'),
			service_id: data.id,
			work_status: 0,
			item_name: kinet.common.blankString,
			item_description: kinet.common.blankString,
			detail_id: detail_id,
			size: kinet.common.blankString,
			insole: kinet.common.blankString,
			tali: kinet.common.blankString,
		};
	}

	$.when(kinet.ajax.post(dataUri, postData, '')).done(function (result) {
		window.location.href = baseurl + 'transaction/order/edit/' + formField.getVal('order_id');
		// var cart = kinet.mo.recalculateCart(result.result);
		// $('tbody#order_detail').html(cart.outputHtml);
		// formField.setVal('txt_total', cart.grandTotal);
		// var grandTotalDisplay = kinet.common.numericFormat(cart.grandTotal);
		// formField.setVal('txt_total_display', grandTotalDisplay);
		// $('#order_detail').html(cart.outputHtml);
		// kinet.mo.recalculatePayment();
	});
	kinet.modal.close();
});

var vmSearchService = {
	grid: {
		container: '#gridSearchCustomer',
		init: function () {
			var table;
			table = $(vmSearchService.grid.container).DataTable({
				"pagingType": "full_numbers",
				"pageLength": 5,
				"info": false,
				"processing": true,
				"destroy": true,
				"autowidth": true,
				"scrollX": true,
				"filter": true,
				"serverSide": true,
				"lengthChange": false,
				"destroy": true,
				"order": [],

				"ajax": {
					"url": gridCustApi,
					"type": "POST",
					'data': function (data) {
						// Read values
						// Append to data
						data.header_id = header_id;
						data.detail_id = detail_id;
						data.is_extra = is_extra;
					}
				},

				"columnDefs": [
					{
						"targets": [0, 1, 3, 4],
						"orderable": false,
					},
					{
						"targets": [3],
						"className": "dt-body-right",
					},
				],

			});
			return table;
		}
	}
};

$(document).ready(function () {
	vmSearchService.grid.init();
});

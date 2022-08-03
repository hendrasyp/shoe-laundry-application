$(document).off('click', '#btn_search');
$(document).on('click', '#btn_search', function () {
	var that = vmSearchCustomer;
	vmSearchCustomer.do_search();
});

$(document).off('click', '#btn_export');
$(document).on('click', '#btn_export', function () {
	var that = vmSearchCustomer;
	vmSearchCustomer.do_export();
});

$(document).off('click', '#btn_search_clear');
$(document).on('click', '#btn_search_clear', function () {
	formField.clearAll($('#frm_user_filter'))
	var that = vmSearchCustomer;
	vmSearchCustomer.do_search();
});

$(document).on('click', '.select_search_customer', function () {
	var data = $(this).info();
	var dataUri = orderUrl + 'save_order_customer';
	var dataPost = {
		order_id: formField.getVal('order_id'),
		order_no: formField.getVal('orderNo'),
		cust_id: data.id,
		order_status: 3,
		user_id:formField.getVal('txtUserID'),
		counter_id:formField.getVal('txtCounterID')
	};
	$.when(kinet.ajax.post(dataUri,dataPost,'')).done(function(result){
		console.log(result);
		var phone = result.header_data.header.phone;
		phone = phone.padStart(phone.length+1,'0');
		formField.setVal('txtCustomerID',data.id);
		formField.setVal('orderNo',result.result.order_no);
		formField.setVal('order_id',result.last_id);
		formField.setVal('txtCustomerName',data.name);
		formField.setVal('txtCustomerPhone',phone);
		formField.setVal('txtCustomerEmail',data.email);
		//console.log(data);
		kinet.modal.close();
	});


});


var vmSearchCustomer = {
	grid: {
		container:'#gridSearchCustomer',
		init: function () {
			var table;
			table = $(vmSearchCustomer.grid.container).DataTable({
				"pagingType": "full_numbers",
				"pageLength":5,
				"info":false,
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
					// 'data': function (data) {
					// 	// Read values
					// 	var name = formField.getVal('search_username');
					//
					// 	// Append to data
					// 	data.searchByName = name;
					// }
				},

				"columnDefs": [
					{
						"targets": [0, 1, 3, 4],
						"orderable": false,
					},
				],

			});
			return table;
		}
	}
};

$(document).ready(function () {
	vmSearchCustomer.grid.init();
});

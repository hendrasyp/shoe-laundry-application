$(document).off('click', '#btn_search');
$(document).on('click', '#btn_search', function () {
	var that = vmCompany;
	vmCompany.do_search();
});

$(document).off('click', '#btn_search_clear');
$(document).on('click', '#btn_search_clear', function () {
	formField.clearAll($('#frm_user_filter'));
	formField.setVal('searchStatus','*');
	formField.setVal('searchPaymentStatus','*');
	var that = vmCompany;
	vmCompany.do_search();
});

$(document).on('click', '.delete_order', function () {
	var data = $(this).info();
	kinet.dialog.yesNo("Are you sure want to Delete this order ?",vmCompany.do_delete_order,data);
});

$(document).off('click', '#btn_clean_order');
$(document).on('click', '#btn_clean_order', function () {
	kinet.dialog.yesNo("Are you sure want to Clean?",vmCompany.do_clean_order,1);
});

$(document).off('click', '#btn_add_order');
$(document).on('click', '#btn_add_order', function () {
	kinet.window.open(pageBaseUrl + '/add');
});

let vmCompany = {
	page: {
		basePage: baseurl + 'administration/'
	},
	do_print: function (header_id){
		window.open(orderUrl + 'print_order/' + header_id);
	},
	do_delete_order:function (data){
		$.when(kinet.ajax.post(pageBaseUrl + '/delete_order/' + data.id, data, '')).done(function (result) {
			if (result.message === kinet.message.success) {
				kinet.notification.show('Order has been deleted.',
					result.message, pageBaseUrl);
			} else {
				kinet.notification.show(result.message_details,
					result.message, kinet.blankString);
				return false;
			}
			// console.log(result);
			// console.log(JSON.parse(result.X));
		});
	},
	do_clean_order:function (data){
		$.when(kinet.ajax.post(pageBaseUrl + '/clean_order/' + data, {}, '')).done(function (result) {
			if (result.message === kinet.message.success) {
				kinet.notification.show('Order has been deleted.',
					result.message, pageBaseUrl);
			} else {
				kinet.notification.show(result.message_details,
					result.message, kinet.blankString);
				return false;
			}
			// console.log(result);
			// console.log(JSON.parse(result.X));
		});
	},
	do_search: function () {
		$('#grid').DataTable().draw(true);
	},
	grid: {
		init: function () {
			var table;
			table = $('#grid').DataTable({
				"pagingType": "full_numbers",
				"scrollX": true,
				"autowidth": true,
				"responsive": true,
				"processing": true,
				"filter": false,
				"serverSide": true,
				"lengthChange": false,
				"destroy": true,
				//"dom" : "Bfrtip",
				"order": [],

				"ajax": {
					"url": gridApiUrl,
					"type": "POST",
					'data': function (data) {
						data.searchInvNumber = formField.getVal('searchNoFaktur');
						data.searchCustomer = formField.getVal('searchCustomer');
						data.searchWStatus = formField.getVal('searchStatus') !== '*' ? parseInt(formField.getVal('searchStatus')) : '*';
						data.searchPStatus = formField.getVal('searchPaymentStatus') !== '*' ? parseInt(formField.getVal('searchPaymentStatus')) : '*';
					}
				},

				"columnDefs": [
					{
						"targets": [0, 1, 3, 4, 7],
						"orderable": false,
					},
					{
						"targets": [8],
						"className": 'dt-body-right',
					},
				],

			});
			return table;
		}
	}
};


$.fn.info = function () {
	var data = {};
	[].forEach.call(this.get(0).attributes, function (attr) {
		if (/^data-/.test(attr.name)) {
			var camelCaseName = attr.name.substr(5).replace(/-(.)/g, function ($0, $1) {
				return $1.toUpperCase();
			});
			data[camelCaseName] = attr.value;
		}
	});
	return data;
}

$(document).ready(function () {
	var that = vmCompany;
	vmCompany.grid.init();
});

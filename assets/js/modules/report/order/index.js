function dateRangeToMySqlDate(value){
	var tmpValue = value.split(' - ');
	var dt1 = tmpValue[0].split('/');
	var dt2 = tmpValue[1].split('/');
	return [
		dt1[2]+'-'+dt1[0]+'-'+dt1[1],
		dt1[2]+'-'+dt2[0]+'-'+dt2[1]
	];
}

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
var rekapitulasiData = null;
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
		$.when($('#grid').DataTable().draw(true)).done(function(result){
			// var postData = {
			// 	searchFrom : dateRangeToMySqlDate(formField.getVal('reservation'))[0],
			// 	searchTo : dateRangeToMySqlDate(formField.getVal('reservation'))[1]
			// }
			// $.when(kinet.ajax.post(baseurl + 'report/order/get_rekapitulasi', postData, '')).done(function (result) {
			// 	console.log(result);
			// });
		});
	},
	grid: {
		init: function () {
			var table;
			table = $('#grid').DataTable({
				//"pagingType": "full_numbers",
				"paging": false,
				"processing": true,
				"scrollX": true,
				"filter": false,
				"serverSide": true,
				"pageLength":100000,
				"lengthChange": false,
				"destroy": true,
				"autowidth": true,
				"responsive": true,
				//"dom" : "Bfrtip",
				"order": [],
				"fnDrawCallback": function( oSettings ) {
					var recap = oSettings.json.rekapitulasi;
					$("#totalKasbonan").html( kinet.common.numericFormat(recap.income.sisa_kasbon));

					$("#totalOrder").html(  kinet.common.numericFormat(recap.income.uangmasuk));
					$("#totalDp").html( kinet.common.numericFormat(recap.income.totaldp));
					$("#totalPaid").html( kinet.common.numericFormat(recap.income.paid));

					$("#totalUnpaid").html( kinet.common.numericFormat(recap.income.unpaid));
					$("#totalSemua").html( kinet.common.numericFormat(recap.income.all));
				},
				"ajax": {
					"url": gridApiUrl,
					"type": "POST",

					'data': function (data) {
						data.searchInvNumber = formField.getVal('searchNoFaktur');
						data.searchCustomer = formField.getVal('searchCustomer');
						data.searchWStatus = formField.getVal('searchStatus') !== '*' ? formField.getVal('searchStatus') : '*';
						data.searchPStatus = formField.getVal('searchPaymentStatus') !== '*' ? formField.getVal('searchPaymentStatus') : '*';
						if (formField.getVal('reservation') !== ''){
							data.searchFrom = dateRangeToMySqlDate(formField.getVal('reservation'))[0];
							data.searchTo = dateRangeToMySqlDate(formField.getVal('reservation'))[1];
						}else{
							data.searchFrom = '';
							data.searchTo = '';
						}

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
	$('#reservation').daterangepicker();
});

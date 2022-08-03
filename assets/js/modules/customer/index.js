$(document).off('click', '#btn_search');
$(document).on('click', '#btn_search', function () {
	var that = vmUser;
	vmUser.do_search();
});

$(document).off('click', '#btn_export');
$(document).on('click', '#btn_export', function () {
	var that = vmUser;
	vmUser.do_export();
});

$(document).off('click', '#btn_search_clear');
$(document).on('click', '#btn_search_clear', function () {
	formField.clearAll($('#frm_user_filter'))
	var that = vmUser;
	vmUser.do_search();
});


$(document).off('click', '.delete_user');
$(document).on('click', '.delete_user', function () {
	var data = $(this).info();
	kinet.dialog.yesNo("Are you sure want to Delete this user ?",vmUser.do_delete,data);
});

$(document).off('click', '.btn_user_add_order');
$(document).on('click', '.btn_user_add_order', function () {
	var data = $(this).info();
	$.when(kinet.ajax.post(baseurl + 'transaction/order/add_customer',{
		cust_id:data.id,
		order_status:0,
		user_id:formField.getVal('txtUserID'),
		counter_id:formField.getVal('txtCounterID')
	})).done(function(result){
		window.location.href = baseurl + 'transaction/order/edit/' + result.order_id
	});
});

$(document).off('click', '#btn_new_user');
$(document).on('click', '#btn_new_user', function () {
	kinet.window.open(baseurl + 'administration/customer/add');
});

let vmUser = {
	page: {
		basePage: baseurl + 'administration/'
	},
	do_delete: function (data) {
		$.when(kinet.ajax.post(vmUser.page.basePage + 'customer/delete/' + data.id, data, '')).done(function (result) {
			if (result.message === kinet.message.success) {
				kinet.notification.show('User berhasil dihapus.',
					result.message, vmUser.page.basePage + 'user');
			} else {
				kinet.notification.show(result.message_details,
					result.message, kinet.blankString);
				return false;
			}
			// console.log(result);
			// console.log(JSON.parse(result.X));
		});
	},
	do_export: function () {
		var postData = {};
		if (formField.getVal('search_username') !== '') {

		}

		$.when(kinet.ajax.post(kinet.admin_ajax, postData, kinet.blankString)).done(function (res) {

		});

		kinet.window.open(baseurl + 'export/customer');
	},
	do_search: function () {
		$('#gridUser').DataTable().draw(true);
	},
	grid: {
		initUser: function () {
			var table;
			table = $('#gridUser').DataTable({
				"pagingType": "full_numbers",
				"processing": true,
				"destroy": true,
				"autowidth": true,
				"scrollX": true,
				"filter": false,
				"language": {
					"emptyTable": "Please search customer first."
				},
				"serverSide": true,
				"lengthChange": false,
				"destroy": true,
				"order": [],

				"ajax": {
					"url": gridUserApiURL,
					"type": "POST",
					'data': function (data) {
						// Read values
						var name = formField.getVal('search_username');

						// Append to data
						data.searchByName = name;
					}
				},

				"columnDefs": [
					{
						"targets": [0, 1, 3, 4],
						"orderable": false,
					},
					{
						"targets": [1],
						"className": "dt-body-center",
					},
				],

			});
			return table;
		}
	}
};

function InitDatatable() {
	//posts
	table_posts = $('#tabel_posts').DataTable({
		"processing": true, //Feature control the processing indicator.
		"serverSide": true, //Feature control DataTables' server-side processing mode.
		"order": [], //Initial no order.
		"dom": 'Blfrtip',
		// Load data for the table's content from an Ajax source
		"ajax": {
			"url": baseurl + "administrator/posts/getdata_posts",
			"type": "POST",
			"data": function (data) {
				data.status = status;
			}
		},
		"bResponsive": true,
		"bAutoWidth": false,
		//Set column definition initialisation properties.
		"columnDefs": [
			{
				"targets": [-1], //last column
				"orderable": false, //set not orderable
			},
		],

	});

	//slider

	tabel_slider = $('#tabel_slider').DataTable({

		"processing": true, //Feature control the processing indicator.
		"serverSide": true, //Feature control DataTables' server-side processing mode.
		"order": [], //Initial no order.

		// Load data for the table's content from an Ajax source
		"ajax": {
			"url": baseurl + "administrator/sliders/getdata_sliders",
			"type": "POST",
			"data": function (data) {
				data.status = status;
			}
		},

		//Set column definition initialisation properties.
		"columnDefs": [
			{
				"targets": [-1], //last column
				"orderable": false, //set not orderable
			},
		],

	});

	//pages
	table_pages = $('#tabel_pages').DataTable({

		"processing": true, //Feature control the processing indicator.
		"serverSide": true, //Feature control DataTables' server-side processing mode.
		"order": [], //Initial no order.

		// Load data for the table's content from an Ajax source
		"ajax": {
			"url": baseurl + "administrator/pages/getdata_pages",
			"type": "POST",
			"data": function (data) {
				data.status = status;
			}
		},

		//Set column definition initialisation properties.
		"columnDefs": [
			{
				"targets": [-1], //last column
				"orderable": false, //set not orderable
			},
		],

	});


	//posts category
	$.ajax({
		type: "GET",
		url: baseurl + "administrator/posts/getdata_category",
		dataType: "json",
		success: function (data) {
			$('#table_categories').DataTable({
				data: data,
				columns: [
					{title: "ID", data: "ID", sortable: true},
					{title: "Name", data: "post_title", sortable: true},
					{title: "Descriptions", data: "post_content", sortable: false},
					{
						sortable: false,
						width: "19%",
						mRender: function (data, type, row) {
							return '<a class="btn btn-primary btn-xs btnedit" onclick="edit_category(' + row['ID'] + ')" href="javascript:;" ><i class="fa fa-edit"></i> &nbsp;&nbsp;' + 'Edit' + '</a>' +
								'<a class="btn btn-danger btn-xs btndelete" onclick="delete_category(' + row['ID'] + ')" href="javascript:;" ><i class="fa fa-trash-o"></i> &nbsp;&nbsp;' + 'Delete' + '</a><input type="hidden" id="txt_id_category" value="' + row["ID"] + '"></input>';
						}
					}
				],
				bDestroy: true,
				bAutoWidth: true,
				bStateSave: true,
				bPaginate: true,
				bProcessing: true

			});

		},
		error: function (data) {
			//console.log(data);
		}
	});


	//posts tags
	$.ajax({
		type: "GET",
		url: baseurl + "administrator/posts/getdata_tags",
		dataType: "json",
		success: function (data) {
			$('#table_tags').DataTable({
				data: data,
				columns: [
					{title: "ID", data: "ID", sortable: true},
					{title: "Category Name", data: "post_title", sortable: false},
					{title: "Descriptions", data: "post_content", sortable: false},
					{title: "Status", data: "post_status", sortable: false},
					{
						sortable: false,
						width: "19%",
						mRender: function (data, type, row) {
							return '<a class="btn btn-primary btn-xs btnedit" onclick="edit_tags(' + row['ID'] + ')" href="javascript:;" ><i class="fa fa-edit"></i> &nbsp;&nbsp;' + 'Edit' + '</a>' +
								'<a class="btn btn-danger btn-xs btndelete" onclick="delete_tags(' + row['ID'] + ')" href="javascript:;" ><i class="fa fa-trash-o"></i> &nbsp;&nbsp;' + 'Delete' + '</a><input type="hidden" id="txt_id_category" value="' + row["ID"] + '"></input>';
						}
					}
				],
				bDestroy: true,
				bAutoWidth: true,
				bStateSave: true,
				bPaginate: true,
				bProcessing: true

			});

			//InitGridView();


		},
		error: function (data) {
			//console.log(data);
		}
	});

}

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
	var that = vmUser;
	vmUser.grid.initUser();
});

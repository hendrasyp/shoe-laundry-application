$(document).on('click', '#btn_search', function () {
	var that = vmRole;
	vmRole.do_search();
});

$(document).on('click', '.delete_role', function () {
	var data = $(this).info();
	$.when(kinet.ajax.post(vmRole.page.basePage + 'role/delete/' + data.id, data, '')).done(function (result) {
		if (result.message === kinet.message.success) {
			kinet.notification.show('Role berhasil dihapus.',
				result.message, vmRole.page.basePage + 'role');
		} else {
			kinet.notification.show(result.message_details,
				result.message, kinet.blankString);
			return false;
		}
		// console.log(result);
		// console.log(JSON.parse(result.X));
	});
});

$(document).on('click', '#btn_new_role', function () {
	kinet.window.open(baseurl + 'administration/role/add');
});

let vmRole = {
	page: {
		basePage: baseurl + 'administration/'
	},
	do_search: function () {
		formField.setVal('search_rolename', formField.getVal('search_rolename'));
		$("#frm_role_filter").submit();
	},
	grid: {
		init: function () {
			var grid = $('#grid').DataTable({
				"searching": false,
				"processing": true,
				"lengthChange": false,
				//"pageLength": 10,
				"serverSide": true,
				"paging": true,
				"order": [], //Initial no order.

				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl + "administration/role/role_get",
					"type": "POST",
					"data": function (data) {
						data.rolename = formField.getVal('search_rolename');
					}
				},
				"responsive": true,
				"autoWidth": false,
				//Set column definition initialisation properties.
				"columnDefs": [
					{
						"targets": [0, 1], //last column
						"orderable": false, //set not orderable
					},
				],

			});
		}
	}
};

$(document).ready(function () {
	var that = vmRole;
	vmRole.grid.init();
});

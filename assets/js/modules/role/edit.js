let pageUri = baseurl + "administration/role";
$(document).on('click', '#btn_save', function () {
	var form = $("#frm_role_detail").serialize();
	var uri = baseurl + "administration/role/update";
	if (formField.getVal('hid_role_id') === "0") {
		uri = baseurl + "administration/role/insert";
	}

	$.when(kinet.ajax.postSerialize(uri, form, '')).done(function (result) {
		if (result.message === kinet.message.success) {
			kinet.notification.show('Role berhasil disimpan', kinet.message.success, pageUri);
		} else {
			kinet.notification.show('Role berhasil disimpan', kinet.message.error, '');
		}
	});
});

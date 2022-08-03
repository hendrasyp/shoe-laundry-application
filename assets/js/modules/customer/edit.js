var pageUri = baseurl + "administration/customer";
$(document).on('click', '#btn_save', function () {
    var form = $("#frm_user_detail").serialize();
    var uri = baseurl + "administration/customer/update";
    if (formField.getVal('hid_user_id') === "0") {
        uri = baseurl + "administration/customer/insert";
    }

    $.when(kinet.ajax.postSerialize(uri, form, '')).done(function (result) {
        if (result.message === kinet.message.success) {
            kinet.notification.show('Customer berhasil disimpan', kinet.message.success, pageUri);
        } else {
            kinet.notification.show('Customer berhasil disimpan', kinet.message.error, '');
        }
    });
});
$(document).on('click', '#btn_cancel', function () {
    kinet.window.open(pageUri);
});

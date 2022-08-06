let pageUri = baseurl + "administration/branch/profile";
$(document).on('click', '#btn_save', function () {
    var form = $("#frm_input").serialize();
    var uri = baseurl + "administration/branch/update";

    $.when(kinet.ajax.post(uri, form, '')).done(function (result) {
        console.log(result);
        if (result.message === kinet.message.success) {
            kinet.notification.show('Company berhasil disimpan', kinet.message.success, pageUri);
        } else {
            kinet.notification.show('Company gagal disimpan', kinet.message.error, '');
        }
    });
});

$(document).on('click', '#btn_cancel', function () {
    kinet.window.open(pageUri);
});

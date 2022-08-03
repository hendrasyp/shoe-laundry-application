let pageUri = baseurl + "administration/service";
$(document).on('click', '#btn_save', function () {
    var form = $("#frm_input").serializeArray();
    var uri = baseurl + "administration/service/update";
    var cboIsExtra = 0;

    if (formField.isChecked('cboIsExtra')) {
        cboIsExtra = 1;
    }

    form = formField.findAndSet(form, 'cboIsExtra', 1);

    if (formField.getVal('txtServiceId') === "0") {
        uri = baseurl + "administration/service/insert";
    }

    $.when(kinet.ajax.postSerialize(uri, form, '')).done(function (result) {
        if (result.message === kinet.message.success) {
            kinet.notification.show('Service has been saved.', kinet.message.success, pageUri);
        } else {
            kinet.notification.show('Service has been saved.', kinet.message.error, '');
        }
    });
});
$(document).on('click', '#btn_cancel', function () {
    kinet.window.open(baseurl + 'administration/service');
});

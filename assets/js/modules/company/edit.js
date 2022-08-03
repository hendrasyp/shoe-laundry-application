let pageUri = baseurl + "administration/company";
$(document).on('click', '#btn_save', function () {
    var form = $("#frm_input").serializeArray();
    var uri = baseurl + "administration/company/update";
    var tmpIsBranch = 0;

    if (formField.isChecked('cboIsBranch')) {
        tmpIsBranch = 1;
    }
    form.find(item => item.name === 'cboIsBranch').value = tmpIsBranch;

    if (formField.getVal('txtCompanyId') === "0") {
        uri = baseurl + "administration/company/insert";
    }

    $.when(kinet.ajax.postSerialize(uri, form, '')).done(function (result) {
        if (result.message === kinet.message.success) {
            kinet.notification.show('Company berhasil disimpan', kinet.message.success, pageUri);
        } else {
            kinet.notification.show('Company berhasil disimpan', kinet.message.error, '');
        }
    });
});
$(document).on('click', '#btn_cancel', function () {
    kinet.window.open(baseurl + 'administration/company');
});

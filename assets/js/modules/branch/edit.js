let pageUri = baseurl + "administration/branch/profile";
$(document).on('click', '#btn_save', function () {
    var form = $("#frm_input").serializeArray();
    var uri = baseurl + "administration/branch/update";

    let postData = {
        txtCompanyId : formField.getVal('txtCompanyId')
    };

    $.ajax({
        url: url,
        data: postData,
        type: "post",
        dataType: "json",
        success: function(response){
            console.log(response);
        }

    });

    // $.when(kinet.ajax.post(uri, postData, '')).done(function (result) {
    //     if (result.message === kinet.message.success) {
    //         kinet.notification.show('Company berhasil disimpan', kinet.message.success, pageUri);
    //     } else {
    //         kinet.notification.show('Company gagal disimpan', kinet.message.error, '');
    //     }
    // });
});

$(document).on('click', '#btn_cancel', function () {
    kinet.window.open(pageUri);
});

let pageUri = baseurl + "administration/branch/profile";
$(document).on('click', '#btn_save', function () {
    var form = $("#frm_input").serializeArray();
    var uri = baseurl + "administration/branch/update";

    $.ajax({
        url: uri,
        method: 'post',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json'
        },
        dataType: 'json',
        data: { emailaddr: "suhendra" },
        success: function(resp) {
            console.log(resp);
        }
    });

    let postData = {
        txtCompanyId : formField.getVal('txtCompanyId')
    };
    $.post( "test.php", { name: "John", time: "2pm" })
        .done(function( data ) {
            alert( "Data Loaded: " + data );
        });
    return false;
    // $.ajax({
    //     url: uri,
    //     data: {
    //         ewasd:1
    //     },
    //     type: "post",
    //     dataType: "json",
    //     async : true,
    //     contentType:"Content-Type: application/json; charset=UTF-8",
    //     // contentType:"application/x-www-form-urlencoded; charset=UTF-8",
    //     success: function(response){
    //         console.log(response);
    //     }
    //
    // });

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

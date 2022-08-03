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

$(document).off('click', '.btn_cancel');
$(document).on('click', '.btn_cancel', function () {
    var postData = {"id": null};
    $.when(kinet.ajax.post(baseurl + 'transaction/order/clear_unused_order', postData, '')).done(function (result) {
        kinet.window.open(baseurl + 'transaction/order');
    });
});

$(document).off('click', '#btnSearchCustomer');
$(document).on('click', '#btnSearchCustomer', function () {
    var modalUri = baseurl + 'rest/modal/customer_search_modal';
    var modalTitle = 'Search Customer';
    var modalData = {};
    $.when(kinet.modal.show(modalUri, modalTitle, modalData)).done(function (res) {
        kinet.modal.width(1024);
    });
});


$(document).off('click', '#btn_add_service');
$(document).on('click', '#btn_add_service', function () {
    if (formField.getVal('txtCustomerID') === "") {
        kinet.notification.show("Please add Customer first.", "error", kinet.common.blankString);
        return false;
    }

    var modalUri = baseurl + 'rest/modal/service_search_modal?service_id=0&did=' + 0 + '&hid=' + formField.getVal('order_id') + '&e=No';
    var modalTitle = 'Search Service Item';
    var modalData = {};
    $.when(kinet.modal.show(modalUri, modalTitle, modalData)).done(function (res) {
        kinet.modal.width(1024);
    });
});

$(document).off('click', '.btn_detail_edit');
$(document).on('click', '.btn_detail_edit', function () {
    var modalUri = baseurl + 'rest/modal/service_search_modal?service_id=' + $(this).data('serviceid') + '&did=' + $(this).data("id") + '&hid=' + formField.getVal('order_id') + '&e=No';
    var modalTitle = 'Edit Service Item';
    var modalData = {};
    $.when(kinet.modal.show(modalUri, modalTitle, modalData)).done(function (res) {
        kinet.modal.width(1024);
    });
});

$(document).off('click', '.btn_delete_order_detail_extra');
$(document).on('click', '.btn_delete_order_detail_extra', function () {
    var dataUri = orderUrl + 'delete_order_extra';
    var postData = {
        is_extra: 'Yes',
        header_id: formField.getVal('order_id'),
        detail_id: $(this).data('detailid'),
        detail_extra_id: $(this).data('id'),
        service_id: $(this).data('serviceid')
    };
    $.when(kinet.ajax.post(dataUri, postData, '')).done(function (result) {
        goToBase(formField.getVal('order_id'));
    });
});

$(document).off('click', '.btn_delete_order_detail');
$(document).on('click', '.btn_delete_order_detail', function () {
    var dataUri = orderUrl + 'delete_order_detail';
    var postData = {
        is_extra: 'No',
        id: $(this).data('id'),
        header_id: formField.getVal('order_id'),
        service_id: $(this).data('serviceid')
    };
    $.when(kinet.ajax.post(dataUri, postData, '')).done(function (result) {
        goToBase(formField.getVal('order_id'));

        // var cart = kinet.mo.recalculateCart(result.result);
        // $('tbody#order_detail').html(cart.outputHtml);
        // formField.setVal('txt_total', cart.grandTotal);
        // var grandTotalDisplay = kinet.common.numericFormat(cart.grandTotal);
        // formField.setVal('txt_total_display', grandTotalDisplay);
        // $('#order_detail').html(cart.outputHtml);
    });
});

function goToBase(id) {
    window.location.href = baseurl + 'transaction/order/edit/' + id;
}

$(document).off('click', '.btn_detail_done');
$(document).on('click', '.btn_detail_done', function () {
    var dataUri = orderUrl + 'order_detail_done';
    var postData = {
        is_extra: 'No',
        id: $(this).data('id'),
        header_id: formField.getVal('order_id'),
        service_id: $(this).data('serviceid')
    };
    $.when(kinet.ajax.post(dataUri, postData, '')).done(function (result) {
        goToBase(formField.getVal('order_id'));
        //
        // var cart = kinet.mo.recalculateCart(result.result);
        // $('tbody#order_detail').html(cart.outputHtml);
        // formField.setVal('txt_total', cart.grandTotal);
        // var grandTotalDisplay = kinet.common.numericFormat(cart.grandTotal);
        // formField.setVal('txt_total_display', grandTotalDisplay);
        // $('#order_detail').html(cart.outputHtml);
    });
});

$(document).off('click', '.btn_detail_taked');
$(document).on('click', '.btn_detail_taked', function () {
    var dataUri = orderUrl + 'order_detail_taked';
    var postData = {
        is_extra: 'No',
        id: $(this).data('id'),
        header_id: formField.getVal('order_id'),
        service_id: $(this).data('serviceid')
    };
    $.when(kinet.ajax.post(dataUri, postData, '')).done(function (result) {

        window.location.href = baseurl + 'transaction/order/edit/' + formField.getVal('order_id');

        // var cart = kinet.mo.recalculateCart(result.result);
        // $('tbody#order_detail').html(cart.outputHtml);
        // formField.setVal('txt_total', cart.grandTotal);
        // var grandTotalDisplay = kinet.common.numericFormat(cart.grandTotal);
        // formField.setVal('txt_total_display', grandTotalDisplay);
        // $('#order_detail').html(cart.outputHtml);
    });
});

$(document).off('click', '.btn_detail_reverttake');
$(document).on('click', '.btn_detail_reverttake', function () {
    var dataUri = orderUrl + 'order_detail_reverttake';

    var postData = {
        is_extra: 'No',
        id: $(this).data('id'),
        header_id: formField.getVal('order_id'),
        service_id: $(this).data('serviceid')
    };
    $.when(kinet.ajax.post(dataUri, postData, '')).done(function (result) {
        window.location.href = baseurl + 'transaction/order/edit/' + formField.getVal('order_id');
        // var cart = kinet.mo.recalculateCart(result.result);
        // $('tbody#order_detail').html(cart.outputHtml);
        // formField.setVal('txt_total', cart.grandTotal);
        // var grandTotalDisplay = kinet.common.numericFormat(cart.grandTotal);
        // formField.setVal('txt_total_display', grandTotalDisplay);
        // $('#order_detail').html(cart.outputHtml);
    });
});

$(document).off('click', '.btn_detail_unfinish');
$(document).on('click', '.btn_detail_unfinish', function () {
    var dataUri = orderUrl + 'order_detail_unfinish';

    var postData = {
        is_extra: 'No',
        id: $(this).data('id'),
        header_id: formField.getVal('order_id'),
        service_id: $(this).data('serviceid')
    };
    $.when(kinet.ajax.post(dataUri, postData, '')).done(function (result) {
        window.location.href = baseurl + 'transaction/order/edit/' + formField.getVal('order_id');
        // var cart = kinet.mo.recalculateCart(result.result);
        // $('tbody#order_detail').html(cart.outputHtml);
        // formField.setVal('txt_total', cart.grandTotal);
        // var grandTotalDisplay = kinet.common.numericFormat(cart.grandTotal);
        // formField.setVal('txt_total_display', grandTotalDisplay);
        // $('#order_detail').html(cart.outputHtml);
    });
});

$(document).off('click', '.btn_add_detail_extra');
$(document).on('click', '.btn_add_detail_extra', function () {
    var modalUri = baseurl + 'rest/modal/service_search_modal?did=' + $(this).data('id') + '&hid=' + $(this).data('headerid') + '&e=Yes';
    var modalTitle = 'Search Service Extra';
    var modalData = {};
    $.when(kinet.modal.show(modalUri, modalTitle, modalData)).done(function (res) {
        kinet.modal.width(1024);
    });
});

$(document).off('click', '.btn_save_order');
$(document).on('click', '.btn_save_order', function () {
    if (formField.getVal('orderFinishDate') === formField.getVal('orderDate')) {
        kinet.notification.show("Order date must be different with Estimation Date.", "error", kinet.common.blankString);
        return false;
    }

    var dataUri = orderUrl + 'save_order';
    var tTanggal = formField.getVal('orderFinishDate').split("/");
    var postData = {
        header_id: formField.getVal('order_id'),
        payment_status: (eval(formField.getVal('txt_balance')) == 0) ? 2 : 1,
        total_after_discount: formField.getVal('txt_total'),
        total_before_discount: formField.getVal('txt_total'),
        total_payment: eval(formField.getVal('txt_current_dp')) + eval(formField.getVal('txt_dp')),
        finish_date: tTanggal[2] + "-" + tTanggal[1] + '-' + tTanggal[0]
    };

    $.when(kinet.ajax.post(dataUri, postData, '')).done(function (result) {
        kinet.dialog.yesNo("Print this order ?", do_print, formField.getVal('order_id'), baseurl + 'transaction/order');
    });
});

$(document).off('click', '.btn_print_order');
$(document).on('click', '.btn_print_order', function () {
    window.location.href = baseurl + 'transaction/order/print_order/' + formField.getVal('order_id');
});

$(document).off('click', '.btn_finish_order');
$(document).on('click', '.btn_finish_order', function () {
    kinet.dialog.yesNo("Are you sure all shoes are finished ?", do_finish_order, formField.getVal('order_id'));
});

$(document).off('click', '.btn_modal_save_pickup');
$(document).on('click', '.btn_modal_save_pickup', function(){
    if (formField.getVal('txtPersonPickup') === '') {
        kinet.notification.show("Alien doesn't wear shoes!!! Please input who pick the shoes!", "error", kinet.common.blankString);
        return false;
    }

    kinet.dialog.yesNo("Pick up all shoes ?", do_pickup, formField.getVal('order_id'));

});$(document).off('click', '.btn_modal_save_pickup_cancel');
$(document).on('click', '.btn_modal_save_pickup_cancel', function(){
    kinet.modal.close();
});

$(document).off('click', '.btn_pick_order');
$(document).on('click', '.btn_pick_order', function () {
    if (formField.getVal('txt_balance') !== "0") {
        kinet.notification.show("Please finish payment first.", "error", kinet.common.blankString);
        return false;
    }

    // Update 8 Juni 2022
    var modalUri = baseurl + 'rest/modal/pickup_all_order';
    var modalTitle = 'Pick Order No.' + formField.getVal('orderNo');
    var modalData = {
        orderId: formField.getVal('order_id'),
        orderNo: formField.getVal('orderNo')
    };
    $.when(kinet.modal.show(modalUri, modalTitle, modalData)).done(function (res) {
        kinet.modal.width(400);
    });


});

$(document).off('click', '.btn_submit');
$(document).on('click', '.btn_submit', function () {
    var dataUri = orderUrl + 'submit_order';
    var payment_status = 0;
    if (eval(formField.getVal('txt_change')) >= 0) {
        payment_status = 2;
    } else if (eval(formField.getVal('txt_change')) < 0) {
        payment_status = 1;
    }

    var postData = {
        header_id: formField.getVal('order_id'),
        payment_status: payment_status,
        total_after_discount: formField.getVal('txt_total'),
        total_before_discount: formField.getVal('txt_total'),
        total_payment: formField.getVal('txt_payment'),
        payment: formField.getVal('txt_payment'),
        change: formField.getVal('txt_change')
    };

    $.when(kinet.ajax.post(dataUri, postData, '')).done(function (result) {
        window.open(orderUrl + 'print_order/' + result.last_id);
    });
});

$(document).on('keyup', '#txt_dp', function () {
    kinet.mo.recalculatePayment();
});

function do_print(header_id) {
    window.open(orderUrl + 'print_order/' + header_id);
    window.location.href = baseurl + 'transaction/order';
}

function do_finish_order(header_id) {
    var dataUri = orderUrl + 'finish_order';
    var postData = {
        order_id: formField.getVal('order_id')
    };
    $.when(kinet.ajax.post(dataUri, postData, '')).done(function (result) {
        kinet.dialog.yesNo("Print this order ?", do_print, formField.getVal('order_id'), baseurl + 'transaction/order');
    });
}

function do_pickup(header_id) {

    var dataUri = orderUrl + 'save_order';
    var tTanggal = formField.getVal('orderFinishDate').split("/");
    var postData = {
        header_id: formField.getVal('order_id'),
        payment_status: (eval(formField.getVal('txt_balance')) === 0) ? 2 : 1,
        total_after_discount: formField.getVal('txt_total'),
        total_before_discount: formField.getVal('txt_total'),
        total_payment: eval(formField.getVal('txt_current_dp')) + eval(formField.getVal('txt_dp')),
        finish_date: tTanggal[2] + "-" + tTanggal[1] + '-' + tTanggal[0]
    };

    $.when(kinet.ajax.post(dataUri, postData, '')).done(function (result) {
        var dataUri = orderUrl + 'pickup_order';
        var tTanggal = formField.getVal('pickupDate').split("/");
        var postData = {
            pickupDate: tTanggal[2] + "-" + tTanggal[1] + '-' + tTanggal[0],
            pickupPerson: formField.getVal('txtPersonPickup'),
            order_id: formField.getVal('order_id')
        };
        $.when(kinet.ajax.post(dataUri, postData, '')).done(function (result) {
            kinet.dialog.yesNo("Print this order ?", do_print, formField.getVal('order_id'), baseurl + 'transaction/order');
        });

        //kinet.dialog.yesNo("Pick up all shoes ?", do_pickup, formField.getVal('order_id'));
    });



}

$(document).ready(function () {
    $(".select2").select2();
});

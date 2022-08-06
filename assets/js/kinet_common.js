// ======================
// DATA TABLES
// ======================
jQuery.extend(jQuery.fn.dataTableExt.oSort, {
    "numeric-comma-pre": function (a) {
        var x = (a === "-") ? 0 : a.replace(/,/, ".");
        return parseFloat(x);
    },

    "numeric-comma-asc": function (a, b) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },

    "numeric-comma-desc": function (a, b) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
});

$(document).on('shown.bs.modal', function (e) {
    $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
});

// ======================
// JQUERY VALIDATION
// ======================
jQuery.validator.addMethod("numberMoreThanZero", function (value, element) {
    if (value > 0) {
        return true;
    } else {
        return false;
    }
}, "Please enter a value more than Zero.");

jQuery.validator.addMethod("validate_email", function (value, element) {
    if (value.length > 1) {
        if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}, "Please enter a valid Email.");

$(document).on("keydown", "form", function (e) {
    if (e.which === 13) {
        var className = e.target.parentNode.className;
        if (!$(e.target).is('textarea') && className !== 'bootstrap-tagsinput') {
            e.preventDefault();
            console.error("ENTER-KEY PREVENTED ON NON-TEXTAREA ELEMENTS");
        }
    }
});

$(document).ready(function () {
    $('.preventSubmit').on('submit', function (e) {
        e.preventDefault();
    });

    $('.datepicker').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
        todayBtn: "linked",
        clearBtn: true,
        todayHighlight: true
    });

    // $('.timepicker').timepicker({
    // 	showInputs: false
    // });

    $("input[data-bootstrap-switch]").each(function () {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
});

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
};

$(document).on("click", ".btn-modal-cancel", function (e) {
    e.preventDefault();
    kinet.modal.close();
    //closeModal("dynamicModal");
});

var kinet = {
    admin_ajax: baseurl + 'rest/admin_ajax',
    common: {
        numericFormat: $.fn.dataTable.render.number('.', ',', 0).display, // kinet.common.numericFormat(0.toFixed(2))
        blankString: '',
        // https://www.sitepoint.com/get-url-parameters-with-javascript/
        getQueryString: function (param) {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const qString = urlParams.get(param);
            return qString;
        },
        implode: function (arrToJoin, separatedWith) {
            return arrToJoin.join(separatedWith);
        },
        explode: function (stringToSplit, separatedWith) {
            return stringToSplit.split(separatedWith);
        },
        findInJson: function (src, val) {
            return src.some(item => _.some(src, val));
        },
        currentUser: {
            userNumber: $('#hidUserNumber').val(),
            userName: $('#hidUserName').val(),
            userPass: $('#hidUserPass').val(),
            roleList: $('#hidUserRoleList').val(),
            today: $('#hidToday').val()
        },
    },
    dtTables: {
        summarized: {
            render: function (api, colsToSum, intVal) {
                var me = dip.grid.summarized;
                var total = 0; // Total over all pages
                var totalPerPage = 0; // Total over this page
                var idx = 0;

                if (Array.isArray(colsToSum)) {
                    for (idx = 0; idx < colsToSum.length; idx++) {
                        total = me.getTotal(api, colsToSum[idx], intVal);
                        totalPerPage = me.getPageTotal(api, colsToSum[idx], intVal);
                        me.renderFooter(api, colsToSum[idx], totalPerPage, total);
                    }
                } else {
                    total = me.getTotal(api, colsToSum, intVal);
                    totalPerPage = me.getPageTotal(api, colsToSum, intVal);
                    me.renderFooter(api, colsToSum, totalPerPage, total);
                }
            },
            getTotal: function (api, colIndex, intVal) {
                return api
                    .column(colIndex)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
            },
            getPageTotal: function (api, colIndex, intVal) {
                return api
                    .column(colIndex, {page: 'current'})
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
            },
            renderFooter: function (api, colIndex, pageTotal, total) {
                $(api.column(colIndex).footer()).html(
                    //'$' + pageTotal + ' ( $' + total + ' total)'
                    // dtTableNumericVar(pageTotal) + ' of ' + dtTableNumericVar(total) + ' total.'
                    dtTableNumericVar(pageTotal)
                    // pageTotal + 'of ( $' + total + ' total)'
                );
            }
        },
        formatter: {
            number: function (thousands, decimal, precision, prefix, postfix) {
                return $.fn.dataTable.render.number(thousands, decimal, precision, prefix, postfix);
            }
        },
        gridBodySelector: function (gridId) {
            return gridId + ' tbody';
        },
        checkBoxSelector: 'input[type="checkbox"]',
        selectAllId: '#select_all',
        hideCustomButton: function (el) {
            $(el + "_wrapper .dt-buttons").hide();
        },
        generateTopButton: {
            onRight: function () {
                $(".dataTables_wrapper div.dt-buttons").addClass("pull-right").css({"position": "initial"});
            },
            onLeft: function () {
                $(".dataTables_wrapper div.dt-buttons").css({"position": "initial"});
            }
        },
        getData: function (el) {
            var tbl = $(el).DataTable();
            return tbl.rows().data();
        },
        getDataLength: function (el) {
            var tbl = $(el).DataTable();
            return tbl.rows().data().length;
        },
        getRowData: function (el, obj) {
            var tbl = $(el).DataTable();
            return tbl.row(obj.parents('tr')).data();
        },
        getRowIndex: function (el, obj) {
            var tbl = $(el).DataTable();
            return tbl.row(obj.parents('tr')).index();

        },
        onWindowResize: function (el) {
            var table = el.DataTable();
            table.columns.adjust().draw();
        },
        dtTableNumeric: function (thousands, decimal, precision, prefix, postfix) {
            return $.fn.dataTable.render.number(thousands, decimal, precision, prefix, postfix);
        },
    },
    window: {
        open: function (uri, target) {
            if (typeof target !== 'undefined') {
                window.open(url, target);
            } else {
                window.location.href = uri;
            }
        },

    },
    modal: {
        container: '#kinetModal',
        close: function () {
            $(kinet.modal.container).modal('hide');
        },
        show: function (url, title, postData, element) {
            element = ((element === "") || (element === null)) ? contentWrapper : element;
            if (postData) {
                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "html",
                    //contentType: "application/json; charset=utf-8",
                    data: postData,
                    headers: {
                        "Content-Type": "application/json"
                    },
                    beforeSend: function () {
                        $(element).LoadingOverlay("show", {
                            image: '',
                            background: "rgba(255, 255, 255, 0.2)",
                            size: "60",
                            maxSize: "60",
                            minSize: "50",
                            fontawesome: 'fa fa-refresh fa-spin'
                        });
                    },
                    complete: function (e) {
                        $(element).LoadingOverlay("hide", true);
                    },
                    // error: function (xhr, ajaxOptions, thrownError) {
                    // 	switch (xhr.status) {
                    // 		case 404:
                    // 			dipNotification.show("The page you requested not found.", "error", "");
                    // 			break;
                    // 		case 400:
                    // 			dipNotification.show("Bad Request. Check your parameter request.", "error", "");
                    // 			break;
                    // 		case 403:
                    // 			dipNotification.show("You don't have authorization to access requested page.", "error", "");
                    // 			break;
                    // 		case 500:
                    // 			dipNotification.show("Internal server error. Please check the requested page.", "error", "");
                    // 			break;
                    //
                    // 	}
                    // 	return false;
                    // },
                    success: function (html) {
                        $(kinet.modal.container + ' .modal-title').text(title);
                        $(kinet.modal.container + ' .modal-body').html(html);
                        $(kinet.modal.container).modal({backdrop: true});
                        $(kinet.modal.container).draggable({handle: ".modal-header"});
                    }
                });
            } else {
                $.ajax({
                    url: url,
                    success: function (html) {
                        $(kinet.modal.container + ' .modal-title').text(title);
                        $(kinet.modal.container + ' .modal-body').html(html);
                        $(kinet.modal.container).modal('show', {
                            backdrop: 'static',
                            keyboard: false
                        });
                    }
                });
            }
        },
        width: function (w) {
            $(kinet.modal.container).on('shown.bs.modal', function () {
                if (w == -1) {
                    $(this).find('.modal-dialog').css({
                        width: '100%', //probably not needed
                        height: 'auto', //probably not needed
                        'max-height': '100%'
                    });
                } else {
                    $(this).find('.modal-dialog').css({
                        width: w + 'px !important', //probably not needed
                        height: 'auto', //probably not needed
                        'max-height': '100%'
                    });
                    $(this).find('.modal-dialog').attr('style', function (i, s) {
                        return (s || '') + 'width: ' + w + 'px !important;';
                    });
                    //$(this).find('.modal-dialog').attr('style','width')
                }
            });
        },
    },
    message: {
        success: 'success',
        error: 'error',
        deleteConfirmation: 'Are you sure want to delete this record ?',
        deleted: function (msg) {
            if (typeof msg !== 'undefined') {
                return msg + ' has been deleted.';
            } else {
                return 'Data has been deleted.';
            }
        },
        updated: function (msg) {
            if (typeof msg !== 'undefined') {
                return msg + ' has been updated.';
            } else {
                return 'Data has been updated.';
            }
        },
        saved: function (msg) {
            if (typeof msg !== 'undefined') {
                return msg + ' has been saved.';
            } else {
                return 'Data has been saved.';
            }
        },
        failSave: function (msg) {
            if (typeof msg !== 'undefined') {
                return msg + ': Oops. can\'t save data.<br/>Please contact your Administrator';
            } else {
                return 'Oops. can\'t save data.<br/>Please contact your Administrator';
            }
        },
        fail: function (msg) {
            if (typeof msg !== 'undefined') {
                return msg + ': Oops. Error occurred during processing data.<br/>Please contact your Administrator';
            } else {
                return ': Oops. Error occurred during processing data.<br/>Please contact your Administrator';
            }
        }
    },
    dialog: {
        custom: function (msg, acceptText, acceptCallback, acceptParam, rejectText, rejectCallback, rejectParam) {
            let dialogBox = new Noty({
                text: msg,
                dismissQueue: true,
                layout: 'center',
                closeWith: ['button'],
                modal: true,
                theme: 'metroui',
                callback: {
                    onCloseClick: function () {
                        dialogBox.close();
                        // callbackCancel(param);
                    },
                },
                buttons: [
                    Noty.button(acceptText, 'btn btn-success', function () {
                        acceptCallback(acceptParam);
                        dialogBox.close();
                    }, {
                        id: 'btnDialogOk',
                        'data-status': 'ok',
                        'style': 'margin-right: 5px;'
                    }),
                    Noty.button(rejectText, 'btn btn-danger', function () {
                        if ((typeof rejectCallback !== 'undefined') && (typeof rejectParam !== 'undefined')) {
                            rejectCallback(rejectParam);
                        } else if ((typeof rejectCallback !== 'undefined') && (typeof rejectParam === 'undefined')) {
                            rejectCallback();
                        } else if ((typeof rejectCallback === 'undefined') && (typeof rejectParam === 'undefined')) {
                        }
                        dialogBox.close();
                    }, {
                        id: 'btnDialogCancel',
                        'data-status': 'cancel'
                    })
                ]
            });
            dialogBox.show();
        },
        okCancel: function (msg, callback, param) {
            let dialogBox = new Noty({
                text: msg,
                dismissQueue: true,
                layout: 'center',
                closeWith: ['button'],
                modal: true,
                theme: 'metroui',
                callback: {
                    onCloseClick: function () {
                        dialogBox.close();
                    },
                },
                buttons: [
                    Noty.button('OK', 'btn btn-success', function () {
                        console.log(typeof callback);
                        console.log(typeof param);
                        if (typeof callback !== 'undefined' && typeof param !== 'undefined') {
                            console.log('Masuk Sini');
                            callback(param);
                        } else if (typeof callback !== 'undefined' && typeof param === 'undefined') {
                            console.log('Masuk Sana');
                            callback();
                        } else if (typeof callback === 'undefined' && typeof param === 'undefined') {

                        }
                        dialogBox.close();
                    }, {
                        id: 'btnDialogOk',
                        'data-status': 'ok',
                        'style': 'margin-right: 5px;'
                    }),
                    Noty.button('Cancel', 'btn btn-danger', function () {
                        dialogBox.close();
                    }, {
                        id: 'btnDialogCancel',
                        'data-status': 'cancel'
                    })
                ]
            });
            dialogBox.show();
        },
        yesNo: function (msg, callback, param, redirectTo) {
            let dialogBox = new Noty({
                text: msg,
                dismissQueue: true,
                layout: 'center',
                closeWith: ['button'],
                modal: true,
                theme: 'metroui',
                callback: {
                    onCloseClick: function () {
                        dialogBox.close();
                    },
                },
                buttons: [
                    Noty.button('Yes', 'btn btn-success', function () {
                        if (typeof callback !== 'undefined' && typeof param !== 'undefined') {
                            console.log('Masuk Sini');
                            callback(param);
                        } else if (typeof callback !== 'undefined' && typeof param === 'undefined') {
                            console.log('Masuk Sana');
                            callback();
                        } else if (typeof callback === 'undefined' && typeof param === 'undefined') {

                        }


                        dialogBox.close();
                    }, {
                        id: 'btnDialogOk',
                        'data-status': 'ok',
                        'style': 'margin-right: 5px;'
                    }),
                    Noty.button('No', 'btn btn-danger', function () {
                        if (typeof redirectTo !== 'undefined') {
                            window.location.href = redirectTo;
                        }
                        dialogBox.close();
                    }, {
                        id: 'btnDialogCancel',
                        'data-status': 'cancel'
                    })
                ]
            });
            dialogBox.show();
        }
    },
    notification: {
        showInvalidField: function () {
            let optionsDefault = {
                type: 'error',
                text: 'Please enter Required value',
                layout: 'topRight',
                timeout: 500,
                closeWith: ['click', 'timeout'],
                progressBar: true,
                modal: true,
                theme: 'metroui'
            };
            new Noty(optionsDefault).show();
        },
        show: function (msg, type, redirect) {
            const optionsDefault = {
                type: type,
                text: msg,
                layout: 'topRight',
                timeout: 3000,
                closeWith: ['click', 'timeout'],
                progressBar: true,
                modal: true,
                theme: 'bootstrap-v4'
            };
            new Noty(optionsDefault).show();
            if (redirect != '') {
                setTimeout(function () {
                    window.location.href = redirect;
                }, 3000);
            }
        }
    },
    ajax: {
        statusCode: {
            400: function () {
                console.log("Error 400", "BadRequest.");
            }, 404: function () {
                console.log("Error 404", "Page Not Found.");
            }, 500: function () {
                console.log("Error 500", "Internal Server Error.");
            }, 505: function () {
                console.log("Error 505", "Internal Server Error.");
            }, 403: function () {
                console.log("Error 403", "Forbidden.");
            }
        },
        postSerialize: function (destination, data, element) {
            var that = kinet;
            if (element === "") {
                element = "#content-wrapper";
            }

            console.log(JSON.stringify(data));
            console.log(data);

            // data: JSON.stringify(data),
            return $.ajax({
                url: destination,
                method: "POST",
                contentType: "application/json; charset=utf-8",
                data: data,
                cache: false,
                dataType: "json",
                statusCode: kinet.ajax.statusCode,
                beforeSend: function () {
                    $(element).LoadingOverlay("show", {
                        image: '',
                        background: "rgba(255, 255, 255, 0.2)",
                        size: "60",
                        maxSize: "60",
                        minSize: "50",
                        fontawesome: 'fa fa-refresh fa-spin'
                    });
                },
                complete: function (e) {
                    $(element).LoadingOverlay("hide", true);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    switch (xhr.status) {
                        case 404:
                            kinet.notification.show("The page you requested not found.", "error", "");
                            break;
                        case 400:
                            kinet.notification.show("Bad Request. Check your parameter request.", "error", "");
                            break;
                        case 403:
                            kinet.notification.show("You don't have authorization to access requested page.", "error", "");
                            break;
                        case 500:
                            kinet.notification.show("Internal server error. Please check the requested page. <br/> Error details: " + xhr.responseText, "error", "");
                            break;

                    }
                    return false;
                }
            });
        },
        post: function (destination, data, element) {
            if (element === "" || typeof element === 'undefined') {
                element = "#floki_container";
            }

            return $.ajax({
                url: destination,
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                // contentType: 'application/json; charset=UTF-8',
                dataType: 'json',
                method: 'post',
                data: data,
                statusCode: kinet.ajax.statusCode,
                beforeSend: function () {
                    $(element).LoadingOverlay("show", {
                        image: '',
                        background: "rgba(255, 255, 255, 0.2)",
                        size: "60",
                        maxSize: "60",
                        minSize: "50",
                        fontawesome: 'fa fa-refresh fa-spin'
                    });
                },
                complete: function (e) {
                    $(element).LoadingOverlay("hide", true);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    switch (xhr.status) {
                        case 404:
                            kinet.notification.show("The page you requested not found.", "error", "");
                            break;
                        case 400:
                            kinet.notification.show("Bad Request. Check your parameter request.", "error", "");
                            break;
                        case 403:
                            kinet.notification.show("You don't have authorization to access requested page.", "error", "");
                            break;
                        case 500:
                            kinet.notification.show("Internal server error. Please check the requested page. <br/> Error details: " + xhr.responseText, "error", "");
                            break;

                    }
                    return false;
                }
            });
        }
    },
    mo: {
        recalculatePayment: function () {
            var total = formField.getVal('txt_total');
            var payment = formField.getVal('txt_dp');
            var change = eval(total) - (eval(payment) + eval(formField.getVal('txt_current_dp')));
            var changeDisplay = kinet.common.numericFormat(change);
            formField.setVal('txt_balance_display', changeDisplay)
            formField.setVal('txt_balance', change)
        },
        recalculateCartSummary: function (detailOrder) {
            var total = 0;
            var extraTotal = 0;
            var estimateDay = 0;
            $.each(detailOrder, function (idx, value) {
                estimateDay = estimateDay + value.estimate_day;
                total = total + value.typeprice;
                var detailExtra = detailOrder[idx].order_extra;
                if (detailExtra.length > 0) {
                    for (var i = 0; i < detailExtra.length; i++) {
                        extraTotal = extraTotal + detailExtra[i].typeprice;
                        estimateDay = estimateDay + detailExtra[i].estimate_day;
                    }
                }
            });

            var cart = {
                grandTotal: total + extraTotal,
                total: total,
                extraTotal: extraTotal,
                estimateDay: estimateDay,
                dataCollection: detailOrder
            }
            return cart;
        },
        recalculateCart: function (result) {
            var output = '';
            var counter = 1;
            var detailOrder = result.order_detail;
            var total = 0;
            var extraTotal = 0;
            var estimateDay = 0;
            $.each(detailOrder, function (idx, value) {
                estimateDay = eval(estimateDay) + eval(value.estimate_day);
                total = eval(total) + eval(value.typeprice);
                output += '<tr>';
                output += '<td>' + counter + '</td>';
                output += '<td>';
                output += value.item_name;
                var desc = [];
                if (value.size !== "") {
                    desc[0] = "<strong>Size</strong>: " + value.size;
                }
                if (value.color_tali !== "") {
                    desc[1] = "<strong>Shoelaces</strong>: " + value.color_tali;
                }
                if (value.color_insole !== "") {
                    desc[2] = "<strong>Insole</strong>: " + value.color_insole;
                }
                if (desc.length > 0) output += "<br/>";
                output += desc.join(", ");

                output += '</td>';
                output += '<td>' + value.typename + '</td>';
                output += '<td style="text-align: right;">' + kinet.common.numericFormat(value.typeprice) + '</td>';
                output += '<td style="text-align: center;">';
                output += '<a href="javascript:void(0)" class="btn_add_detail_extra btn btn-info btn-sm" data-headerid="' + value.header_id + '" data-id="' + value.id + '">Add Extra</a> ';
                if (value.work_status === "0") {
                    output += '<a href="javascript:void(0)" data-serviceid="' + value.service_id + '" class="btn_detail_done btn btn-success btn-sm" data-headerid="' + value.header_id + '" data-id="' + value.id + '">Done</a> ';

                } else if (value.work_status === "1") {
                    output += '<a href="javascript:void(0)" data-serviceid="' + value.service_id + '" class="btn_detail_taked btn btn-success btn-sm" data-headerid="' + value.header_id + '" data-id="' + value.id + '">Taken</a> ';

                } else if (value.work_status === "2") {
                    output += '<a href="javascript:void(0)" data-serviceid="' + value.service_id + '" class="btn_detail_reverttake btn btn-success btn-sm" data-headerid="' + value.header_id + '" data-id="' + value.id + '">' + moment(value.pickup_date).format('L') + '</a> ';
                }
                output += '<a href="javascript:void(0)" data-serviceid="' + value.service_id + '" class="btn_delete_order_detail btn btn-danger btn-sm" data-headerid="' + value.header_id + '" data-id="' + value.id + '">Delete</a>';
                output += '</td>';
                output += '</tr>';
                var detailExtra = detailOrder[idx].order_extra;
                if (detailExtra.length > 0) {
                    output += '<tr>';
                    output += '<td colspan="5" class="table_extra_container">';
                    output += '<div class="order_extra">';
                    output += '<table class="table_order_extra table table-head-fixed text-nowrap">';
                    output += '<thead>';
                    output += '<tr>';
                    output += '<th  style="text-align: center;">No</th>';
                    output += '<th  style="text-align: center;">Service Name</th>';
                    output += '<th  style="text-align: center;">Service Price</th>';
                    output += '<th  style="text-align: center;">Action</th>';
                    output += '</tr>';
                    output += '</thead>';
                    output += '<tbody>';

                    var iCounter = 1;
                    for (var i = 0; i < detailExtra.length; i++) {
                        extraTotal = eval(extraTotal) + eval(detailExtra[i].typeprice);
                        estimateDay = eval(estimateDay) + eval(detailExtra[i].estimate_day);
                        output += '<tr>';
                        output += '<td>' + iCounter + '</td>';
                        output += '<td>' + detailExtra[i].typename + '</td>';
                        output += '<td style="text-align: right;">' + kinet.common.numericFormat(detailExtra[i].typeprice) + '</td>';
                        output += '<td style="text-align: center;">';
                        output += '<a href="javascript:void(0)" data-serviceid="' + detailExtra[i].service_id + '" class="btn_delete_order_detail_extra btn btn-danger btn-sm" data-id="' + detailExtra[i].id + '" data-detailid="' + detailExtra[i].detail_id + '">Delete<a/>';
                        output += '</td>';
                        output += '</tr>';
                        iCounter++;
                    }
                    output += '</tbody>';
                    output += '</table>';
                    output += '</div>';
                    output += '</td>';
                    output += '</tr>';
                }
                counter++;
            });

            var cart = {
                outputHtml: output,
                grandTotal: total + extraTotal,
                total: total,
                extraTotal: extraTotal,
                estimateDay: estimateDay,
                dataCollection: detailOrder
            };
            return cart;
        }
    }
};


function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

$(document).off('click', '#btn_search');
$(document).on('click', '#btn_search', function () {
    var that = vmService;
    vmService.do_search();
});

$(document).off('click', '#btn_search_clear');
$(document).on('click', '#btn_search_clear', function () {
    formField.clearAll($('#frm_filter'))
    var that = vmService;
    vmService.do_search();
});

$(document).off('click', '.delete_service');
$(document).on('click', '.delete_service', function () {
    var data = $(this).info();
    kinet.dialog.yesNo(kinet.message.deleteConfirmation, vmService.do_delete, data);
});

$(document).on('click', '#btn_new_service', function () {
    kinet.window.open(pageBaseUrl + '/add');
});

let vmService = {
    page: {
        basePage: baseurl + 'administration/'
    },
    do_delete: function (data) {
        $.when(kinet.ajax.post(vmService.page.basePage + 'service/delete/' + data.id, data, '')).done(function (result) {
            if (result.message === kinet.message.success) {
                kinet.notification.show(kinet.message.deleted('Service'), result.message, vmService.page.basePage + 'service');
            } else {
                kinet.notification.show(result.message_details,
                        result.message, kinet.blankString);
                return false;
            }
        });
    },
    do_search: function () {
        $('#gridService').DataTable().draw(true);
    },
    grid: {
        init: function () {
            var table;
            table = $('#gridService').DataTable({
                "pagingType": "full_numbers",
                "processing": true,
                "scrollX": true,
                "filter": false,
                "serverSide": true,
                "lengthChange": false,
                "destroy": true,
                "autowidth": false,
                "responsive": true,
                //"dom" : "Bfrtip",
                "order": [],

                "ajax": {
                    "url": gridApiUrl,
                    "type": "POST",
                    'data': function (data) {
                        // Read values
                        var name = formField.getVal('searchName');

                        // Append to data
                        data.searchByName = name;
                    }
                },

                "columnDefs": [
                    {
                        "targets": [0, 1],
                        "orderable": false,
                    }, {
                        "targets": [3],
                        "className": 'dt-body-right',
                        "render": kinet.dtTables.dtTableNumeric('.', ',', 0)
                    },
                ],

            });
            return table;
        }
    }
};


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
}

$(document).ready(function () {
    var that = vmService;
    vmService.grid.init();
});

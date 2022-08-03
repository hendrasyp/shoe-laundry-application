$(document).off('click', '#btn_search');
$(document).on('click', '#btn_search', function () {
    var that = vmCompany;
    vmCompany.do_search();
});

$(document).off('click', '#btn_search_clear');
$(document).on('click', '#btn_search_clear', function () {
    formField.clearAll($('#frm_user_filter'))
    var that = vmCompany;
    vmCompany.do_search();
});

$(document).on('click', '.delete_branch', function () {
    var data = $(this).info();
    $.when(kinet.ajax.post(vmCompany.page.basePage + 'company/delete/' + data.id, data, '')).done(function (result) {
        if (result.message === kinet.message.success) {
            kinet.notification.show('User berhasil dihapus.',
                    result.message, vmCompany.page.basePage + 'user');
        } else {
            kinet.notification.show(result.message_details,
                    result.message, kinet.blankString);
            return false;
        }
        // console.log(result);
        // console.log(JSON.parse(result.X));
    });
});

$(document).on('click', '#btn_new_branch', function () {
    kinet.window.open(pageBaseUrl + '/add');
});

let vmCompany = {
    page: {
        basePage: baseurl + 'administration/'
    },
    do_search: function () {
        $('#gridBranch').DataTable().draw(true);
    },
    grid: {
        init: function () {
            var table;
            table = $('#gridBranch').DataTable({
                "pagingType": "full_numbers",
                "processing": true,
                "scrollX": true,
                "filter": false,
                "serverSide": true,
                "lengthChange": false,
                "destroy": true,
                "autowidth": true,
                "responsive": true,
                //"dom" : "Bfrtip",
                "order": [],

                "ajax": {
                    "url": gridApiUrl,
                    "type": "POST",
                    'data': function (data) {
                        // Read values
                        var name = formField.getVal('searchBranchName');
                        var phone = formField.getVal('searchPhone');
                        var address = formField.getVal('searchAddress');
                        var email = formField.getVal('searchEmails');

                        // Append to data
                        data.searchByName = name;
                        data.searchByPhone = phone;
                        data.searchByAddress = address;
                        data.searchByEmail = email;
                    }
                },

                "columnDefs": [
                    {
                        "targets": [0, 1, 3, 4, 7],
                        "orderable": false,
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
    var that = vmCompany;
    vmCompany.grid.init();
});

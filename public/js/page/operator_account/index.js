var g_user_table = undefined;
var password = undefined;
var id_new = undefined;
$(document).ready(function () {
    searchOperatorAccount();

    //update user
    $('.updateOperatorAccount').on('click', function () {
        var user_id = $('#editOperatorAccount').find('[name="id"]').val();

        //prepare data
        var formData = new FormData();
        formData.append('email', $('#editOperatorAccount').find('[name="email"]').val());
        formData.append('password', $('#editOperatorAccount').find('[name="password"]').val());
        formData.append('full_name', $('#editOperatorAccount').find('[name="full_name"]').val());
        formData.append('phone', $('#editOperatorAccount').find('[name="phone"]').val());
        formData.append('address', $('#editOperatorAccount').find('[name="address"]').val());
        formData.append('memo', $('#editOperatorAccount').find('[name="memo"]').val());
        formData.append('avatar', $("#update_avatar")[0].files[0]);
        formData.append('status', $('#editOperatorAccount').find('[name="status"]').val());
        formData.append('role', $('#editOperatorAccount').find('[name="role_id"]').val());
        // formData.append('class_id', $('#editOperatorAccount').find('[name="class_name"]').val());


        if (user_id != undefined) {
            //update user
            formData.append('id', $('#editOperatorAccount').find('[name="id"]').val());
            updateOperatorAccount(formData)

        }
        // else {
        //     createNewOperatorAccount(formData);
        // }

    });

    //delete operator
    $('.destroy').on('click', function () {

        //prepare data
        var id = $('#deleteOperatorAccount').find('[name="id"]').val();
        //delete category
        destroyOperator(id)
    });
    $('.cancel').on('click', function () {

        operator_account_table_reload();
    });
    $('.generateClass').on('click', function () {
        var formData = new FormData();
        var class_name = $('#createClass').find('[name="class_name"]').val();
        var full_name = $('#createClass').find('[name="full_name"]').val();

        if (class_name != undefined && class_name != "") {
            $("#createClassError").hide();

            $('#btn_generate').hide();

            password = makePassword();
            var max_id = "room" + $('#createClass').find('[name="max_id"]').val();

            formData.append('class_name', $('#createClass').find('[name="class_name"]').val());
            formData.append('login_id', max_id);
            formData.append('password', password);
            formData.append('role', 2);

            if (full_name != undefined && full_name != "") {
                formData.append('full_name', $('#createClass').find('[name="full_name"]').val());
                createNewOperatorAccount(formData)
            } else {
                $("#createClassErrorFullName").show();
                $("#createClassErrorFullName").html(
                    '<div class="alert alert-danger">' +
                    '<button class="close" data-close="alert"></button>' +
                    'Please Input Admin Name' + '<br>'
                    + '</div>'
                )
            }
        } else {
            $("#createClassError").show();
            $("#createClassError").html(
                '<div class="alert alert-danger">' +
                '<button class="close" data-close="alert"></button>' +
                'Please Input Class Name' + '<br>'
                + '</div>'
            )
        }


    });
    $('.createClass').on('click', function () {
        $('#btn_generate').show();
        $('#generate_class').hide();
        $('#createClass').find('[name="class_name"]').val("");
        $('#createClass').find('[name="full_name"]').val("");

    });
});

function destroyOperator(id) {
    var data = {'id': id};
    $.ajax({
        url: SITE_ROOT + '/user_admin/delete_operator',
        data: data,
        method: 'POST',

        success: function (response) {
            //hidden modal
            if (response == "1") {
                $('#deleteOperatorAccount').modal('hide');
                operator_account_table_reload();
            }

        },
        error: function (response) {
            jQuery.each(response.responseJSON, function (i, error) {
                $("#deleteOperatorAccountError").html(
                    '<div class="alert alert-danger">' +
                    '<button class="close" data-close="alert"></button>' +
                    error[0] + '<br>'
                    + '</div>'
                )
            });
        }
    });

}

function searchOperatorAccount() {

    g_user_table = $('#operator-account-list-table').dataTable({
        "sDom": "<'row'<'col-sm-6' i><'col-sm-6' >r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        'bProcessing': true,
        'bServerSide': true,
        "bDestroy": true,
        "bAutoWidth": false,
        'sAjaxSource': SITE_ROOT + '/user_admin/load_datatable',
        'fnServerData': function (sSource, aoData, fnCallback, oSettings) {
            aoData.push({
                "name": "class_name",
                "value": $('#class_search').val()
            }, {
                "name": "status",
                "value": $('#status').val()
            });
            oSettings.jqXHR = $.ajax({
                'dataType': 'json',
                'type': 'POST',
                'url': sSource,
                'data': aoData,
                'success': fnCallback
            });
        },
        "iDisplayLength": parseInt($('[name="record-display"]').val()),
        'aoColumns': [
            {
                'mData': function () {
                    return '';
                },
                // Render operation action.
                'sClass': 'text-center',
                'mRender': function (data, type, full) {
                    var html = '';
                    if (full.login_id != null) {
                        html += full.login_id;
                    } else {
                        html += 'None';
                    }

                    return html;
                },
                'bSortable': false
            }, {
                'mData': function () {
                    return '';
                },
                // Render operation action.
                'sClass': 'text-center',
                'mRender': function (data, type, full) {
                    var html = '';
                    if (full.class_name != null) {
                        html += full.class_name;
                    } else {
                        html += 'None';
                    }

                    return html;
                },
                'bSortable': false
            }, {
                'mData': function () {
                    return '';
                },
                // Render operation action.
                'sClass': 'text-center',
                'mRender': function (data, type, full) {
                    var html = '';
                    if (full.admin_name != null) {
                        html += full.admin_name;
                    } else {
                        html += 'None';
                    }

                    return html;
                },
                'bSortable': false
            }, {
                'mData': function () {
                    return '';
                },
                // Render operation action.
                'sClass': 'text-center',
                'mRender': function (data, type, full) {
                    var html = '';
                    if (full.users != null) {
                        html += full.users;
                    } else {
                        html += 'None';
                    }

                    return html;
                },
                'bSortable': false
            }, {
                'mData': function () {
                    return '';
                },
                // Render operation action.
                'sClass': 'text-center',
                'mRender': function (data, type, full) {
                    var html = '';
                    html += full.created_at;

                    return html;
                },
                'bSortable': false
            }, {
                'mData': function () {
                    return '';
                },
                // Render operation action.
                'sClass': 'text-center',
                'mRender': function (data, type, full) {
                    var html = '';
                    if (full.status == 0) {
                        html += '<button type="button" class="btn btn-sm red">InActive</button>';
                    } else if (full.status == 1) {
                        html += '<button type="button" class="btn btn-sm green">Active</button>';
                    }
                    return html;
                },
                'bSortable': false
            }, {
                'bSortable': false,
                'mData': function () {
                    return '';
                },
                // Render operation action.
                'sClass': 'text-center',
                'mRender': function (data, type, full) {
                    var html = '';
                    html += '<button type="button" onclick="getdata_edit_operator_account(' + full.id + ');" class="btn btn-sm purple"><i class="fa fa-edit"></i></button>';
                    html += '<button type="button" onclick="delete_operator(' + full.id + ');" class="btn btn-sm red"><i class="fa fa-trash-o"></i></button>';
                    return html;
                }
            }]
    });
}

function getdata_edit_operator_account(id) {
    $('#editOperatorAccountError').empty('');

    var find = $('#editOperatorAccount');
    if (id != undefined) {
        $.ajax({
            url: SITE_ROOT + '/user_admin/' + id,
            method: 'GET'
        }).success(function (response) {
            // Populate the form fields with the data returned from server
            find
                .find('[name="id"]').val(response.id).end()
                .find('[name="password"]').val(response.password).end()
                .find('[name="status"]').val(response.status).end()
                .find('[name="email"]').val(response.email).end()
                .find('[name="phone"]').val(response.admin_profile.phone).end()
                .find('[name="address"]').val(response.admin_profile.address).end()
                .find('[name="memo"]').val(response.admin_profile.memo).end()
                .find('[name="last_login_time"]').val(response.last_login).end()
                .find('[name="class_name"]').val(response.class_id).end()
                .find('[name="role_id"]').attr('selected', response.role[0].display_name);

            check_status_change = response.status;
            $('#img_avatar').attr('src', response.admin_profile.avatar);
            $('#editUserFullName').val(response.admin_profile.full_name);

            //show modal
            find.modal('show');
        });
    } else {
        //show modal
        find.modal('show');
    }
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img_avatar').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function updateOperatorAccount(data) {
    $.ajax({
        url: SITE_ROOT + '/user_admin/update',
        data: data,
        method: 'POST',
        processData: false,
        contentType: false,

        success: function (response) {
            //hidden modal
            if (response == "1") {
                $("#editOperatorAccountError").html(
                    '<div class="alert alert-danger">' +
                    '<button class="close" data-close="alert"></button>' +
                    "This class is managed by other User " + '<br>'
                    + '</div>'
                )
            } else {
                $('#editOperatorAccount').modal('hide');
                operator_account_table_reload();
            }

        },
        error: function (response) {
            jQuery.each(response.responseJSON, function (i, error) {
                $("#editOperatorAccountError").html(
                    '<div class="alert alert-danger">' +
                    '<button class="close" data-close="alert"></button>' +
                    error[0] + '<br>'
                    + '</div>'
                )
            });
        }
    });
}
function operator_account_table_reload() {
    if (g_user_table != undefined) {
        g_user_table.fnReloadAjax();
    }
}
function operator_account_table_update_params() {
    if (g_user_table != undefined) {
        g_user_table.fnDestroy();
        searchOperatorAccount();
    }
}
function delete_operator(id) {
    var find = $('#deleteOperatorAccount');

    find.find('[name="id"]').val(id).end();
    find.modal('show');
}
function create_class() {

    $('#btn_generate').show();
    $('#generate_class').hide();

    $('#createClassError').empty('');
    $('#createClassErrorFullName').empty('');

    var find = $('#createClass');
    find.find('[name="class_name"]').val('');
    find.find('[name="full_name"]').val('');
    find.modal('show');
}
function createNewOperatorAccount(data) {
    // $('#editOperatorAccountError').empty('');
    $('#createClassError').empty('');
    $('#createClassErrorFullName').empty('');

    $.ajax({
        url: SITE_ROOT + '/user_admin/create_operator_account',
        data: data,
        method: 'POST',
        processData: false,
        contentType: false,

        success: function (response) {
            // if (response != "1") {
            //     jQuery.each(response.responseJSON, function (i, error) {
            //         $("#createClassError").html(
            //             '<div class="alert alert-danger">' +
            //             '<button class="close" data-close="alert"></button>' +
            //             error[0] + '<br>'
            //             + '</div>'
            //         )
            //     });
            // } else {
            $('#td_password').html(password);
            $('#td_class_name').html(response.login_id);
            $('#createClass').find('[name="max_id"]').val(response.max_id)
            $('#generate_class').show();
            // window.location.href = SITE_ROOT + '/user_admin/index';
            // }
        },
        error: function (response) {
            jQuery.each(response.responseJSON, function (i, error) {
                $("#createClassError").html(
                    '<div class="alert alert-danger">' +
                    '<button class="close" data-close="alert"></button>' +
                    error[0] + '<br>'
                    + '</div>'
                )
            });
        }
    });
}
function makePassword() {
    var text = "";
    var possible = "abcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < 8; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

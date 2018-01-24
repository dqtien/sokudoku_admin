/**
 * Created by Vu Hai on 1/15/2017.
 */

var g_user_table = undefined;
var check_status_change = undefined;
var password = undefined;
$(document).ready(function () {
    searchUser();
    $('#editUser').on('hidden.bs.modal', function () {
        //clear form
        $('#editUserError').empty('');
    });

    $('.cancel').on('click', function () {

        user_table_reload();
    });
    //update user
    $('.updateUser').on('click', function () {
        var user_id = $('#editUser').find('[name="id"]').val();

        //prepare data
        var formData = new FormData();
        formData.append('email', $('#editUser').find('[name="email"]').val());
        formData.append('password', $('#editUser').find('[name="password"]').val());
        formData.append('full_name', $('#editUser').find('[name="full_name"]').val());
        formData.append('status', $('#editUser').find('[name="status"]').val());
        formData.append('phone', $('#editUser').find('[name="phone"]').val());
        formData.append('address', $('#editUser').find('[name="address"]').val());
        formData.append('memo', $('#editUser').find('[name="memo"]').val());
        formData.append('avatar', $("#update_avatar")[0].files[0]);
        formData.append('class_id', $('#editUser').find('[name="class_name"]').val());


        if (user_id != undefined) {
            formData.append('id', $('#editUser').find('[name="id"]').val());
            updateUser(formData)
        }
        // else {
        //     createNewUser(formData);
        // }

    });
    //delete user
    $('.destroy').on('click', function () {

        //prepare data
        var id = $('#deleteUser').find('[name="id"]').val();
        //delete category
        destroyUser(id)
    });

    $('.generateClassUser').on('click', function () {
        var user_name = $('#createClassUser').find('[name="user_name"]').val();
        if (user_name != undefined && user_name != "") {
            $("#createClassUserError").hide();

            $('#btn_generate').hide();

            password = makePassword();
            var max_id = "0000" + $('#createClassUser').find('[name="max_id"]').val();
            //
            var formData = new FormData();
            formData.append('user_name', $('#createClassUser').find('[name="user_name"]').val());
            formData.append('login_id', max_id);
            formData.append('password', password);
            formData.append('class_id', $('#createClassUser').find('[name="class_name"]').val());
            createNewUser(formData);
        } else {
            $("#createClassUserError").show();
            $("#createClassUserError").html(
                '<div class="alert alert-danger">' +
                '<button class="close" data-close="alert"></button>' +
                'Please Input User Name' + '<br>'
                + '</div>'
            )
        }


    });
    $('.createClassNewUser').on('click', function () {

        $('#btn_generate').show();
        $('#generate_class_user').hide();
        $('#createClassUser').find('[name="user_name"]').val("")
        $('#createClassUser').find('[name="class_name"]').val('none')
    });
});

function searchUser() {

    g_user_table = $('#user-list-table').dataTable({
            "sDom": "<'row'<'col-sm-6' i><'col-sm-6' >r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
            'bProcessing': true,
            'bServerSide': true,
            "bDestroy": true,
            "bAutoWidth": false,
            'sAjaxSource': SITE_ROOT + '/user/load_datatable',
            'fnServerData': function (sSource, aoData, fnCallback, oSettings) {
                aoData.push({
                    "name": "class_name",
                    "value": $('#class_search').val()
                }, {
                    "name": "user_name",
                    "value": $('#full_name').val()
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
                        if (full != null) {
                            html += full.user_login_id;
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
                        if (full.profile != null) {
                            if (full.profile.full_name) {
                                html += full.profile.full_name;
                            } else {
                                html += 'None';
                            }
                        }

                        return html;
                    },
                    'bSortable': false
                },
                {
                    'mData': function () {
                        return '';
                    }

                    ,
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
                    }

                    ,
                    'bSortable': false
                }
                ,
                {
                    'mData': function () {
                        return '';
                    }

                    ,
                    // Render operation action.
                    'sClass': 'text-center',
                    'mRender': function (data, type, full) {
                        var html = '';
                        html += full.created_at;

                        return html;
                    }

                    ,
                    'bSortable': false
                },
                {
                    'mData': function () {
                        return '';
                    }

                    ,
                    // Render operation action.
                    'sClass': 'text-center',
                    'mRender': function (data, type, full) {
                        var html = '';
                        if (full.last_login != null) {
                            html += full.last_login;
                        } else {
                            html += 'None';
                        }

                        return html;
                    }

                    ,
                    'bSortable': false
                }
                ,
                {
                    'mData': function () {
                        return '';
                    }

                    ,
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
                    }

                    ,
                    'bSortable': false
                }
                ,
                {
                    'bSortable': false,
                    'mData': function () {
                        return '';
                    }

                    ,
                    // Render operation action.
                    'sClass': 'text-center',
                    'mRender': function (data, type, full) {
                        var html = '';
                        html += '<button type="button" onclick="edit_user(' + full.id + ');" class="btn btn-sm purple"><i class="fa fa-edit"></i></button>';
                        html += '<button type="button" onclick="delete_user(' + full.id + ');" class="btn btn-sm red"><i class="fa fa-trash-o"></i></button>';
                        return html;
                    }
                }
            ]
        }
    )
    ;
}

function user_table_reload() {
    if (g_user_table != undefined) {
        g_user_table.fnReloadAjax();
    }
}
function user_table_update_params() {
    if (g_user_table != undefined) {
        g_user_table.fnDestroy();
        searchUser();
    }
}
function edit_user(id) {
    $('#editUserError').empty('');

    var find = $('#editUser');
    if (id != undefined) {
        $.ajax({
            url: SITE_ROOT + '/user/' + id,
            method: 'GET'
        }).success(function (response) {
            // Populate the form fields with the data returned from server
            find
                .find('[name="id"]').val(response.id).end()
                .find('[name="email"]').val(response.email).end()
                .find('[name="password"]').val(response.password).end()
                .find('[name="status"]').val(response.status).end()
                .find('[name="phone"]').val(response.profile.phone).end()
                .find('[name="address"]').val(response.profile.address).end()
                .find('[name="memo"]').val(response.profile.memo).end()
                .find('[name="class_name"]').val(response.class_id).end()
                .find('[name="last_login_time"]').val(response.last_login).end()
                .find('[name="full_name"]').val(response.profile.full_name).end();

            check_status_change = response.status;
            $('#img_avatar').attr('src', response.profile.avatar);

            //show modal
            find.modal('show');
        });
    } else {
        //show modal
        find.modal('show');
    }
}
function create_class_user() {

    $('#btn_generate').show();
    $('#generate_class_user').hide();

    $('#createClassUserError').empty('');
    var find = $('#createClassUser');
    find.find('[name="user_name"]').val('');
    find.find('[name="class_name"]').val('none');
    find.modal('show');
}
function delete_user(id) {
    var find = $('#deleteUser');

    find.find('[name="id"]').val(id).end();

    find.modal('show');
}
function updateUser(data) {
    $.ajax({
        url: SITE_ROOT + '/user/update',
        data: data,
        method: 'POST',
        processData: false,
        contentType: false,

        success: function (response) {
            //hidden modal
            $('#editUser').modal('hide');
            user_table_reload();
        },
        error: function (response) {
            jQuery.each(response.responseJSON, function (i, error) {
                $("#editUserError").html(
                    '<div class="alert alert-danger">' +
                    '<button class="close" data-close="alert"></button>' +
                    error[0] + '<br>'
                    + '</div>'
                )
            });
        }
    });
}
function createNewUser(data) {
    $.ajax({
        url: SITE_ROOT + '/user/create_user',
        data: data,
        method: 'POST',
        processData: false,
        contentType: false,

        success: function (response) {
            $('#td_password').html(password);
            $('#td_user_name').html(response.user_login_id);
            $('#createClassUser').find('[name="max_id"]').val(response.max_id);
            $('#generate_class_user').show();

            // window.location.href = SITE_ROOT + '/user/index';
        },
        error: function (response) {
            jQuery.each(response.responseJSON, function (i, error) {
                $("#editUserError").html(
                    '<div class="alert alert-danger">' +
                    '<button class="close" data-close="alert"></button>' +
                    error[0] + '<br>'
                    + '</div>'
                )
            });
        }
    });
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
function destroyUser(id) {
    var data = {'id': id};
    $.ajax({
        url: SITE_ROOT + '/user/delete_user',
        data: data,
        method: 'POST',

        success: function (response) {
            //hidden modal
            $('#deleteUser').modal('hide');
            user_table_reload();
        },
        error: function (response) {
            jQuery.each(response.responseJSON, function (i, error) {
                $("#deleteUserError").html(
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

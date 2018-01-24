/**
 * Created by Vu Hai on 1/15/2017.
 */

var g_class_table = undefined;
var check_status_change = undefined;

$(document).ready(function () {
    searchClass();
    $('#editQuestionType').on('hidden.bs.modal', function () {
        //clear form
        $('#editQuestionTypeError').empty('');
    });

    //update Question
    $('.updateClass').on('click', function () {
        //prepare data
        var formData = new FormData();

        formData.append('class_name', $('#editClass').find('[name="class_name"]').val());
        formData.append('id', $('#editClass').find('[name="id"]').val());
        updateClass(formData)


    });
    $('.createClass').on('click', function () {
        //prepare data
        var formData = new FormData();
        formData.append('class_name', $('#createClass').find('[name="class_name"]').val());
        createNewClass(formData);


    });

    //delete Question
    $('.destroy').on('click', function () {

        //prepare data
        var id = $('#deleteClass').find('[name="id"]').val();
        //delete category
        destroyClass(id)
    });
});

function create_class() {
    $('#createClassError').empty('');
    var find = $('#createClass');
    find.modal('show');
}
function searchClass() {

    g_class_table = $('#class-list-table').dataTable({
        "sDom": "<'row'<'col-sm-6' i><'col-sm-6' >r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        'bProcessing': true,
        'bServerSide': true,
        "bDestroy": true,
        'sAjaxSource': SITE_ROOT + '/class/load_datatable',
        'fnServerData': function (sSource, aoData, fnCallback, oSettings) {
            aoData.push({
                "name": "class_name",
                "value": $('#class_name').val()
            });
            oSettings.jqXHR = $.ajax({
                'dataType': 'json',
                'type': 'POST',
                'url': sSource,
                'data': aoData,
                'success': fnCallback
            });
        },
        "bAutoWidth": false,
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
                    if (full.name != null) {
                        html += full.name;
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
                    html += full.author_name;

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
                    html += full.count_user;

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
                    html += full.updated_at;

                    return html;
                },
                'bSortable': false
            }
            , {
                'bSortable': false,
                'mData': function () {
                    return '';
                },
                // Render operation action.
                'sClass': 'text-center',
                'mRender': function (data, type, full) {
                    var html = '';
                    html += '<button type="button" onclick="edit_class(' + full.id + ');" class="btn btn-sm purple"><i class="fa fa-edit"></i></button>';
                    html += '<button type="button" onclick="delete_class(' + full.id + ');" class="btn btn-sm red"><i class="fa fa-trash-o"></i></button>';
                    return html;
                }
            }
        ]
    });
}

function class_table_reload() {
    if (g_class_table != undefined) {
        g_class_table.fnReloadAjax();
    }
}
function edit_class(id) {
    $('#editClassError').empty('');

    var find = $('#editClass');
    if (id != undefined) {
        $.ajax({
            url: SITE_ROOT + '/class/' + id,
            method: 'GET'
        }).success(function (response) {
            // Populate the form fields with the data returned from server
            find
                .find('[name="id"]').val(response.id).end()
                .find('[name="class_name"]').val(response.name).end();

            //show modal
            find.modal('show');
        });
    } else {
        //show modal
        find.modal('show');
    }
}

function delete_class(id) {
    var find = $('#deleteClass');

    find.find('[name="id"]').val(id).end();

    find.modal('show');
}
function updateClass(data) {
    $.ajax({
        url: SITE_ROOT + '/class/update',
        data: data,
        method: 'POST',
        processData: false,
        contentType: false,

        success: function (response) {
            //hidden modal
            $('#editClass').modal('hide');
            class_table_reload();
        },
        error: function (response) {
            jQuery.each(response.responseJSON, function (i, error) {
                $("#editClassError").html(
                    '<div class="alert alert-danger">' +
                    '<button class="close" data-close="alert"></button>' +
                    error[0] + '<br>'
                    + '</div>'
                )
            });
        }
    });
}
function createNewClass(data) {
    $.ajax({
        url: SITE_ROOT + '/class/create_class',
        data: data,
        method: 'POST',
        processData: false,
        contentType: false,

        success: function (response) {
            window.location.href = SITE_ROOT + '/class/index';
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

function destroyClass(id) {
    var data = {'id': id};
    $.ajax({
        url: SITE_ROOT + '/class/delete_class',
        data: data,
        method: 'POST',

        success: function (response) {
            //hidden modal
            $('#deleteClass').modal('hide');
            class_table_reload();
        },
        error: function (response) {
            jQuery.each(response.responseJSON, function (i, error) {
                $("#deleteClassError").html(
                    '<div class="alert alert-danger">' +
                    '<button class="close" data-close="alert"></button>' +
                    error[0] + '<br>'
                    + '</div>'
                )
            });
        }
    });

}

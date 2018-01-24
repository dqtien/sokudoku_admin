/**
 * Created by Vu Hai on 1/15/2017.
 */

var g_question_type_name_table = undefined;
var check_status_change = undefined;

$(document).ready(function () {
    searchQuestionType();
    $('#editQuestionType').on('hidden.bs.modal', function () {
        //clear form
        $('#editQuestionTypeError').empty('');
    });

    //update Question
    $('.updateQuestionType').on('click', function () {
        //prepare data
        var formData = new FormData();

        formData.append('question_type_name', $('#editQuestionType').find('[name="question_type_name"]').val());
        formData.append('id', $('#editQuestionType').find('[name="id"]').val());
        updateQuestionType(formData)


    });
    $('.createQuestionType').on('click', function () {
        //prepare data
        var formData = new FormData();
        formData.append('question_type_name', $('#createQuestionType').find('[name="question_type_name"]').val());
        createNewQuestionType(formData);


    });

    //delete Question
    $('.destroy').on('click', function () {

        //prepare data
        var id = $('#deleteQuestionType').find('[name="id"]').val();
        //delete category
        destroyQuestionType(id)
    });
});

function create_question_type() {
    $('#createQuestionTypeError').empty('');
    var find = $('#createQuestionType');
    find.modal('show');
}
function searchQuestionType() {

    g_question_type_name_table = $('#question-type-list-table').dataTable({
        "sDom": "<'row'<'col-sm-6' i><'col-sm-6' >r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        'bProcessing': true,
        'bServerSide': true,
        "bDestroy": true,
        'sAjaxSource': SITE_ROOT + '/question_type/load_datatable',
        'fnServerData': function (sSource, aoData, fnCallback, oSettings) {
            aoData.push({
                "name": "question_type_name",
                "value": $('#question_type_name').val()
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
                    if (full.display_name != null) {
                        html += full.display_name;
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
            }
            // , {
            //     'bSortable': false,
            //     'mData': function () {
            //         return '';
            //     },
            //     // Render operation action.
            //     'sClass': 'text-center',
            //     'mRender': function (data, type, full) {
            //         var html = '';
            //         html += '<button type="button" onclick="edit_Question_Type(' + full.id + ');" class="btn btn-sm purple"><i class="fa fa-edit"></i></button>';
            //         html += '<button type="button" onclick="delete_Question_Type(' + full.id + ');" class="btn btn-sm red"><i class="fa fa-trash-o"></i></button>';
            //         return html;
            //     }
            // }
            ]
    });
}

function Question_type_table_reload() {
    if (g_question_type_name_table != undefined) {
        g_question_type_name_table.fnReloadAjax();
    }
}
function edit_Question_Type(id) {
    $('#editQuestionTypeError').empty('');

    var find = $('#editQuestionType');
    if (id != undefined) {
        $.ajax({
            url: SITE_ROOT + '/question_type/' + id,
            method: 'GET'
        }).success(function (response) {
            // Populate the form fields with the data returned from server
            find
                .find('[name="id"]').val(response.id).end()
                .find('[name="question_type_name"]').val(response.display_name).end();

            //show modal
            find.modal('show');
        });
    } else {
        //show modal
        find.modal('show');
    }
}

function delete_Question_Type(id) {
    var find = $('#deleteQuestionType');

    find.find('[name="id"]').val(id).end();

    find.modal('show');
}
function updateQuestionType(data) {
    $.ajax({
        url: SITE_ROOT + '/question_type/update',
        data: data,
        method: 'POST',
        processData: false,
        contentType: false,

        success: function (response) {
            //hidden modal
            $('#editQuestionType').modal('hide');
            Question_type_table_reload();
        },
        error: function (response) {
            jQuery.each(response.responseJSON, function (i, error) {
                $("#editQuestionTypeError").html(
                    '<div class="alert alert-danger">' +
                    '<button class="close" data-close="alert"></button>' +
                    error[0] + '<br>'
                    + '</div>'
                )
            });
        }
    });
}
function createNewQuestionType(data) {
    $.ajax({
        url: SITE_ROOT + '/question_type/create_question_type',
        data: data,
        method: 'POST',
        processData: false,
        contentType: false,

        success: function (response) {
            window.location.href = SITE_ROOT + '/question_type/index';
        },
        error: function (response) {
            jQuery.each(response.responseJSON, function (i, error) {
                $("#createQuestionTypeError").html(
                    '<div class="alert alert-danger">' +
                    '<button class="close" data-close="alert"></button>' +
                    error[0] + '<br>'
                    + '</div>'
                )
            });
        }
    });
}

function destroyQuestionType(id) {
    var data = {'id': id};
    $.ajax({
        url: SITE_ROOT + '/question_type/delete_question_type',
        data: data,
        method: 'POST',

        success: function (response) {
            //hidden modal
            $('#deleteQuestionType').modal('hide');
            Question_type_table_reload();
        },
        error: function (response) {
            jQuery.each(response.responseJSON, function (i, error) {
                $("#deleteQuestionTypeError").html(
                    '<div class="alert alert-danger">' +
                    '<button class="close" data-close="alert"></button>' +
                    error[0] + '<br>'
                    + '</div>'
                )
            });
        }
    });

}

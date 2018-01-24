/**
 * Created by Vu Hai on 1/15/2017.
 */

var g_Question_table = undefined;
var check_status_change = undefined;

$(document).ready(function () {
    searchQuestion();
    onChangeQuestionType();
    $('#editQuestion').on('hidden.bs.modal', function () {
        //clear form
        $('#editQuestionError').empty('');
    });

    //update Question
    $('.updateQuestion').on('click', function () {
        Question_id = $('#editQuestion').find('[name="id"]').val();

        //prepare data
        var formData = new FormData();
        formData.append('question_type', $('#editQuestion').find('[name="question_type"]').val());
        formData.append('question_content', $('#editQuestion').find('[name="question_content"]').val());
        formData.append('question_answer', $('#editQuestion').find('[name="question_answer"]').val());
        formData.append('level', $('#editQuestion').find('[name="level"]').val());
        formData.append('writing', $('#editQuestion').find('[name="writing"]').val());
        formData.append('line_type', $('#editQuestion').find('[name="line_type"]').val());

        if (Question_id != undefined && Question_id != "") {
            formData.append('id', $('#editQuestion').find('[name="id"]').val());
            formData.append('status', $('#editQuestion').find('[name="status"]').val());
            updateQuestion(formData)
        } else {
            createNewQuestion(formData);
        }

    });
    //delete Question
    $('.destroy').on('click', function () {

        //prepare data
        var id = $('#deleteQuestion').find('[name="id"]').val();
        //delete category
        destroyQuestion(id)
    });
});

function onChangeQuestionType() {
    //prepare data
    // $('#editQuestion').find('[name="question_content"]').val('');
    var type_question = $('#editQuestion').find('[name="question_type"]').val();
    if (type_question == 1) {
        $('#editQuestion').find('[name="question_content"]').attr('maxlength', 12);
    } else {
        $('#editQuestion').find('[name="question_content"]').removeAttr('maxlength');
    }
    
    // ばらばらフラッシュ
    if (type_question == '1') {
        $('#editQuestion .question-option').hide();
        $('#editQuestion .question-option.level').show();
    }
    
    // ⽂章フラッシュ
    if (type_question == '2') {
        $('#editQuestion .question-option').hide();
        $('#editQuestion .question-option.writing, #editQuestion .question-option.line_type').show();
    }
    
    // Eye Exercise シンボル
    if (type_question == '4') {
        $('#editQuestion .question-option').hide();
    }
    
    // Eye Exercise 文章
    if (type_question == '5') {
        $('#editQuestion .question-option').hide();
    }
}
function searchQuestion() {

    g_Question_table = $('#question-list-table').dataTable({
        "sDom": "<'row'<'col-sm-6' i><'col-sm-6' >r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        'bProcessing': true,
        'bServerSide': true,
        "bDestroy": true,
        "bAutoWidth": false,
        'sAjaxSource': SITE_ROOT + '/question/load_datatable',
        'fnServerData': function (sSource, aoData, fnCallback, oSettings) {
            aoData.push({
                "name": "question_type",
                "value": $('#question_type').val()
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
                    if (full.question_type.display_name != null) {
                        html += full.question_type.display_name;
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
                    if (full.content != null) {
                        if (full.question_type_id == '5')
                            html += full.content.substring(0, 10) + '...';
                        else
                            html += full.content;
                    } else {
                        html += 'None';
                    }

                    return html;
                },
                'bSortable': false
            }, { /*
                'mData': function () {
                    return '';
                },
                // Render operation action.
                'sClass': 'text-center',
                'mRender': function (data, type, full) {
                    var html = '';
                    if (full.question_answer.content != null) {
                        html += full.question_answer.content;
                    } else {
                        html += 'None';
                    }

                    return html;
                },
                'bSortable': false
            }, { */
                'mData': function () {
                    return '';
                },
                // Render operation action.
                'sClass': 'text-center',
                'mRender': function (data, type, full) {
                    var html = '';
                    if (full.question_type_id == '1' && full.level != null) {
                        html += full.level;
                    } else {
                        html += '';
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
                    if (full.question_type_id == '2' && full.writing != null) {
                        if (full.writing == 'vertical')
                            html += '縦';
                        else if (full.writing == 'horizon')
                            html += '横';
                        else
                            html += full.writing;
                    } else {
                        html += '';
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
                    if (full.question_type_id == '2' && full.line_type != null) {
                        if (full.line_type == 'single')
                            html += '1行';
                        else if (full.line_type == 'multiple')
                            html += '複数行';
                        else
                            html += full.line_type;
                    } else {
                        html += '';
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
                    if (full.status == 1) {
                        html += '<button type="button" class="btn btn-sm green">Active</button>';
                    } else if (full.status == 2) {
                        html += '<button type="button" class="btn btn-sm blue">Inactive</button>';
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
                    html += '<button type="button" onclick="edit_Question(' + full.id + ');" class="btn btn-sm purple"><i class="fa fa-edit"></i></button>';
                    html += '<button type="button" onclick="delete_Question(' + full.id + ');" class="btn btn-sm red"><i class="fa fa-trash-o"></i></button>';
                    return html;
                }
            }]
    });
}

function Question_table_reload() {
    if (g_Question_table != undefined) {
        g_Question_table.fnReloadAjax();
    }
}
function Question_table_update_params() {
    if (g_Question_table != undefined) {
        g_Question_table.fnDestroy();
        searchQuestion();
    }
}
function edit_Question(id) {
    $('#editQuestionError').empty('');
    $('#status_form').show();
    var find = $('#editQuestion');
    if (id != undefined) {
        $.ajax({
            url: SITE_ROOT + '/question/' + id,
            method: 'GET'
        }).success(function (response) {
            // Populate the form fields with the data returned from server
            find
                .find('[name="id"]').val(response.id).end()
                .find('[name="question_type"]').val(response.question_type.id).end()
                .find('[name="question_answer"]').val(response.question_answer.content).end()
                .find('[name="status"]').val(response.status).end()
                .find('[name="question_content"]').val(response.content).end()
                .find('[name="level"]').val(response.level).end()
                .find('[name="writing"]').val(response.writing).end()
                .find('[name="line_type"]').val(response.line_type).end();
            //show modal
            find.modal('show');
            onChangeQuestionType();
        });
    } else {
        //show modal
        find.modal('show');
        onChangeQuestionType();
    }
}

function delete_Question(id) {
    var find = $('#deleteQuestion');

    find.find('[name="id"]').val(id).end();

    find.modal('show');
}
function updateQuestion(data) {
    $.ajax({
        url: SITE_ROOT + '/question/update',
        data: data,
        method: 'POST',
        processData: false,
        contentType: false,

        success: function (response) {
            //hidden modal
            $('#editQuestion').modal('hide');
            Question_table_reload();
        },
        error: function (response) {
            jQuery.each(response.responseJSON, function (i, error) {
                $("#editQuestionError").html(
                    '<div class="alert alert-danger">' +
                    '<button class="close" data-close="alert"></button>' +
                    error[0] + '<br>'
                    + '</div>'
                )
            });
        }
    });
}
function create_question() {
    $('#editQuestion').find('[name="id"]').val('');
    $('#status_form').hide();

    $('#editQuestionError').empty('');
    var find = $('#editQuestion');
    find.find('[name="question_content"]').val('');
    find.find('[name="question_answer"]').val('');
    find.modal('show');
}
function createNewQuestion(data) {
    $.ajax({
        url: SITE_ROOT + '/question/create_question',
        data: data,
        method: 'POST',
        processData: false,
        contentType: false,

        success: function (response) {
            window.location.href = SITE_ROOT + '/question/index';
        },
        error: function (response) {
            jQuery.each(response.responseJSON, function (i, error) {
                $("#editQuestionError").html(
                    '<div class="alert alert-danger">' +
                    '<button class="close" data-close="alert"></button>' +
                    error[0] + '<br>'
                    + '</div>'
                )
            });
        }
    });
}

function destroyQuestion(id) {
    var data = {'id': id};
    $.ajax({
        url: SITE_ROOT + '/question/delete_question',
        data: data,
        method: 'POST',

        success: function (response) {
            //hidden modal
            $('#deleteQuestion').modal('hide');
            Question_table_reload();
        },
        error: function (response) {
            jQuery.each(response.responseJSON, function (i, error) {
                $("#deleteQuestionError").html(
                    '<div class="alert alert-danger">' +
                    '<button class="close" data-close="alert"></button>' +
                    error[0] + '<br>'
                    + '</div>'
                )
            });
        }
    });

}

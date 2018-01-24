@extends('layouts.master')

@section('content')
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <h3 class="page-title">
            質問管理
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-question"></i>
                    <a href="">質問管理</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">質問一覧</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">質問タイプ</label>
                            {!! Form::select('question_type',$question_type_arr, $question_type_arr['all'],
                                    array('class' => 'form-control', 'id' => 'question_type')) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">状態</label>
                            {!! Form::select('status',array('0'=>'All','1'=>'Active','2'=>'Inactive'), array('0'),
                                    array('class' => 'form-control', 'id' => 'status')) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-center" style="margin-bottom: 10px">
                <button id type="button" onclick="searchQuestion();" class="btn btn-success">
                    データ取得
                </button>
            </div>
        </div>

        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box green" id="#category-result" style="display: block">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-paper-plane"></i>質問一覧
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse">
                            </a>
                            <a href="javascript:;" onclick="Question_table_reload()" class="reload">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body flip-scroll">
                        <div class="row">
                            <div class="col-md-2">
                                <!-- Dispay record -->
                                <div class="form-group">
                                    <label for="">{!! "記録" !!}</label>
                                    {!! Form::select('record-display',
                                                array('10' => '10', '20' => '20', '30' => '30', '40' => '40', '50' => '50'), null,
                                                array('class' => 'form-control', 'onchange' => 'Question_table_update_params()'))!!}
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2" style="text-align: right; margin-top: 30px;">
                                <button type="button" class="btn green" onclick="create_question()">
                                    <i class="fa fa-plus"></i> 新規追加
                                </button>
                            </div>
                        </div>
                        <table id="question-list-table"
                               class="table table-bordered table-striped table-condensed">
                            <thead>
                            <tr>
                                <th style="text-align: center">
                                    {!! "質問タイプ名" !!}
                                </th>
                                <th style="text-align: center">
                                    {!! "質問内容" !!}
                                </th>
                                <!--
                                <th style="text-align: center">
                                    {!! "質疑応答" !!}
                                </th>
                                -->
                                <th style="text-align: center">
                                    {!! "レベル" !!}
                                </th>
                                <th style="text-align: center">
                                    {!! "向き" !!}
                                </th>
                                <th style="text-align: center">
                                    {!! "行数" !!}
                                </th>
                                <th style="text-align: center">
                                    {!! "作成日時" !!}
                                </th>
                                <th style="text-align: center">
                                    {!! "状態" !!}
                                </th>
                                <th style="text-align: center">
                                    {!! "アクション" !!}
                                </th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL TO DELETE -->
        <div id="deleteQuestion" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-header" style="background-color: #c23f44">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" style="color: #ffffff">警告!!!!!!!!!!</h4>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <!-- Error box -->
                    <div class="row">
                        <div class="col-md-12 col-sm-12" id="deleteQuestionError">

                        </div>
                    </div>
                    <div class="row">
                        {!! Form::hidden('id') !!}
                        <p style="text-align: center">本当にしますか？</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">いいえ</button>
                <button type="button" class="btn red destroy">はい</button>
            </div>
        </div>

        <!-- MODAL TO EDIT -->
        <div id="editQuestion" class="modal fade" tabindex="-1" data-width="800">
            {{Form::hidden("id")}}
            <div class="modal-header" style="background-color: #44b6ae">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"
                    style="color: #ffffff">{{trans('質問編集')}}</h4>
            </div>
            <div class="modal-body">
                <!-- Error box -->
                <div class="row">
                    <div class="col-md-12 col-sm-12" id="editQuestionError">

                    </div>
                </div>

                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form action="#" class="horizontal-form">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label">質問タイプ</label>
                                    {!! Form::select('question_type',$question_type_arr_edit, null,
                                            array('onchange'=>'onChangeQuestionType()','class' => 'form-control', 'id' => 'question_type')) !!}
                                    
                                    <div style="margin-top: 10px" class="question-option level">
                                        <label class="control-label">レベル</label>
                                        {!! Form::select('level',$level_arr_edit, null,
                                                array('class' => 'form-control', 'id' => 'level')) !!}
                                    </div>
                                            
                                    <div style="margin-top: 10px" class="question-option writing">
                                        <label class="control-label">向き</label>
                                        {!! Form::select('writing',$writing_arr_edit, null,
                                                array('class' => 'form-control', 'id' => 'writing')) !!}
                                    </div>
                                            
                                    <div style="margin-top: 10px" class="question-option line_type">
                                        <label class="control-label">行数</label>
                                        {!! Form::select('line_type',$line_type_arr_edit, null,
                                                array('class' => 'form-control', 'id' => 'line_type')) !!}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div id="status_form" class="form-group">
                                        <label class="control-label">状態</label>
                                        {!! Form::select('status',array('1'=>'Active','2'=>'Inactive'), null,
                                                array('class' => 'form-control', 'id' => 'status')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="margin-top: 10px">
                                <div class="col-md-12">
                                    <label class="control-label">質問内容</label>
                                    <textarea rows="5" id="memo" class="form-control"
                                              placeholder="Question Content" style="resize: none; width: 100%"
                                              name="question_content"
                                              cols="50"></textarea>
                                </div>
                                <div class="col-md-12 hidden">
                                    <label class="control-label">質疑応答</label>
                                    <textarea maxlength="150" rows="5" id="memo" class="form-control"
                                              placeholder="Question Answer" style="resize: none; width: 100%"
                                              name="question_answer"
                                              cols="50"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">閉じる</button>
                <button type="button" class="btn blue updateQuestion">変更保存</button>
            </div>
        </div>
        <!-- END PAGE HEADER-->

        <!-- PAGE CONTENT  -->

        <!-- END PAGE CONTENT  -->
    </div>
@endsection
@section("script-plugin")
    <script src="{{ asset('js/plugins/datatables/jquery.dataTables.js') }}"></script>
@endsection
@section("after-scripts-end")
    <script src="{{ asset('js/plugins/datatables/datatables-bs3.js') }}"></script>
    <script src="{{ asset('js/page/question/index.js') }}"></script>
@endsection

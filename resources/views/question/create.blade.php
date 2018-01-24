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
                    <a href="#">質問作成</a>
                </li>
            </ul>
        </div>

        <div id="editQuestion">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>質問作成
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse">
                        </a>
                        <a href="javascript:;" class="reload">
                        </a>
                    </div>
                </div>
                <div class="portlet-body form">
                    {{--{!! Form::open(array('route' => 'system.admin_user.store', 'method' => 'POST', 'class' => 'horizontal-form', 'files' => true)) !!}--}}
                    <div class="form-body">
                        <h3 class="form-section">情報</h3>
                        <div class="row">
                            <div class="col-md-12 col-sm-12" id="editQuestionError">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label">質問タイプ</label>
                                {!! Form::select('question_type',$question_type_arr, null,
                                        array('onchange'=>'onChangeQuestionType()','class' => 'form-control', 'id' => 'question_type')) !!}
                            </div>
                        </div>

                        <div class="row" style="margin-top: 10px">
                            <div class="col-md-6">
                                <label class="control-label">質問内容</label>
                                <textarea maxlength="150" rows="5"
                                          id="question_content" class="form-control"
                                          placeholder="Question Content" style="resize: none; width: 100%"
                                          name="question_content"
                                          cols="50"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">質疑応答</label>
                                <textarea maxlength="150" rows="5" id="question_answer" class="form-control"
                                          placeholder="Question Answer" style="resize: none; width: 100%"
                                          name="question_answer"
                                          cols="50"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions right">
                        <button type="submit" class="btn blue updateQuestion"><i class="fa fa-check"></i> 変更保存</button>
                    </div>
                    {!! Form::close() !!}
                </div>
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
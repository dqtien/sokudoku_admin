@extends('layouts.master')

@section('content')
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <h3 class="page-title">
            教室管理
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-book"></i>
                    <a href="">教室管理</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h3>で検索</h3>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">教室名</label>
                            {!! Form::text('class_name',null,
                                    array('class' => 'form-control', 'id' => 'class_name')) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-center" style="margin-bottom: 10px">
                <button id type="button" onclick="searchClass();" class="btn btn-success">
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
                            <i class="fa fa-paper-plane"></i>教室一覧
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse">
                            </a>
                            <a href="javascript:;" onclick="class_table_reload()" class="reload">
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
                                                array('class' => 'form-control'))!!}
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2" style="text-align: right; margin-top: 30px;">
                                <button type="button" class="btn green" onclick="create_class()">
                                    <i class="fa fa-plus"></i> 新規追加
                                </button>
                            </div>
                        </div>
                        <table id="class-list-table"
                               class="table table-bordered table-striped table-condensed">
                            <thead>
                            <tr>
                                <th style="text-align: center">
                                    {!! "クラス名" !!}
                                </th>
                                <th style="text-align: center">
                                    {!! "管理者名" !!}
                                </th>
                                <th style="text-align: center">
                                    {!! "ユーザ" !!}
                                </th>
                                <th style="text-align: center">
                                    {!! "～に作成されました" !!}
                                </th>
                                <th style="text-align: center">
                                    {!! "～に更新されました  " !!}
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
        <div id="deleteClass" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-header" style="background-color: #c23f44">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" style="color: #ffffff">警告!!!!!!!!!!</h4>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <!-- Error box -->
                    <div class="row">
                        <div class="col-md-12 col-sm-12" id="deleteClassError">

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
        <div id="editClass" class="modal fade" tabindex="-1" data-width="400">
            {{Form::hidden("id")}}
            <div class="modal-header" style="background-color: #44b6ae">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"
                    style="color: #ffffff">{{trans('クラス編集')}}</h4>
            </div>
            <div class="modal-body">
                <!-- Error box -->
                <div class="row">
                    <div class="col-md-12 col-sm-12" id="editClassError">

                    </div>
                </div>

                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form action="#" class="horizontal-form">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="control-label">教室名</label>
                                    {!! Form::text('class_name', null,
                                            array('class' => 'form-control', 'id' => 'class_name')) !!}
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">クローズ</button>
                <button type="button" class="btn blue updateClass">変更保存</button>
            </div>
        </div>

        <!-- MODAL TO CREATE -->
        <div id="createClass" class="modal fade" tabindex="-1" data-width="400">
            <div class="modal-header" style="background-color: #44b6ae">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"
                    style="color: #ffffff">{{trans('クラス作成')}}</h4>
            </div>
            <div class="modal-body">
                <!-- Error box -->
                <div class="row">
                    <div class="col-md-12 col-sm-12" id="createClassError">

                    </div>
                </div>

                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form action="#" class="horizontal-form">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="control-label">教室名</label>
                                    {!! Form::text('class_name', null,
                                            array('class' => 'form-control', 'id' => 'class_name')) !!}
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">クローズ</button>
                <button type="button" class="btn blue createClass">変更保存</button>
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
    <script src="{{ asset('js/page/class/index.js') }}"></script>
@endsection
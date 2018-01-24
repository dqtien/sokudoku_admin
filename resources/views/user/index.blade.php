@extends('layouts.master')

@section('content')
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <h3 class="page-title">
            生徒管理
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-users"></i>
                    <a href="">生徒管理</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">生徒一覧</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        {{--<div class="form-group">--}}
                        {{--<label>Eメール</label>--}}
                        {{--{!! Form::text('email', null, array('class' => 'form-control', 'id' => 'email')) !!}--}}
                        {{--</div>--}}
                    </div>
                    {{--<div class="col-md-3">--}}
                    {{--<div class="form-group">--}}
                    {{--<label>電話</label>--}}
                    {{--{!! Form::text('phone', null, array('class' => 'form-control', 'id' => 'phone')) !!}--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-3">--}}
                    {{--<div class="form-group">--}}
                    {{--<label>クラス名</label>--}}
                    {{--{!! Form::text('class_name', null, array('class' => 'form-control', 'id' => 'class_name')) !!}--}}
                    {{----}}
                    {{--</div>--}}
                    {{--</div>--}}

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">クラス名</label>
                            {!! Form::select('class_name', $arr_class_search, $arr_class_search['all'] , array('class' => 'form-control','id'=>'class_search')) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>氏名</label>
                            {!! Form::text('full_name', null, array('class' => 'form-control', 'id' => 'full_name')) !!}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">状態</label>
                            {!! Form::select('status',array('0'=>'InActive','1'=>'Active','2'=>'All'), array('2'),
                                    array('class' => 'form-control', 'id' => 'status')) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-center" style="margin-bottom: 10px">
                <button id type="button" onclick="searchUser();" class="btn btn-success">
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
                            <i class="fa fa-paper-plane"></i>生徒一覧
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse">
                            </a>
                            <a href="javascript:;" onclick="user_table_reload()" class="reload">
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
                                                array('class' => 'form-control', 'onchange' => 'user_table_update_params()'))!!}
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2" style="text-align: right; margin-top: 30px;">
                                <button type="button" class="btn green" onclick="create_class_user()">
                                    <i class="fa fa-plus"></i> 新規追加
                                </button>
                            </div>
                        </div>
                        <table id="user-list-table"
                               class="table table-bordered table-striped table-condensed">
                            <thead>
                            <tr>
                                <th style="text-align: center">
                                    {!! "ID" !!}
                                </th>
                                <th style="text-align: center">
                                    {!! "氏名" !!}
                                </th>
                                <th style="text-align: center">
                                    {!! "クラス名" !!}
                                </th>
                                <th style="text-align: center">
                                    {!! "作成日時" !!}
                                </th>
                                <th style="text-align: center">
                                    {!! "最終ログイン時間" !!}
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

        <!-- MODAL TO CREATE -->
        <div id="createClassUser" class="modal fade" tabindex="-1" data-width="400">
            <div class="modal-header" style="background-color: #44b6ae">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"
                    style="color: #ffffff">{{trans('生徒作成')}}</h4>
                {!! Form::hidden('max_id',$max_id) !!}

            </div>
            <div class="modal-body">
                <!-- Error box -->
                <div class="row">
                    <div class="col-md-12 col-sm-12" id="createClassUserError">

                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form action="#" class="horizontal-form">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label">氏名</label>
                                    {!! Form::text('user_name', null,
                                            array('class' => 'form-control', 'id' => 'user_name')) !!}
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">教室名</label>
                                        {!! Form::select('class_name', $arr_class, $arr_class['none'] , array('class' => 'form-control')) !!}
                                    </div>
                                </div>

                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-2">

                                </div>
                                <div class="col-md-8" id="btn_generate">
                                    <button style="margin-left: 10px;width: 200px" type="button"
                                            class="btn blue generateClassUser">
                                        ID発行
                                    </button>
                                </div>
                                <div class="col-md-2">

                                </div>
                            </div>


                            <hr>
                            <div class="row">
                                <div class="col-md-2">

                                </div>
                                <div class="col-md-8">
                                    <b>IDとパスワードが表示されます。</b>
                                </div>
                                <div class="col-md-2">

                                </div>
                            </div>
                            <br>
                            <br>
                            <div hidden class="row" id="generate_class_user">
                                <div class="col-md-3">

                                </div>
                                <div class="col-md-8">
                                    <table style="width: 100%">
                                        <tr>
                                            <td style="border: 1px solid #dddddd;text-align: left;padding: 8px; width: 30%">ID
                                            </td>
                                            <td id="td_user_name"
                                                style="border: 1px solid #dddddd;text-align: left;padding: 8px; width: 70%">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">PASS
                                            </td>
                                            <td id="td_password"
                                                style="border: 1px solid #dddddd;text-align: left;padding: 8px;">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-3">

                                </div>

                            </div>

                        </div>
                    </form>
                    <!-- END FORM-->
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default cancel">閉じる</button>
                <button type="button" class="btn blue createClassNewUser">続けて登録</button>
            </div>
        </div>
        <!-- MODAL TO DELETE -->
        <div id="deleteUser" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-header" style="background-color: #c23f44">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" style="color: #ffffff">警告!!!!!!!!!!</h4>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <!-- Error box -->
                    <div class="row">
                        <div class="col-md-12 col-sm-12" id="deleteUserError">

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
        <div id="editUser" class="modal fade" tabindex="-1" data-width="400">
            {{Form::hidden("id")}}
            <div class="modal-header" style="background-color: #44b6ae">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"
                    style="color: #ffffff">{{trans('ユーザーの編集')}}</h4>
            </div>
            <div class="modal-body">
                <!-- Error box -->
                <div class="row">
                    <div class="col-md-12 col-sm-12" id="editUserError">

                    </div>
                </div>

                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form action="#" class="horizontal-form">
                        <div class="form-body">
                            <div class="row">
                                <div style="display:none;" class="col-md-3">
                                    <div class="form-group" style="text-align: left">
                                        <img src="" id="img_avatar" name="avatar" style="width:75%;height:100px;"/>
                                        <div>
                                            <input id="update_avatar" style="border: none;margin-top: 10px"
                                                   onchange="readURL(this)"
                                                   type="file" name="choose_image" class="" id="chooseImage"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">氏名</label>
                                            <input type="text" name="full_name" class="form-control"
                                                   id="editUserFullName"
                                                   placeholder="Full Name">
                                    </div>
                                </div>
                                <div style="display:none;" class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label">住所</label>
                                        {!! Form::text('address',old('address'), array('class' => 'form-control',
                                                        'placeholder' => 'Address')) !!}
                                    </div>
                                </div>
                            </div>


                            <div class="row" style="margin-top: 10px">
                                <div style="display:none;" class="col-md-5">
                                    <label class="control-label">Eメール</label>
                                    <div class="input-group">
																<span class="input-group-addon">
																<i class="fa fa-envelope"></i>
																</span>
                                        <input type="text" name="email" class="form-control" id="editUserEmail"
                                               placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="control-label">パスワード</label>
                                    <div class="input-group">
                                        <input maxlength="13" type="password" name="password" class="form-control"
                                               id="editPassword"
                                               placeholder="Password">
                                        <span class="input-group-addon">
																<i class="fa fa-lock"></i>
																</span>
                                    </div>
                                </div>
                                <div style="display:none;" class="col-md-3">
                                    <div class="form-group">
                                        <label>電話</label>
                                        {!! Form::text('phone', null, array('maxlength'=>'15','class' => 'form-control', 'id' => 'phone')) !!}
                                    </div>
                                </div>

                            </div>
                            <div class="row" style="margin-top: 10px">
                                <div class="col-md-12">
                                    <label class="control-label">状態</label>
                                    {!! Form::select('status',array('0'=>'InActive','1'=>'Active'), null,
                                            array('class' => 'form-control', 'id' => 'status')) !!}
                                </div>

                                <div style="display:none;" class="col-md-4">
                                    <label class="control-label">最終ログイン時間</label>
                                    <input disabled type="text" name="last_login_time" class="form-control"
                                           id="editLastLoginTime"
                                           placeholder="Last Login Time">
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">教室名</label>
                                        {!! Form::select('class_name', $arr_class, $arr_class['none'] , array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div style="display:none;" class="row" style="margin-top: 10px">
                                <div class="col-md-6">
                                    <label class="control-label">メモ</label>
                                    <textarea maxlength="150" rows="5" id="memo" class="form-control"
                                              placeholder="Memo" style="resize: none; width: 100%" name="memo"
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
                <button type="button" class="btn blue updateUser">変更保存</button>
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
    <script src="{{ asset('js/page/user/index.js') }}"></script>
@endsection

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
                    <a href="#">生徒作成</a>
                </li>
            </ul>
        </div>

        <div id="editUser">
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>生徒作成
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
                                <div class="col-md-12 col-sm-12" id="editUserError">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group" style="text-align: left">
                                        <img src="" id="img_avatar" name="avatar" style="width:100px;height:100px;"/>
                                        <div>
                                            <input id="update_avatar" style="border: none;margin-top: 10px"
                                                   onchange="readURL(this)"
                                                   type="file" name="choose_image" class=""/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">氏名</label>
                                        {!! Form::text('full_name',old('full_name'), array('class' => 'form-control',
                                                        'placeholder' => 'Full Name')) !!}
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label">住所</label>
                                        {!! Form::text('address',old('address'), array('class' => 'form-control',
                                                        'placeholder' => 'Address')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5">
                                    <label class="control-label">Eメール</label>
                                    <div class="input-group">
																<span class="input-group-addon">
																<i class="fa fa-envelope"></i>
																</span>
                                        <input type="text" name="email" class="form-control" id="editUserEmail"
                                               placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">パスワード</label>
                                    <div class="input-group">
                                        <input maxlength="13" type="password" name="password" class="form-control"
                                               id="editPassword"
                                               placeholder="Password">
                                        <span class="input-group-addon">
																<i class="fa fa-user"></i>
																</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>電話</label>
                                        {!! Form::text('phone', null, array('maxlength'=>'15','class' => 'form-control', 'id' => 'phone')) !!}
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <label class="control-label">メモ</label>
                                    <textarea maxlength="150" rows="5" id="memo" class="form-control"
                                              placeholder="Memo" style="resize: none; width: 100%" name="memo"
                                              cols="50"></textarea>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">クラス名</label>
                                        {!! Form::select('class_name', $arr_class, $arr_class['none'] , array('class' => 'form-control')) !!}
                                    </div>
                                </div>


                            </div>

                        </div>
                        <div class="form-actions right">
                            <button type="submit" class="btn blue updateUser"><i class="fa fa-check"></i> 変更保存</button>
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
    <script src="{{ asset('js/page/user/index.js') }}"></script>
@endsection
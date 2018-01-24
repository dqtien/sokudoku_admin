@extends('layouts.master')

@section('content')
    <div class="page-content">
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        Widget settings form goes here
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn blue">Save changes</button>
                        <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <!-- BEGIN PAGE HEADER-->
        <h3 class="page-title">
            ダッシュボード
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="">ホーム</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">トップページ</a>
                </li>
            </ul>
        </div>
        <!-- END PAGE HEADER-->

        <!-- User count -->
        <div class="row">
            @role('super_admin')
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue-madison">
                    <div class="visual">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                        </div>
                        <div class="desc">
                            運営者管理
                        </div>
                    </div>
                    <a class="more" href="{!! route('user_admin.index') !!}">
                        もっと見る
                        <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            @endrole
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue-madison">
                    <div class="visual">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                        </div>
                        <div class="desc">
                            生徒管理
                        </div>
                    </div>
                    <a class="more" href="{!! route('user.index') !!}">
                        もっと見る
                        <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            @role('super_admin')
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat red-intense">
                    <div class="visual">
                        <i class="fa fa-question"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                        </div>
                        <div class="desc">
                            質問管理
                        </div>
                    </div>
                    <a class="more" href="{!! route('question.index') !!}">
                        もっと見る
                        <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            @endrole
        </div>

    </div>
    @endsection
    @section('after-scripts-end')
            <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{asset('assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('assets/global/plugins/flot/jquery.flot.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/global/plugins/flot/jquery.flot.resize.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/global/plugins/flot/jquery.flot.categories.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/global/plugins/jquery.pulsate.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/global/plugins/bootstrap-daterangepicker/moment.min.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"
            type="text/javascript"></script>
    <!-- IMPORTANT! fullcalendar depends on jquery-ui.min.js for drag & drop support -->
    <script src="{{asset('assets/global/plugins/fullcalendar/fullcalendar.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('assets/global/plugins/jquery.sparkline.min.js')}}" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
@endsection
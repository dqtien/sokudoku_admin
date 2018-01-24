<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>
        @section('title')
            Sokudoku管理画面
        @show
    </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <meta content="{!! csrf_token() !!}" name="csrf-token">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/global/plugins/uniform/css/uniform.default.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
    <link href="{!! asset('assets/global/plugins/icheck/skins/all.css') !!}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') !!}"/>
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') !!}"/>
    <link href="{{asset('assets/global/plugins/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/global/plugins/jqvmap/jqvmap/jqvmap.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/global/plugins/bs_pagination/jquery.bs_pagination.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css')}}" rel="stylesheet" type="text/css"/>
    @yield('css-plugin')
    <!-- END PAGE LEVEL PLUGIN STYLES -->

    <!-- BEGIN PAGE STYLES -->
    <link href="{{asset('assets/admin/pages/css/tasks.css')}}" rel="stylesheet" type="text/css"/>
    <!-- END PAGE STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link href="{{asset('assets/global/css/components.css')}}" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/global/css/plugins.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/admin/layout/css/layout.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/admin/layout/css/themes/darkblue.css')}}" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="{{asset('assets/admin/layout/css/custom.css')}}" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="{!! asset('favicon.png') !!}"/>
    <style>
        .table>tbody>tr>td {
            vertical-align: middle;
        }
    </style>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
<body class="page-header-fixed page-quick-sidebar-over-content">

<!-- BEGIN HEADER -->
@include('includes.header')
<!-- END HEADER -->

<div class="clearfix"></div>

<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    @include('includes.sidebar')
    <!-- END SIDEBAR -->

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        @yield('content')
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->

<!-- BEGIN FOOTER -->
@include('includes.footer')
<!-- END FOOTER -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="{{asset('assets/global/plugins/respond.min.js')}}"></script>
<script src="{{asset('assets/global/plugins/excanvas.min.js')}}"></script>
<![endif]-->
<script>
    SITE_ROOT = '{!! url("/") !!}';
</script>
<script src="{{asset('assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/jquery-migrate.min.js')}}" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="{{asset('assets/global/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/jquery.cokie.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/uniform/jquery.uniform.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/bs_pagination/jquery.bs_pagination.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bs_pagination/localization/en.min.js') }}" type="text/javascript"></script>

@yield('script-plugin')
<!-- END CORE PLUGINS -->
<script type="text/javascript" src="{!! asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') !!}"></script>
<script src="{{asset('assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{!! asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') !!}"></script>
<script src="{!! asset('assets/global/plugins/icheck/icheck.min.js') !!}"></script>

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{asset('assets/global/scripts/metronic.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/layout/scripts/layout.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/layout/scripts/quick-sidebar.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/layout/scripts/demo.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/pages/scripts/index.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/pages/scripts/tasks.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/pages/scripts/ui-extended-modals.js')}}"></script>
<script src="{!! asset('assets/admin/pages/scripts/components-pickers.js') !!}"></script>
<script src="{!! asset('assets/global/plugins/ckeditor/ckeditor.js') !!}"></script>

<script src="{{asset('assets/global/scripts/common.js')}}" type="text/javascript"></script>
<!-- DataTables -->
@yield('after-scripts-end')
<!-- END PAGE LEVEL SCRIPTS -->
<script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core componets
        Layout.init(); // init layout
        QuickSidebar.init(); // init quick sidebar
        Demo.init(); // init demo features
        Index.init();
//        UIExtendedModals.init();
        ComponentsPickers.init();
    });
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.2
Version: 3.3.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>Sokudoku管理画面 | Login</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/global/plugins/uniform/css/uniform.default.css')}}" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="{{asset('/assets/admin/pages/css/login.css')}}" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME STYLES -->
    <link href="{{asset('assets/global/css/components.css')}}" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/global/css/plugins.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/admin/layout/css/layout.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/admin/layout/css/themes/darkblue.css')}}" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="{{asset('assets/admin/layout/css/custom.css')}}" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="{!! asset('favicon.png') !!}"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="javascript:;">
        {{--<p style="color: white;font-size: 30px">SOKU<span style="color: red;font-size: 35px">DOKU</span></p>--}}
        <img  src="{{asset('assets/image/logo.png')}}" alt="Chron" style="max-width: 100%;width: 170px;height: 50px"/>
    </a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    {!! Form::open(array('url' => "/login",'class'=>'login-form', 'method' => 'POST')) !!}
    <h3 class="form-title">Sign In</h3>
    <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button>
			<span>
			{!! "Enter your e-mail and password!!!" !!} </span>
    </div>
    @if ($errors->has('login_id'))
        <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
            {{ $errors->first('login_id') }}
        </div>
    @endif
    @if ($errors->has('password'))
        <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
            {{ $errors->first('password') }}
        </div>
    @endif
    <div class="form-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">ID</label>
        <input class="form-control form-control-solid placeholder-no-fix" type="text"
               autocomplete="off" placeholder="ID" value="{!! old('login_id') !!}" name="login_id"/>
    </div>
    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password"/>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-success uppercase">Login</button>
        <label class="rememberme check">
            <input type="checkbox" name="remember"/>Remember </label>
        {{--<a href="{!! url('/password/reset') !!}" id="forget-password" class="forget-password">Forgot Password?</a>--}}
    </div>
    {!! Form::close() !!}
    <!-- END LOGIN FORM -->
</div>
<div class="copyright">
    2016 &copy; ManagementSite by Sokudoku.
</div>
<!-- END LOGIN -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="{{asset('assets/global/plugins/respond.min.js')}}"></script>
<script src="{{asset('assets/global/plugins/excanvas.min.js')}}"></script>
<![endif]-->
<script src="{{asset('assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/jquery-migrate.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/jquery.cokie.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/uniform/jquery.uniform.min.js')}}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{asset('assets/global/scripts/metronic.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/layout/scripts/layout.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/layout/scripts/demo.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/pages/scripts/login.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        Login.init();
        Demo.init();
    });
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>

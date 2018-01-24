<!-- BEGIN HEADER -->
<div class="page-header -i navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="">
                {{--<p style="color: white;font-size: 20px">SOKU<span style="color: red;font-size: 25px">DOKU</span></p>--}}
                <img style="margin-left: 50px;width: 70px;height: 20px" src="{!! asset("assets/image/logo.png") !!}" alt="logo" class="logo-default">
            </a>
            <div class="menu-toggler sidebar-toggler hide">
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
           data-target=".navbar-collapse">
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <!-- BEGIN USER LOGIN DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                       data-close-others="true">
                        {{--<img alt="" class="img-circle" src="{{asset('assets/admin/layout/img/avatar3_small.jpg')}}"/>--}}
                        <span class="username username-hide-on-mobile">
					{!! Auth::user()->adminProfile->full_name==null?"Me":Auth::user()->adminProfile->full_name !!}
                            {{--{!! $full_name !!}--}}
                    </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        {{--<li>--}}
                        {{--<a href="{!! route('profile.index') !!}">--}}
                        {{--<i class="icon-user"></i> My Profile </a>--}}
                        {{--</li>--}}
                        {{--<li class="divider">--}}
                        </li>
                        <li>
                            <a href="{!! url('/logout') !!}">
                                <i class="icon-key"></i> ログアウト</a>
                        </li>
                        <li>
                            <a href="{!! url('/profile/index') !!}">
                                <i class="icon-settings"></i> プロファイル設定</a>
                        </li>
                    </ul>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
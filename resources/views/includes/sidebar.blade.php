<div class="page-sidebar-wrapper">
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse" id="layout_menu">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <li class="sidebar-toggler-wrapper" style="margin-bottom: 10px;">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler">
                </div>
                <!-- END SIDEBAR TOGGLER BUTTON -->
            </li>
            <li class="start {{ active_class(if_route('home')) }}">
                <a href="{!! route('home') !!}">
                    <i class="icon-home"></i>
                    <span class="title">{!! "ダッシュボード"!!}</span>
                    <span class="select {{ active_class(if_route('home'), 'selected') }}"></span>
                    <span class="arrow {{ active_class(if_route('home'), 'open') }}"></span>
                </a>
                {{--<ul class="sub-menu">--}}
                    {{--<li class="{{ active_class(if_route('home'))}}">--}}
                        {{--<a href="{!! route('home') !!}">--}}
                            {{--<i class="icon-bar-chart"></i>--}}
                            {{--{!! "トップページ" !!}--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            </li>
            @role('super_admin')
            <li class="start {{ active_class(if_route('user_admin.index')) }}">
                <a href="{!! route('user_admin.index') !!}">
                    <i class="fa fa-book"></i>
                    <span class="title">{!! "教室管理"!!}</span>
                    <span class="select {{ active_class(if_route('user_admin.index'), 'selected') }}"></span>
                    <span class="arrow {{ active_class(if_route('user_admin.index'), 'open') }}"></span>
                </a>
                {{--<ul class="sub-menu">--}}
                    {{--<li class="{{ active_class(if_route('user_admin.index'))}}">--}}
                        {{--<a href="{!! route('user_admin.index') !!}">--}}
                            {{--<i class="fa fa-list"></i>--}}
                            {{--{!! "運営者ユーザ一覧" !!}--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="{{ active_class(if_route('user_admin.create_view'))}}">--}}
                        {{--<a href="{!! route('user_admin.create_view') !!}">--}}
                            {{--<i class="fa fa-plus"></i>--}}
                            {{--{!! "運営者ユーザ作成" !!}--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            </li>
            @endrole
            {{--@role('super_admin')--}}
            {{--<li class="start {{ active_class(if_route('class.index')) }}">--}}
                {{--<a href="{!! url('/class/index') !!}">--}}
                    {{--<i class="fa fa-book"></i>--}}
                    {{--<span class="title">{!! "クラス管理"!!}</span>--}}
                    {{--<span class="select {{ active_class(if_route('class.index'), 'selected') }}"></span>--}}
                    {{--<span class="arrow {{ active_class(if_route('class.index'), 'open') }}"></span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--@endrole--}}
            <li class="start {{ active_class(if_route('user.index')) }}">
                <a href="{!! route('user.index') !!}">
                    <i class="icon-users"></i>
                    <span class="title">{!! "生徒管理"!!}</span>
                    <span class="select {{ active_class(if_route('user.index'), 'selected') }}"></span>
                    <span class="arrow {{ active_class(if_route('user.index'), 'open') }}"></span>
                </a>
                {{--<ul class="sub-menu">--}}
                    {{--<li class="{{ active_class(if_route('user.index'))}}">--}}
                        {{--<a href="{!! route('user.index') !!}">--}}
                            {{--<i class="fa fa-list"></i>--}}
                            {{--{!! "ユーザ一覧" !!}--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="{{ active_class(if_route('user.create_view'))}}">--}}
                        {{--<a href="{!! route('user.create_view') !!}">--}}
                            {{--<i class="fa fa-plus"></i>--}}
                            {{--{!! "ユーザ作成" !!}--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            </li>
            @role('super_admin')
            <li class="start {{ active_class(if_route('question.index')) }}">
                <a href="javascript:;">
                    <i class="icon-question"></i>
                    <span class="title">{!! "質問管理"!!}</span>
                    <span class="select {{ active_class(if_route('question.index'), 'selected') }}"></span>
                    <span class="arrow {{ active_class(if_route('question.index'), 'open') }}"></span>
                </a>
                <ul class="sub-menu">
                    <li class="{{ active_class(if_route('question.index'))}}">
                        <a href="{!! route('question.index') !!}">
                            <i class="fa fa-list"></i>
                            {!! "質問一覧" !!}
                        </a>
                    </li>
                    {{--<li class="{{ active_class(if_route('question.create_view'))}}">--}}
                        {{--<a href="{!! route('question.create_view') !!}">--}}
                            {{--<i class="fa fa-plus"></i>--}}
                            {{--{!! "質問作成" !!}--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    <li class="{{ active_class(if_route('question_type.index'))}}">
                        <a href="{!! route('question_type.index') !!}">
                            <i class="fa fa-question"></i>
                            {!! "質問タイプ" !!}
                        </a>
                    </li>
                </ul>
            </li>
            @endrole
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>
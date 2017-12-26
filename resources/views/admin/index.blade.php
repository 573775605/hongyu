@extends('admin.layout.master')

@section('title','平台首页')

@section('css')
    <link href="{{asset('asset/admin/css/animate.css')}}" rel="stylesheet">
@stop

@section('body','fixed-sidebar full-height-layout gray-bg')

@section('content')
    <div id="wrapper">
        <!--左侧导航开始-->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="nav-close">
                <i class="fa fa-times-circle"></i>
            </div>
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear">
                                <span class="block m-t-xs" style="font-size:20px;">
                                    <i class="fa fa-area-chart"></i>
                                    <strong class="font-bold">小红鱼管理平台</strong>
                                </span>
                            </span>
                            </a>
                        </div>
                        <div class="logo-element">小红鱼管理平台</div>
                    </li>
                    <li>
                        <a class="J_menuItem" href="{{ url('admin/index/home') }}">
                            <i class="fa fa-home"></i>
                            <span class="nav-label">主页</span>
                        </a>
                    </li>
                    <li class="line dk"></li>
                    <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                        <span class="ng-scope">功能列表</span>
                    </li>
                    {!! $menuHtml !!}
                    <li class="line dk"></li>
                </ul>
            </div>
        </nav>
        <!--左侧导航结束-->
        <!--右侧部分开始-->
        <div id="page-wrapper" class="gray-bg dashbard-1">
            {{--右侧顶部--}}
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-info " href="#">
                        <i class="fa fa-bars"></i>
                    </a>

                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <a class="J_menuItem" href="{{ url('admin/manager/change-password') }}"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span>修改密码</a>
                        </li>
                        <li><a href="{{ url('admin/manager/logout') }}"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>登出</a></li>
                    </ul>
                </nav>
            </div>

            <div class="row J_mainContent" id="content-main">
                <iframe id="J_iframe" width="100%" height="100%" src="{{ url('admin/index/home') }}" frameborder="0" data-id="main_ifram" seamless></iframe>
            </div>
        </div>
        <!--右侧部分结束-->
    </div>
@stop

@section('js')
    <script src="{{asset('asset/admin/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{asset('asset/admin/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
    <!-- 自定义js -->
    <script src="{{asset('asset/admin/js/hAdmin.js?v=4.1.0')}}"></script>
    <script type="text/javascript" src="{{asset('asset/admin/js/index.js')}}"></script>
@stop
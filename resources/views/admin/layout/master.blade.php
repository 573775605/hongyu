<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{csrf_token()}}">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>小红鱼管理平台 - @yield('title')</title>

    {{--<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">--}}

    <link href="{{ asset('asset/admin/css/bootstrap.min.css?v=3.3.6') }}" rel="stylesheet">
    <link href="{{ asset('asset/admin/css/font-awesome.min.css?v=4.4.0') }}" rel="stylesheet">
    {{--    <link href="{{ asset('asset/admin/css/animate.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('asset/admin/css/style.css?v=4.1.0') }}" rel="stylesheet">
    <link href="{{asset('asset/admin/css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">

    @yield('css')

</head>

<body class="@yield('body')">

@yield('content')

<script src="{{ asset('asset/admin/js/jquery.min.js?v=2.1.4') }}"></script>
<script src="{{ asset('asset/admin/js/jquery.cxselect.min.js?v=2.1.4') }}"></script>
<script src="{{ asset('asset/admin/js/bootstrap.min.js?v=3.3.6') }}"></script>
<script src="{{ asset('asset/admin/js/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{ asset('asset/admin/js/plugins/layer/layer.min.js')}}"></script>

@yield('js')

</body>

</html>

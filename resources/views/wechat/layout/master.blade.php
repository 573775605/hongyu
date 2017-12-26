<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>小红鱼 - @yield('title')</title>
    <meta name="_token" content="{{csrf_token()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    @section('mui-css')
        <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/mui.min.css')}}"/>
    @show
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/index.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/public.css')}}"/>
    @yield('css')
</head>
<body class="@yield('body')">
@yield('content')
</body>
</html>
<script src="{{asset('asset/wechat/js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
@section('mui-js')
    <script src="{{asset('asset/wechat/js/mui.min.js')}}" type="text/javascript" charset="utf-8"></script>
@show
<script>
    var flag = false;
    function checkForm() {
        if (flag === true) {
            return false;
        }
        flag = true;
        return true;
    }
</script>
@yield('js')
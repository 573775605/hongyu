@extends('wechat.layout.master')

@section('title','商品浏览')

@section('css')
    <style type="text/css">
        .TShareTwo {
            position: absolute;
            top: 0;
            right: 10px;
            width: 70%;
            z-index: 999;
        }

        .TShareTwo img {
            width: 100%;
        }

        .bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #000;
            -moz-opacity: 0.4;
            -webkit-opacity: 0.4;
            opacity: 0.4;
        }

    </style>
@stop

@section('content')
    <div class="bg"></div>
    <div class="TShareTwo">
        <img src="{{asset('asset/wechat/img/tips2.png')}}"/>
    </div>
@stop

@section('js')
    <script src="{{asset('asset/ext/layer/layer.min.js')}}"></script>
    <script>
        $(function () {
            //获取页面内容高度
            var wH = $(document).height();
            $(".bg").css("height", wH);

            //点击背景关闭分享
            $(".bg").click(function () {
                $(".TShareTwo,.bg").hide();
            })

            $(".TShareTwo,.bg").show();
        })
    </script>
@stop
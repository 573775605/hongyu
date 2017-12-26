@extends('wechat.layout.master')

@section('title','商品浏览')

@section('css')
    <style type="text/css">
        .btniframe, .btniframe input {
            position: fixed;
            bottom: 0;
            left: 0;
            color: #fff;
            font-size: 14px;
            width: 100%;
            text-align: center;
            background-color: #F8525A;
            height: 40px;
            line-height: 40px;
        }

        .contiframe {
            width: 100%;
        }

    </style>
@stop

@section('content')
    <div class="contiframe">
        <iframe id="frame_content" name="frame_content" src="{{request('url')}}" width="100%" height="100%" scrolling="yes" frameborder="0"></iframe>
    </div>

    <div style="height: 40px;width: 100%;"></div>
    <div class="btniframe">
        <input type="button" value="一键发布" onclick="issue()"/>
    </div>
@stop

@section('js')
    <script src="{{asset('asset/ext/layer/layer.min.js')}}"></script>
    <script>
        function issue() {
            console.log($('#frame_content').contents())
        }
        $(function () {
            var wHeight = $(window).height();
            $(".contiframe").css("height", wHeight);
        })
    </script>
@stop
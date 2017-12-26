@extends('wechat.layout.master')

@section('title','商家地址')

@section('css')
    <style type="text/css">
        * {
            margin: 0px;
            padding: 0px;
        }

        body, button, input, select, textarea {
            font: 12px/16px Verdana, Helvetica, Arial, sans-serif;
        }

        #info {
            width: 603px;
            padding-top: 3px;
            overflow: hidden;
        }

        .btn {
            width: 112px;
        }

        #container {
            min-width: 600px;
            min-height: 767px;
        }
    </style>
@stop

@section('content')
    <div class="dingweiall">
        {{--<span class="dingweiNum">距您：24km</span>--}}

    </div>
    <div class="map" id="container">

    </div>
@stop

@section('js')
    <script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
    <script>
        var center = new qq.maps.LatLng({{$goods->store_lat or request('lat')}}, {{$goods->store_lng or request('lng')}});
        var map = new qq.maps.Map(document.getElementById('container'), {
            center: center,
            zoom: 13
        });
        //创建marker
        var marker = new qq.maps.Marker({
            position: center,
            map: map
        });
        var label = new qq.maps.Label({
            position: center,
            map: map,
            content: '{{isset($goods)?$goods->getSite().'('.$goods->store_name.')':request('address').'('.request('name').')'}}'
        });
    </script>
@stop
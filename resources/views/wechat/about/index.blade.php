@extends('wechat.layout.master')

@section('title','关于我们')

@section('content')
    <ul class="aboutUs">
        @foreach($rows as $v)
            <li class="jiantou"><a href="{{url('wechat/about/article-details/'.$v->id)}}">{{$v->title}}</a></li>
        @endforeach
            <li class="jiantou"><a href="{{url('wechat/user/feedback')}}">意见和投诉</a></li>
    </ul>
    <style>
        .aboutUs li{            width: 100%;}

    </style>
@stop
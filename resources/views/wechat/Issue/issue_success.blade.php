@extends('wechat.layout.master')

@section('title','发布成功')

@section('content')
    <div class="SuccessAll"></div>
    <p class="SuccessAllword1">恭喜您发布成功，等待报价！</p>
    <p class="SuccessAllword2">报价结果将以系统消息通知！</p>


    <a class="whitebtn80" href="{{url('wechat/address')}}?is_issue=1">
        <input type="button" name="" id="" value="继续发布"/>
    </a>

    <a class="redbtn80 " href="{{url('wechat/demand/index')}}">
        <input type="button" name="" id="" value="查看"/>
    </a>

    <a class="yellowbtn80 " href="{{url('wechat')}}">
        <input type="button" name="" id="" value="首页"/>
    </a>
@stop

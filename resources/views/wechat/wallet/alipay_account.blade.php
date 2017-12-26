@extends('wechat.layout.master')

@section('title','支付宝账号')

@section('content')
    <form action="" method="post" onsubmit="return submitCheck()">
        {!! csrf_field() !!}
        <dl class="dlword clearfix">
            <dt class="fl">账户姓名：</dt>
            <dd class="fl">
                <input type="text" name="name" value="{{$row->name or ''}}">
            </dd>
        </dl>
        <dl class="dlword clearfix">
            <dt class="fl">支付宝账号：</dt>
            <dd class="fl">
                <input type="text" name="account" value="{{$row->account or ''}}">
            </dd>
        </dl>
        <a class="redbtn90">
            <input type="submit" value="保存"/>
        </a>
    </form>
@stop

@section('js')
    <script src="{{asset('asset/ext/layer/layer.min.js')}}"></script>
    <script>
        function submitCheck() {
            if ($('input[name=name]').val() == '') {
                layer.msg('请填写账户姓名');
                return false;
            }
            if ($('input[name=account]').val() == '') {
                layer.msg('请填写支付宝账户');
                return false;
            }
            return true;
        }
    </script>
@stop
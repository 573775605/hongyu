@extends('wechat.layout.master')

@section('title','添加银行卡号')

@section('content')
    <form action="" method="post" onsubmit="return submitCheck()">
        {!! csrf_field() !!}
        <dl class="dlword clearfix">
            <dt class="fl"> 姓名：</dt>
            <dd class="fl">
                <input type="text" name="name">
            </dd>
        </dl>

        <dl class="dlword clearfix">
            <dt class="fl">卡号：</dt>
            <dd class="fl">
                <input type="text" name="account">
            </dd>
        </dl>
        <dl class="dlword clearfix">
            <dt class="fl">银行：</dt>
            <dd class="fl">
                <input type="text" name="bank_name">
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
            if ($('input[name=bank_name]').val() == '') {
                layer.msg('请输入银行名称');
                return false;
            }
            if ($('input[name=account]').val() == '') {
                layer.msg('请填写银行卡号');
                return false;
            }
            return true;
        }
    </script>
@stop
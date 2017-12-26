@extends('wechat.layout.master')

@section('title','保证金充值')

@section('content')
    <form action="" method="post" onsubmit="return submitCheck()">
        {!! csrf_field() !!}
        <dl class="dlinput clearfix">
            <dt class="fl">充值金额：</dt>
            <dd class="fl">
                <div class="dlinputtext">
                    <input type="number" placeholder="输入金额" name="price"/>
                    {!! $errors->first('price','<span class="help-block m-b-none" style="color: red">:message</span>') !!}
                </div>
            </dd>
        </dl>

        <dl class="offers clearfix">
            <dt><em>*</em>备注：</dt>
            <dd>
                <input type="checkbox" checked="checked">
                <a class="Remarks" href="{{url('wechat/about/explain-article/pledge_frost_explain')}}">
                    保证金冻结和退回规则
                </a>
            </dd>
        </dl>

        <a class="redbtn90">
            <input type="submit" value="确认"/>
        </a>
    </form>
@stop

@section('js')
    <script src="{{asset('asset/ext/layer/layer.min.js')}}"></script>
    <script>
        function submitCheck() {
            if ($('input[name=price]').val() == '') {
                layer.msg('请输入充值金额');
                return false;
            }
            return true;
        }
    </script>
@stop
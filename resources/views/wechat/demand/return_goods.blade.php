@extends('wechat.layout.master')

@section('title','退货申请')

@section('content')
    <form action="" method="post" onsubmit="return submitCheck()">
        {!! csrf_field() !!}
        <input type="hidden" name="type" value="{{request('type')}}">
        <dl class="offers clearfix">
            <dt class="mt5">申请原因：</dt>
            <dd>
                <div class="OrderLotextarea">
                    <textarea placeholder="请输入申请原因" name="remark"></textarea>
                </div>
            </dd>
        </dl>
        @if(request('type')=='return-money')
            <dl class="offers clearfix">
                <dt>退款金额：</dt>
                <dd>
                    <span class="wred">¥{{$demand->price}}</span>
                </dd>
            </dl>
        @endif
        <a class="redbtn90">
            <input type="submit" value="确认"/>
        </a>
    </form>
@stop

@section('js')
    <script src="{{asset('asset/ext/layer/layer.min.js')}}"></script>
    <script>
        function submitCheck() {
            if ($('textarea[name=remark]').val() == '') {
                layer.msg('请填写申请原因');
                return false;
            }
            return true;
        }
    </script>
@stop
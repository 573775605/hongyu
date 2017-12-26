@extends('wechat.layout.master')

@section('title','发布需求')

@section('mui-css')
@stop

@section('content')
    <form action="{{url('wechat/issue/index')}}" onsubmit="return submitCheck()">
        <input type="hidden" name="action" value="type">
        <div class="clearfix paiall">
            <a class="fl pai" href="{{url('wechat/issue/index?type=upload&action=type')}}">
                拍摄/相册
                <input type="radio" name="type" value="upload" style="display: none;">
            </a>
            <a class="fr lian" href="{{url('wechat/issue/index?type=link&action=type')}}">
                商品链接
                <input type="radio" name="type" value="link" style="display: none;">
            </a>
        </div>
        {{--<a class="redbtn90" style="position: fixed; bottom: 10px;left:0px; ">--}}
        {{--<input type="submit" value="确认"/>--}}
        {{--</a>--}}
    </form>
@stop

@section('js')
    <script src="{{asset('asset/ext/layer/layer.min.js')}}"></script>
    <script type="text/javascript">
        function submitCheck() {
            if ($('input[name=type]:checked').length == 0) {
                layer.msg('请选择发布类型');
                return false;
            }
            return true;
        }
        $(function () {
            $(".paiall a").click(function () {
                $(".paiall a").removeClass("active");
                $(this).addClass("active");
                $(this).find('input').prop('checked', true);
            })
        })
    </script>
@stop
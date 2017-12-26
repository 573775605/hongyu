@extends('wechat.layout.master')

@section('title','意见反馈')

@section('content')
    <form action="" method="post" onsubmit="return submitCheck()">
        {!! csrf_field() !!}
        <dl class="offers clearfix">
            <dt class="mt5">意见和投诉：</dt>
            <dd>
                <div class="OrderLotextarea">
                    <textarea placeholder="请输入问题或意见" name="content"></textarea>
                </div>
            </dd>
        </dl>
        <a class="redbtn90">
            <input type="submit" value="提交"/>
        </a>
    </form>
@stop

@section('js')
    <script src="{{asset('asset/ext/layer/layer.min.js')}}"></script>
    <script>
        function submitCheck() {
            if ($('textarea[name=content]').val() == '') {
                layer.msg('请描述相关内容');
                return false;
            }
            return true;
        }
    </script>
@stop
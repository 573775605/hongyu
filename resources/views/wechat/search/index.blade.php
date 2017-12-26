@extends('wechat.layout.master')

@section('title','需求搜索')

@section('body','bgfff')

@section('content')
    <div class="searchSS">
        <form action="{{url('wechat/search/result')}}" onsubmit="return submitCheck()">
            <div class=" search2 " style="width: 100%;">
                <input type="text" name="keyword" placeholder="搜索您要找的宝贝"/>
            </div>
        </form>
    </div>
    <p class="history">历史记录</p>
    <ul class="historyUL clearfix">
        @foreach(Cookie::get('history_search',[]) as $v)
            <li><a href="{{url('wechat/search/result?keyword='.$v)}}">{{$v}}</a></li>
        @endforeach
    </ul>
    <div class="historyclear" onclick="delCookie()">
        清空搜索历史
    </div>
@stop

@section('js')
    <script src="{{asset('asset/ext/layer/layer.min.js')}}"></script>
    <script>
        function submitCheck() {
            if ($('input[name=keyword]').val() == '') {
                layer.msg('请输入搜索关键字');
                return false;
            }
            return true;
        }

        function delCookie() {
            $.post("{{url('wechat/search/clear-search')}}",
                {_token: '{{csrf_token()}}'},
                function (data, status) {
                    if (data.status != 1) {
                        layer.msg(data.message);
                    } else {
                        location.reload();
                    }
                });
        }
    </script>
@stop
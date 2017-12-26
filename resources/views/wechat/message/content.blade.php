@extends('wechat.layout.master')

@section('title',$title)

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('asset/ext/dropload/dropload.css')}}">
@stop

@section('content')
    <div id="dropload">
        <div class="p3" id="list">
            @foreach($message as $v)
                <div class="clearfix mt10">
                    <div class="fl XQdata">
                        {{$v->create_time}}
                    </div>
                    <div class="fr">
                        <div class="XQbtnselectred" onclick="delMessage({{$v->id}})">
                            <input type="button" value="删除"/>
                        </div>
                    </div>
                </div>
                <div class="XQnewcontall">
                    <div class="XQnewcontit ellipsis1">
                        {{$v->title}}
                    </div>
                    <div class="XQnewcont">
                        {{$v->content}}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@stop

@section('js')
    <script src="{{asset('asset/ext/dropload/dropload.min.js')}}"></script>
    <script>
        function delMessage(id) {
            $.post("{{url('wechat/message/remove')}}/" + id,
                {_token: '{{csrf_token()}}'},
                function (data, status) {
                    if (data.status != 1) {
                        alert('删除失败');
                    } else {
                        location.reload();
                    }
                });
        }
        var page = 2, pageTotal ={{$message->lastPage()}};
        $('#dropload').dropload({
            scrollArea: window,
            domDown: {
                domClass: "dropload-down",
                domRefresh: '<div class="dropload-refresh" style="display: none;">↑上拉加载更多</div>',
                domLoad: '<div class="dropload-load"><span class="loading"></span>加载中...</div>',
                domNoData: '<div class="dropload-noData">{{$message->lastPage()?'没有更多数据':'暂无数据'}}</div>'
            },
            loadDownFn: function (me) {
                $.post("{{request()->getUri()}}",
                    {_token: '{{csrf_token()}}', page: page},
                    function (data, status) {
                        $('#list').append(data.data.rows);
                        page++;
                        if (page > pageTotal) {
                            // 锁定
                            me.lock();
                            // 无数据
                            me.noData();
                        }
                        me.resetload();
                    });
            }
        });
    </script>
@stop
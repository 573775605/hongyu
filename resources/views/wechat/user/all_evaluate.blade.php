@extends('wechat.layout.master')

@section('title','所有评价')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('asset/ext/dropload/dropload.css')}}">
@stop

@section('body','bgf9')

@section('content')
    <div class="InformationView">
        <div class="InformationViewimg">
            <img src="{{asset('asset/wechat/img/3.png')}}"/>
        </div>
        <div class="InformationViewicon">
            <img src="{{$user->data->img_url or ''}}"/>
        </div>
    </div>
    <div class="IVadress">
        <p class="ellipsis1 IVadressword1">{{$user->data->nickname or ''}}</p>
    </div>

    <p class="IVtit">收到的评价</p>
    <div id="dropload">
        <ul class="evaluateUl " id="list">
            @foreach($rows as $v)
                <li class="clearfix">
                    <div class="evaluateUlimg">
                        <img src="{{$v->evaluateUser->img_url or ''}}"/>
                    </div>
                    <div class="evaluateUlR">
                        <div class="clearfix evaluateUltit">
                            <div class="fl evaluateUltit1">
                                <span class="ellipsis1">{{$v->evaluateUser->nickname or ''}}</span>
                            </div>
                            <div class="fr evaluateUltit2">
                                <span class="ellipsis1">{{$v->create_time}}</span>
                            </div>
                        </div>
                        <div class="evaluateUltit3 ellipsis1">
                            {{$v->content}}
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@stop

@section('js')
    <script src="{{asset('asset/ext/dropload/dropload.min.js')}}"></script>
    <script>
        var page = 2, pageTotal ={{$rows->lastPage()}};
        $('#dropload').dropload({
            scrollArea: window,
            domDown: {
                domClass: "dropload-down",
                domRefresh: '<div class="dropload-refresh" style="display: none;">↑上拉加载更多</div>',
                domLoad: '<div class="dropload-load"><span class="loading"></span>加载中...</div>',
                domNoData: '<div class="dropload-noData">{{$rows->lastPage()?'没有更多数据':'暂无数据'}}</div>'
            },
            loadDownFn: function (me) {
                $.post("{{request()->url()}}",
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
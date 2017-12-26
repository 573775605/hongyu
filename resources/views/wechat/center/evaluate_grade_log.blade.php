@extends('wechat.layout.master')

@section('title','评价详情')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('asset/ext/dropload/dropload.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/mingxi.css')}}"/>
@stop

@section('content')
    <div id="dropload">
        <ul class="MlevelList" id="list">
            @foreach($evaluate as $v)
                <li>
                    <p class="MlevelListword1">{{$v->create_time}}</p>
                    <div class="MlevelListword2">
                        <dl class="MXdlall borderB clearfix">
                            <dt>订单号：</dt>
                            <dd>{{$v->demand->order_number or ''}}</dd>
                        </dl>

                        <dl class="MXdlall clearfix">
                            <dt>购买商品获得：</dt>
                            @if(request('type')=='issue')
                                <dd><span class="Mlevelgreen">+ {{$v->grade}}</span></dd>
                            @else
                                <dd><span class="Mlevelgreen">+ {{$v->avg_grade}}</span></dd>
                            @endif
                        </dl>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@stop

@section('js')
    <script src="{{asset('asset/ext/dropload/dropload.min.js')}}"></script>
    <script>
        var page = 2, pageTotal ={{$evaluate->lastPage()}};
        $('#dropload').dropload({
            scrollArea: window,
            domDown: {
                domClass: "dropload-down",
                domRefresh: '<div class="dropload-refresh" style="display: none;">↑上拉加载更多</div>',
                domLoad: '<div class="dropload-load"><span class="loading"></span>加载中...</div>',
                domNoData: '<div class="dropload-noData">{{$evaluate->lastPage()?'没有更多数据':'暂无数据'}}</div>'
            },
            loadDownFn: function (me) {
                $.post("{{url('wechat/center/evaluate-grade-log?type='.request('type'))}}",
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
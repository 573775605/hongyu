@extends('wechat.layout.master')

@section('title','保证金明细')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/mingxi.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('asset/ext/dropload/dropload.css')}}">
@stop

@section('content')
    <div id="dropload">
        <ul class="MlevelList" id="list">
            @foreach($rows as $v)
                <li>
                    <p class="MlevelListword1">{{$v->create_time}}</p>
                    <div class="MlevelListword2">
                        @if($v->demand_id)
                            <dl class="MXdlall borderB clearfix">
                                <dt>订单号：</dt>
                                <dd>{{$v->demand->order_number}}</dd>
                            </dl>
                        @endif
                        <dl class="MXdlall clearfix">
                            <dt>{{$v->remark}}：</dt>
                            <dd><span class="{{$v->change_pledge>0?'Mlevelgreen':'Mlevelred'}}">¥{{$v->change_pledge}}</span></dd>
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
                $.post("{{url('wechat/wallet/pledge-log')}}",
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
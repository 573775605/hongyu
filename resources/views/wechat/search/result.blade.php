@extends('wechat.layout.master')

@section('title','搜索结果')

@section('css')
    {{--    <link rel="stylesheet" type="text/css" href="{{asset('asset/ext/dropload/dropload.css')}}">--}}
@stop

@section('content')
    <div class="mui-content">
        <div id="dropload">
            <ul class="mui-table-view OrderlistUl" id="list">
                @foreach($demand as $v)
                    <li>
                        <div class="Uneedtit clearfix">
                            <span class="Uword2">订单号:{{$v->order_number or ''}}</span>
                            <span class="Uorder">订单总额:<em class="Iprice">¥<em class="Iprice2">{{$v->known_price or ''}}</em></em></span>
                            <span class="Idistance">{{$v->create_time or ''}}</span>
                        </div>

                        <div class="Uneedcont clearfix" onclick="location.href='{{url('wechat/tender/demand-details/'.$v->id)}}'">
                            <div class="Uneedcontimg ">
                                <img src="{{$v->demandGoods->first()->img->url or ''}}">
                            </div>
                            <div class="fl Uneedcontwords">
                                <p class="Uneedcontwords1 ellipsis1">{{$v->demandGoods->first()->name or ''}}</p>
                                <p class="Uneedcontwords2">
                                    <em class="Uneedred1">¥<span class="Uneedred2">{{$v->demandGoods->first()->known_unit_price or ''}}</span></em> /
                                    *{{$v->demandGoods->first()->count or ''}}{{$v->demandGoods->first()->unit or ''}}</p>
                                <p class="Uneedcontwords3 clearfix">
                                    <span class="fl">{{isset($v->demandGoods)?$v->demandGoods->first()->getSite():''}}</span></p>
                            </div>
                        </div>

                        <div class="clearfix Uneedtime">
                            <div class="{{$v->is_select?'UneedButtonhuise':'UneedButtonred'}} fl">
                                <input type="button" value="{{$v->is_select?'历史红利':'寻找红利'}}"/>
                            </div>
                            @if($v->status==1)
                                <div class="timespan fl" id="time{{$v->id}}">
                                    <span class="day_show">0</span>&nbsp;<em>天</em>
                                    <span class="hour_show"><s id="h"></s>0</span>&nbsp;<em>时</em>
                                    <span class="minute_show"><s></s>0</span>&nbsp;<em>分</em>
                                    <span class="second_show"><s></s>0</span>&nbsp;<em>秒</em>
                                </div>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@stop

@section('js')
    {{--    <script src="{{asset('asset/ext/dropload/dropload.min.js')}}"></script>--}}
    <script>
        function timer(intDiff, obj) {//倒计时
            window.setInterval(function () {
                var day = 0,
                    hour = 0,
                    minute = 0,
                    second = 0;//时间默认值
                if (intDiff > 0) {
                    day = Math.floor(intDiff / (60 * 60 * 24));
                    hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
                    minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
                    second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
                }
                if (minute <= 9) minute = '0' + minute;
                if (second <= 9) second = '0' + second;
                $(obj + ' .day_show').html(day);
                $(obj + ' .hour_show').html('<s id="h"></s>' + hour);
                $(obj + ' .minute_show').html('<s></s>' + minute);
                $(obj + ' .second_show').html('<s></s>' + second);
                intDiff--;
            }, 1000);
        }

        $(function () {
            @foreach($demand as $v)
            timer(parseInt({{$v->end_time-time()}}), "#time{{$v->id}}");
            @endforeach
        })
        {{--var page = 2, pageTotal ={{$rows->lastPage()}};--}}
        {{--$('#dropload').dropload({--}}
        {{--scrollArea: window,--}}
        {{--domDown: {--}}
        {{--domClass: "dropload-down",--}}
        {{--domRefresh: '<div class="dropload-refresh" style="display: none;">↑上拉加载更多</div>',--}}
        {{--domLoad: '<div class="dropload-load"><span class="loading"></span>加载中...</div>',--}}
        {{--domNoData: '<div class="dropload-noData">{{$rows->lastPage()?'没有更多数据':'暂无数据'}}</div>'--}}
        {{--},--}}
        {{--loadDownFn: function (me) {--}}
        {{--$.post("{{url('wechat/center/tender-list')}}",--}}
        {{--{_token: '{{csrf_token()}}', page: page},--}}
        {{--function (data, status) {--}}
        {{--$('#list').append(data.data.rows);--}}
        {{--page++;--}}
        {{--if (page > pageTotal) {--}}
        {{--// 锁定--}}
        {{--me.lock();--}}
        {{--// 无数据--}}
        {{--me.noData();--}}
        {{--}--}}
        {{--me.resetload();--}}
        {{--});--}}
        {{--}--}}
        {{--});--}}
    </script>
@stop
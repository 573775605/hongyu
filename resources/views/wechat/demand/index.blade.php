@extends('wechat.layout.master')

@section('title','订单列表')
@section('body','background: #F7F7F7;')
@section('content')
    <div class="mui-content">
        <div id="slider" class="mui-slider mui-fullscreen">
            <div id="sliderSegmentedControl" class="mui-scroll-wrapper mui-slider-indicator mui-segmented-control mui-segmented-control-inverted">
                <div class="mui-scroll">
                    <a class="mui-control-item mui-active" href="#item0mobile">全部</a>
                    <a class="mui-control-item " href="#item1mobile">
                        待发布
                    </a>
                    <a class="mui-control-item" href="#item2mobile">
                        发布中
                    </a>
                    <a class="mui-control-item" href="#item3mobile">
                        待支付
                    </a>
                    <a class="mui-control-item" href="#item4mobile">
                        待发货
                    </a>
                    <a class="mui-control-item" href="#item5mobile">
                        待收货
                    </a>
                    <a class="mui-control-item" href="#item6mobile">
                        待评价
                    </a>
                    <a class="mui-control-item" href="#item7mobile">
                        退款/货
                    </a>
                </div>
            </div>

            <div class="mui-slider-group">
                <div id="item0mobile" class="mui-slider-item mui-control-content mui-active">
                    <div class="mui-scroll-wrapper">
                        <div class="mui-scroll" status="0">
                            <div class="Orderserach ">
                                <form action="">
                                    <p>
                                        <input type="text" placeholder="请输入订单编号或商品名称" name="keyword" value="{{request('keyword')}}"/>
                                    </p>
                                </form>
                            </div>
                            <ul class="mui-table-view OrderlistUl"></ul>
                        </div>
                    </div>
                </div>
                <div id="item1mobile" class="mui-slider-item mui-control-content">
                    <div id="scroll1" class="mui-scroll-wrapper">
                        <div class="mui-scroll" status="-1">
                            <div class="Orderserach ">
                                <form action="">
                                    <p>
                                        <input type="text" placeholder="请输入订单编号或商品名称" name="keyword" value="{{request('keyword')}}"/>
                                    </p>
                                </form>
                            </div>
                            <ul class="mui-table-view OrderlistUl">
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="item2mobile" class="mui-slider-item mui-control-content">
                    <div class="mui-scroll-wrapper">
                        <div class="mui-scroll" status="1">
                            <div class="Orderserach ">
                                <form action="">
                                    <p>
                                        <input type="text" placeholder="请输入订单编号或商品名称" name="keyword" value="{{request('keyword')}}"/>
                                    </p>
                                </form>
                            </div>
                            <ul class="mui-table-view OrderlistUl">
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="item3mobile" class="mui-slider-item mui-control-content">
                    <div class="mui-scroll-wrapper">
                        <div class="mui-scroll" status="2">
                            <div class="Orderserach ">
                                <form action="">
                                    <p>
                                        <input type="text" placeholder="请输入订单编号或商品名称" name="keyword" value="{{request('keyword')}}"/>
                                    </p>
                                </form>
                            </div>
                            <ul class="mui-table-view OrderlistUl">
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="item4mobile" class="mui-slider-item mui-control-content">
                    <div class="mui-scroll-wrapper">
                        <div class="mui-scroll" status="3">
                            <div class="Orderserach ">
                                <form action="">
                                    <p>
                                        <input type="text" placeholder="请输入订单编号或商品名称" name="keyword" value="{{request('keyword')}}"/>
                                    </p>
                                </form>
                            </div>
                            <ul class="mui-table-view OrderlistUl">
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="item5mobile" class="mui-slider-item mui-control-content">
                    <div class="mui-scroll-wrapper">
                        <div class="mui-scroll" status="4">
                            <div class="Orderserach ">
                                <form action="">
                                    <p>
                                        <input type="text" placeholder="请输入订单编号或商品名称" name="keyword" value="{{request('keyword')}}"/>
                                    </p>
                                </form>
                            </div>
                            <ul class="mui-table-view OrderlistUl">
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="item6mobile" class="mui-slider-item mui-control-content">
                    <div class="mui-scroll-wrapper">
                        <div class="mui-scroll" status="5">
                            <div class="Orderserach ">
                                <form action="">
                                    <p>
                                        <input type="text" placeholder="请输入订单编号或商品名称" name="keyword" value="{{request('keyword')}}"/>
                                    </p>
                                </form>
                            </div>
                            <ul class="mui-table-view OrderlistUl" >
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="item7mobile" class="mui-slider-item mui-control-content">
                    <div class="mui-scroll-wrapper">
                        <div class="mui-scroll" status="-2">
                            <div class="Orderserach ">
                                <form action="">
                                    <p>
                                        <input type="text" placeholder="请输入订单编号或商品名称" name="keyword" value="{{request('keyword')}}"/>
                                    </p>
                                </form>
                            </div>
                            <ul class="mui-table-view OrderlistUl">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{asset('asset/wechat/js/mui.pullToRefresh.js')}}"></script>
    <script src="{{asset('asset/wechat/js/mui.pullToRefresh.material.js')}}"></script>
    <script>
        mui.init();
        (function ($) {
            //阻尼系数
            var deceleration = mui.os.ios ? 0.003 : 0.0009;
            $('.mui-scroll-wrapper').scroll({
                bounce: true,
                indicators: true, //是否显示滚动条
                deceleration: deceleration
            });

            $.ready(function () {
                //循环初始化所有上拉加载。
                $.each(document.querySelectorAll('.mui-slider-group .mui-scroll'), function (index, pullRefreshEl) {
                    $(pullRefreshEl).pullToRefresh({
                        up: {
                            auto: true,
                            callback: function () {
                                paging(this);
                            }
                        }
                    });
                });
            });
        })(mui);
        //订单分页
        function paging(event) {
            var status = $(event.element).attr('status');
            var page = typeof $(event.element).attr('page') == 'undefined' ? 1 : parseInt($(event.element).attr('page'));
            var keyword = '{!! request('keyword')?:'' !!}';
            $.post("{{url('wechat/demand/paging')}}",
                {_token: '{{csrf_token()}}', page: page, status: status, keyword: keyword},
                function (data, status) {
                    $(event.element).attr('page', ++page);
                    $(event.element).find('.mui-table-view').append(data.data.rows);
//                    alert(page)
                    if (page > data.data.pageTotal) {
                        event.endPullUpToRefresh(true);
                    } else {
                        event.endPullUpToRefresh();
                    }
                });
        }

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
    </script>
@stop

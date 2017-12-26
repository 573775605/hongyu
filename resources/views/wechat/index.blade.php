@extends('wechat.layout.master')

@section('title','首页')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/swiper-3.4.2.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('asset/ext/dropload/dropload.css')}}">
    <style>
        .swiper-container1, .swiper-container2 {
            width: 100%;
            height: 100%;
        }

        .swiper-container1 .swiper-slide {
            text-align: center;
            font-size: 18px;
            background-color: #3cb2d9;
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
        }

        .swiper-container1 .swiper-pagination-bullet-active {
            background: #fff;
        }

        .swiper-container1 .swiper-pagination-bullet {
            background: rgba(255, 255, 255, 0.70);
        }

        .swiper-container2 {
            position: relative;
        }

        .swiper-container2 .swiper-pagination {
            bottom: 0;
        }

        .swiper-container2 .swiper-pagination .swiper-pagination-bullet {
            width: 10px;
            height: 3px;
            background: rgba(0, 0, 0, 0.80) !important;
            border-radius: 13px;
        }

        .swiper-container2 .swiper-pagination .swiper-pagination-bullet-active {
            background: #F8525A !important;
            border-radius: 13px;
        }

        .mui-control-content {
            background-color: white;
            min-height: 215px;
        }

        .mui-control-content .mui-loading {
            margin-top: 50px;
        }

        .mui-scroll-wrapper {
            position: inherit;
        }

        .mui-scroll {
            position: initial;
        }

        .mui-pull {
            font-weight: 500;
        }

    </style>
@stop

@section('content')
    <!--banner  search-->
    <div class="Ibanner">
        <div class="search" onclick="location.href='{{url('wechat/search/index')}}'">
            <input type="text" placeholder="搜索您要找的宝贝或订单号"/>
        </div>
        <div class="swiper-container1 bannercont">
            <div class="swiper-wrapper">
                @foreach($banner as $v)
                    <a href="{{$v->url}}">
                        <div class="swiper-slide"><img src="{{$v->img->url or ''}}"/></div>
                    </a>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <!--使用步骤-->
    <div class="p3">
        <p class="index1word">使用步骤</p>
        {{--<ul class="index1UL clearfix">--}}
        {{--<li class="Iicon1" title="逛街选商品" onclick="location.href='{{url('wechat/about/explain-article/select_goods')}}'"></li>--}}
        {{--<li class="Iicon2" title="发布红利需求" onclick="location.href='{{url('wechat/about/explain-article/issue_demand')}}'"></li>--}}
        {{--<li class="Iicon3" title="选定报价成交" onclick="location.href='{{url('wechat/about/explain-article/select_tender')}}'"></li>--}}
        {{--</ul>--}}
        <a href="{{url('wechat/about/explain-article/select_goods')}}">
            <ul class="index1UL2 clearfix">
                <li class="" title="逛街选商品">
                    <img src="{{asset('asset/wechat/img/23a.png')}}"/>
                </li>
                <li class="" title="发布红利需求">
                    <img src="{{asset('asset/wechat/img/24a.png')}}"/>
                </li>
                <li class="" title="选定报价成交">
                    <img src="{{asset('asset/wechat/img/25a.png')}}"/>
                </li>
                <span class="jiantour jxq" style="  margin-top:8px;    width: 20px;    height: 20px;"></span>
            </ul>
        </a>

        <p class="index1word2">已有 <span class="wred">{{$useUserCount}}</span> 人得到消费红利，累计节省 <span class="wred">¥{{$totalSparePrice}}</span>元</p>
    </div>
    <!--推荐商品-->
    <div class="RecommendedMall">
        <p class="RMalltit">推荐商城</p>
        <div class="swiper-container2 Ibanner2">
            <div class="swiper-wrapper">
                @foreach($store->chunk(10) as $v)
                    <div class="swiper-slide RmallUL">
                        @foreach($v as $v1)
                            <li>
                                <div class="">
                                    @if($v1->is_shield)
                                        <a href="{{url('wechat/check-browse?url='.urlencode($v1->link))}}">
                                            <img src="{{$v1->img->url or ''}}"/>
                                        </a>
                                    @else
                                        <a href="{{$v1->link}}">
                                            <img src="{{$v1->img->url or ''}}"/>
                                        </a>
                                    @endif
                                </div>
                                <p>{{$v1->name}}</p>
                            </li>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!--商品1-->
    {{--@if($demand->count()>0 && $demand->first()->demandGoods->first())--}}
    {{--<div class="index1offer clearfix" onclick="location.href='{{url('wechat/tender/demand-details/'.$demand->first()->id)}}'">--}}
    {{--<div class="fl index1offerL clearfix">--}}
    {{--<div class="fl index1offerimg">--}}
    {{--<img src="{{$demand->first()->demandGoods->first()->img->url or ''}}"/>--}}
    {{--</div>--}}
    {{--<div class="fl index1offerword">--}}
    {{--<p class="ellipsis1 word1">{{$demand->first()->demandGoods->first()->name}}</p>--}}
    {{--<p class="ellipsis1 word2">{{$demand->first()->demandGoods->first()->sku_name}}</p>--}}
    {{--<p class="ellipsis1 word2">{{$demand->first()->issue_time}}</p>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="fr index1offerR">--}}
    {{--<a class="redbtn" href="{{url('wechat/tender/demand-details/'.$demand->first()->id)}}">报价</a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--@endif--}}

    <div class="banner3" onclick="location.href='{{$centerBanner->data->url or ''}}'"><img src="{{$centerBanner->data->img->url or ''}}" alt=""></div>

    <!--急需 附近-->
    <div class="Uneeded">
        <ul class="UneededUL clearfix">
            <li class="active" name="dropload"><a href="javascript:;">急需</a></li>
            <li name="dropload1"><a href="javascript:;">附近</a></li>
        </ul>
        <div class="UneededULcont">
            <ul class="UneededULconts active" id="dropload">
                <div id="list">
                    @foreach($demand as $v)
                        <li>
                            <div class="Uneedtit clearfix">
                                <span class="Uword">订单号:{{$v->order_number}}</span>
                                <span class="Uorder">订单总额:<em class="Iprice">¥<em class="Iprice2">{{$v->known_price}}</em></em></span>
                                <span class="Idistance">{{$v->distance}}km</span>
                            </div>
                            <a href="{{url('wechat/tender/demand-details/'.$v->id)}}">
                                <div class="Uneedcont clearfix">
                                    <div class="Uneedcontimg ">
                                        <img src="{{$v->demandGoods->first()->img->url or ''}}"/>
                                    </div>
                                    <div class="fl Uneedcontwords">
                                        <p class="Uneedcontwords1 ellipsis1">{{$v->demandGoods->first()->name or ''}}</p>
                                        <p class="Uneedcontwords2">
                                            <em class="Uneedred1">¥<span class="Uneedred2">{{$v->demandGoods->first()->known_unit_price or ''}}</span></em>
                                            / *{{$v->demandGoods->first()->count or ''}}{{$v->demandGoods->first()->unit or ''}}</p>
                                        <p class="Uneedcontwords3 clearfix"><span class="fl">{{$v->getIssueSite()}}</span>
                                            <span class="UneedcontwordsR3">货源： <em class="Uneedred1">{{$v->demandGoods->first()->source or ''}}</em></span>
                                        </p>

                                    </div>
                                </div>
                            </a>
                            <div class="clearfix Uneedtime">
                                <div class="UneedButtonred fl">
                                    <input type="button" value="寻找红利中" style="line-height: 25px;"/>
                                </div>
                                <div class="timespan fl" id="time{{$v->id}}">
                                    <span class="day_show">0</span>&nbsp;<em>天</em>
                                    <span class="hour_show"><s id="h"></s>0</span>&nbsp;<em>时</em>
                                    <span class="minute_show"><s></s>0</span>&nbsp;<em>分</em>
                                    <span class="second_show"><s></s>0</span>&nbsp;<em>秒</em>
                                </div>
                                <div class="Uneedtimejuli">{{$v->issue_time}}</div>
                            </div>
                        </li>
                    @endforeach
                </div>
            </ul>
            <ul class="UneededULconts" id="dropload1">
                <div id="list1">
                    @foreach($nearbyDemand as $v)
                        <li>
                            <div class="Uneedtit clearfix">
                                <span class="Uword">订单号:{{$v->order_number}}</span>
                                <span class="Uorder">订单总额:<em class="Iprice">¥<em class="Iprice2">{{$v->known_price}}</em></em></span>
                                <span class="Idistance">{{$v->distance}}km</span>
                            </div>
                            <a href="{{url('wechat/tender/demand-details/'.$v->id)}}">
                                <div class="Uneedcont clearfix">
                                    <div class="Uneedcontimg ">
                                        <img src="{{$v->demandGoods->first()->img->url or ''}}"/>
                                    </div>
                                    <div class="fl Uneedcontwords">
                                        <p class="Uneedcontwords1 ellipsis1">{{$v->demandGoods->first()->name or ''}}</p>
                                        <p class="Uneedcontwords2">
                                            <em class="Uneedred1">¥<span class="Uneedred2">{{$v->demandGoods->first()->known_unit_price or ''}}</span></em>
                                            / *{{$v->demandGoods->first()->count or ''}}{{$v->demandGoods->first()->unit or ''}}</p>
                                        <p class="Uneedcontwords3 clearfix"><span class="fl">{{$v->getIssueSite()}}</span>
                                            <span class="UneedcontwordsR3">货源： <em class="Uneedred1">{{$v->demandGoods->first()->source or ''}}</em></span>
                                        </p>

                                    </div>
                                </div>
                            </a>
                            <div class="clearfix Uneedtime">
                                <div class="UneedButtonred fl   ">
                                    <input type="button" value="寻找红利中" style="line-height: 25px;"/>
                                </div>
                                <div class="timespan fl" id="time{{$v->id}}">
                                    <span class="day_show">0</span>&nbsp;<em>天</em>
                                    <span class="hour_show"><s id="h"></s>0</span>&nbsp;<em>时</em>
                                    <span class="minute_show"><s></s>0</span>&nbsp;<em>分</em>
                                    <span class="second_show"><s></s>0</span>&nbsp;<em>秒</em>
                                </div>
                                <div class="Uneedtimejuli">{{$v->issue_time}}</div>
                            </div>
                        </li>
                    @endforeach
                </div>
            </ul>
        </div>
    </div>
    @include('wechat.layout.footer',['active'=>'home'])
@stop

@section('js')
    <script src="{{asset('asset/wechat/js/swiper-3.4.2.min.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('asset/ext/dropload/dropload.min.js')}}"></script>
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

        var page = 2, page1 = 2, pageTotal ={{$demand->lastPage()}}, pageTotal1 ={{$nearbyDemand->lastPage()}};
        var dropload = new Array();

        dropload['dropload'] = $('#dropload').dropload({
            scrollArea: window,
            domDown: {
                domClass: "dropload-down",
                domRefresh: '<div class="dropload-refresh" style="display: none;">↑上拉加载更多</div>',
                domLoad: '<div class="dropload-load"><span class="loading"></span>加载中...</div>',
                domNoData: '<div class="dropload-noData">{{$demand->lastPage()?'没有更多数据':'暂无数据'}}</div>'
            },
            loadDownFn: function (me) {
                $.post("{{url('wechat')}}",
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
        dropload['dropload1'] = $('#dropload1').dropload({
            scrollArea: window,
            domDown: {
                domClass: "dropload-down",
                domRefresh: '<div class="dropload-refresh" style="display: none;">↑上拉加载更多</div>',
                domLoad: '<div class="dropload-load"><span class="loading"></span>加载中...</div>',
                domNoData: '<div class="dropload-noData">{{$demand->lastPage()?'没有更多数据':'暂无数据'}}</div>'
            },
            loadDownFn: function (me) {
                $.post("{{url('wechat/index/distance-sort')}}",
                    {_token: '{{csrf_token()}}', page: page1},
                    function (data, status) {
                        $('#list1').append(data.data.rows);
                        page1++;
                        if (page1 > pageTotal1) {
                            // 锁定
                            me.lock();
                            // 无数据
                            me.noData();
                        }
                        me.resetload();
                    });
            }
        });
        dropload['dropload1'].lock();
        @foreach($demand as $v)
            timer(parseInt({{$v->end_time-time()}}), "#time{{$v->id}}");
        @endforeach
    </script>
    <script>
        /***********************************banner1，banner2 开始**************************************************************/
//bannerjs
        var swiper = new Swiper('.swiper-container1', {
            pagination: '.swiper-pagination',
            paginationClickable: true
        });

        //banner2 推荐商城 js
        var swiper = new Swiper('.swiper-container2', {
            pagination: '.swiper-pagination',
            paginationClickable: true
        });
        /***********************************banner1，banner2 结束**************************************************************/


        /***********************************推荐商城，急需,附近 js 开始**************************************************************/
        $(function () {
            Rheights(); //推荐商城icon 的高度
            Uneededs();//急需,附近。的切换
        })

        $(window).resize(function () {
            Rheights(); //推荐商城icon 的高度
        });

        function Rheights() {//推荐商城icon 的高度
            var Rheight = $(".RmallUL li").width();
            $(".RmallUL li>div").css("height", Rheight);
        }


        function Uneededs() {
            $(".UneededUL li").click(function () {//急需,附近。的切换
                var clickDropload = $(this).attr('name');
                for (i in dropload) {
                    if (i == clickDropload) {
                        dropload[i].unlock();
                    } else {
                        dropload[i].lock();
                    }
                }
                var i = $(".UneededUL li").index(this);
                $(".UneededUL li").removeClass('active');
                $(this).addClass("active");
                $(".UneededULcont ul").removeClass("active");
                $(".UneededULcont ul").eq(i).addClass("active");
            })
        }
        /***********************************推荐商城，急需,附近 js 结束**************************************************************/
    </script>
@stop
@extends('wechat.layout.master')

@section('title','红市')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/swiper-3.4.2.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/city/demo.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/city/ydui.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('asset/ext/dropload/dropload.css')}}">
    <style>
        .swiper-container {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
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

        .redcitybanner .swiper-pagination .swiper-pagination-bullet {
            width: 10px;
            height: 3px;
            background: rgba(0, 0, 0, 0.80) !important;
            border-radius: 13px;
        }

        .redcitybanner .swiper-pagination .swiper-pagination-bullet-active {
            background: #F8525A !important;
            border-radius: 13px;
        }

        .swiper-container-horizontal > .swiper-pagination-bullets, .swiper-pagination-custom, .swiper-pagination-fraction {
            bottom: 0px;
        }

        .mui-row.mui-fullscreen > [class*="mui-col-"] {
            height: 100%;
        }

        .mui-col-xs-3, .mui-col-xs-9 {
            overflow-y: auto;
            height: 100%;
        }

        .swiper-container-horizontal > .swiper-pagination-bullets, .swiper-pagination-custom, .swiper-pagination-fraction {
            bottom: -4px;
        }

        .mui-segmented-control .mui-control-item {
            line-height: 50px;
            width: 100%;
        }

        .mui-control-content {
            display: block;
        }

        .mui-segmented-control.mui-segmented-control-inverted .mui-control-item.mui-active {
            background-color: #fff;
        }

        #segmentedControlContents {
            background-color: #fff;
        }

        .mui-segmented-control.mui-segmented-control-inverted .mui-control-item.mui-active {
            background: transparent;
        }

        .mui-segmented-control.mui-segmented-control-inverted .mui-control-item {
            background-color: #fff;
        }

        .mui-segmented-control.mui-segmented-control-inverted.mui-segmented-control-vertical .mui-control-item,
        .mui-segmented-control.mui-segmented-control-inverted.mui-segmented-control-vertical .mui-control-item.mui-active {
            border-bottom: 1px solid #f1f1f1;
        }

        .mui-control-content {
            display: none;
        }

        #segmentedControlContents .mui-control-content.active {
            display: block;
        }

        .fenleilist a {
            font-size: 12px;
            color: #666;
            float: left;
            padding: 0px 5px;
            margin-bottom: 10px;
        }

        .fenleilist a.mui-active {
            border-bottom: 2px solid red;
            padding: 0px 5px;
            margin-bottom: 8px;
        }

        /*分类下面的列表*/
        .mui-row.mui-fullscreen > [class*="mui-col-"] {
            height: 100%;
        }

        .mui-col-xs-3, .mui-col-xs-9 {
            overflow-y: auto;
            height: 100%;
        }

        .mui-segmented-control .mui-control-item {
            line-height: 50px;
            width: 100%;
        }

        .mui-control-content {
            display: block;
        }

        .mui-segmented-control.mui-segmented-control-inverted .mui-control-item.mui-active {
            background-color: #fff;
        }

        #segmentedControlContents {
            background-color: #fff;
            border-left: 1px solid #F5F5F5;
        }

        .mui-segmented-control.mui-segmented-control-inverted .mui-control-item.mui-active {
            background: transparent;
        }

        .mui-segmented-control.mui-segmented-control-inverted .mui-control-item {
            background-color: #fff;
        }

        .mui-segmented-control.mui-segmented-control-inverted.mui-segmented-control-vertical .mui-control-item,
        .mui-segmented-control.mui-segmented-control-inverted.mui-segmented-control-vertical .mui-control-item.mui-active {
            border-bottom: 1px solid #f1f1f1;
        }

        .mui-control-content {
            display: none;
        }

        #segmentedControlContents .mui-control-content.active {
            display: block;
        }

        .listLR {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
        }


    </style>
@stop

@section('content')
    <div id="testel">
        <div class="clearfix redcitySreachcont">
            <div class="fl redcitySreach" style="width: 100%;" onclick="location.href='{{url('wechat/search/index')}}'">
                <input type="text" placeholder="搜索您要找的宝贝或订单号"/>
            </div>
            {{--<div class="fr redcityfabu">--}}
            {{--<input type="button" value="发布需求" onclick="location.href='{{url('wechat/address?is_issue=1')}}'"/>--}}
            {{--</div>--}}
        </div>
        <!--banner-->
        <div class="redcitybanner2">
            <div class="swiper-container ">
                <div class="swiper-wrapper">
                    @foreach($source->chunk(3) as $v)
                        <div class="swiper-slide">
                            <ul class="redcityBUL clearfix">
                                @foreach($v as $v1)
                                    <a href="{{url('wechat/demand/filter?source_id='.$v1->id)}}">
                                        <li>
                                            <div class="redcityBULtit clearfix">
                                                <div class="redcityBULimg">
                                                    <img src="{{$v1->img->url or ''}}"/>
                                                </div>
                                                <div class="redcityBULName">
                                                    <p class="redcityBULName1 ellipsis1">{{$v1->name}}</p>
                                                    <p class="redcityBULNamestart Astart{{$v1->total_grade}}"></p>
                                                </div>
                                            </div>
                                            <div class="redcityBULcont">
                                                <p class="ellipsis1">红利订单：<span class="redcityBULcontred">{{$v1->demand_count}}</span></p>
                                                <p class="ellipsis1">在线红鱼：<span class="redcityBULcontred">{{$v1->issue_demand_count}}</span></p>
                                                <p class="ellipsis1">成交订单：<span class="redcityBULcontred">{{$v1->over_demand_count}}</span></p>
                                                <p class="ellipsis1">累计节省：<span class="redcityBULcontred">{{$v1->total_spare_price}}</span></p>
                                            </div>
                                        </li>
                                    </a>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <!--区域分类-->
        <!--<div class="h10"></div>-->
        <!--<div style=" height: 10px; z-index: 999; "></div>-->

        <ul class="Rsds clearfix">
            <span class="cell-input fl" id="J_Address2">区域</span>
            <li class="classification zan {{request('filter-active')=='category'?'active':''}}">
                <a href="javascript:void(0)">分类</a>
            </li>
            {{--Jtop 向上箭头，Jbottom 向下箭头--}}
            <li class="sorts @if(request('sort')=='price')active {{request('orderby')=='asc'?'Jtop':'Jbottom'}}@endif" onclick="filterSort('price')">
                <a href="javascript:void(0)">排序</a>
            </li>
            <li class="distance {{request('sort')=='distance'?'active':''}}">
                <a href="javascript:filterSort('distance')">距离</a>
            </li>
            <li class="screen zan {{request('filter-active')=='filter'?'active':''}}">
                <a href="javascript:;">筛选</a>
            </li>
        </ul>

        <div class="Rsdscont">
            <div class="Rsdsconts clearfix" style="position: relative;">
                <!--左右列表-->
                <div class="listLR">
                    <div class="mui-content mui-row mui-fullscreen">
                        <div class="mui-col-xs-3">
                            <div id="segmentedControls" class="Listnav mui-segmented-control mui-segmented-control-inverted mui-segmented-control-vertical">
                                @foreach($category->whereLoose('level',1) as $k=>$v)
                                    <a class="mui-control-item {!! !$k?'mui-active':'' !!}" data-index="{{$k}}">{{$v->name}}</a>
                                @endforeach
                            </div>
                        </div>
                        <div id="segmentedControlContents" class="mui-col-xs-9">
                            @foreach($category->whereLoose('level',1) as $k=>$v)
                                <div class="mui-control-content {{!$k?'active':''}}">
                                    <ul class="mui-table-view ListR ListPading clearfix">
                                        @foreach($category->whereLoose('level',2) as $v1)
                                            @if($v1->parent_id==$v->id)
                                                <li>
                                                    <a href="{{url('wechat/demand/filter?filter-active=category&source_id='.request('source_id').'&category_id='.$v1->id)}}">
                                                        <div class="Listimg">
                                                            <img src="{{$v1->img->url or ''}}">
                                                        </div>
                                                        <p class="listword2 ">{{$v1->name}}</p>
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="Rsdsconts screensx clearfix">
                <form action="{{url('wechat/demand/filter')}}" id="search-filter">
                    <div class="clearfix">
                        <span class="fl typetit">类型</span>
                        <span class="fr typeReset">
                            <input type="button" value="重置" onclick="resetFilter()">
                        </span>
                    </div>

                    <input type="hidden" name="filter-active" value="filter">
                    <div class="clearfix mt10" id="filter-cond">
                        <div class="OS-radio checkhid1">
                            <label class="" data-id="a">
                                <input type="radio" name="filter_type" value="not_select" {{request('filter_type')=='not_select'?'checked':''}}>
                                <span class="check_box {{request('filter_type')=='not_select'?'checked':''}}">寻找红利-可报价</span>
                            </label>
                        </div>
                        <div class="OS-radio checkhid1">
                            <label class="" data-id="a">
                                <input type="radio" name="filter_type" value="circulation" {{request('filter_type')=='circulation'?'checked':''}}>
                                <span class="check_box {{request('filter_type')=='circulation'?'checked':''}}">循环红利-可跟单</span>
                            </label>
                        </div>
                        <div class="OS-radio checkhid1">
                            <label class="" data-id="a">
                                <input type="radio" name="filter_type" value="select" {{request('filter_type')=='select'?'checked':''}}>
                                <span class="check_box {{request('filter_type')=='select'?'checked':''}}">历史红利-可围观</span>
                            </label>
                        </div>
                    </div>
                    <p class="typetit mt10">价格</p>

                    <div class="clearfix">
                        <div class="fl w50">
                            <div class="border mt10">
                                <input type="number" placeholder="最低价格" name="min_price" value="{{request('min_price')}}"/>
                            </div>
                        </div>
                        <span class="typePrice">-</span>
                        <div class="fr w50">
                            <div class="border mt10">
                                <input type="number" placeholder="最高价格" name="max_price" value="{{request('max_price')}}"/>
                            </div>
                        </div>
                    </div>

                    <div class="redbtnh30max80 mt10">
                        <input type="submit" value="确定"/>
                    </div>
                </form>
            </div>
        </div>
        {{--<div class="Rsdsconts clearfix">--}}
        {{--<div class="">--}}
        {{--<div id="segmentedControls" class="fenleilist clearfix">--}}
        {{--@foreach($category->whereLoose('level',1) as $k=>$v)--}}
        {{--<a class=" {{$k?'':'mui-active'}}">{{$v->name}}</a>--}}
        {{--@endforeach--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div id="segmentedControlContents" class="">--}}
        {{--@foreach($category->whereLoose('level',1) as $k=>$v)--}}
        {{--<div id="content" class="mui-control-content {{$k?'':'mui-active'}}">--}}
        {{--<ul class="mui-table-view ListR ">--}}
        {{--@foreach($category as $v1)--}}
        {{--@if($v1->parent_id==$v->id)--}}
        {{--<li>--}}
        {{--<a href="{{url('wechat/demand/filter?filter-active=category&source_id='.request('source_id').'&category_id='.$v1->id)}}">--}}
        {{--<div class="Listimg"><img src="{{$v1->img->url or ''}}"/></div>--}}
        {{--<p class="ellipsis1 Listword">{{$v1->name}}</p>--}}
        {{--</a>--}}
        {{--</li>--}}
        {{--@endif--}}
        {{--@endforeach--}}
        {{--</ul>--}}
        {{--</div>--}}
        {{--@endforeach--}}
        {{--</div>--}}
        {{--</div>--}}
    </div>
    <!--列表-->
    <div id="dropload">
        <div class="clearfix redcityList" id="list">
            @foreach($demand as $v)
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
                                <em class="Uneedred1">
                                    ¥<span class="Uneedred2">{{$v->demandGoods->first()->known_unit_price or ''}}</span>
                                </em>
                                /
                                *{{$v->demandGoods->first()->count or ''}}{{$v->demandGoods->first()->unit or ''}}</p>
                            <p class="Uneedcontwords3 clearfix">
                                <span class="adressding">{{$v->getIssueSite()}}</span>
                                <span class="adressdingR">
                                        货源： <em class="Uneedred1">{{$v->demandGoods->first()->source or ''}}</em>
                                    </span>
                                @if($v->circulation)
                                    <span class="adressding">
                                        累计{{$v->circulation_count}}人跟随
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                </a>
                <div class="clearfix Uneedtime">
                    @if($v->circulation)
                        <div class="UneedButtonlanse fl">
                            <input type="button" value="循环红利"/>
                        </div>
                    @else
                        <div class="{{$v->is_select?'UneedButtonhuise':'UneedButtonred'}} fl">
                            <input type="button" value="{{$v->is_select?'历史红利':'寻找红利'}}"/>
                        </div>
                    @endif
                    @if($v->status==1||$v->circulation)
                        <div class="timespan fl {{$v->is_select?'timespanBlue':''}}" id="time{{$v->id}}">
                            <span class="day_show">0</span>&nbsp;<em>天</em>
                            <span class="hour_show"><s id="h"></s>0</span>&nbsp;<em>时</em>
                            <span class="minute_show"><s></s>0</span>&nbsp;<em>分</em>
                            <span class="second_show"><s></s>0</span>&nbsp;<em>秒</em>
                        </div>
                    @endif
                    <div class="Uneedtimejuli">{{$v->issue_time}}</div>
                </div>
            @endforeach
        </div>
    </div>
    <form action="" id="search">
        {!! csrf_field() !!}
        @foreach(request()->except('_token') as $k=>$v)
            <input type="hidden" name="{{$k}}" value="{{$v}}">
        @endforeach
    </form>
    <!--导航-->
    @include('wechat.layout.footer',['active'=>'filter'])
    <div class="bg"></div>
    </div>
@stop
@section('mui-js')@stop
@section('js')
    <script src="{{asset('asset/wechat/js/swiper-3.4.2.min.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('asset/wechat/js/city/ydui.citys.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('asset/wechat/js/city/ydui.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('asset/wechat/js/city/ydui.flexible.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('asset/ext/dropload/dropload.min.js')}}"></script>
    <script>
        //计算分类下面的高度
        var Wheight = $(window).height();//是文档窗口高度
        var ListHeight = $(".Rsds").offset().top//是标签距离顶部高度
        var allHeight = Wheight - ListHeight;
        $(".listLR").css("height", allHeight - 100);


        function filterSort(sort) {
            var form = $('#search');
            if (form.find('input[name=sort]').length < 1) {
                var html = '<input type="hidden" name="sort" value="' + sort + '">';
                html += '<input type="hidden" name="orderby" value="desc">';
                form.append(html);
            }
            var orderby = '{{request('orderby')=='asc'?'desc':'asc'}}';
            form.find('input[name=orderby]').val(orderby);
            form.find('input[name=sort]').val(sort);
            $('#search').submit();
        }

        function resetFilter() {
            $('#search-filter').find('input[name=min_price]').val('');
            $('#search-filter').find('input[name=max_price]').val('');
            $('#search-filter').find('input[name=filter_type]').prop('checked', false);
            $('#filter-cond .checkhid1').find('.check_box').removeClass('checked');
        }

        var swiper = new Swiper('.swiper-container', {
            pagination: '.swiper-pagination',
            paginationClickable: true
        });

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
            @if($v->circulation)
            timer(parseInt({{$v->selectUserTender->hotboom_end_time-time()}}), "#time{{$v->id}}");
            @else
            timer(parseInt({{$v->end_time-time()}}), "#time{{$v->id}}");
            @endif
            @endforeach
        })

        var page = 2, pageTotal ={{$demand->lastPage()}};
        $('#dropload').dropload({
            scrollArea: window,
            domDown: {
                domClass: "dropload-down",
                domRefresh: '<div class="dropload-refresh" style="display: none;">↑上拉加载更多</div>',
                domLoad: '<div class="dropload-load"><span class="loading"></span>加载中...</div>',
                domNoData: '<div class="dropload-noData">{{$demand->lastPage()?'没有更多数据':'暂无数据'}}</div>'
            },
            loadDownFn: function (me) {
                $.post("{{url('wechat/demand/filter')}}?page=" + page,
                    $('#search').serialize(),
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

        $("#segmentedControls a").click(function () {//列表切换
            var i = $("#segmentedControls a").index($(this));
            $("#segmentedControls a").removeClass("mui-active");
            $(this).addClass("mui-active");
            $("#segmentedControlContents div.mui-control-content").removeClass("mui-active");
            $("#segmentedControlContents div.mui-control-content").eq(i).addClass("mui-active");
        })


        //分类下面的列表切换
//        $("#segmentedControls a").click(function () {//列表切换
//            var i = $("#segmentedControls a").index($(this));
//            $("#segmentedControls a").removeClass("mui-active");
//            $(this).addClass("mui-active");
//            $("#segmentedControlContents div.mui-control-content").removeClass("active");
//            $("#segmentedControlContents div.mui-control-content").eq(i).addClass("active");
//        })


        $(function () {
            $(".Rsds li.zan").click(function () {//
                var i = $(".Rsds li.zan").index(this);
                $(".Rsds li").removeClass("active");
                $(this).addClass("active");
                $(".Rsdscont .Rsdsconts").hide();
                $(".bg").show();
                $(".Rsdscont .Rsdsconts").eq(i).show();
            })

            $('#filter-cond .checkhid1').click(function () {
                $('#filter-cond .checkhid1').find('.check_box').removeClass('checked');
                $(this).find('.check_box').addClass('checked');
                $(this).find('input').prop('checked', true);
            });

            $(".bg").click(function () {
                $('.bg,.Rsdsconts').hide();
            })

        })

        $(function () {
            $("#J_Address2").click(function () { //区域
                $('.bg,.Rsdsconts').hide();
                $('.Rsds li').removeClass("active");
            })
        })


        /*默认调用*/
        //        !function () {
        //            var $target = $('#J_Address');
        //            $target.citySelect();
        //            $target.on('click', function (event) {
        //                event.stopPropagation();
        //                $target.citySelect('open');
        //            });
        //            $target.on('done.ydui.cityselect', function (ret) {
        //                $(this).val(ret.provance + ' ' + ret.city);
        //            });
        //        }();
        /*** 设置默认值*/
        !function () {
            var $target = $('#J_Address2');
            $target.citySelect({
                provance: '{{request('city','线上')}}',
                city: '{{request('area','线上')}}',
            });

            $target.on('click', function (event) {
                event.stopPropagation();
                $target.citySelect('open');
            });

            $target.on('done.ydui.cityselect', function (ret) {
                var url = '{{url('wechat/demand/filter?')}}' + 'filter-active=area&source_id={{request('source_id')}}&city=' + ret.provance + '&area=' + ret.city;
                location.href = url;
            });
        }();
    </script>
@stop
@extends('wechat.layout.master')

@section('title','报价详情')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/swiper-3.4.2.min.css')}}"/>
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

        .XQbanner .swiper-pagination .swiper-pagination-bullet {
            width: 10px;
            height: 3px;
            background: rgba(0, 0, 0, 0.80) !important;
            border-radius: 13px;
        }

        .XQbanner .swiper-pagination .swiper-pagination-bullet-active {
            background: #F8525A !important;
            border-radius: 13px;
        }
    </style>
@stop

@section('content')
    <div class="XQbanner">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach($goods->imgs as $v)
                    <div class="swiper-slide"><img src="{{$v->url}}"/></div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <div class="clearfix Uneedtime XQtime">
        <div class="UneedButtonred fl   ">
            <input type="button" value="{{$status[$demand->data->status]}}">
        </div>
        @if($demand->data->status==1)
            <div class="timespan fl" id="time1">
                <span class="day_show">0</span>&nbsp;<em>天</em>
                <span class="hour_show"><s id="h"></s>0</span>&nbsp;<em>时</em>
                <span class="minute_show"><s></s>0</span>&nbsp;<em>分</em>
                <span class="second_show"><s></s>0</span>&nbsp;<em>秒</em>
            </div>
        @endif
        <div class="Uneedtimejuli">{{$demand::countTimeInterval($demand->data->issue_time)}}</div>
    </div>

    <div class="Uneedtit clearfix XQdingdan">
        <span class="Uword2">订单号:{{$demand->data->order_number}}</span>
        <span class="Uorder">订单总额:<em class="Iprice">¥{{$demand->data->getPrice()}}</em></span>
        <span class="Idistance">{{$demand->data->create_time}}</span>
    </div>

    <div class=" XQcont">
        <div class="XQcontwords">
            <div class="clearfix">
                <div class="fl orderLinkword">
                    <p class="Uneedcontwords1 ellipsis1">{{$goods->name}}</p>
                </div>
                @if($demand->data->type=='link')
                    <div class="fr orderLinkgreen">
                        <input type="button" value="商品链接">
                    </div>
                @endif
            </div>
            <div class="clearfix">
                <div class="fl Uneedcontwords2"><em class="Uneedred1">¥{{$goods->known_unit_price}}</em> / *{{$goods->count}}{{$goods->unit}}</div>
                <div class="fr Uneedcontwords3">货源： <em class="Uneedred1">{{$goods->source}}</em></div>
            </div>
            <div class="beizu">这里是备注信息这里是备注信息这里是备注信息这里是备注信息这里是备注信息这里是备注信息这里是备注信息这里是备注信息这里是备注信息</div>

        </div>
    </div>

    <p class="fabuing">其他商品</p>
    @foreach($demand->data->demandGoods as $v)
        @if($v->id!=$goods->id)
            <div class="clearfix XQgoods" onclick="location.href='{{url('wechat/hotboom-demand/tender-details/'.$tender->id.'?goods_id='.$v->id)}}'">
                <div class="fl XQgoodsimg">
                    <img src="{{$v->img->url or ''}}"/>
                </div>
                <div class="fl XQgoodsCont">
                    <p class="ellipsis1 XQgoodsword2">{{$v->name}}</p>
                    <p class="ellipsis1">
                        <span class="XQgoodsword1">¥<em class="XQgoodsword1red">{{$v->known_unit_price}}</em>/ *{{$v->count}}{{$v->unit}}</span>
                        <span class="XQgoodsword1">商品合计：¥<em class="XQgoodsword1red">{{$v->price}}</em></span>
                    </p>
                </div>
            </div>
        @endif
    @endforeach
    <div class="XQadress jiantou" onclick="location.href='{{url('wechat/tender/store-site/'.$goods->id)}}'">
        <p class="mapwrodd">需求实体店位置</p>
        <p class="XQadressicon ellipsis1">{{$goods->getSite()}}</p>
        <p class="XQadresword1">距您：{{$distance}}km</p>
    </div>

    <a href="" class="jiantou disb mt10">
        <div class="guarantee">代购担保交易</div>
    </a>
    <a class="jiantou XQmassegeall mt10" href="{{url('wechat/user/issue-demand/'.$demand->data->user_id.'/'.$demand->data->id)}}">
        <div class="clearfix">
            <div class="fl clearfix XQmassegeR">
                <div class="XQmassegeimg fl"><img src="{{$demand->data->user->img_url or ''}}"></div>
                <div class="fl XQmassegewordR">
                    <div><span class="XQmassegeword1"><em class="ellipsis1">{{$demand->data->user->nickname or ''}}</em></span></div>
                    <p class="Userword2">成交量：<em class="green">{{$demand->data->user->over_demand}}</em></p>
                    <p class="XQmassegeword3">{{$demand::countTimeInterval($demand->data->user->update_time).'来过'}}</p></div>
            </div>
            {{--<div class="fr XQmassegeL mt15">--}}
                {{--<div class="Aisstart{{$demand->data->user->daigou_evaluate_avg_grade or '0'}}"></div>--}}
            {{--</div>--}}

            <div class="fr " style="width:45%;">
                <span class="fl XQhlword">红利需求信誉</span>
                <div class="XQmassegeL ">
                    <div class="Aisstart{{$demand->data->user->daigou_evaluate_avg_grade or '0'}}"style="width: 100px;"></div>
                </div>
            </div>

        </div>
    </a>

    <div class="XQTotal clearfix">
        <span class="XQTotalwrod1">报价总额：<em class="XQTotalred1">￥</em><em class="XQTotalred2">{{$tender->getPrice()}}</em></span>
        <span class="XQTotalwrod3">节约邮费：<em class="XQTotalred1">￥</em>
                    <em class="XQTotalred2">{{$demand->getTenderPrice()}}</em>
        </span>
        <div class="XQTotalwrod2">较已知订单总额节省<em class="XQTotalgreen1">￥</em>
            <em class="XQTotalgreen2">{{$demand->data->known_price-$tender->getPrice()>0?$demand->data->known_price-$tender->getPrice():'0.00'}}</em>
        </div>
    </div>
    <p class="fabuing">报价优势
        <span class="fabuingtips">(请注意报价货源，平台不允许代购无法溯源商家的产品)</span>
    </p>
    <ul class="XQadvantage clearfix">
        @foreach($tender->quoteAdvantage as $v1)
            @foreach(json_decode($v1->label,true) as $v2)
                <li>{{$v2}}</li>
            @endforeach
        @endforeach
    </ul>

    {{--<div style="height: 45px;"></div>--}}
    {{--<div class="XQbottom clearfix">--}}
    {{--<a class="XQbottomchat">聊天</a>--}}
    {{--<a class="XQbottomenter"><input type="button" value="加入代购车"/></a>--}}
    {{--<a class="XQbottomBJ" href="javascript:tenderCheck({{$demand->data->id}})">马上报价</a>--}}
    {{--</div>--}}
@stop

@section('js')
    <script src="{{asset('asset/wechat/js/swiper-3.4.2.min.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('asset/ext/layer/layer.min.js')}}"></script>
    <script>

        var swiper = new Swiper('.swiper-container', {//banner
            pagination: '.swiper-pagination',
            paginationClickable: true,
        });

        /***********************************倒计时 开始**************************************************************/
        $(function () {
            timer(parseInt({{$demand->data->end_time-time()}}), "#time1");
        })
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
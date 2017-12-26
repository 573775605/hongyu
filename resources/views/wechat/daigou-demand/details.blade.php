@extends('wechat.layout.master')

@section('title','订单详情')

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
            @if($demand->data->status==-2)
                <input type="button" value="{{$status[$demand->data->status].'('.$returnStatus[$demand->data->returnGoodsApply->status].')'}}">
            @elseif($demand->data->status!=5)
                <input type="button" value="{{$status[$demand->data->status] or ''}}">
            @else
                <input type="button" value="{{$demand->data->daigou_evaluate?'已完成':'待评价'}}">
            @endif
        </div>
        @if($demand->data->status==1||$demand->data->status==2)
            <div class="timespan fl" id="time1">
                @if($demand->data->status==1)
                    <span class="day_show">0</span>&nbsp;<em>天</em>
                @endif
                <span class="hour_show"><s id="h"></s>0</span>&nbsp;<em>时</em>
                <span class="minute_show"><s></s>0</span>&nbsp;<em>分</em>
                <span class="second_show"><s></s>0</span>&nbsp;<em>秒</em>
            </div>
        @endif
        <div class="Uneedtimejuli">{{$demand::countTimeInterval($demand->data->issue_time)}}</div>
    </div>

    <div class="Uneedtit clearfix XQdingdan">
        <span class="Uword2">订单号:{{$demand->data->order_number}}</span>
        <span class="Uorder">订单总额:<em class="Iprice">¥{{$demand->data->known_price}}</em></span>
        <span class="btnsqueryellow fr" onclick="location.href='{{url('wechat/about/explain-article/hotboom_assure_deal')}}'">担保交易</span>
    </div>

    <div class=" XQcont">
        <div class="XQcontwords">
            <div class="clearfix">
                <div class="fl orderLinkword">
                    <p class="Uneedcontwords1 ellipsis2">{{$goods->name}}</p>
                </div>
                @if($goods->type=='link')
                    @if(in_array($goods->domain,['tmall','taobao']))
                        <a class="fr orderLinkgreen" href="{{url('wechat/check-browse?url='.urlencode($goods->link))}}">
                            <input type="button" value="商品链接">
                        </a>
                    @else
                        <div class="fr orderLinkgreen" onclick="location.href='{{$goods->link}}'">
                            <input type="button" value="商品链接">
                        </div>
                    @endif
                @endif
            </div>
            <div class="clearfix">
                <div class="fl Uneedcontwords2"><em class="Uneedred1">¥{{$goods->known_unit_price}}</em> / *{{$goods->count}}{{$goods->unit}}</div>
                <div class="fr Uneedcontwords3">货源： <em class="Uneedred1">{{$goods->source}}</em></div>
            </div>

            <div class="beizu">备注：{{$demand->data->is_copy?$demand->data->remark:$goods->remark}}</div>

        </div>
    </div>
    @if($demand->data->demandGoods->count()>1)
        <p class="fabuing">本订单还包含以下商品</p>
        @foreach($demand->data->demandGoods as $v)
            @if($v->id!=$goods->id)
                <div class="clearfix XQgoods" onclick="location.href='{{url('wechat/hotboom-demand/details/'.$demand->data->id.'?goods_id='.$v->id)}}'">
                    <div class="fl XQgoodsimg">
                        <img src="{{$v->img->url or ''}}"/>
                    </div>
                    <div class="fl XQgoodsCont">
                        <p class="ellipsis1 XQgoodsword2">{{$v->name}}</p>
                        <p class="ellipsis1">
                            <span class="XQgoodsword1">¥<em class="XQgoodsword1red">{{$v->known_unit_price}}</em>/ *{{$v->count}}{{$v->unit}}</span>
                            {{--<span class="XQgoodsword1">商品合计：¥<em class="XQgoodsword1red">{{$v->price}}</em></span>--}}
                        </p>
                    </div>
                </div>
            @endif
        @endforeach
    @endif
    @if($goods->getSite())
        <div class="XQadress jiantou" onclick="location.href='{{url('wechat/tender/store-site/'.$goods->id)}}'">
            <p class="mapwrodd">需求实体店位置</p>
            <p class="XQadressicon ellipsis1">{{$goods->getSite()}}</p>
            <p class="XQadresword1">距您：{{$distance}}km</p>
        </div>
    @endif

    <div class="pricelist">
        <dl class="clearfix">
            <dt>报价总额:</dt>
            <dd>￥{{$demand->data->getTenderprice()}}</dd>
        </dl>
        <dl class="clearfix">
            <dt>运费快递:</dt>
            <dd>￥{{$demand->data->express_price}}</dd>
        </dl>
        <dl class="clearfix">
            <dt>红券抵扣:</dt>
            <dd id="coupon-price">￥{{$demand->data->coupon_price}}</dd>
        </dl>
        <dl class="clearfix">
            <dt class="pricelistCu">支付总额:</dt>
            <dd class="pricelistred">￥{{$demand->data->price}}</dd>
        </dl>
        <dl class="clearfix ">
            <dt style="width: 65%; ">较已知订单总额节省（不含邮费）：</dt>
            <dd class="pricelistgreen">
                ￥{{$demand->data->known_price-$demand->data->getTenderprice()<0?0:$demand->data->known_price-$demand->data->getTenderprice()}}</dd>
        </dl>
    </div>

    <p class="fabuing">收件人</p>
    <a class=" XQ2adress jiantou">
        <div class="clearfix XQ2adressword1">
            <div class="fl">
                收货人：{{$demand->data->consignee}}
            </div>
            <div class="fr">
                {{$demand->data->phone}}
            </div>
        </div>
        <div class="XQ2adressword2 ellipsis2">
            收货地址：{{$demand->data->address}}
        </div>
    </a>

    {{--<p class="fabuing">报价信息</p>--}}
    {{--<div class="XQTotal clearfix" style="margin-top: 0;">--}}
    {{--<span class="XQTotalwrod1">报价总额：<em class="XQTotalred1">￥</em><em class="XQTotalred2">{{$demand->data->getTenderprice()}}</em></span>--}}
    {{--<span class="XQTotalwrod3">邮费：<em class="XQTotalred1">￥</em>--}}
    {{--<em class="XQTotalred2">{{$demand->data->express_price}}</em>--}}
    {{--</span>--}}
    {{--<span class="XQTotalwrod2">较已知订单总额节省--}}
    {{--<em class="XQTotalgreen1">￥</em><em class="XQTotalgreen2">{{$demand->data->known_price-$demand->data->getTenderprice()<0?0:$demand->data->known_price-$demand->data->getTenderprice()}}</em>--}}
    {{--</span>--}}
    {{--</div>--}}

    <p class="fabuing">报价优势</p>
    <ul class="XQadvantage clearfix">
        @if($demand->data->selectUserTender->type=='other-hotboom')
            <li class="qustion" onclick="location.href='{{url('wechat/demand/hotboom-store-site?lng='.$demand->data->selectUserTender->hotboom_lng.'&lat='.$demand->data->selectUserTender->hotboom_lat.'&name='.$demand->data->selectUserTender->hotboom_store_name)}}'">
                其他商家
            </li>
        @else
            <li>原路代购</li>
        @endif
        @foreach($demand->data->quoteAdvantage as $v)
            @foreach(json_decode($v->label,true) as $v1)
                <li>{{$v1}}</li>
            @endforeach
            @if($v->other)
                <li>{{$v->other}}</li>
            @endif
        @endforeach
    </ul>

    @if($demand->data->status>3)
        <p class="fabuing">订单信息</p>
        <dl class="OrderLogistics clearfix">
            <dt>订单时间：</dt>
            <dd>{{$demand->data->issue_time}}</dd>
        </dl>
        <dl class="OrderLogistics clearfix">
            <dt>支付时间：</dt>
            <dd>{{$demand->data->pay_time}}</dd>
        </dl>
        <dl class="OrderLogistics clearfix">
            <dt>收货时间：</dt>
            <dd>{{$demand->data->over_time}}</dd>
        </dl>
        <dl class="OrderLogistics clearfix">
            <dt>快递公司：</dt>
            <dd>{{$express[$demand->data->express_company_number] or ''}}</dd>
        </dl>
        <dl class="OrderLogistics clearfix">
            <dt class="OrderLogisticswrod1">快递单号：</dt>
            <dd class="clearfix"><span class="OrderLogisticswrod2">{{$demand->data->express_number}}</span>
                <div class="btnsquerIcongred fr" onclick="location.href='{{url('wechat/demand/view-logistics/'.$demand->data->id)}}'">
                    <input type="button" value="查看物流"></div>
            </dd>
        </dl>
        <dl class="OrderLogistics clearfix">
            <dt>发货时间：</dt>
            <dd>{{$demand->data->delivery_time}}</dd>
        </dl>
        <dl class="offers clearfix">
            <dt class="mt5">购买凭证：</dt>
            <dd>
                <ul class="cUl mt10 clearfix">
                    <li class="">
                        @foreach($demand->data->shopInvoiceImg as $v)
                            <img src="{{$v->url}}" alt="">
                        @endforeach
                    </li>
                </ul>
            </dd>
        </dl>
        @if($demand->data->hotboom_evaluate && $demand->hotboomEvaluate)
            <dl class="dlword clearfix">
                <dt class="">评分：</dt>
                <dd>
                    <ul class="clickstart mt12" id="goods_grade">
                        @for($i=0;$i<$demand->hotboomEvaluate->grade;$i++)
                            <li class="hasStart"></li>
                        @endfor
                    </ul>
                </dd>
            </dl>
            <dl class="offers clearfix">
                <dt class="mt5">评价：</dt>
                <dd>
                    <div class="OrderLotextarea">
                        <textarea placeholder="输入评价.." style="width: 100%;" disabled="">{{$demand->hotboomEvaluate->content or ''}}</textarea>
                    </div>
                </dd>
            </dl>
        @endif
    @endif
    <div class="XQmassegeall ">

        <a class="  XQa " style="" href="{{url('wechat/user/issue-demand/'.$demand->data->user_id.'/'.$demand->data->id)}}">
            <div class="jiantou jiantoubs">
                <div class="clearfix">
                    <p class="faqiren">需求发起人</p>
                    <div class="fl clearfix XQmassegeR">
                        <div class="XQmassegeimg fl"><img src="{{$demand->data->user->img_url or ''}}"></div>
                        <div class="fl XQmassegewordR">
                            <div><span class="XQmassegeword1"><em class="ellipsis1">{{$demand->data->user->nickname or ''}}</em></span></div>
                            <p class="Userword2">成交量：<em class="green">{{$demand->data->user->issue_over_demand?:0}}</em></p>
                            <p class="XQmassegeword3">{{$demand::countTimeInterval($demand->data->user->update_time).'来过'}}</p></div>
                    </div>

                    <div class="fr XQmassegeL clearfix " style="    margin-top: 4px;">
                        <div class="clearfix">
                            <em class="fr XQmassegestart Aisstart{{$demand->data->user->daigou_evaluate_avg_grade or '0'}}"></em>
                            <span class="XQhlword">红利需求信誉</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <div class="clearfix chatselect2 ">
        <span class="fl sButtongyellow mr10" onclick="location.href='{{url('wechat/chat/message/'.$demand->data->user_id)}}'">
                            <input type="button" value="聊天"/></span>
        </div>
    </div>
    <div style="height:55px;"></div>
    @if($demand->data->status==3)
        <a class="Lbtnred" href="{{url('wechat/hotboom-demand/delivery/'.$demand->data->id)}}">
            立即发货
        </a>
    @elseif($demand->data->status==5 && !$demand->data->daigou_evaluate)
        <a class="Lbtnred" href="{{url('wechat/hotboom-demand/evaluate/'.$demand->data->id)}}">
            评价
        </a>
    @elseif($demand->data->status==-2&&!$demand->data->returnGoodsApply->is_check)
        <div class="btnthere clearfix">
            <a href="javascript:;" class="reason"><input type="button" value="申请原因"></a>
            <a href="javascript:returnCheck({{$demand->data->id}},2);"><input type="button" value="同意"></a>
            <a href="javascript:returnCheck({{$demand->data->id}},-1);"><input type="button" value="不同意"></a>
        </div>

        <div class="bgtan"></div>
        <div class="tanReason">
            <div class="tanReasoncont">
                <span class="tanReasonClose"></span>
                <p>{{$demand->data->returnGoodsApply->remark or ''}}</p>
            </div>

        </div>
    @endif
@stop

@section('js')
    <script src="{{asset('asset/wechat/js/swiper-3.4.2.min.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('asset/ext/layer/layer.min.js')}}"></script>
    <script>

        function returnCheck(id, status) {
            $.post("{{url('wechat/hotboom-demand/return-check')}}/" + id,
                {_token: '{{csrf_token()}}', status: status},
                function (data, status) {
                    if (data.status != 1) {
                        layer.msg(data.message);
                    } else {
                        location.reload();
                    }
                });
        }
        $(function () {
            //弹窗高度
            var tanH = $(".tanReason").height();
            $(".tanReason").css("margin-top", -tanH / 2);

            $(".reason").click(function () {
                $(".tanReason,.bgtan").show();
            })


            $(".tanReasonClose").click(function () {
                $(".tanReason,.bgtan").hide();
            })


            $(".tanclose,.bg,.tanbtnclose").click(function () {
                $(".tan,.bg").hide();
            })

        })
        var swiper = new Swiper('.swiper-container', {//banner
            pagination: '.swiper-pagination',
            paginationClickable: true,
        });

        /***********************************倒计时 开始**************************************************************/
        $(function () {
            @if($demand->data->is_select)
            timer(parseInt({{$demand->data->pay_end_time-time()}}), "#time1");
            @else
            timer(parseInt({{$demand->data->end_time-time()}}), "#time1");
            @endif
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
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" charset="utf-8"></script>
    <script>
        //微信分享配置
        wx.config({!! $js->config(['onMenuShareTimeline','onMenuShareAppMessage'],false) !!});
        wx.ready(function () {
            //分享朋友圈
            wx.onMenuShareTimeline({
                @if($demand->data->is_select)
                title: '共享钱包，您挑商品我下单，立省¥{{$demand->getSavePrice()}}，上【红鱼】公众号体验购物新玩法！',
                {{--                title: '(节省金额￥{{$demand->getSavePrice()}})我在【红鱼】找到了能更低价拿货的牛人，快来围观吧', // 分享标题--}}
                        @else
                title: '(已知售价￥{{$goods->known_unit_price}})我在【红鱼】等待能更低价拿货的牛人，是你吗？', // 分享标题
                @endif
                link: '', // 分享链接
                imgUrl: '{{$goods->img->url or ''}}', // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
            //分享微信好友
            wx.onMenuShareAppMessage({
                @if($demand->data->is_select)
                title: '共享钱包，您挑商品我下单，立省¥{{$demand->getSavePrice()}}，上【红鱼】公众号体验购物新玩法！',
                {{--title: '(节省金额￥{{$demand->getSavePrice()}})我在【红鱼】找到了能更低价拿货的牛人，快来围观吧', // 分享标题--}}
                desc: '{{$goods->name}}', // 分享描述
                @else
                title: '(已知售价￥{{$goods->known_unit_price}})我在【红鱼】等待能更低价拿货的牛人，是你吗？', // 分享标题
                desc: '{{$goods->name}}', // 分享描述
                @endif
                link: '', // 分享链接
                imgUrl: '{{$goods->img->url or ''}}', // 分享图标
                type: '', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function () {
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
        });
    </script>
@stop
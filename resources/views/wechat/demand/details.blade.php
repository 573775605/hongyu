@extends('wechat.layout.master')

@section('title','订单详情')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/swiper-3.4.2.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/AddSubtract.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/start.css')}}"/>
    <style>
        swiper-container {
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
    <div id="testel">
        <div class="XQbanner">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($goods->imgs as $v)
                        <div class="swiper-slide"><img src="{{$v->url or ''}}"/></div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

        <div class="clearfix Uneedtime XQtime">
            <div class="orderButtonyellow fl  " style="position: relative; height: 25px;line-height: 25px;">
                @if($demand->status==-2)
                    <input type="button" value="{{$status[$demand->status].'('.$returnStatus[$demand->returnGoodsApply->status].')'}}">
                @elseif($demand->status!=5)
                    <input type="button" value="{{$status[$demand->status] or ''}}">
                @else
                    <input type="button" value="{{$demand->issue_evaluate?'已完成':'待评价'}}" style="position: absolute;    top: 0;    left: 0;    width: 100%;    height: 25px;line-height: 25px;padding: 0;">
                @endif
            </div>
            @if($demand->status==1||$demand->status==2)
                <div class="timespan fr" id="time1">
                    @if($demand->status==1)
                        <span class="day_show">0</span>&nbsp;<em>天</em>
                    @endif
                    <span class="hour_show"><s id="h"></s>0</span>&nbsp;<em>时</em>
                    <span class="minute_show"><s></s>0</span>&nbsp;<em>分</em>
                    <span class="second_show"><s></s>0</span>&nbsp;<em>秒</em>
                </div>
            @endif
        </div>

        <style>
            .orderButtonyellow input {
                padding: 0;
                height: 25px;
                line-height: 25px;
            }
        </style>

        @if($demand->is_select)
            <div class=" XQcont">
                @foreach($demand->demandGoods as $v)
                    <div class="XQcontwords">
                        <div class="clearfix">
                            <div class="fl orderLinkword">
                                <p class="Uneedcontwords1 ellipsis2">{{$v->name}}</p>
                            </div>
                            @if($v->type=='link')
                                @if(in_array($v->domain,['tmall','taobao']))
                                    <div class="fr">
                                        <a class="btnsquerIcongreen" href="{{url('wechat/check-browse?url='.urlencode($v->link))}}">
                                            <input type="button" value="商品链接">
                                        </a>
                                    </div>
                                @else
                                    <div class="fr" onclick="location.href='{{$v->link}}'">
                                        <div class="btnsquerIcongreen">
                                            <input type="button" value="商品链接">
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div class="clearfix">
                            <div class="fl Uneedcontwords2"><em class="Uneedred1">¥{{$v->known_unit_price}}</em> / *{{$v->count}}{{$v->unit}}</div>
                            <div class="fr Uneedcontwords3">货源： <em class="Uneedred1">{{$v->source}}</em></div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="Uneedtit clearfix XQdingdan" style="border-top: 1px solid #f1f1f1;">
                <span class="Uword2">订单号:{{$demand->order_number}}</span>
                <span class="Uorder">订单总额:<em class="Iprice">¥{{$demand->known_price}}</em></span>
                <span class="btnsqueryellow fr" onclick="location.href='{{url('wechat/about/explain-article/hotboom_assure_deal')}}'">担保交易</span>
            </div>
        @else
            <div class="Uneedtit clearfix XQdingdan" style="border-top: 1px solid #f1f1f1;">
                <span class="Uword2">订单号:{{$demand->order_number}}</span>
                <span class="Uorder">订单总额:<em class="Iprice">¥{{$demand->known_price}}</em></span>
                <span class="btnsqueryellow fr" onclick="location.href='{{url('wechat/about/explain-article/hotboom_assure_deal')}}'">担保交易</span>
            </div>
            <div class=" XQcont">
                @foreach($demand->demandGoods as $v)
                    <div class="XQcontwords">
                        <div class="clearfix">
                            <div class="fl orderLinkword">
                                <p class="Uneedcontwords1 ellipsis1">{{$v->name}}</p>
                            </div>
                            @if($v->type=='link')
                                @if(in_array($v->domain,['tmall','taobao']))
                                    <a class="fr" href="{{url('wechat/check-browse?url='.urlencode($v->link))}}">
                                        <div class="btnsquerIcongreen">
                                            <input type="button" value="商品链接">
                                        </div>
                                    </a>
                                @else
                                    <div class="fr" onclick="location.href='{{$v->link}}'">
                                        <div class="btnsquerIcongreen">
                                            <input type="button" value="商品链接">
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div class="clearfix">
                            <div class="fl Uneedcontwords2"><em class="Uneedred1">¥{{$v->known_unit_price}}</em> / *{{$v->count}}{{$v->unit}}</div>
                            <div class="fr Uneedcontwords3">货源： <em class="Uneedred1">{{$v->source}}</em></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        @if($demand->is_select)
            <div class="pricelist">
                <dl class="clearfix">
                    <dt>报价总额:</dt>
                    <dd>￥{{$demand->getTenderprice()}}</dd>
                </dl>
                <dl class="clearfix">
                    <dt>运费快递:</dt>
                    <dd>￥{{$demand->express_price}}</dd>
                </dl>
                @if($coupon->count()&&!$demand->is_pay&&!$demand->coupon_price)
                    <dl class="clearfix pricelistquan">
                        <dt>选择优惠券:</dt>
                        <dd>
                            <div class="pricelistselect">
                                <select id="select-coupon">
                                    @foreach($coupon as $v)
                                        <option value="{{$v->id}}" price="{{$v->price}}">{{$v->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </dd>
                    </dl>
                @endif
                <dl class="clearfix">
                    <dt>红券抵扣:</dt>
                    <dd id="coupon-price">￥{{$demand->coupon_price}}</dd>
                </dl>
                <dl class="clearfix">
                    <dt class="pricelistCu">支付总额:</dt>
                    <dd class="pricelistred" id="pay-price" price="{{$demand->price}}">￥{{$demand->price}}</dd>
                </dl>
                <dl class="clearfix  ">
                    <dt style="width: 65%; ">较已知订单总额节省（不含邮费）：</dt>
                    <dd class="pricelistgreen">￥{{$sparePrice}}</dd>
                </dl>
            </div>
        @endif

        <p class="fabuing">收件人</p>
        <a class=" XQ2adress jiantou">
            <div class="clearfix XQ2adressword1">
                <div class="fl shouhuo">
                    收货人：{{$demand->consignee}}
                </div>
                <div class="fr">
                    {{$demand->phone}}
                </div>
            </div>
            <div class="XQ2adressword2 ellipsis2">
                收货地址：{{$demand->address}}
            </div>
        </a>

        @if($demand->status==1 && $demand->userTender->count())
            <p class="fabuing clearfix">
                报价人信息
                <span class="fabuingword1 ">
                (最多可接收5个报价，您可以点击“取消”来淘汰报价人)
            </span>
            </p>
            @foreach($demand->userTender->sortByDesc(function($item,$key){return $item->user->is_auth;}) as $v)
                <a class="XQmassegeall jiantou">
                    <div class="clearfix " onclick="location.href='{{url('wechat/user/hotboom-info/'.$v->id)}}'">
                        <div class="fl clearfix XQmassegeR">
                            <div class="XQmassegeimg fl">
                                <img src="{{$v->user->img_url}}"/>
                            </div>
                            <div class="fl XQmassegewordR">
                                <div class="">
                                    <span class="XQmassegeword1">
                                        <em class="ellipsis1">{{$v->user->nickname}}</em>
                                    </span>
                                    <em class="XQmassegeicon1{{$v->user->mobile?'':'NO'}}"></em>
                                    <em class="XQmassegeicon2{{$v->user->is_auth?'':'NO'}}"></em>
                                </div>
                                @if($v->user->hide_mobile)
                                    <p class="XQmassegeword2">{{str_replace(substr($v->user->mobile,3,4),'****',$v->user->mobile)}}</p>
                                @else
                                    <p class="XQmassegeword2">{{$v->user->mobile}}</p>
                                @endif
                                <p class="XQmassegeword3">成交笔数：<em class="green">{{$v->user->over_demand?:0}}</em></p>
                            </div>
                        </div>
                        <div class="fr XQmassegeL  clearfix">
                            <div class="clearfix">
                                <em class="fr XQmassegestart Aisstart{{$v->user->evaluate_avg_grade?:0}}" :class="starts"></em>
                                <span class="XQhlword">红利分享信誉</span>
                            </div>

                            {{--<div class="clearfix XQxuanze">--}}
                            {{--<span class="fr sButtongrey " onclick="cancel({{$v->id}})"><input type="button" value="取消"/></span>--}}
                            {{--<span class="fr sButtongred mr10" onclick="selectTender({{$v->id}})"><input type="button" value="选择"/></span>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                    <div class="clearfix XQxuanze" style="margin-left:58px">
                        <span class="fl sButtongyellow mr10" onclick="location.href='{{url('wechat/chat/message/'.$v->user->id)}}'">
                            <input type="button" value="聊天"/></span>
                        <span class="fl sButtongred mr10" onclick="selectTender({{$v->id}})"><input type="button" value="选择"/></span>
                        <span class="fl sButtongrey mr10" onclick="cancel({{$v->id}})"><input type="button" value="取消"/></span>
                    </div>
                </a>
                <div class="XQTotal clearfix">
                    <span class="XQTotalwrod1">报价总额：<em class="XQTotalred1">￥</em><em class="XQTotalred2">{{$v->getPrice()}}</em></span>
                    <span class="XQTotalwrod3">邮费：<em class="XQTotalred1">￥</em><em class="XQTotalred2">{{$v->express_price}}</em></span>
                    <div class="XQTotalwrod2">较已知订单总额节省 <em class="XQTotalgreen1">￥</em><em class="XQTotalgreen2">{{$v->countSparePrice()}}</em></div>
                </div>
                <p class="fabuing">报价优势
                    <span class="fabuingtips">(请注意报价货源，平台不允许代购无法溯源商家的产品)</span>
                </p>
                <ul class="XQadvantage clearfix">
                    @if($v->type=='other-hotboom')
                        <li class="qustion" onclick="location.href='{{url('wechat/demand/hotboom-store-site?lng='.$v->hotboom_lng.'&lat='.$v->hotboom_lat.'&name='.$v->hotboom_store_name)}}'">
                            其他商家
                        </li>
                    @else
                        <li>原路代购</li>
                    @endif
                    @foreach($v->quoteAdvantage as $v1)
                        @foreach(json_decode($v1->label,true) as $v2)
                            <li>{{$v2}}</li>
                        @endforeach
                        @if($v1->other)
                            <li>{{$v1->other}}</li>
                        @endif
                    @endforeach
                </ul>
            @endforeach
        @endif

        @if($demand->is_select)
            <p class="fabuing">报价人信息</p>
            <div class="XQmassegeall">
                <div class="jiantou jiantoubs" onclick="location.href='{{url('wechat/user/hotboom-info/'.$demand->user_tender_id)}}'">
                    <div class="clearfix ">
                        <div class="fl clearfix XQmassegeR">
                            <div class="XQmassegeimg fl">
                                <img src="{{$demand->selectUser->img_url or ''}}">
                            </div>
                            <div class="fl XQmassegewordR">
                                <div>
                            <span class="XQmassegeword1">
                                <em class="ellipsis1">{{$demand->selectUser->nickname or ''}}</em>
                            </span>
                                    <em class="XQmassegeicon1{{$demand->selectUser->mobile?'':'NO'}}"></em>
                                    <em class="XQmassegeicon2{{$demand->selectUser->is_auth?'':'NO'}}""></em>
                                </div>
                                <p class="XQmassegeword2">{{$demand->selectUser->mobile or ''}}</p>
                                <p class="XQmassegeword3">成交笔数：<em class="green">{{$demand->selectUser->daigou_over_demand or ''}}</em></p>
                            </div>
                        </div>
                        <div class="fr XQmassegeL  clearfix">
                            <div class="clearfix">
                                <em class="fr XQmassegestart Aisstart{{$demand->selectUser->evaluate_avg_grade or 0}}"></em>
                                <span class="XQhlword">红利分享信誉</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix chatselect">
                    <span class="fr sButtongrey "><input type="button" value="已选择"/></span>
                    <span class="fr sButtongyellow mr10" onclick="location.href='{{url('wechat/chat/message/'.$demand->selectUser->id)}}'">
                            <input type="button" value="聊天"/></span>
                </div>
            </div>
            {{--<div class="XQTotal clearfix">--}}
            {{--<span class="XQTotalwrod1 ">报价总额：<em class="XQTotalred1">￥</em>--}}
            {{--<em class="XQTotalred2">{{$demand->getTenderPrice()}}</em>--}}
            {{--</span>--}}
            {{--<span class="XQTotalwrod3">邮费：<em class="XQTotalred1">￥</em>--}}
            {{--<em class="XQTotalred2">{{$demand->express_price}}</em>--}}
            {{--</span>--}}
            {{--<div class="XQTotalwrod2">较已知订单总额节省--}}
            {{--<em class="XQTotalgreen1">￥</em><em class="XQTotalgreen2">{{$sparePrice}}</em>--}}
            {{--</div>--}}
            {{--</div>--}}
            <p class="fabuing">报价优势
                <span class="fabuingtips">(请注意报价货源，平台不允许代购无法溯源商家的产品)</span>
            </p>
            <ul class="XQadvantage clearfix">
                @if($demand->selectUserTender->type=='other-hotboom')
                    <li class="qustion" onclick="location.href='{{url('wechat/demand/hotboom-store-site?lng='.$demand->selectUserTender->hotboom_lng.'&lat='.$demand->selectUserTender->hotboom_lat.'&name='.$demand->selectUserTender->hotboom_store_name)}}'">
                        其他商家
                    </li>
                @else
                    <li>原路代购</li>
                @endif
                @foreach($demand->quoteAdvantage as $v)
                    @foreach(json_decode($v->label,true) as $v1)
                        <li>{{$v1}}</li>
                    @endforeach
                    @if($v->other)
                        <li>{{$v->other}}</li>
                    @endif
                @endforeach
            </ul>
        @endif

        @if($demand->status>3)
            <p class="fabuing">订单信息 <span style="font-size: 10px;color:#F8525A;">（请注意物流溯源和购买凭证是甄别货源的重要依据）</span></p>
            <dl class="OrderLogistics clearfix">
                <dt>订单时间：</dt>
                <dd>{{$demand->issue_time}}</dd>
            </dl>
            <dl class="OrderLogistics clearfix">
                <dt>支付时间：</dt>
                <dd>{{$demand->pay_time}}</dd>
            </dl>
            <dl class="OrderLogistics clearfix">
                <dt>收货时间：</dt>
                <dd>{{$demand->over_time}}</dd>
            </dl>
            <dl class="OrderLogistics clearfix">
                <dt>快递公司：</dt>
                <dd>{{$express[$demand->express_company_number] or ''}}</dd>
            </dl>
            <dl class="OrderLogistics clearfix">
                <dt class="OrderLogisticswrod1">快递单号：</dt>
                <dd class="clearfix"><span class="OrderLogisticswrod2">{{$demand->express_number}}</span>
                    <div class="btnsquerIcongred fr" onclick="location.href='{{url('wechat/demand/view-logistics/'.$demand->id)}}'">
                        <input type="button" value="查看物流"></div>
                </dd>
            </dl>
            <dl class="OrderLogistics clearfix">
                <dt>发货时间：</dt>
                <dd>{{$demand->delivery_time}}</dd>
            </dl>
            <dl class="offers clearfix">
                <dt class="mt5">购买凭证：</dt>
                <dd>
                    <ul class="cUl mt10 clearfix">
                        <li class="">
                            @foreach($demand->shopInvoiceImg as $v)
                                <img src="{{$v->url}}" alt="">
                            @endforeach
                        </li>
                    </ul>
                </dd>
            </dl>
            @if($demand->issue_evaluate && $demand->issueEvaluate)
                <dl class="dlword clearfix">
                    <dt class="">与描述相符：</dt>
                    <dd>
                        <ul class="clickstart mt12" id="goods_grade">
                            @for($i=0;$i<$demand->issueEvaluate->goods_grade;$i++)
                                <li class="hasStart"></li>
                            @endfor
                        </ul>
                    </dd>
                </dl>

                <dl class="dlword clearfix">
                    <dt class="">服务态度：</dt>
                    <dd>
                        <ul class="clickstart mt12" id="service_grade">
                            @for($i=0;$i<$demand->issueEvaluate->service_grade;$i++)
                                <li class="hasStart"></li>
                            @endfor
                        </ul>
                    </dd>
                </dl>

                <dl class="dlword clearfix">
                    <dt class="">发货速度：</dt>
                    <dd>
                        <ul class="clickstart mt12" id="deliver_grade">
                            @for($i=0;$i<$demand->issueEvaluate->deliver_grade;$i++)
                                <li class="hasStart"></li>
                            @endfor
                        </ul>
                    </dd>
                </dl>

                <dl class="dlword clearfix">
                    <dt class="">物流服务：</dt>
                    <dd>
                        <ul class="clickstart mt12" id="logistics_grade">
                            @for($i=0;$i<$demand->issueEvaluate->logistics_grade;$i++)
                                <li class="hasStart"></li>
                            @endfor
                        </ul>
                    </dd>
                </dl>
                <dl class="offers clearfix">
                    <dt class="mt5">评价：</dt>
                    <dd>
                        <div class="OrderLotextarea">
                            <textarea placeholder="输入评价.." style="width: 100%;" disabled="">{{$demand->issueEvaluate->content or ''}}</textarea>
                        </div>
                    </dd>
                </dl>
            @endif
        @endif

        <div style="height: 45px;"></div>

        @if($demand->status==-1)
            <div class="btnthere clearfix">
                <a href="{{url('wechat/demand/edit/'.$goods->id)}}"><input type="button" value="修改"></a>
                <a href="javascript:removeDemand({{$demand->id}})"><input type="button" value="删除"></a>
                <a href="javascript:issueAlert()"><input type="button" value="发布"></a>
            </div>
        @elseif($demand->status==1 && !$demand->userTender->count())
            <div class="btntwo clearfix">
                <a href="{{url('wechat/demand/edit/'.$goods->id)}}"><input type="button" value="修改"></a>
                <a href="javascript:recall({{$demand->id}})"><input type="button" value="撤回"></a>
            </div>
        @elseif($demand->status==2)
            <a class="Lbtnred" href="{{url('wechat/demand/pay/'.$demand->id)}}" id="demand-pay">
                立即支付
            </a>
        @elseif($demand->status==3)
            <a class="Lbtnred" href="{{url('wechat/demand/return-goods/'.$demand->id.'?type=return-money')}}">
                申请退款
            </a>
        @elseif($demand->status==4)
            <div class="OrderConfirm clearfix">
                <a class="fl" href="{{url('wechat/demand/return-goods/'.$demand->id.'?type=return-goods')}}"><input type="button" value="申请退货"></a>
                <a class="fl active" href="javascript:confirmSignfor({{$demand->id}})"><input type="button" value="确认收货"></a>
            </div>
        @elseif($demand->status==5 && !$demand->issue_evaluate)
            <a class="Lbtnred" href="{{url('wechat/demand/evaluate/'.$demand->id)}}">
                评价
            </a>
        @endif
    </div>
    {{--发布需求弹窗--}}
    <div class="bg"></div>
    <div class="fubutanall">
        <div class="fubutan">
            <div class="tanclose">+</div>

            <dl class="offers clearfix">
                <dt class="mt5"><em>*</em>订单有效期：</dt>
                <dd>
                    <div class="NBnumall2 clearfix  ">
                        <span class="reduce2"></span>
                        <input class="NBnumtext2 quantity2" type="text" name="day" value="1" id="issue-day">
                        <span class="timedate mr10">天</span>
                        <span class="plus2"></span>
                    </div>
                    <div class="NBnumall clearfix mt15 ">
                        <span class="reduce"></span>
                        <input class="NBnumtext quantity" type="text" name="hour" value="1" id="issue-hour">
                        <span class="timedate mr10">时</span>
                        <span class="plus"></span>
                    </div>
                    <a class="tansure save-demand" status="1" href="javascript:confirmIssue();">
                        <input type="button" value="确认"/>
                    </a>
                </dd>
            </dl>
        </div>
    </div>
@stop

@section('js')
    <script src="{{asset('asset/wechat/js/swiper-3.4.2.min.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('asset/wechat/js/vue.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('asset/ext/layer/layer.min.js')}}"></script>
    <script>
        function removeDemand(id) {
            layer.confirm('确认要删除吗？', {
                title: '删除警告',
                btn: ['确认', '取消'], //按钮
//                shade: false //不显示遮罩
            }, function () {
                $.post("{{url('wechat/demand/remove')}}/" + id,
                    {_token: '{{csrf_token()}}'},
                    function (data, status) {
                        if (data.status != 1) {
                            layer.msg(data.message);
                        } else {
                            location.href = '{{url('wechat/demand/index')}}';
                        }
                    });
            }, function () {

            });
        }

        function recall(id) {
            layer.confirm('确认要撤回吗？', {
                title: '撤回提示',
                btn: ['确认', '取消'], //按钮
//                shade: false //不显示遮罩
            }, function () {
                $.post("{{url('wechat/demand/recall')}}/" + id,
                    {_token: '{{csrf_token()}}'},
                    function (data, status) {
                        if (data.status != 1) {
                            layer.msg(data.message);
                        } else {
                            location.reload();
                        }
                    });
            }, function () {

            });
        }
        //发布需求弹窗
        function issueAlert() {
            $(".fubutanall,.bg").show();
        }
        //确认发布
        function confirmIssue() {
            var day = $('#issue-day').val();
            var hour = $('#issue-hour').val();
            $.post("{{url('wechat/demand/issue/'.$demand->id)}}",
                {_token: '{{csrf_token()}}', day: day, hour: hour},
                function (data, status) {
                    if (data.status != 1) {
                        layer.msg(data.message);
                    } else {
                        location.reload();
                    }
                });
        }
        //选择报价用户
        function selectTender(id) {
            layer.confirm('请注意报价优势里的货源信息，无法公开查询店铺信息的非原路代购请谨慎选择！', {
                btn: ['确认选择', '再考虑下']
            }, function (index, layero) {
                $.post("{{url('wechat/tender/select')}}/" + id,
                    {_token: '{{csrf_token()}}'},
                    function (data, status) {
                        if (data.status != 1) {
                            layer.msg(data.message);
                        } else {
                            location.reload();
                        }
                    });
            }, function (index) {
                //按钮【按钮二】的回调
            });
        }
        //取消报价用户
        function cancel(id) {
            layer.confirm('确定要取消该报价吗？', {
                btn: ['确认取消', '再考虑下']
            }, function (index, layero) {
                $.post("{{url('wechat/tender/cancel')}}/" + id,
                    {_token: '{{csrf_token()}}'},
                    function (data, status) {
                        if (data.status != 1) {
                            layer.msg(data.message);
                        } else {
                            location.reload();
                        }
                    });
            }, function (index) {
                //按钮【按钮二】的回调
            });
        }
        //确认收货
        function confirmSignfor(id) {
            layer.confirm('请注意判断货源的真实性(如通过物流溯源，购买凭证，查询店铺公开信息和联系求证等)', {
                btn: ['确认收货', '再检查下']
            }, function (index, layero) {
                $.post("{{url('wechat/demand/confirm-signfor')}}/" + id,
                    {_token: '{{csrf_token()}}'},
                    function (data, status) {
                        if (data.status != 1) {
                            layer.msg(data.message);
                        } else {
                            location.reload();
                        }
                    });
            }, function (index) {
                //按钮【按钮二】的回调
            });
        }

        $(".tanclose,.bg").click(function () {
            $(".fubutanall,.bg").hide();
        })

        var swiper = new Swiper('.swiper-container', {//banner
            pagination: '.swiper-pagination',
            paginationClickable: true,
        });

        xqwchange();
        $(window).resize(function () {
            xqwchange();
        })

        function xqwchange() {//banner 图片
            var xqw = $(".XQbanner").width();
            $(".XQbanner img,.XQbanner").css("height", xqw);
        }


        /***********************************倒计时 开始**************************************************************/
        $(function () {
            @if($demand->is_select)
            timer({{$demand->pay_end_time-time()}}, "#time1");
            @else
            timer(parseInt({{$demand->end_time-time()}}), "#time1");
            @endif
            //选择优惠券
            $('#select-coupon').on('change', function () {
                var url = '{{url('wechat/demand/pay/'.$demand->id)}}';
                var couponPrice = parseFloat($(this).find(':selected').attr('price'));
                var payPrice = parseFloat($('#pay-price').attr('price')) - couponPrice;
                payPrice = payPrice < 0 ? 0 : payPrice;
                $('#coupon-price').text('￥' + couponPrice);
                $('#pay-price').text('￥' + payPrice);
                $('#demand-pay').attr('href', url + '/' + $(this).val())

            });
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

        //购物加减
        $('.plus').click(function () {//加
            add(this);
        })
        $('.reduce').click(function () {//减
            reduce(this);
        })

        //购物加减2 ，value=0
        $('.plus2').click(function () {//加
            add2(this);
        })
        $('.reduce2').click(function () {//减
            reduce2(this);
        })

        function add(obj) {//加法
            var divObj = $(obj).parent('.NBnumall');
            changeCount(divObj, 1);
        }

        function reduce(obj) {//减法
            var divObj = $(obj).parent('.NBnumall');
            changeCount(divObj, -1);
        }
        function changeCount(obj, count) { //改变数量
            var nowCount = $(obj).find('.quantity').val();
            nowCount = parseInt(nowCount);
            if (nowCount + count > 0) {
                $(obj).find('.quantity').val(nowCount + count);
            } else {
                $(obj).find('.quantity').val(1);
            }
        }

        /***********************数量加减 value=0*************************/

        function add2(obj) {//加法
            var divObj = $(obj).parent('.NBnumall2');
            changeCount2(divObj, 1);
        }

        function reduce2(obj) {//减法
            var divObj = $(obj).parent('.NBnumall2');
            changeCount2(divObj, -1);
        }
        function changeCount2(obj, count) { //改变数量
            var nowCount = $(obj).find('.quantity2').val();
            nowCount = parseInt(nowCount);
            if (nowCount + count > 0) {
                $(obj).find('.quantity2').val(nowCount + count);
            } else {
                $(obj).find('.quantity2').val(0);
            }
        }
    </script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" charset="utf-8"></script>
    <script>
        //微信分享配置
        wx.config({!! $js->config(['onMenuShareTimeline','onMenuShareAppMessage'],false) !!});
        wx.ready(function () {
            //分享朋友圈
            wx.onMenuShareTimeline({
                @if($demand->is_select)
                title: '共享钱包，您挑商品我下单，立省¥{{$savePrice}}，上【红鱼】公众号体验购物新玩法！',
                {{--                title: '(节省金额￥{{$savePrice}})我在【红鱼】找到了能更低价拿货的牛人，快来围观吧', // 分享标题--}}
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
                @if($demand->is_select)
                title: '共享钱包，您挑商品我下单，立省¥{{$savePrice}}，上【红鱼】公众号体验购物新玩法！',
                {{--title: '(节省金额￥{{$savePrice}})我在【红鱼】找到了能更低价拿货的牛人，快来围观吧', // 分享标题--}}
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
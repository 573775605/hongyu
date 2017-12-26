@extends('wechat.layout.master')

@section('title','参加报价')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/AddSubtract.css')}}"/>
@stop

@section('content')
    <div class="Uneedtit clearfix XQdingdan">
        <span class="Uword2">订单号:{{$demand->order_number}}</span>
        <span class="Uorder">订单总额:<em class="Iprice">¥{{number_format($demand->getPrice(),2)}}</span>
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
                            <div class="fr" onclick="location.href='{{url('wechat/check-browse?url='.urlencode($v->link))}}'">
                                <div class="btnsquerIcongreen">
                                    <input type="button" value="商品链接">
                                </div>
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

    <a class=" XQ2adress jiantou">
        <div class="clearfix XQ2adressword1">
            <div class="fl">
                收货人：{{$demand->consignee}}
            </div>
            <div class="fr">
                {{str_replace(substr($demand->phone,3,4),'****',$demand->phone)}}
            </div>
        </div>
        <div class="XQ2adressword2 ellipsis2">
            收货地址：{{$address}}
        </div>
    </a>

    <form action="" method="post" id="form" onsubmit="return checkForm()">
        {!! csrf_field() !!}
        <input type="hidden" name="demand_id" value="{{request('demand_id')}}">
        <input type="hidden" name="type" value="{{request('type')}}">
        <input type="hidden" name="hotboom_lng" value="{{request('hotboom_lng')}}">
        <input type="hidden" name="hotboom_lat" value="{{request('hotboom_lat')}}">
        <input type="hidden" name="hotboom_store_name" value="{{request('hotboom_store_name')}}">
        @foreach(request('advantage',[]) as $k=>$v)
            @if(isset($v['select']))
                @foreach($v['select'] as $v1)
                    <input type="hidden" name="advantage[{{$k}}][select][]" value="{{$v1}}">
                @endforeach
            @endif
            <input type="hidden" name="advantage[{{$k}}][other]" value="{{$v['other']}}">
        @endforeach

        {{--<dl class="offers clearfix">--}}
        {{--<dt class="mt12"><em>*</em>报价类型：</dt>--}}
        {{--<dd>--}}
        {{--<div class="border jiantoub">--}}
        {{--<select name="hotboom_type" class="selects selectstext">--}}
        {{--@foreach($hotboomType as $k=>$v)--}}
        {{--<option value="{{$k}}">{{$v}}</option>--}}
        {{--@endforeach--}}
        {{--</select>--}}
        {{--</div>--}}
        {{--</dd>--}}
        {{--</dl>--}}

        <dl class="offers clearfix">
            <dt class="mt12"><em>*</em>报价金额(元)：</dt>
            <dd>
                <div class="border Daddress">
                    <input type="number" placeholder="您代购该订单收取的总价款" name="quote" value="{{request('quote')}}"/>
                </div>
            </dd>
        </dl>

        <dl class="offers clearfix">
            <dt class="mt12"><em>*</em>邮费：</dt>
            <dd>
                <div class="border Daddress">
                    <input type="number" placeholder="0" name="express_price" value="{{request('express_price')}}"/>
                </div>
            </dd>
        </dl>
        <dl class="offers clearfix">
            <dt class="mt5"><em>*</em>报价优势：</dt>
            <dd>
                <a class="btnsqueryellow2">
                    <input type="button" value="选择" onclick="selectAdvantage()"/>
                </a>
            </dd>
        </dl>
        <dl class="offers clearfix">
            <dt class="mt5">库存数量：</dt>
            <dd>
                <div class="NBnumall clearfix ">
                    <span class="reduce"></span>
                    <input class="NBnumtext quantity" type="number" name="repertory" value="{{request('repertory',1)}}">
                    <span class="plus"></span>
                </div>
            </dd>
        </dl>

        <dl class="offers clearfix">
            <dt class="mt5">代购有效期：</dt>
            <dd>
                <div class="NBnumall clearfix  ">
                    <span class="reduce"></span>
                    <input class="NBnumtext quantity" type="number" name="day" value="{{request('day',1)}}">
                    <span class="timedate mr10">天</span>
                    <span class="plus"></span>
                </div>
                <div class="NBnumall clearfix mt15 ">
                    <span class="reduce"></span>
                    <input class="NBnumtext quantity" type="number" name="hour" value="{{request('hour',1)}}">
                    <span class="timedate mr10">时</span>
                    <span class="plus"></span>
                </div>
            </dd>
        </dl>
    </form>

    <a class="redbtn90">
        <input type="button" value="确认报价" onclick="submitQuote()"/>
    </a>

@stop

@section('js')
    <script>
        //选择报价优势
        function selectAdvantage() {
            var url = '{{url('wechat/tender/select-advantage')}}'
            $('#form').attr('action', url);
            $('#form').submit();
        }
        //提交报价
        function submitQuote() {
            var url = '{{url('wechat/tender/submit')}}'
            $('#form').attr('action', url);
            if ($('input[name=quote]').val() == '') {
                alert('请输入报价金额');
                return false;
            }
            $('#form').submit();
        }

        function changeCount(obj, count, defaultVal) { //改变数量
            var nowCount = $(obj).find('.quantity').val();
            nowCount = parseInt(nowCount);
            if (nowCount + count > 0) {
                $(obj).find('.quantity').val(nowCount + count);
            } else {
                $(obj).find('.quantity').val(defaultVal);
            }
        }
        $('.plus').click(function () {//加
            var divObj = $(this).parent('.NBnumall');
            changeCount(divObj, 1, 1);
        })
        $('.reduce').click(function () {//减
            var divObj = $(this).parent('.NBnumall');
            if ($(divObj).find('.quantity').attr('name') == 'day') {
                changeCount(divObj, -1, 0);
            } else {
                changeCount(divObj, -1, 1);
            }
        })
    </script>
@stop
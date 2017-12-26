@foreach($rows as $v)
    <li>
        <div class="Uneedtit clearfix">
            <span class="Uword2">订单号:
                <input type="text" readonly="text" value="{{$v->order_number}}">
            </span>
            <span class="Uorder">订单总额:<em class="Iprice">¥{{$v->known_price}}</em></span>
            <span class="Idistance">{{$v->create_time}}</span>
        </div>
        @if($v->demandGoods && $v->demandGoods->first())
            <a href="{{url('wechat/demand/details/'.$v->id)}}">
                <div class="Uneedcont clearfix">
                    <div class="Uneedcontimg ">
                        <img src="{{$v->demandGoods->first()->img->url or ''}}">
                    </div>
                    <div class="fl Uneedcontwords">
                        <p class="Uneedcontwords1 ellipsis1">{{$v->demandGoods->first()->name}}</p>
                        <p class="Uneedcontwords2"><em class="Uneedred1">¥{{$v->demandGoods->first()->known_unit_price}}</em> /
                            *{{$v->demandGoods->first()->count}}{{$v->demandGoods->first()->unit}}</p>
                        <p class="Uneedcontwords3 clearfix"><span class="fl">{{$v->getIssueSite()}}</span></p>
                    </div>
                </div>
            </a>
        @endif
        <div class="clearfix Uneedtime">
            <div class="ordertimeL clearfix">
            <div class="Orderwyellow fl ">
                @if($v->is_select)
                    已选中报价
                @else
                    已有{{$v->userTender->whereLoose('status',1)->count()}}人报价
                @endif
            </div>
            @if($v->status==1||$v->status==2)
                <div class="timespan" id="time{{request('status')}}{{$v->id}}">
                    @if($v->status==1)
                        <span class="day_show">0</span>&nbsp;<em>天</em>
                    @endif
                    <span class="hour_show"><s id="h"></s>0</span>&nbsp;<em>时</em>
                    <span class="minute_show"><s></s>0</span>&nbsp;<em>分</em>
                    <span class="second_show"><s></s>0</span>&nbsp;<em>秒</em>
                </div>
                <script>
                    @if($v->is_select)
                    timer({{$v->pay_end_time-time()}}, '#time{{request('status')}}{{$v->id}}');
                    @else
                    timer({{$v->end_time-time()}}, '#time{{request('status')}}{{$v->id}}');
                    @endif
                </script>
            @endif
            </div>
            <div class="orderButtonyellow mt5   ">
                @if($v->status==-2)
                    <input type="button" value="{{$status[$v->status].'('.$returnStatus[$v->returnGoodsApply->status].')'}}">
                @elseif($v->status!=5)
                    <input type="button" value="{{$status[$v->status] or ''}}">
                @else
                    <input type="button" value="{{$v->issue_evaluate?'已完成':'待评价'}}">
                @endif
            </div>
        </div>
    </li>
@endforeach
@foreach($rows as $v)
    <li>
        <div class="Uneedtit clearfix">
            <span class="Uword2">订单号:{{$v->demand->order_number or ''}}</span>
            <span class="Uorder">订单总额:<em class="Iprice">¥<em class="Iprice2">{{$v->demand->getPrice()}}</em></em></span>
            <span class="Idistance">{{$v->demand->create_time or ''}}</span>
        </div>

        <div class="Uneedcont clearfix" onclick="location.href='{{url('wechat/tender/demand-details/'.$v->demand_id.'?tender_id='.$v->id)}}'">
            <div class="Uneedcontimg ">
                <img src="{{$v->demand->demandGoods->first()->img->url or ''}}">
            </div>
            <div class="fl Uneedcontwords">
                <p class="Uneedcontwords1 ellipsis1">{{$v->demand->demandGoods->first()->name or ''}}</p>
                <p class="Uneedcontwords2">
                    <em class="Uneedred1">¥<span class="Uneedred2">{{$v->demand->demandGoods->first()->known_unit_price or ''}}</span></em> /
                    *{{$v->demand->demandGoods->first()->count or ''}}{{$v->demand->demandGoods->first()->unit}}</p>
                <p class="Uneedcontwords3 clearfix"><span class="fl">{{$v->demand->getIssueSite()}}</span></p>
            </div>
        </div>

        <div class="clearfix Uneedtime">
            <div class="Orderwgreen fl ">参与报价</div>
            @if($v->status==1)
                <div class="timespan fl" id="time{{$v->id}}">
                    <span class="day_show">0</span>&nbsp;<em>天</em>
                    <span class="hour_show"><s id="h"></s>0</span>&nbsp;<em>时</em>
                    <span class="minute_show"><s></s>0</span>&nbsp;<em>分</em>
                    <span class="second_show"><s></s>0</span>&nbsp;<em>秒</em>
                </div>
                <script>
                    timer(parseInt({{$v->demand->end_time-time()}}), "#time{{$v->id}}");
                </script>
            @endif
            @if($v->status==1|$v->status==3)
                <div class="orderButtongreen fr mt5   ">
                    <input type="button" value="{{$demandStatus[$v->demand->status] or ''}}">
                </div>
            @endif
            @if($v->isDelete())
                <a class="orderButtongred fr mt5" href="javascript:removeTender('{{route('tenderDelete',['id'=>$v->id])}}')">
                    <input type="button" value="删除">
                </a>
            @endif

        </div>

    </li>
@endforeach
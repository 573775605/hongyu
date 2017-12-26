@foreach($rows as $v)
    <li>
        <div class="Uneedtit clearfix">
            <span class="Uword2">订单号:{{$v->demand->order_number}}</span>
            <span class="Uorder">订单总额:<em class="Iprice">¥<em class="Iprice2">{{$v->demand->known_price}}</em></em></span>
            <span class="Idistance">{{$v->demand->create_time}}</span>
        </div>

        <div class="Uneedcont clearfix" {{url('wechat/tender/demand-details/'.$v->demand_id)}}>
            <div class="Uneedcontimg ">
                <img src="{{$v->demand->demandGoods->first()->img->url or ''}}">
            </div>
            <div class="fl Uneedcontwords">
                <p class="Uneedcontwords1 ellipsis1">{{$v->demand->demandGoods->first()->name or ''}}</p>
                <p class="Uneedcontwords2"><em class="Uneedred1">¥<span class="Uneedred2">15</span>.50</em> /
                    *{{$v->demand->demandGoods->first()->count or ''}}{{$v->demand->demandGoods->first()->unit or ''}}</p>
                <p class="Uneedcontwords3 clearfix">
                    <span class="fl">{{$v->demand->getIssueSite()}}</span><span class="fr">货源： <em class="Uneedred1">{{$v->demand->demandGoods->first()->source or ''}}</em></span>
                </p>
            </div>
        </div>

        <div class="clearfix Uneedtime">
            <div class="Orderwgreen Orderwred  fl ">{{$status[$v->demand->status] or ''}}</div>
            @if($v->demand->status==1)
                <div class="timespan fl" id="time{{$v->id}}">
                    <span class="day_show">0</span>&nbsp;<em>天</em>
                    <span class="hour_show"><s id="h"></s>0</span>&nbsp;<em>时</em>
                    <span class="minute_show"><s></s>0</span>&nbsp;<em>分</em>
                    <span class="second_show"><s></s>0</span>&nbsp;<em>秒</em>
                </div>
                <a class="orderButtongred fr " href="{{url('wechat/tender/demand-details/'.$v->demand_id)}}">
                    <input type="button" value="报价">
                </a>
                <script>
                    timer(parseInt({{$v->demand->end_time-time()}}), "#time{{$v->id}}");
                </script>
            @endif
            <a class="orderButtongred fr " href="javascript:removeDemand({{$v->id}})">
                <input type="button" value="报价">
            </a>
        </div>

    </li>
@endforeach
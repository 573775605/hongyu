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
            <div class="UneedButtonred fl   ">
                <input type="button" value="{{$status[$v->status] or ''}}"/>
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
    <script>
        timer(parseInt({{$v->end_time-time()}}), "#time{{$v->id}}");
    </script>
@endforeach
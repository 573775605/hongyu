{{--@foreach($rows as $v)--}}
{{--<li class="clearfix">--}}
{{--<div class="evaluateUlimg">--}}
{{--<img src="{{$v->evaluateUser->img_url or ''}}"/>--}}
{{--</div>--}}
{{--<div class="evaluateUlR">--}}
{{--<div class="clearfix evaluateUltit">--}}
{{--<div class="fl evaluateUltit1">--}}
{{--<span class="ellipsis1">{{$v->evaluateUser->nickname or ''}}</span>--}}
{{--</div>--}}
{{--<div class="fr evaluateUltit2">--}}
{{--<span class="ellipsis1">{{$v->create_time}}</span>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="evaluateUltit3 ellipsis1">--}}
{{--{{$v->content}}--}}
{{--</div>--}}
{{--</div>--}}
{{--</li>--}}
{{--@endforeach--}}
@foreach($rows as $v)
    <li>
        <a href="{{url('wechat/tender/demand-details/'.$v->id)}}">
            {{--<div class="timespan2" id="time{{$v->id}}">--}}
            {{--<span class="day_show">0</span><em>天</em>--}}
            {{--<span class="hour_show"><s id="h"></s>0</span><em>时</em>--}}
            {{--<span class="minute_show"><s></s>0</span><em>分</em>--}}
            {{--<span class="second_show"><s></s>0</span><em>秒</em>--}}
            {{--</div>--}}
            @if($v->demandGoods&&$v->demandGoods->first())
                <div class="fubuimgListimg">
                    <img src="{{$v->demandGoods->first()->img->url or ''}}"/>
                </div>
                <div class="fubuimgListword1 ellipsis1">{{$v->demandGoods->first()->name}}</div>
                <p class="fubuimgListword2">￥{{$v->demandGoods->first()->price}}</p>
                <div class="clearfix ">
                    <div class="fubuimgListword3">
                        <div class="ellipsis1 fubuimgListword3icon">{{$v->getIssueSite()}}</div>
                    </div>
                    <div class="fubuimgListword4">{{$v->issue_time}}</div>
                </div>
            @endif
        </a>
    </li>
@endforeach
@extends('wechat.layout.master')

@section('title','优惠券')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/youhuiquan.css')}}"/>
@stop

@section('content')
    <ul class="Coupon clearfix">
        <li class="active"><a href="javascript:;">未使用</a></li>
        <li><a href="javascript:;">已使用</a></li>
        <li><a href="javascript:;">已过期</a></li>
    </ul>

    <div class="Couponcont">
        <ul class="active">
            @foreach($rows->filter(function($item){return $item->status==1 && strtotime($item->valid_time)>time();}) as $v)
                <li class="">
                    <div class="couRed"></div>
                    <a href="javascript:;" class="clearfix">
                        <div class="fl couPrice">
                            <em>¥</em>
                            <span>{{$v->price}}</span>
                            <p>满{{$v->full_price_use}}使用</p>
                        </div>
                        <div class="fr couwords">
                            <p class="couwords1">{{$v->name}}</p>
                            <div class="couwords2">有效期至{{$v->valid_time}}</div>
                            <div class="couwords3">{{$v->description}}<em></em></div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>

        <ul>
            @foreach($rows->filter(function($item){return $item->status==2;}) as $v)
                <li class="">
                    <div class="couRed"></div>
                    <a href="javascript:;" class="clearfix">
                        <div class="fl couPrice">
                            <em>¥</em>
                            <span>{{$v->price}}</span>
                            <p>满{{$v->full_price_use}}使用</p>
                        </div>
                        <div class="fr couwords">
                            <p class="couwords1">{{$v->name}}</p>
                            <div class="couwords2">有效期至{{$v->valid_time}}</div>
                            <div class="couwords3">{{$v->description}}<em></em></div>
                        </div>
                    </a>
                    <div class="usedimg" title="已使用"></div>
                </li>
            @endforeach
        </ul>
        <ul>
            @foreach($rows->filter(function($item){return $item->status==1 && time()>strtotime($item->valid_time);}) as $v)
                <li class="">
                    <div class="couRed"></div>
                    <a href="javascript:;" class="clearfix">
                        <div class="fl couPrice">
                            <em>¥</em>
                            <span>{{$v->price}}</span>
                            <p>满{{$v->full_price_use}}使用</p>
                        </div>
                        <div class="fr couwords">
                            <p class="couwords1">{{$v->name}}</p>
                            <div class="couwords2">有效期至{{$v->valid_time}}</div>
                            <div class="couwords3">{{$v->description}}<em></em></div>
                        </div>
                    </a>
                    <div class="passedimg" title="已过期"></div>
                </li>
            @endforeach
        </ul>
    </div>
@stop

@section('js')
    <script type="text/javascript">
        $(function () {
            //头部导航切换
            $('.Coupon li').click(function () {
                var i = $('.Coupon li').index($(this));
                $('.Coupon li').removeClass('active');
                $(this).addClass('active');
                $(".Couponcont ul").eq(i).addClass('active').siblings().removeClass("active");
            })
        })
    </script>
@stop
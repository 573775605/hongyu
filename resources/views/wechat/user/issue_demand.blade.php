@extends('wechat.layout.master')

@section('title','用户发布信息')
@section('body','bgf9')
@section('content')
    <div id="testel">
        <div class="clearfix User">
            <div class="fl UserL clearfix">
                <div class="fl Userimg">
                    <img src="{{$user->img_url}}"/>
                </div>
                <div class="fl ">
                    <p class="ellipsis1 Userword1">{{$user->nickname}}</p>
                    <p class="ellipsis1 Userword2">成交笔数: <em class="green">{{$user->issue_over_demand}}</em></p>
                    <p class="ellipsis1 Userword3">{{$demand::countTimeInterval($user->update_time)}}来过</p>
                </div>
            </div>
            <div class="fr UserR clearfix">
                <p class="clearfix fr">
                    <span class="fl">红利需求信誉</span><em class="fl Astart{{$user->daigou_evaluate_avg_grade}}" style="margin-top:8px; margin-left: 5px;"></em></p>
                {{--<p class="clearfix fr">--}}
                {{--<span class="fl">红利分享信誉</span><em class="fl Astart{{$user->evaluate_avg_grade}}" style="margin-top:8px; margin-left: 5px;"></em></p>--}}
            </div>
        </div>

        <div class="clearfix Userphoneall">
            <div class="fl Userphone">{{str_replace(substr($demand->data->phone,3,4),'****',$demand->data->phone)}}</div>
            <div class="fl Useradress">{{$demand->hideAddress()}}</div>
            <p class="Userlook bgfff">报价被选定后才能查看</p>
        </div>

        <div class="clearfix evaluateall">
            <div class="fl evaluate">
                收到的评价
            </div>
            <a class="fr evaluateMore" href="{{url('wechat/user/all-evaluate/issue/'.$user->id)}}">
                更多评价
            </a>
        </div>

        <ul class="evaluateUl ">
            @foreach($evaluate as $v)
                <li class="clearfix">
                    <div class="evaluateUlimg">
                        <img src="{{$v->evaluateUser->img_url or ''}}"/>
                    </div>
                    <div class="evaluateUlR">
                        <div class="clearfix evaluateUltit">
                            <div class="fl evaluateUltit1">
                                <span class="ellipsis1">{{$v->evaluateUser->nickname or ''}}</span>
                            </div>
                            <div class="fr evaluateUltit2">
                                <span class="ellipsis1">{{$v->create_time}}</span>
                            </div>
                        </div>
                        <div class="evaluateUltit3 ellipsis1">
                            {{$v->content}}
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

        <p class="fabuing">正在发布</p>
        <ul class="fubuimgList clearfix">
            @foreach($demandList as $v)
                <li>
                    <a href="{{url('wechat/tender/demand-details/'.$v->id)}}">
                        <div class="timespan2" id="time{{$v->id}}">
                            <span class="day_show">0</span><em>天</em>
                            <span class="hour_show"><s id="h"></s>0</span><em>时</em>
                            <span class="minute_show"><s></s>0</span><em>分</em>
                            <span class="second_show"><s></s>0</span><em>秒</em>
                        </div>
                        @if($v->demandGoods&&$v->demandGoods->first())
                            <div class="fubuimgListimg">
                                <img src="{{$v->demandGoods->first()->img->url or ''}}"/>
                            </div>
                            <div class="fubuimgListword1 ellipsis1">{{$v->demandGoods->first()->name}}</div>
                            <p class="fubuimgListword2">￥{{$v->demandGoods->first()->price}}</p>
                            <div class="clearfix ">
                                <div class="fubuimgListword3">
                                    <div class="ellipsis1 fubuimgListword3icon">{{$v->demandGoods->first()->getSite()}}</div>
                                </div>
                                <div class="fubuimgListword4">{{$v->issue_time}}</div>
                            </div>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@stop

@section('js')
    <script>
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
        $(function () {
            //列表图片
            var fuW = $(".fubuimgListimg").width();
            $('.fubuimgListimg').css("height", fuW);

            @foreach($demandList as $v)
            timer(parseInt({{$v->end_time-time()}}), "#time{{$v->id}}");
            @endforeach
        })
    </script>
@stop
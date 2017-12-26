@extends('wechat.layout.master')

@section('title','报价人信息')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('asset/ext/dropload/dropload.css')}}">
@stop

@section('body','bgf9')

@section('content')
    <div class="InformationView">
        <div class="InformationViewimg">
            <img src="{{asset('asset/wechat/img/3.png')}}"/>
        </div>
        <div class="InformationViewicon">
            <img src="{{$tender->user->img_url or ''}}"/>
        </div>
    </div>
    <div class="IVadress">
        <p class="ellipsis1 IVadressword1">{{$tender->user->nickname or ''}}</p>
        <p class="ellipsis1 IVadressword2">{{$tender->getSite()}}</p>
    </div>

    <p class="IVtit">红利资源</p>
    <div class="ellipsis1 IVresourcesword ">
        {{$tender->user->userInfo->description or ''}}
    </div>
    <div class="clearfix evaluateall">
        <div class="fl evaluate">
            收到的评价
        </div>
        <a class="fr evaluateMore" href="{{url('wechat/user/all-evaluate/hotboom/'.$tender->user_id)}}">
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
    <p class="fabuing">参加报价</p>
    <div id="dropload">
        <ul class="fubuimgList clearfix" id="list">
            @foreach($demand as $v)
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
        </ul>
    </div>
@stop

@section('js')
    <script src="{{asset('asset/ext/dropload/dropload.min.js')}}"></script>
    <script>
        var page = 2, pageTotal ={{$evaluate->lastPage()}};
        $('#dropload').dropload({
            scrollArea: window,
            domDown: {
                domClass: "dropload-down",
                domRefresh: '<div class="dropload-refresh" style="display: none;">↑上拉加载更多</div>',
                domLoad: '<div class="dropload-load"><span class="loading"></span>加载中...</div>',
                domNoData: '<div class="dropload-noData">{{$evaluate->lastPage()?'没有更多数据':'暂无数据'}}</div>'
            },
            loadDownFn: function (me) {
                $.post("{{url('wechat/user/hotboom-info/'.$tender->id)}}",
                    {_token: '{{csrf_token()}}', page: page},
                    function (data, status) {
                        $('#list').append(data.data.rows);
                        page++;
                        if (page > pageTotal) {
                            // 锁定
                            me.lock();
                            // 无数据
                            me.noData();
                        }
                        me.resetload();
                    });
            }
        });
    </script>
@stop
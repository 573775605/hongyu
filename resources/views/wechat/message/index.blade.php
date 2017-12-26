@extends('wechat.layout.master')

@section('title','消息中心')


@section('content')

             <ul class="Mynews " >
                <li class="mynewsicon1">

                    <a href="{{url('wechat/chat/index')}}" class="jiantou">聊天消息 </a>
                        @if($chatMessageCount)
                            <span class="mynewqipao">{{$chatMessageCount}}</span>
                        @endif

                </li>
                <li class="mynewsicon2">

                    <a href="{{url('wechat/message/content/tender')}}" class="jiantou">报价消息 </a>
                        @if($tenderMessageCount)
                            <span class="mynewqipao">{{$tenderMessageCount}}</span>
                        @endif

                </li>
                <li class="mynewsicon3">
                    <a href="{{url('wechat/message/content/demand')}}" class="jiantou">订单消息 </a>
                        @if($demandMessageCount)
                            <span class="mynewqipao">{{$demandMessageCount}}</span>
                        @endif

                </li>
                <li class="mynewsicon4">

                    <a href="{{url('wechat/message/content/system')}}" class="jiantou">系统消息</a>
                    @if($systemMessageCount)
                        <span class="mynewqipao">{{$systemMessageCount}}</span>
                    @endif
                </li>
                <li class="mynewsicon5">

                    <a href="{{url('wechat/message/content/other')}}" class="jiantou">其他消息 </a>
                        @if($otherMessageCount)
                            <span class="mynewqipao">{{$otherMessageCount}}</span>
                        @endif

                </li>
</ul>


@stop

@section('js')




    <script>
        $(function () {
            if ($(".mynewqipao").text().length > 3) {
                $(".mynewqipao").html("...");
                $(".mynewqipao").css({"height": "26px", "line-height": "10px", "font-size": "26px"});
            }
        })
    </script>

@stop
@extends('wechat.layout.master')

@section('title','个人中心')


@section('content')
    <div class="Mycenter" style="background:url({{asset('asset/wechat/img/26.png')}}) no-repeat;background-size:cover;">
        <div style="padding-top: 20px"></div>
        <p class="Mycenterimg">
            <img src="{{$user->img_url}}"/>
        </p>
        <p class="Mycentername">{{$user->nickname}}</p>
        {{--<span class="Mycenternumber clearfix" onclick="location.href='{{url('wechat/user/user-info')}}'">{{$user->mobile}}15484--}}
        <span style="position: relative;display: inline-block;">
            @if($user->hide_mobile)
                <span class="Mycenternumber clearfix" id="mobile">{{str_replace(substr($user->mobile,3,4),'****',$user->mobile)}}</span>
            @else
                <span class="Mycenternumber clearfix" id="mobile">{{$user->mobile}}</span>
            @endif
            <em class="bianjiall" id="view" mobile="{{$user->hide_mobile?$user->mobile:str_replace(substr($user->mobile,3,4),'****',$user->mobile)}}"></em>
        </span>
        <a href="{{url('wechat/user/user-info')}}" class="Mycenterbj" title="编辑"></a>
    </div>

    <ul class="mineicon">
        <li class="aboutUsicon11"><a href="{{url('wechat/demand/index')}}" class="jiantou">红利需求订单</a></li>
        <li class="aboutUsicon12"><a href="{{url('wechat/hotboom-demand/index')}}" class="jiantou">红利分享订单</a></li>
        <li class="aboutUsicon1"><a href="{{url('wechat/center/tender-list')}}" class="jiantou">参加报价</a></li>
        <li class="aboutUsicon3"><a href="{{url('wechat/user/wallet')}}" class="jiantou">我的钱包</a></li>
        <li class="aboutUsicon4 mt10"><a href="{{url('wechat/hotboom-cart/index')}}" class="jiantou">我的代购车</a></li>
        <li class="aboutUsicon5"><a href="{{url('wechat/address')}}" class="jiantou">收货地址</a></li>
        <li class="aboutUsicon6"><a href="{{url('wechat/center/evaluate-grade')}}" class="jiantou">我的服务等级</a></li>
        <li class="aboutUsicon7 mt10"><a href="{{url('wechat/about/index')}}" class="jiantou">关于我们</a></li>
    </ul>
@stop

@section('js')
    <script src="{{asset('asset/ext/layer/layer.min.js')}}"></script>
    <script>
        $(function () {
            $('#view').click(function () {
                var element=this;
                $.post("{{url('wechat/user/hide-mobile')}}",
                    {_token: '{{csrf_token()}}'},
                    function (data, status) {
                        if (data.status != 1) {
                            layer.msg('操作失败');
                        } else {
                            layer.msg('操作成功');
                            var txt = $('#mobile').text();
                            $('#mobile').text($(element).attr('mobile'));
                            $(element).attr('mobile', txt);
                        }
                    });
            });
        })
    </script>
@stop



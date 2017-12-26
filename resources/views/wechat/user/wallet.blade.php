@extends('wechat.layout.master')

@section('title','我的钱包')

@section('mui-css')

@stop

@section('content')
    <ul class="clearfix Mywallet">
        <li><a href="{{url('wechat/wallet/balance-log')}}">
                <p class="ellipsis1 Mywalletword1">¥{{$user->balance}}</p>
                <p class="ellipsis1 Mywalletword2">余额</p>
            </a></li>
        <li><a href="{{url('wechat/wallet/pledge-log')}}">
                <p class="ellipsis1 Mywalletword1">¥{{$user->pledge}}</p>
                <p class="ellipsis1 Mywalletword2">保证金</p>
            </a></li>
        <li><a href="{{url('wechat/wallet/hotboom-balance-log')}}">
                <p class="ellipsis1 Mywalletword1">¥{{$user->daigou_balance+$payDemandPrice}}</p>
                <p class="ellipsis1 Mywalletword2">代购收益</p>
            </a></li>
        <li>
            <a href="{{url('wechat/wallet/spare-log')}}">
                <p class="ellipsis1 Mywalletword1">¥{{$user->total_spare_price}}</p>
                <p class="ellipsis1 Mywalletword2">累计红利</p>
            </a>
        </li>
    </ul>
    <ul class="aboutUs">
        <li class="jiantou"><a href="{{url('wechat/wallet/withdraw?type=other')}}">余额提现</a></li>
        <li class="jiantou"><a href="{{url('wechat/wallet/withdraw?type=hotboom')}}">代购收益提现</a></li>
        <li class="jiantou"><a href="{{url('wechat/wallet/withdraw?type=pledge')}}">保证金提现</a></li>
        <li class="jiantou"><a href="{{url('wechat/user/pledge-recharge')}}">保证金充值</a></li>
        <li class="jiantou"><a href="{{url('wechat/user/coupon')}}">我的红券</a></li>
        <li class="jiantou"><a href="{{url('wechat/wallet/alipay-account')}}">我的支付宝</a></li>
        <li class="jiantou"><a href="{{url('wechat/wallet/bank-list')}}">我的银行卡</a></li>
    </ul>
@stop
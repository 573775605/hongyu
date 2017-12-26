<!--导航-->
<div class="h100"></div>
<div class="nav">
    <a href="{{url('wechat')}}" class="home {{$active=='home'?'active':''}}">
        <span></span>
        <em>首页</em>
    </a>
    <a href="{{url('wechat/demand/filter')}}" class="redcity {{$active=='filter'?'active':''}}">
        <span></span>
        <em>红市</em>
    </a>
    <a href="{{url('wechat/address')}}?type=issue-demand">
        <em class="fabu"></em>
    </a>
    <a href="{{url('wechat/message/index')}}" class="news {{$active=='message'?'active':''}}">
        <span></span>
        <em>消息</em>
    </a>
    <a href="{{url('wechat/center')}}" class="mine {{$active=='center'?'active':''}}">
        <span></span>
        <em>我的</em>
    </a>
</div>
@extends('wechat.layout.master')

@section('title','个人资料')

@section('content')
    <div id="ziliao">
        <ul class="aboutUs personalData">
            <li style="width: 100%;">
                <div class="clearfix">
                    <div class="fl">头像</div>
                    <div class="fr ">
                        <div class="toux">
                            <img src="{{$user->img_url}}"/>
                        </div>
                    </div>
                </div>
            </li>
            <li style="width: 100%;">
                <div class="clearfix">
                    <div class="fl">昵称</div>
                    <div class="fr touxName">
                        <div class="ellipsis1 ">
                            {{$user->nickname}}
                        </div>
                    </div>
                </div>
            </li>
            <form action="" method="post" id="form">
                {!! csrf_field() !!}
                <li style="width: 100%;">
                    <div class="clearfix">
                        <div class="fl">我的红利资源</div>
                        <div class="fr touxtext">
                            <input type="text" name="description" value="{{$user->userInfo->description or ''}}" placeholder="请填写您在哪些领域有红利资源.."/>
                        </div>
                    </div>
                </li>
            </form>
            <li style="width: 100%;">
                <a href="javascript:{{$user->is_auth?'void(0)':'submitInfo()'}}">
                    <div class="clearfix">
                        <div class="fl">身份证认证</div>
                        <div class="fr">
                            @if($user->is_auth)
                                <div class="wsagrenn">已认证</div>
                            @else
                                <div class="wsgrey">未认证</div>
                            @endif
                        </div>
                    </div>
                </a>
            </li>
        </ul>
            <p style="font-size: 10px;color:#F8525A; padding: 0 3% ">*完成身份证实名认证，能进一步提高信誉并享有报价特权</p>
            <a class="Lbtnred" href="javascript:$('#form').submit()">
                保存
            </a>

    </div>
@stop

@section('js')
    <script src="{{asset('asset/ext/layer/layer.min.js')}}"></script>
    <script>
        function submitInfo() {
            $.post("{{url('wechat/user/perfect-info')}}",
                {_token: '{{csrf_token()}}'},
                function (data, status) {
                    if (data.status != 1) {
                        layer.msg(data.message);
                    } else {
                        location.href = '{{url('wechat/user/perfect-info')}}';
                    }
                });
        }
    </script>
@stop
@extends('wechat.layout.master')

@section('title','绑定手机号')

@section('content')

    <form action="" method="post" id="form">
        {!! csrf_field() !!}
        <dl class="offerstwo clearfix">
            <dt class="mt5"><em>*</em>手机号：</dt>
            <dd>
                <div class="clearfix">
                    <div class="fl yzmNum">
                        <div class="border ">
                            <input type="text" placeholder="输入您的手机号码" name="mobile"/>
                        </div>
                    </div>
                    <div class="fr yzm">
                        <input id="btnSendCode" type="button" value="发送验证码" onclick="sendMessage()"/></p>
                    </div>
                </div>
            </dd>
        </dl>

        <dl class="offerstwo clearfix">
            <dt class="mt5"><em>*</em>验证码：</dt>
            <dd>
                <div class="border ">
                    <input type="hidden" name="verify_id">
                    <input type="text" name="verify_code" placeholder="输入验证码"/>
                </div>
            </dd>
        </dl>
    </form>
    {{--<div id="fabuTips" class="fabuTips">--}}
    {{--进入个人资料页完成身份证实名认证，能提高信誉并享有报价特权--}}
    {{--</div>--}}
    <p class="entertips">*如想提高信誉并享有报价特权，您可进入个人资料页完成身份证实名认证</p>

    <a class="redbtn90">
        <input type="button" value="提交" onclick="submitSave()"/>
    </a>

    <div class="readchebox">
        <input type="checkbox" checked="checked">
        <a class="" href="{{url('wechat/about/explain-article/bind_mobile_protocol')}}">
            已阅读并同意以下协议，接受免除或限制责任等条文规则
        </a>
    </div>
@stop

@section('js')
    <script src="{{asset('asset/ext/layer/layer.min.js')}}"></script>
    <script type="text/javascript">
        var InterValObj; //timer变量，控制时间
        var count = 60; //间隔函数，1秒执行
        var curCount;//当前剩余秒数
        function sendMessage() {
            var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
            var mobile = $("input[name=mobile]").val();
            if (!myreg.test(mobile)) {
                layer.msg('请输入有效的手机号码');
                return false;
            }
            curCount = count;
            //设置button效果，开始计时
            $("#btnSendCode").attr("disabled", "true");
            $("#btnSendCode").val(curCount + "秒");
            InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
            $.post("{{url('wechat/user/send-verifycode')}}",
                {_token: '{{csrf_token()}}', mobile: mobile},
                function (data, status) {
                    if (data.status != 1) {
                        layer.msg(data.message);
                    } else {
                        $('input[name=verify_id]').val(data.data.id);
                    }
                });
        }
        //timer处理函数
        function SetRemainTime() {
            if (curCount == 0) {
                window.clearInterval(InterValObj);//停止计时器
                $("#btnSendCode").removeAttr("disabled");//启用按钮
                $("#btnSendCode").val("重发验证码");
            }
            else {
                curCount--;
                $("#btnSendCode").val(curCount + "秒");
            }
        }

        function submitSave() {
            if ($('input[name=verify_code]').val() == '') {
                layer.msg('请输入验证码');
                return false;
            }
            if ($('input[type=checkbox]:checked').length <= 0) {
                layer.msg('必须同意勾选以下协议');
                return false;
            }
            $.post("{{url('wechat/user/bind-mobile')}}",
                $('#form').serialize(),
                function (data, status) {
                    if (data.status != 1) {
                        layer.msg(data.message);
                    } else {
                        location.href = '{{url('wechat/tender/index?demand_id='.request('demand_id'))}}';
                    }
                });
        }
    </script>
@stop
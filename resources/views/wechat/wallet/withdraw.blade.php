@extends('wechat.layout.master')

@section('title','余额提现')

@section('content')
    <dl class="dlinput clearfix">
        <dt class="fl">提现到：</dt>
        <dd class="fl">
            <div class="dlinputtext  jiantoub">
                <select name="" class="selects" onchange="selectFund(this)">
                    @if($alipay)
                        <option value="alipay">支付宝</option>
                    @endif
                    @foreach($bank as $v)
                        <option value="{{$v->id}}">{{$v->bank_name.'(尾号'.substr($v->account,-4).')'}}</option>
                    @endforeach
                </select>
            </div>
        </dd>
    </dl>
    <form action="" method="post" onsubmit="return submitCheck()" id="form">
        {!! csrf_field() !!}
        <input type="hidden" name="type" value="{{request('type')}}">
        <div id="withdraw-fund">
            @if($alipay || !$bank->count())
                <dl class="dlword clearfix">
                    <dt class="fl"> 支付宝账号：</dt>
                    <input type="hidden" name="fund_id" value="{{$alipay->id or ''}}">
                    <dd class="fl">
                        {{--<span class="dlbuleword">--}}
                        {{$alipay->account or ''}}
                        @if(!$alipay)
                            {{--<a class="redbtn90" href="{{url('wechat/wallet/alipay-account?type='.request('type'))}}"><input type="button" value="添加支付宝"/></a>--}}
                            <a class="addpay" href="{{url('wechat/wallet/alipay-account?type='.request('type'))}}"><input type="button" value="添加支付宝"/></a>

                        @endif
                        {{--</span>--}}
                    </dd>
                </dl>
            @else
                <dl class="dlword clearfix">
                    <dt class="fl"> 银行卡号：</dt>
                    <input type="hidden" name="fund_id" value="{{$bank->first()->id or ''}}">
                    <dd class="fl">
                    <span class="dlbuleword">
                        {{$bank->first()->account or ''}}
                    </span>
                    </dd>
                </dl>
            @endif
        </div>
        <dl class="dlinput clearfix">
            <dt class="fl"> 提现金额：</dt>
            <dd class="fl">
                <div class="dlinputtext">
                    <input type="number" placeholder="请输入金额" name="price"/>
                </div>
                <div class="clearfix mt10">
                    @if(request('type')=='pledge')
                        <div class="fl"><span class="dl9wrod">可提现金额:</span>
                            <em class="dlredwrod">¥{{$user->getPledge()}}</em>
                        </div>
                    @else
                        <div class="fl"><span class="dl9wrod">可提现余额:</span>
                            <em class="dlredwrod">¥{{request('type')=='hotboom'?$user->getDaigouBalance():$user->getBalance()}}</em>
                        </div>
                        @if(request('type')=='hotboom')
                            <div class="fr dlquestionicoin"><span class="dld6wrod">平台服务费: {{$scale}}%</span></div>
                        @endif
                    @endif
                </div>
            </dd>
        </dl>
    </form>
    <a class="redbtn90">
        <input type="button" value="提交" onclick="submitWithdraw()"/>
    </a>
    <div style="display: none">
        @if($alipay)
            <div id="alipay-account">
                <dl class="dlword clearfix">
                    <dt class="fl"> 支付宝账号：</dt>
                    <input type="hidden" name="fund_id" value="{{$alipay->id or ''}}">
                    <dd class="fl">
                    <span class="dlbuleword">
                        {{$alipay->account or ''}}
                    </span>
                    </dd>
                </dl>
            </div>
        @endif
        @foreach($bank as $v)
            <div id="bank-account{{$v->id}}">
                <dl class="dlword clearfix">
                    <dt class="fl"> 银行卡号：</dt>
                    <input type="hidden" name="fund_id" value="{{$v->id}}">
                    <dd class="fl">
                    <span class="dlbuleword">
                        {{$v->account}}
                    </span>
                    </dd>
                </dl>
            </div>
        @endforeach
    </div>
@stop

@section('js')
    <script src="{{asset('asset/ext/layer/layer.min.js')}}"></script>
    <script>
        function selectFund(event) {
            var val = $(event).val();
            if (val == 'alipay') {
                $('#withdraw-fund').html($('#alipay-account').html())
            } else {
                $('#withdraw-fund').html($('#bank-account' + val).html());
            }
        }

        var layerConfirm = false;
        function submitCheck() {
                    @if(request('type')=='pledge')
            var balance ={{$user->getPledge()}};
                    @else
            var balance ={{request('type')=='hotboom'?$user->getDaigouBalance():$user->getBalance()}};
                    @endif
            var price = $('input[name=price]').val();
            price = parseFloat(price);
            if ($('input[name=fund_id]').val() == '') {
                layer.msg('请选择提现账户')
                return false;
            }
            if (isNaN(price)) {
                layer.msg('请输入有效提现金额');
                return false;
            }
            if (price < 10) {
                layer.msg('提现金额最少为10元');
                return false;
            }
            if (price > balance) {
                layer.msg('账户余额不足');
                return false;
            }
                    @if(request('type')=='hotboom')
            var scale ={{$scale/100}};
            if (layerConfirm) {
                return true;
            }
            var servicePrice = price * scale;
            var actualPrice = price - servicePrice.toFixed(2);
            layer.confirm('提现金额' + price + ',其中平台服务费' + servicePrice.toFixed(2) + '，实际提现' + actualPrice.toFixed(2), {
                title: '平台服务费',
                btn: ['确认', '取消'], //按钮
//                shade: false //不显示遮罩
            }, function () {
                layerConfirm = true;
//                $('#form').submit();
                submitWithdraw();
            }, function () {

            });
            return false;
            @else
                return true;
            @endif
        }

        function submitWithdraw() {
            if (!submitCheck()) {
                return false;
            }

            $.post("{{url('wechat/wallet/withdraw')}}",
                $('#form').serialize(),
                function (data, status) {
                    if (data.status != 1) {
                        layer.msg(data.message);
                    } else {
                        layer.msg('您的提现申请已提交，等待管理员审核');
                        setTimeout(function () {
                            location.reload()
                        }, 4000)
                    }
                });
        }
    </script>
@stop
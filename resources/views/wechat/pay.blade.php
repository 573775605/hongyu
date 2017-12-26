<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>微信支付</title>
</head>
<body>

</body>
</html>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js" type="text/javascript" charset="utf-8"></script>
<script>
    wx.config({!! $js->config(['chooseWXPay'], false) !!});

    wx.ready(function () {
        wx.chooseWXPay({
            timestamp: '{{ $config['timestamp'] }}',
            nonceStr: '{{ $config['nonceStr'] }}',
            package: '{{ $config['package'] }}',
            signType: '{{ $config['signType'] }}',
            paySign: '{{ $config['paySign'] }}', // 支付签名
            success: function (res) {
                location.href = '{{url('wechat')}}';
            }
        });
    });
</script>
@extends('wechat.layout.master')

@section('title','添加收货地址')

@section('css')
    <link href="{{asset('asset/wechat/css/city/mui.picker.css')}}" rel="stylesheet"/>
    <link href="{{asset('asset/wechat/css/city/mui.poppicker.css')}}" rel="stylesheet"/>
@stop

@section('body','bgf6')

@section('content')
    <form action="" method="post" id="form">
        {!! csrf_field() !!}
        <dl class="dlinput clearfix">
            <dt class="fl"> 收货人：</dt>
            <dd class="fl">
                <div class="dlinputtext">
                    <input type="text" placeholder="请输入收货人" name="name" value="{{$row->name or ''}}"/>
                </div>
            </dd>
        </dl>

        <dl class="dlinput clearfix">
            <dt class="fl">联系电话：</dt>
            <dd class="fl">
                <div class="dlinputtext">
                    <input type="text" placeholder="请输入联系电话" name="phone" value="{{$row->phone or ''}}"/>
                </div>
            </dd>
        </dl>

        {{--<dl class="dlinput clearfix">--}}
        {{--<dt class="fl">邮政编码：</dt>--}}
        {{--<dd class="fl">--}}
        {{--<div class="dlinputtext">--}}
        {{--<input type="text" placeholder="请输入邮政编码" name="postcode" value="{{$row->postcode or ''}}"/>--}}
        {{--</div>--}}
        {{--</dd>--}}
        {{--</dl>--}}

        {{--<dl class="offers clearfix">--}}
        <dl class="dlinput clearfix">

            <dt class="mt5">所在地区：</dt>
            <dd>
                <div class="border">
                    <div id="select-location">
                        <span id="location-show">{{$row->location or '请选择省市区'}}</span>
                        <input type="hidden" name="location" id="location" value="{{$row->location or ''}}">
                    </div>
                </div>
            </dd>
        </dl>

        <dl class="dlinput clearfix">
            <dt class="fl">详细地址：</dt>
            <dd class="fl">
                <div class="dlinputtext">
                    <input type="text" placeholder="请输入详细地址" name="address" value="{{$row->address or ''}}"/>
                </div>
            </dd>
        </dl>
    </form>
    <a class="redbtn90">
        <input type="button" value="确认" onclick="saveAddress()"/>
    </a>

    <p style="padding: 3%">
        <input type="checkbox" checked>
        <a href="{{url('wechat/about/explain-article/add_address_protocol')}}" style="color: #999">已阅读并同意以下协议，接受免除或限制负责等条文规则</a>
    </p>
@stop

@section('js')
    <script src="{{asset('asset/ext/layer/layer.min.js')}}"></script>
    <script src="{{asset('asset/wechat/js/city/data.city.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('asset/wechat/js/city/mui.picker.min.js')}}" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        function saveAddress() {
            var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
            if ($('input[name=name]').val() == '') {
                layer.msg('请输入收货人姓名');
                return false;
            }
            if (!myreg.test($("input[name=phone]").val())) {
                layer.msg('请输入有效的手机号码');
                return false;
            }
            if ($('input[name=location]').val() == '') {
                layer.msg('请选择省、市、区');
                return false;
            }
            if ($('input[name=address]').val() == '') {
                layer.msg('请输入详细地址');
                return false;
            }
            if ($('input[type=checkbox]:checked').length <= 0) {
                layer.msg('必须勾选以下规定');
                return false;
            }
            $('#form').submit();
        }
        $(".addAdressList li:last-child").css("border-bottom", "none");

        //选择省市区
        var city_picker = new mui.PopPicker({layer: 3});
        city_picker.setData(init_city_picker);
        $("#select-location").on("tap", function () {
            setTimeout(function () {
                city_picker.show(function (items) {
                    $("#location-show").html((items[0] || {}).text + " " + (items[1] || {}).text + " " + (items[2] || {}).text);
                    $("#location").val((items[0] || {}).text + " " + (items[1] || {}).text + " " + (items[2] || {}).text);
                });
            }, 200);
        });

    </script>
@stop

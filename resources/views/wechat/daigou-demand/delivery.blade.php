@extends('wechat.layout.master')

@section('title','填写发货信息')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/photo.css')}}"/>
@stop

@section('content')
    <p class="fabuing">收件人</p>
    <a class=" XQ2adress ">
        <div class="clearfix XQ2adressword1">
            <div class="fl">收货人：{{$demand->consignee}}</div>
            <div class="fr">{{$demand->phone}}</div>
        </div>
        <div class="XQ2adressword2 ellipsis2">
            收货地址：{{$demand->address}}
        </div>
    </a>

    <form action="" method="post" onsubmit="return checkSubmit()">
        {!! csrf_field() !!}
        <dl class="offers clearfix">
            <dt class="mt5">快递公司：</dt>
            <dd>
                <div class="border jiantoub">
                    <select name="express_company_number" class="selects selectstext">
                        @foreach($express as $k=>$v)
                            <option value="{{$k}}">{{$v}}</option>
                        @endforeach
                    </select>
                </div>
            </dd>
        </dl>

        <dl class="offers clearfix">
            <dt class="mt5">物流单号：</dt>
            <dd>
                <div class="border ">
                    <input type="text" placeholder="输入物流单号" name="express_number"/>
                </div>
            </dd>
        </dl>

        <dl class="offers clearfix">
            <dt class="mt5">购买凭证：</dt>
            <dd>
                <ul class="cUl mt10 clearfix">
                    <li class="">
                        <input class="NO " type="file" name="file" id="file">
                        <div class="cadd"></div>
                    </li>
                </ul>
                {{--<div class=" cborder">--}}
                {{--<input class="NO " type="file" name="file" id="file">--}}
                {{--<div class="cadd">--}}
                {{--<img src="{{asset('asset/wechat/img/sc.png')}}"/>--}}
                {{--</div>--}}
                {{--</div>--}}
                <p class="cbordertop">*如代购订单截图，结账小票，发票等</p>
            </dd>
        </dl>

        <a class="redbtn90">
            <input type="submit" value="确认发货"/>
        </a>
    </form>
@stop

@section('js')
    <script src="{{asset('asset/ext/layer/layer.min.js')}}"></script>
    {{--上传插件--}}
    <script src="{{ asset("asset/ext/jquery-file-upload/vendor/jquery.ui.widget.js") }}"></script>
    <script src="{{ asset("asset/ext/jquery-file-upload/jquery.iframe-transport.js") }}"></script>
    <script src="{{ asset("asset/ext/jquery-file-upload/jquery.fileupload.js") }}"></script>
    <script>
        function checkSubmit() {
            if ($('input[name=express_number]').val() == '') {
                layer.msg('请填写物流单号');
                return false;
            }
            return true;
        }

        function creatImg(imgRUL, id) {
            var cul = $(".cUl");
            var textHtml = '<li class="goods-imgs"><img src="' + imgRUL + '"/><em class="cdel"></em>';
            textHtml += '<input type="hidden" name="imgs[]" value="' + id + '">';
            $(cul).prepend(textHtml);
        }

        $(".cadd").click(function () {
            $(this).siblings('input[type=file]').trigger("click");
        });

        $(".cUl").delegate(".cdel", "click", function () {
            $(this).parents("li").remove();
        })

        $('#file').fileupload({
            url: '{{url('wechat/upload')}}',
            formData: {_token: '{{csrf_token()}}'},
            //dataType: 'json',
            done: function (e, data) {
                creatImg(data.result.data.url, data.result.data.id);
//                console.log(data.result);
            }
        });
    </script>
@stop
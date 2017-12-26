@extends('wechat.layout.master')

@section('title','修改需求商品')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/photo.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/AddSubtract.css')}}"/>
@stop
@section('body','bgf6')
@section('content')
    @foreach($goodsList as $v)
        @if($v->id!=$goods->id)
            <a class="Uneedcont bgfff disb jiantou p3" href="{{url('wechat/demand/edit/'.$v->id)}}">
                <div class="clearfix" style="padding: 3% 0;">
                    <div class="Uneedcontimg " style="top:10px; left: 3%;">
                        <img src="{{$v->img->url or ''}}"/>
                    </div>
                    <div class="fl Uneedcontwords" style="width:70%; ">
                        <p class="Uneedcontwords1 ellipsis1 mt10">{{$v->name}}</p>
                        <p class="Uneedcontwords2 mt10">
                            <em class="Uneedred1">¥{{$v->known_unit_price}}</em> / *{{$v->count}}{{$v->unit}}
                            <span>合计
                <em class="Uneedred1">¥{{$v->price}}</em>
                </span>
                        </p>
                    </div>
                </div>
            </a>
        @endif
    @endforeach
    <form action="" method="post" id="form" onsubmit="return checkData()">
        {!! csrf_field() !!}
        <input type="hidden" name="submit_type">
        <ul class="cUl mt10  clearfix">
            @foreach($imgs as $k=>$v)
                <li class="goods-imgs">
                    <img src="{{$v['url']}}"><em class="cdel"></em>
                    <input type="hidden" name="imgs[{{$k}}][id]" value="{{$v['id']}}">
                    <input type="hidden" name="imgs[{{$k}}][url]" value="{{$v['url']}}">
                </li>
            @endforeach
            <li class="" id="add-img">
                <input class="NO " type="file" name="file" id="file">
                <div class="cadd"></div>
            </li>
        </ul>

        <dl class="offers clearfix">
            <dt class="mt8"><em>*</em>商品货源：</dt>
            <dd>
                <input type="hidden" name="source" value="{{$goods->source}}">
                <input type="hidden" name="source_id" value="{{$goods->source_id}}">
                <div class="clearfix">
                    <div class="fl Sname">
                        <div class="border">
                            <input class="inputs" type="text" value="{{$goods->source}}" disabled>
                        </div>
                    </div>
                    <a class="fr btnsquergrey" id="select-source">
                        <input type="button" value="重新选择"/>
                    </a>
                </div>
            </dd>
        </dl>

        <dl class="offers clearfix">
            <dt class="mt12">商品名称：</dt>
            <dd>
                <div class="border Daddress">
                    <input class="inputs" type="text" placeholder="请输入商品名称" name="name" value="{{$goods->name}}">
                </div>
            </dd>
        </dl>

        {{--<dl class="offers clearfix">--}}
            {{--<dt class="mt12">商品规格：</dt>--}}
            {{--<dd>--}}
                {{--<div class="border Daddress">--}}
                    {{--<input class="inputs" type="text" placeholder="请输入商品规格名称" name="sku_name" value="{{$goods->sku_name}}">--}}
                {{--</div>--}}
            {{--</dd>--}}
        {{--</dl>--}}

        <dl class="offers clearfix">
            <dt class="mt12">已知售价：</dt>
            <dd>
                <div class="border Daddress">
                    <input class="inputs" type="number" placeholder="请输入商品价格" name="known_unit_price" value="{{$goods->known_unit_price}}">
                </div>
            </dd>
        </dl>

        {{--<dl class="offers clearfix">--}}
        {{--<dt class="mt12">商品单位：</dt>--}}
        {{--<dd>--}}
        {{--<div class="border jiantoub">--}}
        {{--<select name="goods_unit" class="selects selectstext">--}}
        {{--@foreach($unit as $v)--}}
        {{--<option value="{{$v->name}}" {{$goods->unit==$v->name?'selected':''}}>{{$v->name}}</option>--}}
        {{--@endforeach--}}
        {{--</select>--}}
        {{--</div>--}}
        {{--</dd>--}}
        {{--</dl>--}}

        <dl class="offers clearfix">
            <dt class="mt5"><em>*</em>购买数量：</dt>
            <dd>
                <div class="NBnumall clearfix ">
                    <span class="reduce"></span>
                    <input class="NBnumtext quantity" type="number " name="count" value="{{$goods->count}}">
                    <span class="plus"></span>
                </div>
            </dd>
        </dl>

        <dl class="offers clearfix">
            <dt class="mt8"><em>*</em>商品分类：</dt>
            <dd>
                <input type="hidden" name="category_id" value="{{$goods->category_id}}">
                <div class="clearfix">
                    <div class="fl Sname">
                        <div class="border">
                            <input class="inputs" type="text" value="{{$goods->goodsCategory->name or ''}}" disabled>
                        </div>
                    </div>
                    <a class="fr btnsquergrey" id="select-category">
                        <input type="button" value="重新选择"/>
                    </a>
                </div>
            </dd>
        </dl>

        <dl class="offers clearfix">
            <dt class="mt15"><em>*</em>备注信息：</dt>
            <dd>
                <div class="border Daddress">
                    <input class="inputs" type="text" placeholder="颜色、尺寸、规格、发票要求等" name="remark" value="{{$goods->remark}}">
                </div>
            </dd>
        </dl>

        <dl class="offers clearfix">
            <dt class="mt12">指定商家：</dt>
            <dd>
                <div class="clearfix">
                    <div class="fl Sname">
                        <div class="border">
                            <input class="inputs" type="text" placeholder="输入商家名字" name="store_name" value="{{$goods->store_name}}">
                        </div>
                    </div>
                    <div class="fr sding" id="select-location">
                        <input type="button" value="" title="商家定位"/>
                        <input type="hidden" name="store_lng" value="{{$goods->store_lng}}">
                        <input type="hidden" name="store_lat" value="{{$goods->store_lat}}">
                    </div>
                </div>
            </dd>
        </dl>
        {{--<ul class="libtn clearfix">--}}
        {{--<li class="libtnyellow save-demand" status="0"><a href="javascript:void(0)"><input type="button" value="确认保存"/></a></li>--}}
        {{--</ul>--}}
        <div style="height: 35px;"></div>
        <div class="btnLyellow" status="0" style="position: fixed;width: 100%;left: 0;bottom: 0;"><a href="javascript:void(0)"><input type="submit" value="确认保存"/></a></div>
    </form>
@stop

@section('js')
    <script src="{{asset('asset/wechat/js/selectcolor.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('asset/ext/layer/layer.min.js')}}"></script>
    {{--上传插件--}}
    <script src="{{ asset("asset/ext/jquery-file-upload/vendor/jquery.ui.widget.js") }}"></script>
    <script src="{{ asset("asset/ext/jquery-file-upload/jquery.iframe-transport.js") }}"></script>
    <script src="{{ asset("asset/ext/jquery-file-upload/jquery.fileupload.js") }}"></script>
    <script>
        var u = navigator.userAgent;
        var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
        var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
        if (isiOS) {
            $('#file').prop('multiple', 'multiple');
        }

        function creatImg(imgRUL, id) {
            var cul = $(".cUl");
            var textHtml = '<li class="goods-imgs"><img src="' + imgRUL + '"/><em class="cdel"></em>';
            textHtml += '<input type="hidden" name="imgs[' + id + '][id]" value="' + id + '">';
            textHtml += '<input type="hidden" name="imgs[' + id + '][url]" value="' + imgRUL + '"></li>';
            $('#add-img').before(textHtml);
        }

        function checkData() {
            if ($('.goods-imgs').length < 1) {
                layer.msg('请上传商品图片');
                return false;
            }
            if ($('input[name=goods_name]').val() == '') {
                layer.msg('请填写商品名称');
                return false;
            }
            if ($('input[name=price]').val() == '') {
                layer.msg('请填写商品价格');
                return false;
            }
            return true;
        }

        $('#file').fileupload({
            url: '{{url('wechat/upload')}}',
            formData: {_token: '{{csrf_token()}}'},
            //dataType: 'json',
            done: function (e, data) {
                creatImg(data.result.data.url, data.result.data.id);
//                console.log(data.result);
            }
        });
        $(function () {
            //选择商家位置
            $('#select-location').click(function () {
                $('input[name=submit_type]').val('select-site');
                $('#form').submit();
            });
            //选择货源
            $('#select-source').click(function () {
                $('input[name=submit_type]').val('select-source');
                $('#form').submit();
            });
            //选择分类
            $('#select-category').click(function () {
                $('input[name=submit_type]').val('select-category');
                $('#form').submit();
            });
            //保存需求
            $('.save-demand').click(function () {
                if (!checkData()) {
                    return false;
                }
                $('#form').submit();
            });

            $("#gofabu").click(function () {
                $(".fubutanall,.bg").show();
            })
            $(".tanclose,.bg").click(function () {
                $(".fubutanall,.bg").hide();
            })

            //上传图片
            $(".cadd").click(function () {
                $("#file").trigger("click");
            });
            //删除图片
            $(".cUl").delegate(".cdel", "click", function () {
                $(this).parents("li").remove();
            })
            //购物加减
            $('.plus').click(function () {//加
                add(this);
            })
            $('.reduce').click(function () {//减
                reduce(this);
            })
        })
        /***********************数量加减*************************/

        function add(obj) {//加法
            var divObj = $(obj).parent('.NBnumall');
            changeCount(divObj, 1);
        }

        function reduce(obj) {//减法
            var divObj = $(obj).parent('.NBnumall');
            changeCount(divObj, -1);
        }
        function changeCount(obj, count) { //改变数量
            var nowCount = $(obj).find('.quantity').val();
            nowCount = parseInt(nowCount);
            if (nowCount + count > 0) {
                $(obj).find('.quantity').val(nowCount + count);
            } else {
                $(obj).find('.quantity').val(1);
            }
        }
    </script>
@stop
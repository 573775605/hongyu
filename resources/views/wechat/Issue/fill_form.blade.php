@extends('wechat.layout.master')

@section('title','填写商品信息')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/photo.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/AddSubtract.css')}}"/>
@stop
@section('body','bgf6')
@section('content')
    @foreach($rows as $v)
        <a class="Uneedcont bgfff disb jiantou p3">
            <div class="clearfix" style="padding: 3% 0;">
                <div class="Uneedcontimg " style="top:10px; left: 3%;">
                    <img src="{{$v->firstImg}}"/>
                </div>
                <div class="fl Uneedcontwords" style="width:70%; ">
                    <p class="Uneedcontwords1 ellipsis1 mt10">{{$v->goods_name}}</p>
                    <p class="Uneedcontwords2 mt10">
                        <em class="Uneedred1">¥{{$v->price}}</em> / *{{$v->count}}{{$v->goods_unit}}
                        <span>合计
                <em class="Uneedred1">¥{{number_format(round($v->price*$v->count,2),2)}}</em>
                </span>
                    </p>
                </div>
            </div>
        </a>
    @endforeach
    <form action="" method="post" id="form" onsubmit="return checkForm()">
        {!! csrf_field() !!}
        <input type="hidden" name="type" value="{{$row['type'] or 'upload'}}">
        <input type="hidden" name="link" value="{{$row['link'] or ''}}">
        <input type="hidden" name="domain" value="{{$row['domain'] or ''}}">
        <input type="hidden" name="select_type" value="issue_store">
        <ul class="cUl mt10  clearfix">
            @if(isset($row['imgs'])&&is_array($row['imgs']))
                @foreach($row['imgs'] as $k=>$v)
                    <li class="goods-imgs">
                        <img src="{{$v['url']}}"><em class="cdel"></em>
                        <input type="hidden" name="imgs[{{$k}}][id]" value="{{$v['id']}}">
                        <input type="hidden" name="imgs[{{$k}}][url]" value="{{$v['url']}}">
                    </li>
                @endforeach
            @endif
            <li id="add-img">
                <input class="NO " type="file" name="file" id="file">
                <div class="cadd "></div>
            </li>
        </ul>

        <dl class="offers clearfix">
            <dt class="mt8"><em>*</em>商品货源：</dt>
            <dd>
                <input type="hidden" name="source" value="{{$row['source'] or ''}}">
                <input type="hidden" name="source_id" value="{{$row['source_id'] or ''}}">
                @if(empty($row['source']))
                    <a class="btnsqueryellow2" id="select-source">
                        <input type="button" value="选择"/>
                    </a>
                @else
                    <div class="clearfix">
                        <div class="fl Sname">
                            <div class="border">
                                <input class="inputs" style="color: #333;" type="text" value="{{$row['source'] or ''}}" disabled>
                            </div>
                        </div>
                        <a class="fr btnsquergrey" id="select-source">
                            <input type="button" value="重新选择"/>
                        </a>
                    </div>
                @endif
            </dd>
        </dl>

        <dl class="offers clearfix">
            <dt class="mt12">商品名称：</dt>
            <dd>
                <div class="border Daddress">
                    <input class="inputs" type="text" placeholder="请输入商品名称" name="goods_name" value="{{$row['goods_name'] or ''}}">
                </div>
            </dd>
        </dl>

        {{--<dl class="offers clearfix">--}}
        {{--<dt class="mt12">商品规格：</dt>--}}
        {{--<dd>--}}
        {{--<div class="border Daddress">--}}
        {{--<input class="inputs" type="text" placeholder="请输入商品规格名称" name="sku_name" value="{{$row['sku_name'] or ''}}">--}}
        {{--</div>--}}
        {{--</dd>--}}
        {{--</dl>--}}

        <dl class="offers clearfix">
            <dt class="mt12">已知售价(￥)：</dt>
            <dd>
                <div class="border Daddress">
                    <input class="inputs" type="number" placeholder="请输入商品价格" name="price" value="{{$row['price'] or ''}}">
                </div>
            </dd>
        </dl>

        {{--<dl class="offers clearfix">--}}
        {{--<dt class="mt8">商品单位：</dt>--}}
        {{--<dd>--}}
        {{--<div class="border jiantoub">--}}
        {{--<select name="goods_unit" class="selects selectstext">--}}
        {{--@foreach($unit as $v)--}}
        {{--<option value="{{$v->name}}" {{isset($row['unit'])&&$row['unit']==$v->name?'selected':''}}>{{$v->name}}</option>--}}
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
                    <input class="NBnumtext quantity" type="text " value="{{$row['count'] or 1}}" name="count">
                    <span class="plus"></span>
                </div>
            </dd>
        </dl>

        <dl class="offers clearfix">
            <dt class="mt8"><em>*</em>商品分类：</dt>
            <dd>
                <input type="hidden" name="category_id" value="{{$row['category_id'] or ''}}">
                @if(empty($row['category_name']))
                    <a class="btnsqueryellow2" id="select-category">
                        <input type="button" value="选择"/>
                    </a>
                @else
                    <div class="clearfix">
                        <div class="fl Sname">
                            <div class="border">
                                <input class="inputs" type="text" value="{{$row['category_name'] or ''}}" disabled>
                            </div>
                        </div>
                        <a class="fr btnsquergrey" id="select-category">
                            <input type="button" value="重新选择"/>
                        </a>
                    </div>
                @endif
            </dd>
        </dl>

        <dl class="offers clearfix">
            <dt class="mt15">备注信息：</dt>
            <dd>
                <div class="border Daddress">
                    <input class="inputs" type="text" placeholder="颜色、尺寸、规格、发票要求等" name="remark" value="{{$row['remark'] or ''}}">
                </div>
            </dd>
        </dl>

        <dl class="offers clearfix">
            <dt style="margin-top: 7px;">指定商家：</dt>
            <dd>
                <div class="clearfix">
                    <div class="fl Sname">
                        <div class="border">
                            <input class="inputs" type="text" placeholder="请输入商家名或位置" name="store_name" value="{{$row['store_name'] or ''}}">
                        </div>
                    </div>
                    <div class="fr sding" id="select-location">
                        <input type="button" value="" title="商家定位"/>
                        <input type="hidden" name="store_lng" value="{{$row['store_lng'] or ''}}">
                        <input type="hidden" name="store_lat" value="{{$row['store_lat'] or ''}}">
                    </div>
                </div>
            </dd>
        </dl>
        <p style="color:#F8525A;font-size: 10px; padding-left:53px; padding-top: 5px;">*如果是实体店商品，可以指定商家位置</p>


        <div class="bg"></div>
        <div class="fubutanall">
            <div class="fubutan">
                <div class="tanclose">+</div>

                <dl class="offers clearfix">
                    <dt class="mt5"><em>*</em>订单有效期：</dt>
                    <dd>
                        <div class="NBnumall2 clearfix  ">
                            <span class="reduce2"></span>
                            <input class="NBnumtext2 quantity2" type="text" name="day" value="0">
                            <span class="timedate mr10">天</span>
                            <span class="plus2"></span>
                        </div>
                        <div class="NBnumall clearfix mt15 ">
                            <span class="reduce"></span>
                            <input class="NBnumtext quantity" type="text" name="hour" value="1">
                            <span class="timedate mr10">时</span>
                            <span class="plus"></span>
                        </div>
                        <a class="tansure save-demand" status="1" href="javascript:;"><input type="button" value="确认"/></a>
                    </dd>
                </dl>
            </div>
        </div>
    </form>
    <ul class="libtn2 clearfix">
        {{--<li class="libtngery" id="add-goods"><a href="javascript:void(0)"><input type="button" value="继续添加商品"/></a></li>--}}
        {{--<li class="libtnyellow save-demand" status="0"><a href="javascript:void(0)"><input type="button" value="保存到购物计划"/></a></li>--}}
        <li class="libtngery" id="add-goods"><a href="javascript:void(0)"><input type="button" value="继续添加(同一货源)"/></a></li>
        <li class="libtnyellow save-demand" status="0"><a href="javascript:void(0)"><input type="button" value="保存到待发布"/></a></li>
        <li class="libtnred" id="gofabu"><a href="javascript:void(0)"><input type="button" value="确认发布"/></a></li>
    </ul>

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
            if ($('input[name=source]').val() == '') {
                layer.msg('请选择货源');
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
            if ($('input[name=category_id]').val() == '') {
                layer.msg('请选择分类');
                return false;
            }
            return true;
        }

        $('#file').fileupload({
            url: '{{url('wechat/upload')}}',
            formData: {_token: '{{csrf_token()}}'},
            dataType: 'json',
            done: function (e, data) {
                creatImg(data.result.data.url, data.result.data.id);
            }
        });

        $(function () {
            //选择商家位置
            $('#select-location').click(function () {
                var url = '{{url('wechat/issue/index?action=location')}}'
                $('#form').attr('action', url);
                $('#form').submit();
            });
            //选择货源
            $('#select-source').click(function () {
                var url = '{{url('wechat/issue/index?action=source')}}'
                $('#form').attr('action', url);
                $('#form').submit();
            });
            //选择分类
            $('#select-category').click(function () {
                var url = '{{url('wechat/issue/index?action=category')}}'
                $('#form').attr('action', url);
                $('#form').submit();
            });
            //添加商品
            $('#add-goods').click(function () {
                var url = '{{url('wechat/issue/index?action=add')}}'
                $('#form').attr('action', url);
                if (!checkData()) {
                    return false;
                }
                $('#form').submit();
            });
            //保存需求
            $('.save-demand').click(function () {
                var status = $(this).attr('status');
                var url = '{{url('wechat/issue/index')}}?action=save&is_issue=' + status;
                $('#form').attr('action', url);
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
            //购物加减2 ，value=0
            $('.plus2').click(function () {//加
                add2(this);
            })
            $('.reduce2').click(function () {//减
                reduce2(this);
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

        /***********************数量加减 value=0*************************/

        function add2(obj) {//加法
            var divObj = $(obj).parent('.NBnumall2');
            changeCount2(divObj, 1);
        }

        function reduce2(obj) {//减法
            var divObj = $(obj).parent('.NBnumall2');
            changeCount2(divObj, -1);
        }
        function changeCount2(obj, count) { //改变数量
            var nowCount = $(obj).find('.quantity2').val();
            nowCount = parseInt(nowCount);
            if (nowCount + count > 0) {
                $(obj).find('.quantity2').val(nowCount + count);
            } else {
                $(obj).find('.quantity2').val(0);
            }
        }

    </script>
@stop
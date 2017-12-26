@extends('wechat.layout.master')

@section('title','填写商品链接')

@section('content')
    <form action="{{url('wechat/issue/index')}}" method="post" id="form">
        {!! csrf_field() !!}
        <input type="hidden" name="type" value="link">
        <div class="copyall">
            <div class="copyallinput">
                <input type="text" name="form_link" placeholder="请输入或长按粘贴宝贝地址"/>
            </div>
        </div>
    </form>

    <a class="used" href="{{url('wechat/about/explain-article/link_grab_explain')}}">如何使用一键获取商品信息？</a>

    <a class="redbtn90">
        <input type="button" value="确认" onclick="grab()"/>
    </a>
@stop

@section('js')
    <script src="{{asset('asset/ext/layer/layer.min.js')}}"></script>
    <script>
        function grab() {
            var url = $('input[name=form_link]').val();
            if (url == '') {
                layer.msg('请输入商品详情链接');
                return false;
            }
            $.ajax({
                url: '{{url('wechat/issue/grab')}}',
                type: 'POST', //GET
                async: true,    //或false,是否异步
                data: {
                    _token: '{{csrf_token()}}',
                    form_link: url
                },
                timeout: 5000,    //超时时间
                dataType: 'json',    //返回的数据格式：json/xml/html/script/jsonp/text
                beforeSend: function (xhr) {
                    console.log(xhr)
                    console.log('发送前')
                },
                success: function (data, textStatus, jqXHR) {
                    if (data.status != 1) {
                        if (data.status == -1) {
                            layer.msg(data.message);
                        } else {
                            layer.confirm('该链接暂不能抓取图片，请填写信息后勿关闭页面，直接上传图片发布', {
                                title: '抓取结果提示',
                                btn: ['确认', '取消'], //按钮
                            }, function () {
                                $('#form').append(data.data.html);
                                $('#form').submit();
                            }, function () {

                            });
                        }
                    } else {
                        $('#form').append(data.data.html);
                        $('#form').submit();
                    }
                },
                error: function (xhr, textStatus) {
                    if (xhr.status == 422) {
                        layer.msg(xhr.responseJSON.url[0]);
                    } else {
                        layer.msg('请求错误');
                    }
                    console.log(textStatus)
                },
                complete: function () {
                    console.log('结束')
                }
            })
        }
    </script>
@stop
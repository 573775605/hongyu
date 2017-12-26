@extends('wechat.layout.master')

@section('title','聊天消息')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('asset/ext/dropload/dropload.css')}}">
@stop

@section('body','bgfff')
@section('content')
    <div id="dropload">
        <div style="padding: 3% 5%;" id="message">
            @foreach($message->sortBy('id') as $v)
                @if($user->id==$v->send_user_id)
                    <div class="chatall">
                        <div class="clearfix chartcont">
                            <div class="touxiangimgR">
                                <img src="{{$v->sendUser->img_url or ''}}"/>
                            </div>
                            <div class="fr chartmine">
                                @if(filter_var($v->content,FILTER_VALIDATE_URL))
                                    <a href="{{$v->content}}">{{$v->content}}</a>
                                @else
                                    <input type="text" readonly="readonly" value="{{$v->content}}">
                                @endif

                                @if($v->img)
                                    <img src="{{$v->img->url}}"/>
                                @endif
                            </div>
                        </div>
                        <p class="fr chartMtimeR">{{$v->create_time}}</p>
                    </div>
                @else
                    <div class="chatall">
                        <div class="clearfix chartcont">
                            <div class="touxiangimgL">
                                <img src="{{$v->sendUser->img_url or ''}}"/>
                            </div>
                            <div class="fl chartother">
                                @if(filter_var($v->content,FILTER_VALIDATE_URL))
                                    <a href="{{$v->content}}">{{$v->content}}</a>
                                @else
                                    <input type="text" readonly="readonly" value="{{$v->content}}">
                                @endif
                                @if($v->img)
                                    <img src="{{$v->img->url}}"/>
                                @endif
                            </div>
                        </div>
                        <p class="fl chartMtimeL">{{$v->create_time}}</p>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <div style="height:55px"></div>
    <form action="" id="form" onsubmit="return submitMessage()">
        <input type="hidden" name="accept_user_id" value="{{$acceptUserId}}">
        <input type="hidden" name="img_id">
        <div class="chartinput">
            <div class="chartinputss clearfix">
                <input type="text" placeholder="我来说两句" name="content"/>
                <input type="file" name="file" id="file" style="display: none">
            </div>
            <div class="send"><input type="button" value="发送" onclick="submitMessage()"/></div>
            <div class="chartimg" onclick="$('#file').trigger('click')"></div>
        </div>
    </form>
@stop

@section('js')
    <script src="{{asset('asset/ext/layer/layer.min.js')}}"></script>
    <script src="{{asset('asset/ext/dropload/dropload.min.js')}}"></script>
    {{--上传插件--}}
    <script src="{{ asset("asset/ext/jquery-file-upload/vendor/jquery.ui.widget.js") }}"></script>
    <script src="{{ asset("asset/ext/jquery-file-upload/jquery.iframe-transport.js") }}"></script>
    <script src="{{ asset("asset/ext/jquery-file-upload/jquery.fileupload.js") }}"></script>
    <script>
        function submitMessage() {
            if ($('input[name=content]').val() == '' && $('input[name=img_id]').val() == '') {
                layer.msg('请输入聊天内容');
                return false;
            }
            $.post("{{url('wechat/chat/send')}}",
                $('#form').serialize(),
                function (data, status) {
                    if (data.status != 1) {
                        layer.msg('发送失败');
                    } else {
                        $('#message').append(data.data.html);
                        $('input[name=content]').val('');
                        $('input[name=img_id]').val('');
                        maxId = data.data.result.id;
                    }
                });
            return false
        }

        var maxId = {{$message->first()->id or 0}}
        setInterval(function () {
            $.post("{{url('wechat/chat/pull')}}",
                {max_id: maxId, accept_user_id: '{{$acceptUserId}}'},
                function (data, status) {
                    $('#message').append(data.data.message);
                    maxId = data.data.maxId;
                }
            )
            ;
        }, 5000);

        var page = 2, pageTotal ={{$message->lastPage()}};
        $('#dropload').dropload({
            scrollArea: window,
            autoload: false,
            domUp: {
                domClass: 'dropload-up',
                domRefresh: '<div class="dropload-refresh"><span>下拉刷新</span></div>',
                domUpdate: '<div class="dropload-update"><span>释放更新</span></div>',
                domLoad: '<div class="dropload-load">加载中</div>'
            },
            loadUpFn: function (me) {
                $.post("{{url('wechat/chat/paging')}}",
                    {max_id: maxId, accept_user_id: '{{$acceptUserId}}', page: page},
                    function (data, status) {
                        $('#message').prepend(data.data.message);
                        page++;
                        if (page > pageTotal) {
                            // 锁定
                            me.lock();
                            // 无数据
//                            me.noData();
                        }
                        me.resetload();
                    });
            }
        });

        $('#file').fileupload({
            url: '{{url('wechat/upload')}}',
            formData: {_token: '{{csrf_token()}}'},
            //dataType: 'json',
            done: function (e, data) {
                $('input[name=img_id]').val(data.result.data.id);
                submitMessage();
            }
        });
    </script>
@stop
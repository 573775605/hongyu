@extends('wechat.layout.master')

@section('title','完善资料')

@section('content')
    <form action="" method="post">
        {!! csrf_field() !!}
        <dl class="offers clearfix">
            <dt class="mt5"><em>*</em>姓名：</dt>
            <dd>
                <div class="border ">
                    <input type="text" placeholder="输入您的姓名" name="name" value="{{old('name')}}"/>
                    {!! $errors->first('name','<span class="help-block m-b-none" style="color: red">:message</span>') !!}
                </div>
            </dd>
        </dl>

        <dl class="offers clearfix">
            <dt class="mt5"><em>*</em>身份证：</dt>
            <dd>
                <div class="border ">
                    <input type="text" placeholder="输入您的身份证号码" name="idcard" value="{{old('idcard')}}"/>
                    {!! $errors->first('idcard','<span class="help-block m-b-none" style="color: red">:message</span>') !!}
                </div>
            </dd>
        </dl>

        <dl class="offers clearfix">
            <dt class="mt5"><em>*</em>上传身份证：</dt>
            <dd>
                <div class=" cborder">
                    <input class="NO upload-file" type="file" name="file">
                    <div class="cadd">
                        <input type="hidden" name="idcard_front_img" value="{{old('idcard_front_img')}}">
                        <input type="hidden" name="idcard_front_url" value="{{old('idcard_front_url')}}">
                        <img src="{{old('idcard_front_url')?:asset('asset/wechat/img/sc.png')}}"/>
                    </div>
                    {!! $errors->first('idcard_front_img','<span class="help-block m-b-none" style="color: red">:message</span>') !!}
                </div>
                <p class="cbordertop">身份证正面</p>
            </dd>
        </dl>
        <p style="color: #F8525A;font-size: 10px; padding:5px 10px;">*请上传手持身份证拍摄的上半身图片，并确保身份证上的头像和文字清晰可见。</p>


        <dl class="offers clearfix">
            <dt class="mt5"><em>*</em>上传身份证：</dt>
            <dd>
                <div class=" cborder">
                    <input class="NO upload-file" type="file" name="file">
                    <div class="cadd">
                        <input type="hidden" name="idcard_reverse_img" value="{{old('idcard_reverse_img')}}">
                        <input type="hidden" name="idcard_reverse_url" value="{{old('idcard_reverse_url')}}">
                        <img src="{{old('idcard_reverse_url')?:asset('asset/wechat/img/sc.png')}}"/>
                    </div>
                    {!! $errors->first('idcard_reverse_img','<span class="help-block m-b-none" style="color: red">:message</span>') !!}
                </div>
                <p class="cbordertop">身份证反面</p>
            </dd>
        </dl>
        <p style="color: #F8525A;font-size: 10px; padding:5px 10px;">*请上传手持身份证拍摄的上半身图片，并确保身份证上的头像和文字清晰可见。</p>


        <a class="redbtn90">
            <input type="submit" value="提交">
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
        //上传文件
        $('.upload-file').fileupload({
            url: '{{url('wechat/upload')}}',
            formData: {_token: '{{csrf_token()}}'},
            //dataType: 'json',
            done: function (e, data) {
                var file = e.target;
                $(file).siblings('.cadd').find('img').attr('src', data.result.data.url);
                $(file).siblings('.cadd').find('input').eq(0).val(data.result.data.id);
                $(file).siblings('.cadd').find('input').eq(1).val(data.result.data.url);
            }
        });

        $(".cadd").click(function () {
            $(this).siblings('input[type=file]').trigger("click");
        });
    </script>
@stop
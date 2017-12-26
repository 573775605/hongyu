@extends('admin/layout/master')

@section('title','介绍说明')

@section('css')
    <link href="{{asset('asset/admin/js/plugins/summernote/summernote.css')}}" rel="stylesheet">
@stop

@section('content')
    <div class="row">
        <div class="col-sm-12">
            @include('admin.layout.hint')
            <form class="form-horizontal" id="base_form" method="post">
                {!! csrf_field() !!}
                <div class="ibox float-e-margins">
                    @foreach($explain as $v)
                    <div class="ibox-title">
                        <h5>{{$v->title}}</h5>
                    </div>
                    <div class="ibox-content">
                        <textarea name="{{$v->key}}" class="summernote">{!! $v->value !!}</textarea>
                    </div>
                    @endforeach

                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-5">
                            <button class="btn btn-primary">保存内容</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('js')
    {{--富文本编辑器--}}
    <script src="{{ asset('asset/admin/js/plugins/summernote/summernote.min.js')}}"></script>
    <script src="{{ asset('asset/admin/js/plugins/summernote/summernote-zh-CN.js')}}"></script>
    {{--上传插件--}}
    <script src="{{ asset("asset/admin/js/plugins/jquery_file_upload/vendor/jquery.ui.widget.js") }}"></script>
    <script src="{{ asset("asset/admin/js/plugins/jquery_file_upload/jquery.iframe-transport.js") }}"></script>
    <script src="{{ asset("asset/admin/js/plugins/jquery_file_upload/jquery.fileupload.js") }}"></script>
    <script>
        $(document).ready(function () {
            $('.summernote').summernote({
                lang: 'zh-CN',
                height: '300px',
                callbacks: {
                    onImageUpload: function (files) {
                        var element = this;
                        var formData = new FormData();
                        formData.append('file', files[0]);
                        formData.append('_token', '{{csrf_token()}}');
                        $.ajax({
                            url: '{{url('admin/upload')}}',//后台文件上传接口
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                $(element).summernote('insertImage', data.data.url, 'img');
                            }
                        });
                    }
                }
            });
        });
    </script>
@stop



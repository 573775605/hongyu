@extends('admin.layout.master')

@section('title','文章列表')

@section('css')
    <link href="{{asset('asset/admin/js/plugins/summernote/summernote.css')}}" rel="stylesheet">
@stop

@section('content')
    <div class="wrapper wrapper-content">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-sm-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title" style="height: 50px">
                            <h5>添加文章
                                <small></small>
                            </h5>
                            <div class="ibox-tools">
                                <a href="javascript:history.go(-1)">
                                    <button class="btn btn-w-m btn-primary">返回</button>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <form method="post" class="form-horizontal">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">文章标题</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="title" value="{{old('title',isset($row->data->title)?$row->data->title:'')}}">
                                        {!! $errors->first('title','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">文章分类</label>

                                    <div class="col-sm-10">
                                        <select class="form-control m-b" name="category_id">
                                            @foreach($category as $v)
                                                <option value="{{$v->id}}">{{$v->name}}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('category_id','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">文章图片</label>

                                    <div class="col-sm-10">
                                        <div id="banner-img">
                                            @if(isset($row->data->img))
                                                <img src="{{$row->data->img->url}}" alt="" width="300" height="150">
                                                <input type="hidden" name="img_id" value="{{$row->data->img_id}}">
                                            @endif
                                        </div>
                                        <input type="file" class="file-control" name="file" id="upload-img">
                                        {!! $errors->first('img_id','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">文章描述</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="description" value="{{old('description',isset($row->data->description)?$row->data->description:'')}}">
                                        {!! $errors->first('description','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">文章内容</label>

                                    <div class="col-sm-10">
                                        <textarea name="content" id="summernote" class="summernote">{{old('content',isset($row->data->content)?$row->data->content:'')}}</textarea>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">排序</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="sort" value="{{old('sort',isset($row->data->sort)?$row->data->sort:20)}}">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">是否启用</label>

                                    <div class="col-sm-10">
                                        <label class="radio-inline">
                                            <input type="radio" value="1" name="status">是</label>
                                        <label class="radio-inline">
                                            <input type="radio" value="0" name="status">否</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-5">
                                        <button class="btn btn-primary" type="submit">保存内容</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@stop

@section('js')
    {{--上传插件--}}
    <script src="{{ asset("asset/admin/js/plugins/jquery_file_upload/vendor/jquery.ui.widget.js") }}"></script>
    <script src="{{ asset("asset/admin/js/plugins/jquery_file_upload/jquery.iframe-transport.js") }}"></script>
    <script src="{{ asset("asset/admin/js/plugins/jquery_file_upload/jquery.fileupload.js") }}"></script>
    {{--富文本编辑器--}}
    <script src="{{ asset('asset/admin/js/plugins/summernote/summernote.min.js')}}"></script>
    <script src="{{ asset('asset/admin/js/plugins/summernote/summernote-zh-CN.js')}}"></script>
    <script>
        $(function () {
            $('input[name=status]').val([{{old('status',isset($row->data->status)?$row->data->status:1)}}])
            $('select[name=category_id]').val({{old('category_id',isset($row->data->category_id)?$row->data->category_id:'')}})

            $('#upload-img').fileupload({
                url: '{{url('admin/upload')}}',
                formData: {_token: '{{csrf_token()}}'},
                //dataType: 'json',
                done: function (e, data) {
                    var html = '<img src="' + data.result.data.url + '" alt="" width="300" height="150">';
                    html += '<input type="hidden" name="img_id" value="' + data.result.data.id + '">';
                    $('#banner-img').html(html);
                    console.log(data.result);
                }
            });

            $('#summernote').summernote({
                lang: 'zh-CN',
                height: '300px',
                callbacks: {
                    onImageUpload: function (files) {
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
                                $('#summernote').summernote('insertImage', data.data.url, 'img');
                            }
                        });
                    }
                }
            });
        });
    </script>
@stop

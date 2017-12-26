@extends('admin.layout.master')

@section('title','添加广告图')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title" style="height: 50px">
                        <h5>
                            广告图上传
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
                                <label class="col-sm-2 control-label">广告标题</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title" value="{{old('title',isset($row->data->title)?$row->data->title:'')}}">
                                    {!! $errors->first('title','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">广告位置</label>

                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="space" id="space">
                                        @foreach($space as $k=>$v)
                                            <option value="{{$k}}">{{$v}}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('space','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">链接地址</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="url" value="{{old('url',isset($row->data->url)?$row->data->url:'')}}" placeholder="http://">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">广告图片</label>

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
@stop

@section('js')
    {{--上传插件--}}
    <script src="{{ asset("asset/admin/js/plugins/jquery_file_upload/vendor/jquery.ui.widget.js") }}"></script>
    <script src="{{ asset("asset/admin/js/plugins/jquery_file_upload/jquery.iframe-transport.js") }}"></script>
    <script src="{{ asset("asset/admin/js/plugins/jquery_file_upload/jquery.fileupload.js") }}"></script>
    <script charset="utf-8">
        $(function () {
            $('input[name="status"]').val([{{old('status',isset($row->data->status)?$row->data->status:1)}}]);
            $('#space').val('{{old('space',isset($row->data->space)?$row->data->space:'home-top')}}');

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
        });

    </script>
@stop
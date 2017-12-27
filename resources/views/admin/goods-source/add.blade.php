@extends('admin.layout.master')

@section('title','商品货源')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title" style="height: 50px">
                        <h5>商品货源
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
                                <label class="col-sm-2 control-label">货源名称</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" value="{{old('name',isset($row->data->name)?$row->data->name:'')}}">
                                    {!! $errors->first('name','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">品牌LOGO</label>

                                <div class="col-sm-10">
                                    <div id="banner-img">
                                        @if(isset($row->data->img))
                                            <img src="{{$row->data->img->url}}" alt="" width="200" height="200">
                                            <input type="hidden" name="img_id" value="{{$row->data->img_id}}">
                                        @endif
                                    </div>
                                    <input type="file" class="file-control" name="file" id="upload-img">
                                    {!! $errors->first('img_id','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                {{--<label class="col-sm-2 control-label">货源所在地</label>--}}
                                {{--<div class="col-sm-10">--}}
                                    {{--<select class="form-control m-b" name="parent_id">--}}
                                        {{--@foreach($parent as $v)--}}
                                            {{--<option value="{{$v->id}}">{{$v->name}}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                {{--</div>--}}

                                <label for="type">选择获奖学生</label>
                                <br>
                                <select name="studentnum" id="" class='studentnum' data-url="{{URL('getmedalstujson')}}" data-json-space="data">
                                    <option value="a">请选择</option>
                                </select>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">星级</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="total_grade">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">描述</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="description" value="{{old('description',isset($row->data->description)?$row->data->description:'')}}">
                                    {!! $errors->first('description','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
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
            $('select[name="parent_id"]').val({{old('parent_id',isset($row->data->parent_id)?$row->data->parent_id:0)}});
            $('select[name="total_grade"]').val({{old('total_grade',isset($row->data->total_grade)?$row->data->total_grade:0)}});

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

    {{-- 联动 --}}
    <script charset="utf-8">

        $(function () {
            $('#studentsel').cxSelect({ //要做联动的DIV，这个必须设置！

                selects: ['college_id', 'act_id','studentnum'], //要做联动的select的class
                jsonName: 'name', //传回JSON时要应用的option名字
                jsonValue: 'value', //传回JSON时要应用的option值
                jsonSpace: 'data',//传回JSON时要应用的命名空间，例如传回来"data":['value':0,'name':1]
                required:'true', //是否为必选

            });


        })

    </script>
@stop
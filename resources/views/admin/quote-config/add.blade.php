@extends('admin.layout.master')

@section('title','报价优势管理')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title" style="height: 50px">
                        <h5>报价优势管理
                            <small></small>
                        </h5>
                        <div class="ibox-tools">
                            <a href="javascript:history.back()">
                                <button class="btn btn-w-m btn-info">返回</button>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form method="post" class="form-horizontal">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label class="col-sm-2 control-label">优势名称</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" value="{{old('name',isset($row->data->name)?$row->data->name:'')}}">
                                    {!! $errors->first('name','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">标签</label>
                                <div class="col-sm-10">
                                    <button class="btn btn-w-m btn-primary" type="button" onclick="addLabel()">+ 新增</button>
                                </div>
                                <div id="label">
                                    @if(isset($row))
                                        @foreach($row->data->label as $v)
                                            <div style="margin-top: 15px">
                                                <div class="col-sm-3 col-sm-offset-2">
                                                    <input type="text" class="form-control" name="label[]" placeholder="请输入标签名称" value="{{$v}}">
                                                </div>
                                                <button class="btn btn-w-m btn-danger" type="button" onclick="removeLabel(this)">- 删除</button>
                                            </div>
                                        @endforeach
                                    @endif
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
                                    {!! $errors->first('sort','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
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
    <script charset="utf-8">

        function addLabel() {
            var html = '<div style="margin-top: 15px">';
            html += '<div class="col-sm-3 col-sm-offset-2">';
            html += '<input type="text" class="form-control" required="" name="label[]" placeholder="请输入标签名称">';
            html += '</div><button class="btn btn-w-m btn-danger" type="button" onclick="removeLabel(this)">- 删除</button></div>';
            $('#label').append(html);
        }

        function removeLabel(event) {
            $(event).parent().remove();
        }
        $(function () {
            $('input[name="status"]').val([{{old('status',isset($row->data->status)?$row->data->status:1)}}]);
        });

    </script>
@stop
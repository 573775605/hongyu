@extends('admin.layout.master')

@section('title','商品单位配置')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title" style="height: 50px">
                        <h5>商品单位配置
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
                                <label class="col-sm-2 control-label">单位名称</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" value="{{old('name',isset($row->data->name)?$row->data->name:'')}}">
                                    {!! $errors->first('name','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
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
    <script charset="utf-8">
        $(function () {

            $('input[name="status"]').val([{{old('status',isset($row->data->status)?$row->data->status:1)}}]);

        });

    </script>
@stop
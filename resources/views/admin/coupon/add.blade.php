@extends('admin.layout.master')

@section('title','优惠券信息')

@section('css')
    <link href="{{ asset('asset/admin/js/plugins/layer/skin/layer.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title" style="height: 50px">
                        <h5>优惠券信息
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
                                <label class="col-sm-2 control-label">优惠券名称</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" value="{{old('name',isset($row->data->name)?$row->data->name:'')}}">
                                    {!! $errors->first('name','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">优惠券类型</label>

                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="type">
                                        @foreach($type as $k=>$v)
                                            <option value="{{$k}}">{{$v}}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('type','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">使用范围</label>

                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="use_scope">
                                        @foreach($useScope as $k=>$v)
                                            <option value="{{$k}}">{{$v}}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('type','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">首次登陆时间</label>
                                <div class="col-sm-10">
                                    <div class="input-daterange input-group" id="datepicker" style="width: 530px;">
                                        <input type="text" class="input-sm form-control" id="start" name="start_time" value="{{old('start_time',isset($row->data->start_time)?$row->data->start_time:'')}}">
                                        <span class="input-group-addon">到</span>
                                        <input type="text" class="input-sm form-control" id="end" name="end_time" value="{{old('end_time',isset($row->data->end_time)?$row->data->end_time:'')}}">
                                    </div>
                                    {!! $errors->first('start_time','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                    {!! $errors->first('end_time','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">优惠金额</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="price" value="{{old('price',isset($row->data->price)?$row->data->price:'')}}">
                                    {!! $errors->first('price','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">使用条件</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="full_price_use" value="{{old('full_price_use',isset($row->data->full_price_use)?$row->data->full_price_use:'')}}" placeholder="请输入满减金额">
                                    {!! $errors->first('full_price_use','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">有效时间(天)</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="valid_time" value="{{old('valid_time',isset($row->data->valid_time)?$row->data->valid_time/60/60/24:'')}}" placeholder="请输入有效时间(单位：天)">
                                    {!! $errors->first('valid_time','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
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
                                <label class="col-sm-2 control-label">描述</label>

                                <div class="col-sm-10">
                                    <textarea rows="8" cols="80" name="description">{{old('description',isset($row->data->description))?$row->data->description:''}}</textarea>
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
    <script src="{{asset('asset/admin/js/plugins/layer/laydate/laydate.js')}}"></script>
    <script charset="utf-8">
        $(function () {
            $('select[name=type]').val('{{old('type',isset($row->data->type)?$row->data->type:'voucher')}}')
            $('select[name=use_scope]').val('{{old('use_scope',isset($row->data->use_scope)?$row->data->use_scope:'all')}}')
        });

        var start = {
            elem: '#start',
            format: 'YYYY-MM-DD hh:mm:ss',
            min: laydate.now(), //设定最小日期为当前日期
            max: '2099-06-16 23:59:59', //最大日期
            istime: true,
            istoday: false,
            choose: function (datas) {
//                end.min = datas; //开始日选好后，重置结束日的最小日期
//                end.start = datas //将结束日的初始值设定为开始日
            }
        };
        var end = {
            elem: '#end',
            format: 'YYYY-MM-DD hh:mm:ss',
            min: laydate.now(),
            max: '2099-06-16 23:59:59',
            istime: true,
            istoday: false,
            choose: function (datas) {
//                start.max = datas; //结束日选好后，重置开始日的最大日期
            }
        };
        laydate(start);
        laydate(end);

    </script>
@stop
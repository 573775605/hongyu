@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>公众号设置</h5>
                </div>
                @include('admin.layout.hint')
                <div class="ibox-content">
                    <form class="form-horizontal" id="base_form" method="post">
                        {!! csrf_field() !!}
                        @foreach($rows->getItems() as $v)
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{$v->title}}</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="param[{{$v->key}}]" value="{{$v->value}}" placeholder="请输入配置参数" class="form-control">
                                        {!! $errors->first('not_delivery_order_price','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                        @endforeach
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary">保存内容</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
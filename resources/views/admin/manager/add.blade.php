@extends('admin.layout.master')

@section('title','系统管理员')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title" style="height: 50px">
                        <h5>系统管理员
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
                                <label class="col-sm-2 control-label">登陆账号</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="username" value="{{old('username',isset($row->data->username)?$row->data->username:'')}}">
                                    {!! $errors->first('username','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            @if(!isset($row))
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">登陆密码</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="password" value="{{old('password',isset($row->data->password)?$row->data->password:'')}}">
                                        {!! $errors->first('password','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">确认密码</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="password_confirmation" value="{{old('password_confirmation',isset($row->data->password_confirmation)?$row->data->password_confirmation:'')}}">
                                        {!! $errors->first('password_confirmation','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                            @endif
                            <div class="form-group">
                                <label class="col-sm-2 control-label">姓名</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" value="{{old('name',isset($row->data->name)?$row->data->name:'')}}">
                                    {!! $errors->first('name','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">手机号</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="mobile" value="{{old('mobile',isset($row->data->mobile)?$row->data->mobile:'')}}">
                                    {!! $errors->first('mobile','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">邮箱</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="email" value="{{old('email',isset($row->data->email)?$row->data->email:'')}}">
                                    {!! $errors->first('email','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">角色</label>
                                <div class="col-sm-10">
                                    @foreach($role as $v)
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="role[]" value="{{$v->id}}">{{$v->display_name}}</label>
                                    @endforeach
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

            $('input[type="checkbox"]').val([{{isset($row)?$row->data->roles->keyBy('id')->keys()->implode(','):''}}]);

        });

    </script>
@stop
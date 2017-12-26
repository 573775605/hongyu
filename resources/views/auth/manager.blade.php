@extends('admin.layout.master')

@section('title','登陆')

@section('css')
    <link href="{{asset('asset/admin/css/login.css')}}" rel="stylesheet">
@stop

@section('body','signin')

@section('content')
    <div class="signinpanel">
        <div class="row">
            <div class="col-sm-12">
                <form method="post" action="" id="form">
                    <h4 class="no-margins">请输入登陆账号和密码</h4>
                    {!! csrf_field() !!}
                    <input type="text" class="form-control uname" placeholder="用户名" name="username"/>
                    <input type="password" class="form-control pword m-b" placeholder="密码" name="password"/>
                    <label class="checkbox-inline">
                        <input type="checkbox" value="1" name="remember_token">自动登陆
                    </label>
                    <button class="btn btn-success btn-block" type="button" onclick="login()">登录</button>
                </form>
            </div>
        </div>
        <div class="signup-footer">
            <div class="pull-left">
                {{--&copy; hAdmin--}}
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        function login() {
            $.ajax({
                type: "POST",
                url: '{{url('auth/manager')}}',
                data: $('#form').serialize(),// 要提交的表单
                success: function (data) {
                    if (data.status != 1) {
                        layer.msg(data.message);
                    } else {
                        location.href = '{{url('admin')}}';
                    }
                }
            });
        }
        if (window.top !== window.self) {
            window.top.location = window.location;
        }
    </script>
@stop
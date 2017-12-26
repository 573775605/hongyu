@extends('admin.layout.master')

@section('title','没有操作权限')

@section('css')
    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            color: #B0BEC5;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 72px;
            margin-bottom: 40px;
        }

    </style>
@stop

@section('content')
    <div class="container">
        <div class="content">
            <div class="title">Action 403 Forbidden</div>
            <a href="{{url('admin/index/home')}}" class="btn btn-primary m-t">返回主页</a>
        </div>
    </div>
@stop
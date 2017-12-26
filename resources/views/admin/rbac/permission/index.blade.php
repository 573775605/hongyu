@extends('admin.layout.master')

@section('title','权限列表')

@section('css')
    <link href="{{ asset('asset/admin/css/plugins/bootstrap-table/bootstrap-table.min.css') }}" rel="stylesheet">
    <link href="{{ asset("asset/admin/js/plugins/treegrid/css/jquery.treegrid.css") }}" rel="stylesheet">
@stop

@section('content')
    <div class="ibox float-e-margins">
        <ul class="nav nav-tabs">
            <li class="active"><a href="javascript:void(0)" style="font-size: 15px;"><i class="fa"></i>权限列表</a></li>
            <a href="{{url('admin/rbac/permission/add')}}">
                <button type="button" class="btn btn-w-m btn-primary pull-right" style="margin-bottom: 0px; line-height:33px;">添加权限</button>
            </a>
        </ul>
        <div class="ibox-content">
            <div class="row row-lg">
                <div class="col-sm-12">
                    <table id="tree-table" data-toggle="table" data-height="100%" data-mobile-responsive="true" data-card-view="false">
                        <thead>
                        <tr>
                            <th>权限名称</th>
                            <th>执行操作</th>
                            <th>描述</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rows->loadTree() as $v)
                            <tr class="treegrid-{{$v->id}} {{$v->parent_id?'treegrid-parent-'.$v->parent_id:''}}">
                                <td>{{$v->display_name}}</td>
                                <td>{{$v->name}}</td>
                                <td>{{$v->description}}</td>
                                <td>
                                    <a href="{{url('admin/rbac/permission/edit/'.$v->id)}}" class="mod btn btn-info">编辑</a>
                                    <a href="javascript:remove({{$v->id}})" class="mod btn btn-danger">删除</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@stop

@section('js')
    <!-- Bootstrap table -->
    <script src="{{asset('asset/admin/js/plugins/bootstrap-table/bootstrap-table.min.js')}}"></script>
    <script src="{{asset('asset/admin/js/plugins/bootstrap-table/bootstrap-table-mobile.min.js')}}"></script>
    <script src="{{asset('asset/admin/js/plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js')}}"></script>
    <script src="{{ asset("asset/admin/js/plugins/treegrid/js/jquery.treegrid.js") }}"></script>
    <script>
        function remove(id) {
            swal({
                    title: "你确定此操作吗？",
                    text: "此操作不能恢复",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "确定",
                    cancelButtonText: "取消",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post("{{url('admin/rbac/permission/remove')}}/" + id,
                            {_token: '{{csrf_token()}}'},
                            function (data, status) {
                                if (data.status != 1) {
                                    alert(data.message);
                                } else {
                                    location.reload();
                                }

                            });
                    }
                });
        }

        $(function () {
            $('#tree-table').treegrid();
        })

    </script>
@stop
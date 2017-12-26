@extends('admin.layout.master')

@section('title','角色列表')

@section('css')
    <link href="{{ asset('asset/admin/css/plugins/bootstrap-table/bootstrap-table.min.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="ibox float-e-margins">
        <ul class="nav nav-tabs">
            <li class="active"><a href="javascript:void(0)" style="font-size: 15px;"><i class="fa"></i>角色列表</a></li>
            <a href="{{url('admin/rbac/role/add')}}">
                <button type="button" class="btn btn-w-m btn-primary pull-right" style="margin-bottom: 0px; line-height:33px;">添加角色</button>
            </a>
        </ul>
        <div class="ibox-content">
            <div class="row row-lg">
                <div class="col-sm-12">
                    <table id="tree-table" data-toggle="table" data-height="100%" data-mobile-responsive="true" data-card-view="false">
                        <thead>
                        <tr>
                            <th>角色名称</th>
                            <th>操作名称</th>
                            <th>描述</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rows->getItems() as $v)
                            <tr>
                                <td>{{$v->display_name}}</td>
                                <td>{{$v->name}}</td>
                                <td>{{$v->description}}</td>
                                <td>
                                    <a href="{{url('admin/rbac/role/edit/'.$v->id)}}" class="mod btn btn-info">编辑</a>
                                    <a href="javascript:remove({{$v->id}})" class="mod btn btn-danger">删除</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $rows->getItems()->links() !!}
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
                        $.post("{{url('admin/rbac/role/remove')}}/" + id,
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
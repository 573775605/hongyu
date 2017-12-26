@extends('admin.layout.master')

@section('title','优惠券列表')

@section('css')
    <link href="{{ asset('asset/admin/css/plugins/bootstrap-table/bootstrap-table.min.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="ibox float-e-margins">
        <ul class="nav nav-tabs">
            <li class="active"><a href="javascript:void(0)" style="font-size: 15px;"><i class="fa"></i>优惠券列表</a></li>
            <a href="{{url('admin/coupon/add')}}">
                <button type="button" class="btn btn-w-m btn-primary pull-right" style="margin-bottom: 0px; line-height:33px;">添加优惠券</button>
            </a>
        </ul>
        <div class="ibox-content">
            <div class="row row-lg">
                <div class="col-sm-12">
                    <div id="example-wrap">
                        <div class="example">
                            <table data-toggle="table" data-height="100%" data-mobile-responsive="true" data-card-view="false">
                                <thead>
                                <tr>
                                    <th>优惠券名称</th>
                                    <th>优惠券类型</th>
                                    <th>优惠金额</th>
                                    <th>登陆时间</th>
                                    <th>有效时间</th>
                                    <th>添加时间</th>
                                    <th>添加人</th>
                                    <th>排序</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rows->getItems() as $v)
                                    <tr>
                                        <td>{{$v->name}}</td>
                                        <td>{{$type[$v->type]}}</td>
                                        <td>{{$v->price}}</td>
                                        <td>{{$v->start_time.' 至 '.$v->end_time}}</td>
                                        <td>{{$v->valid_time/60/60/24}}天</td>
                                        <td>{{$v->create_time}}</td>
                                        <td>{{$v->manager->username or ''}}</td>
                                        <td>{{$v->sort}}</td>
                                        <td>
                                            <a href="{{url('admin/coupon/edit').'/'.$v->id}}" class="mod btn btn-info">编辑</a>
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
                        $.post("{{url('admin/coupon/remove')}}/" + id,
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
    </script>
@stop
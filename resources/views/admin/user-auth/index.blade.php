@extends('admin.layout.master')

@section('title','用户资料审核')

@section('css')
    <link href="{{ asset('asset/admin/css/plugins/bootstrap-table/bootstrap-table.min.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="ibox float-e-margins">
        <ul class="nav nav-tabs">
            <li class="{{request()->has('is_check')?'':'active'}}">
                <a href="{{url('admin/user/auth')}}" style="font-size: 15px;"><i class="fa"></i>全部</a>
            </li>
            <li class="{{request('is_check')==1?'active':''}}">
                <a href="{{url('admin/user/auth')}}?is_check=1" style="font-size: 15px;"><i class="fa"></i>已处理</a>
            </li>
            <li class="{{request('is_check')==='0'?'active':''}}">
                <a href="{{url('admin/user/auth')}}?is_check=0" style="font-size: 15px;"><i class="fa"></i>未处理</a>
            </li>
        </ul>
        <div class="ibox-content">
            {{--<div class="col-sm-3" style="padding-left:0px;">--}}
            {{--<form action="" id="search">--}}
            {{--<div class="input-group">--}}
            {{--<input type="text" placeholder="请输入用户昵称" class="input-sm form-control" name="keyword" value="{{request('keyword')}}">--}}
            {{--<span class="input-group-btn">--}}
            {{--<button type="button" class="btn btn-sm btn-primary" onclick="$('#search').submit()"> 搜索</button>--}}
            {{--</span>--}}
            {{--</div>--}}
            {{--</form>--}}
            {{--</div>--}}
            <div class="row row-lg">
                <div class="col-sm-12">
                    <table data-toggle="table" data-height="100%" data-mobile-responsive="true" data-card-view="false">
                        <thead>
                        <tr>
                            <th>用户昵称</th>
                            <th>用户姓名</th>
                            <th>手机号码</th>
                            <th>身份证号</th>
                            <th>提交时间</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rows->getItems() as $v)
                            <tr>
                                <td>{{$v->user->nickname or ''}}</td>
                                <td>{{$v->name}}</td>
                                <td>{{$v->mobile}}</td>
                                <td>{{$v->idcard}}</td>
                                <td>{{$v->create_time}}</td>
                                <td>{{$status[$v->status] or ''}}</td>
                                <td>
                                    <a href="{{url('admin/user/auth/view/'.$v->id)}}" class="mod btn btn-primary">查看</a>
                                    @if(!$v->is_check)
                                        <a href="javascript:showModal({{$v->id}})" class="mod btn btn-primary">审核</a>
                                    @endif
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

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        资料审核
                    </h4>
                </div>
                <div class="modal-body">
                    <form action="" id="form" class="form-horizontal">
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" value="0"/>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">审核状态</label>
                            <div class="col-sm-9">
                                <select class="form-control m-b" name="status">
                                    <option value="2">通过</option>
                                    <option value="-1">不通过</option>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">审核备注</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="check_remark">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-bottom: 0px">取消
                    </button>
                    <button type="button" class="btn btn-primary" onclick="submitCheck()">
                        确认提交
                    </button>
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
        function showModal(id) {
            $('#modal').find('input[name=id]').val(id);
            $('#modal').modal('show');
        }

        function submitCheck() {
            $.ajax({
                type: "POST",
                url: '{{url('admin/user/auth/check')}}',
                data: $('#form').serialize(),// 要提交的表单
                success: function (data) {
                    if (data.status != 1) {
                        alert(data.message);
                    } else {
                        location.reload();
                    }
                }
            });
        }
    </script>
@stop
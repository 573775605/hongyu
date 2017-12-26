@extends('admin.layout.master')

@section('title','发布需求列表')

@section('css')
    <link href="{{ asset('asset/admin/css/plugins/bootstrap-table/bootstrap-table.min.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="ibox float-e-margins">
        <ul class="nav nav-tabs">
            <li class="{{request('is_check')===null?'active':''}}">
                <a href="{{url('admin/user/withdraw')}}" style="font-size: 15px;"><i class="fa"></i>全部</a>
            </li>
            <li class="{{request('is_check')==='0'?'active':''}}">
                <a href="{{url('admin/user/withdraw')}}?is_check=0" style="font-size: 15px;"><i class="fa"></i>未处理</a>
            </li>
            <li class="{{request('is_check')==1?'active':''}}">
                <a href="{{url('admin/user/withdraw')}}?is_check=1" style="font-size: 15px;"><i class="fa"></i>已处理</a>
            </li>
            <a class="btn btn-primary pull-right" href="javascript:$('#modal2').modal('show');">
                代购提现设置
            </a>
        </ul>
        <div class="ibox-content">
            <div class="bs-glyphicons" style="text-align: center">
                <ul class="bs-glyphicons-list ">

                    <li style="width: 25%;">
                        <span class="glyphicon-class" aria-hidden="true">提现总额</span>
                        <span class="glyphicon" style="margin-top: 20px;">{{$price}}</span>
                    </li>
                    <li style="width: 25%;">
                        <span class="glyphicon-class" aria-hidden="true">待审核</span>
                        <span class="glyphicon" style="margin-top: 20px;">{{$stayPrice}}</span>
                    </li>
                    <li style="width: 25%;">
                        <span class="glyphicon-class" aria-hidden="true">已打款</span>
                        <span class="glyphicon" style="margin-top: 20px;">{{$thenPrice}}</span>
                    </li>
                    <li style="width: 25%;">
                        <span class="glyphicon-class" aria-hidden="true">不通过</span>
                        <span class="glyphicon" style="margin-top: 20px;">{{$notpassPrice}}</span>
                    </li>

                </ul>
            </div>
            <div class="row">
                <form action="" id="search">
                    <div class="col-sm-3">
                        <div class="input-group">
                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" class="input-sm form-control" style="width: 240px;" id="start" name="start_time" value="{{request('start_time')}}" placeholder="开始时间">
                                <span class="input-group-addon">到</span>
                                <input type="text" class="input-sm form-control" style="width: 240px;" id="end" name="end_time" value="{{request('end_time')}}" placeholder="结束时间">
                            </div>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-sm btn-primary" onclick="$('#search').submit()"> 搜索</button>
                                {{--<button type="button" class="btn btn-outline btn-default" onclick="exportExcel()"> 导出</button>--}}
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="row row-lg">
                <div class="col-sm-12">
                    <table data-toggle="table" data-height="100%" data-mobile-responsive="true" data-card-view="false">
                        <thead>
                        <tr>
                            <th>用户名称</th>
                            <th>余额类型</th>
                            <th>提现金额</th>
                            <th>实际金额</th>
                            <th>账户类型</th>
                            <th>账户名称</th>
                            <th>提现账号</th>
                            <th>申请时间</th>
                            <th>审核时间</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rows->getItems() as $v)
                            <tr>
                                <td>{{$v->user->nickname or ''}}</td>
                                <td>{{$type[$v->type] or ''}}</td>
                                <td>{{$v->price}}</td>
                                <td>{{$v->actual_price}}</td>
                                <td>{{$accountType[$v->account_type] or ''}}</td>
                                <td>{{$v->name}}{{$v->account_type=='bank'?'('.$v->bank_name.')':''}}</td>
                                <td>{{$v->account}}</td>
                                <td>{{$v->create_time}}</td>
                                <td>{{$v->check_time}}</td>
                                <td>{{$status[$v->status] or ''}}</td>
                                <td>
                                    @if($v->status==1)
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

    <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        退货审核
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
                                    <option value="2">已打款</option>
                                    <option value="-1">不通过</option>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">审核备注</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="remark">
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

    <div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title">
                        代购余额提现配置
                    </h4>
                </div>
                <div class="modal-body">
                    <form action="" id="form1" class="form-horizontal">
                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label class="col-sm-3 control-label">抽成比例(%)</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="scale" value="{{$scale}}">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-bottom: 0px">
                        取消
                    </button>
                    <button type="button" class="btn btn-primary" onclick="saveScale()">
                        确认提交
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{asset('asset/admin/js/plugins/layer/laydate/laydate.js')}}"></script>
    <!-- Bootstrap table -->
    <script src="{{asset('asset/admin/js/plugins/bootstrap-table/bootstrap-table.min.js')}}"></script>
    <script src="{{asset('asset/admin/js/plugins/bootstrap-table/bootstrap-table-mobile.min.js')}}"></script>
    <script src="{{asset('asset/admin/js/plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js')}}"></script>
    <script>
        var start = {
            elem: '#start',
            format: 'YYYY-MM-DD hh:mm:ss',
//            min: laydate.now(), //设定最小日期为当前日期
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
//            min: laydate.now(),
            max: '2099-06-16 23:59:59',
            istime: true,
            istoday: false,
            choose: function (datas) {
//                start.max = datas; //结束日选好后，重置开始日的最大日期
            }
        };
        laydate(start);
        laydate(end);

        function showModal(id) {
            $('#form').find('input[name=id]').val(id);
            $('#modal1').modal('show');
        }

        function submitCheck() {
            $.ajax({
                type: "POST",
                url: '{{url('admin/user/withdraw/check')}}',
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
                        $.post("{{url('admin/banner/remove')}}/" + id,
                            {_token: '{{csrf_token()}}'},
                            function (data, status) {
                                if (data.status) {
                                    location.reload();
                                } else {
                                    alert(data.message);
                                }

                            });
                    }
                });
        }

        function saveScale() {
            $.post("{{url('admin/config/save-scale')}}",
                $('#form1').serialize(),
                function (data, status) {
                    if (data.status != 1) {
                        swal({
                                title: data.message,
//                    text: "此操作不能恢复",
                                type: "error",
                                showCancelButton: false,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "确定",
                                cancelButtonText: "取消",
                                closeOnConfirm: true,
                                closeOnCancel: true
                            }
                        );
                    } else {
                        $('#modal2').modal('hide');
                        swal({
                                title: "保存成功",
//                    text: "此操作不能恢复",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "确定",
                                cancelButtonText: "取消",
                                closeOnConfirm: true,
                                closeOnCancel: true
                            }
                        );
                    }
                });
        }
    </script>
@stop
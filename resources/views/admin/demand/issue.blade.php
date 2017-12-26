@extends('admin.layout.master')

@section('title','发布需求列表')

@section('css')
    <link href="{{ asset('asset/admin/css/plugins/bootstrap-table/bootstrap-table.min.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="ibox float-e-margins">
        <ul class="nav nav-tabs">
            <li class="{{request('status')?'':'active'}}"><a href="{{url('admin/demand/issue')}}" style="font-size: 15px;"><i class="fa"></i>全部</a></li>
            <li class="{{request('status')==1?'active':''}}"><a href="{{url('admin/demand/issue')}}?status=1" style="font-size: 15px;"><i class="fa"></i>发布中</a>
            </li>
            <li class="{{request('status')==2?'active':''}}"><a href="{{url('admin/demand/issue')}}?status=2" style="font-size: 15px;"><i class="fa"></i>待支付</a>
            </li>
            <li class="{{request('status')==3?'active':''}}"><a href="{{url('admin/demand/issue')}}?status=3" style="font-size: 15px;"><i class="fa"></i>待发货</a>
            </li>
            <li class="{{request('status')==4?'active':''}}"><a href="{{url('admin/demand/issue')}}?status=4" style="font-size: 15px;"><i class="fa"></i>待收货</a>
            </li>
            <li class="{{request('status')==5?'active':''}}"><a href="{{url('admin/demand/issue')}}?status=5" style="font-size: 15px;"><i class="fa"></i>已完成</a>
            </li>
            <li class="{{request('status')==-1?'active':''}}">
                <a href="{{url('admin/demand/issue')}}?status=-1" style="font-size: 15px;"><i class="fa"></i>已取消</a></li>
        </ul>
        <div class="ibox-content">
            <div class="row">
                <form action="" id="search">
                    <div class="col-sm-3">
                        <input type="text" placeholder="请输入订单编号/用户名" class="form-control" name="keyword" value="{{request('keyword')}}">
                    </div>
                    <div class="col-sm-3" style="padding: 0px;">
                        <div class="input-group">
                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" class="input-sm form-control" style="width: 240px;" id="start" name="start_time" value="{{request('start_time')}}" placeholder="开始时间">
                                <span class="input-group-addon">到</span>
                                <input type="text" class="input-sm form-control" style="width: 240px;" id="end" name="end_time" value="{{request('end_time')}}" placeholder="结束时间">
                            </div>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-sm btn-primary" onclick="$('#search').submit()"> 搜索</button>
                                <button type="button" class="btn btn-outline btn-default" onclick="exportExcel()"> 导出</button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="row row-lg">
                <div class="col-sm-12">
                    <table data-toggle="table" data-height="100%" data-mobile-responsive="true" data-card-view="true">
                        <thead>
                        <tr>
                            <th>订单编号</th>
                            <th>微信单号</th>
                            <th>发布用户</th>
                            <th>代购用户</th>
                            <th>发布金额</th>
                            <th>报价金额</th>
                            <th>创建时间</th>
                            <th>收货人</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rows->getItems() as $v)
                            <tr>
                                <td>{{$v->order_number}}</td>
                                <td>{{$v->paymentOrder->wechat_order_number or ''}}</td>
                                <td>{{$v->user->nickname or ''}}</td>
                                <td>{{$v->selectUser->nickname or ''}}</td>
                                <td>{{$v->known_price}}</td>
                                <td>{{$v->tender_price}}</td>
                                <td>{{$v->create_time}}</td>
                                <td>{{$v->consignee}}:{{$v->phone}}</td>
                                <td>
                                    <a href="{{url('admin/demand/details/'.$v->id)}}" class="mod btn btn-primary">查看</a>
                                    @if($v->status==1)
                                        <a href="javascript:recallDemand({{$v->id}})" class="mod btn btn-primary">撤回</a>
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
                        需求撤回
                    </h4>
                </div>
                <div class="modal-body">
                    <form action="" id="form" class="form-horizontal">
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" value="0"/>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">撤回说明</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="remark">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-bottom: 0px">取消
                    </button>
                    <button type="button" class="btn btn-primary" onclick="submitRecall()">
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
        function exportExcel() {
            var url = '{{url('admin/demand/export')}}';
            $('#search').attr('action', url);
            $('#search').submit();
        }
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

        function recallDemand(id) {
            $('#form').find('input[name=id]').val(id);
            $('#modal1').modal('show');
        }

        function submitRecall() {
            $.post("{{url('admin/demand/recall')}}",
                $('#form').serialize(),
                function (data, status) {
                    if (data.status != 1) {
                        alert(data.message);
                    } else {
                        location.reload();
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
    </script>
@stop
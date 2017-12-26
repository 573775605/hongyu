@extends('admin.layout.master')

@section('title','用户列表')

@section('css')
    <link href="{{ asset('asset/admin/css/plugins/bootstrap-table/bootstrap-table.min.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="ibox float-e-margins">
        <ul class="nav nav-tabs">
            <li class="active"><a href="javascript:void(0)" style="font-size: 15px;"><i class="fa"></i>用户列表</a></li>
        </ul>
        <div class="ibox-content">
            <div class="row">
                <form action="" id="search">
                    <div class="col-sm-3">
                        <input type="text" placeholder="请输入用户名" class="form-control" name="keyword" value="{{request('keyword')}}">
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
                    <table data-toggle="table" data-height="100%" data-mobile-responsive="true" data-card-view="false">
                        <thead>
                        <tr>
                            <th>用户昵称</th>
                            <th>微信头像</th>
                            <th>用户性别</th>
                            <th>代购余额</th>
                            <th>账户余额</th>
                            <th>账户押金</th>
                            <th>所在地区</th>
                            <th>加入时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rows->getItems() as $v)
                            <tr>
                                <td>{{$v->nickname}}</td>
                                <td><img src="{{$v->img_url}}" alt="" width="80" height="80"></td>
                                <td>{{$v->sex==1?'男':'女'}}</td>
                                <td>{{$v->getDaigouBalance()}}</td>
                                <td>{{$v->getBalance()}}</td>
                                <td>{{$v->pledge}}</td>
                                <td>{{$v->country.'-'.$v->province.'-'.$v->city}}</td>
                                <td>{{$v->create_time}}</td>
                                <td>
                                    @if($v->status==1)
                                        <a href="javascript:frostUser({{$v->id}})" class="btn mod btn-warning">冻结</a>
                                    @else
                                        <a href="javascript:frostUser({{$v->id}})" class="mod btn btn-success">解冻</a>
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
@stop

@section('js')
    <script src="{{asset('asset/admin/js/plugins/layer/laydate/laydate.js')}}"></script>
    <!-- Bootstrap table -->
    <script src="{{asset('asset/admin/js/plugins/bootstrap-table/bootstrap-table.min.js')}}"></script>
    <script src="{{asset('asset/admin/js/plugins/bootstrap-table/bootstrap-table-mobile.min.js')}}"></script>
    <script src="{{asset('asset/admin/js/plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js')}}"></script>
    <script>
        function exportExcel() {
            var url = '{{url('admin/user/export')}}';
            $('#search').attr('action', url);
            $('#search').submit();
        }
        function frostUser(id) {
            swal({
                    title: "你确定此操作吗？",
//                    text: "此操作不能恢复",
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
                        $.post("{{url('admin/user/frost')}}/" + id,
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
    </script>
@stop
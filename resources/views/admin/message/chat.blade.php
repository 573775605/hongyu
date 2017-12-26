@extends('admin.layout.master')

@section('title','聊天记录')

@section('css')
    <link href="{{ asset('asset/admin/css/plugins/bootstrap-table/bootstrap-table.min.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="ibox float-e-margins">
        <ul class="nav nav-tabs">
            <li class="active"><a href="javascript:void(0)" style="font-size: 15px;"><i class="fa"></i>聊天记录</a></li>
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
                            <th>发送用户</th>
                            <th>接受用户</th>
                            <th>发送时间</th>
                            <th>内容</th>
                            <th>图片</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rows->getItems() as $v)
                            <tr>
                                <td>{{$v->sendUser->nickname or ''}}</td>
                                <td>{{$v->acceptUser->nickname or ''}}</td>
                                <td>{{$v->create_time}}</td>
                                <td>{{$v->content}}</td>
                                <td><img src="{{$v->img->url or ''}}" alt="" width="80" height="80"></td>
                                <td>
                                    @if($v->status==1)
                                        未读
                                    @else
                                        已读
                                    @endif
                                </td>
                                <td>
                                    <a href="javascript:removeChat({{$v->id}})" class="mod btn btn-danger">删除</a>
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
        function removeChat(id) {
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
                        $.post("{{url('admin/message/remove-chat')}}/" + id,
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
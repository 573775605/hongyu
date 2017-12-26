@extends('admin.layout.master')

@section('title','意见反馈')

@section('css')
    <link href="{{ asset('asset/admin/css/plugins/bootstrap-table/bootstrap-table.min.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="ibox float-e-margins">
        <ul class="nav nav-tabs">
            <li class="active"><a href="javascript:void(0)" style="font-size: 15px;"><i class="fa"></i>意见反馈</a></li>
        </ul>
        <div class="ibox-content">
            <div class="col-sm-3" style="padding-left:0px;">
                {{--<form action="" id="search">--}}
                {{--<div class="input-group">--}}
                {{--<input type="text" placeholder="请输入用户昵称" class="input-sm form-control" name="keyword" value="{{request('keyword')}}">--}}
                {{--<span class="input-group-btn">--}}
                {{--<button type="button" class="btn btn-sm btn-primary" onclick="$('#search').submit()"> 搜索</button>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--</form>--}}
            </div>
            <div class="row row-lg">
                <div class="col-sm-12">
                    <table data-toggle="table" data-height="100%" data-mobile-responsive="true" data-card-view="false">
                        <thead>
                        <tr>
                            <th>用户昵称</th>
                            <th>手机号</th>
                            <th>内容</th>
                            <th>回复内容</th>
                            <th>提交时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rows->getItems() as $v)
                            <tr>
                                <td>{{$v->user->nickname or ''}}</td>
                                <td>{{$v->user->mobile or ''}}</td>
                                <td>{{$v->content}}</td>
                                <td>{{$v->reply}}</td>
                                <td>{{$v->create_time}}</td>
                                <td>
                                    @if($v->status==1)
                                        <a href="javascript:replyFeedback({{$v->id}})" class="mod btn btn-primary">回复</a>
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
                        意见回复
                    </h4>
                </div>
                <div class="modal-body">
                    <form action="" id="form" class="form-horizontal">
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" value="0"/>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">回复内容</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="reply">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-bottom: 0px">取消
                    </button>
                    <button type="button" class="btn btn-primary" onclick="submitReply()">
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
        function replyFeedback(id) {
            $('#form').find('input[name=id]').val(id);
            $('#modal1').modal('show');
        }

        function submitReply() {
            $.post("{{url('admin/user/feedback-reply')}}",
                $('#form').serialize(),
                function (data, status) {
                    if (data.status != 1) {
                        alert(data.message);
                    } else {
                        location.reload();
                    }

                });
        }
    </script>
@stop
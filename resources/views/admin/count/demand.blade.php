@extends('admin.layout.master')

@section('title','需求交易统计')

@section('css')
    <link href="{{ asset('asset/admin/js/plugins/layer/skin/layer.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/admin/css/plugins/bootstrap-table/bootstrap-table.min.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="ibox float-e-margins">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#" style="font-size: 15px;"><i class="fa"></i>需求交易统计</a></li>
        </ul>
        <div class="bs-glyphicons" style="text-align: center">
            <ul class="bs-glyphicons-list ">

                <li style="width: 33%;">
                    <span class="glyphicon-class" aria-hidden="true">成交金额</span>
                    <span class="glyphicon" style="margin-top: 20px;">{{$dealPrice?:0}}</span>
                </li>

                <li style="width: 33%;">
                    <span class="glyphicon-class" aria-hidden="true">成交数量</span>
                    <span class="glyphicon" style="margin-top: 20px;">{{$dealCount}}</span>
                </li>

                <li style="width: 33%;">
                    <span class="glyphicon-class" aria-hidden="true">使用优惠券</span>
                    <span class="glyphicon" style="margin-top: 20px;">{{$couponPrice?:0}}</span>
                </li>

            </ul>
        </div>
        <div class="ibox-content">
            <div class="col-sm-3" style="padding-left:0px;">
                <form action="" id="search">
                    <div class="input-group">
                        <div class="input-daterange input-group" id="datepicker" style="width: 530px;">
                            <input type="text" class="input-sm form-control" id="start" name="start_time" value="{{request('start_time')}}">
                            <span class="input-group-addon">到</span>
                            <input type="text" class="input-sm form-control" id="end" name="end_time" value="{{request('end_time')}}">
                        </div>
                        <span class="input-group-btn">
                             <button type="button" class="btn btn-sm btn-primary" onclick="$('#search').submit()"> 搜索</button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="row row-lg">
                <div class="col-sm-12">
                    <table data-toggle="table" data-height="100%" data-mobile-responsive="true" data-card-view="false">
                        <thead>
                        <tr>
                            <th>订单编号</th>
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
                                <td>{{$v->user->nickname or ''}}</td>
                                <td>{{$v->selectUser->nickname or ''}}</td>
                                <td>{{$v->known_price}}</td>
                                <td>{{$v->tender_price}}</td>
                                <td>{{$v->create_time}}</td>
                                <td>{{$v->consignee}}:{{$v->phone}}</td>
                                <td>
                                    <a href="{{url('admin/demand/details/'.$v->id)}}" class="mod btn btn-primary">查看</a>
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
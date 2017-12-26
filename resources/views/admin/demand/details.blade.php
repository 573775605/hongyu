@extends('admin.layout.master')

@section('title','订单详情')

@section('content')
    <div class="ibox-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="m-b-md">
                    <a href="javascript:history.go(-1)" class="btn btn-primary pull-right" style="width: 80px;height: 100%;margin-bottom: 0px;">返回</a>
                    <h2>订单详情</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5">
                <dl class="dl-horizontal">

                    <dt>订单编号：</dt>
                    <dd>{{$demand->order_number}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>创建时间：</dt>
                    <dd>{{$demand->create_time}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>发布金额：</dt>
                    <dd>{{$demand->known_price}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>报价金额：</dt>
                    <dd>{{$demand->tender_price}}({{$demand->express_price?'含邮费'.$demand->express_price:'免邮费'}})</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>优惠金额：</dt>
                    <dd>{{$demand->coupon_price}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>实际支付：</dt>
                    <dd>{{$demand->price}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>优惠金额：</dt>
                    <dd>{{$demand->coupon_price}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>物流公司：</dt>
                    <dd>{{$express[$demand->express_company_number] or ''}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>物流单号：</dt>
                    <dd>{{$demand->express_number}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>订单状态：</dt>
                    <dd>{{$status[$demand->status] or ''}}</dd>
                    <div class="hr-line-dashed"></div>
                </dl>
            </div>
            <div class="col-sm-5" id="cluster_info">
                <dl class="dl-horizontal">

                    <dt>发布用户：</dt>
                    <dd>{{$demand->user->nickname or ''}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>代购用户：</dt>
                    <dd>{{$demand->selectUser->nickname or ''}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>是否支付：</dt>
                    <dd>{{$demand->is_pay?'是':'否'}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>支付时间：</dt>
                    <dd>{{$demand->pay_time}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>发布时间：</dt>
                    <dd>{{$demand->issue_time}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>结束时间：</dt>
                    <dd>{{date('Y-m-d H:i:s',$demand->end_time)}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>发货时间：</dt>
                    <dd>{{$demand->delivery_time}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>收货人：</dt>
                    <dd>{{$demand->consignee}}：{{$demand->phone}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>收货地址：</dt>
                    <dd>{{$demand->address}}</dd>
                    <div class="hr-line-dashed"></div>

                </dl>
            </div>
        </div>

        <div class="row m-t-sm">
            <div class="col-sm-12">
                <div class="panel blank-panel">

                    <div class="panel-body">
                        <div class="ibox-content">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>商品名称</th>
                                    {{--<th>商品规格</th>--}}
                                    <th>商品来源</th>
                                    <th>商品单价</th>
                                    <th>商品总价</th>
                                    <th>购买数量</th>
                                    <th>备注</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($demand->demandGoods as $v)
                                    <tr>
                                        <td>{{$v->name}}</td>
                                        {{--<td>{{$v->sku_name}}</td>--}}
                                        <td>{{$v->source}}</td>
                                        <td>{{$v->known_unit_price}}</td>
                                        <td>{{$v->price}}</td>
                                        <td>{{$v->count}}</td>
                                        <td>{{$v->remark}}</td>
                                        <td>
                                            <a href="{{url('admin/demand/goods-details/'.$v->id)}}" class="mod btn btn-primary">查看</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script charset="utf-8">

    </script>
@stop
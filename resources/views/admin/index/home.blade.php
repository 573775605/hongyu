@extends('admin.layout.master')

@section('title','平台首页')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-sm-3">
                <div class="widget style1 lazur-bg">
                    <div class="row">
                        <div class="col-xs-4 text-center">
                            <i class="fa fa-trophy fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> 总交易额 </span>
                            <h2 class="font-bold">¥ {{number_format($demandTotalPrice)}}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="widget style1 lazur-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-reorder fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> 总交易量 </span>
                            <h2 class="font-bold">{{$demandTotalCount}}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="widget style1 navy-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> 用户总数 </span>
                            <h2 class="font-bold">{{$userTotalCount}}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="widget style1 yellow-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-shield fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> 保证金总额 </span>
                            <h2 class="font-bold">¥ {{number_format($pledgeTotalPrice)}}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div id="echarts-line-chart" style="height: 400px;">

            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{asset('asset/ext/layer/layer.min.js')}}"></script>
    <!-- ECharts -->
    <script src="{{ asset('asset/admin/js/plugins/echarts/echarts-all.js') }}"></script>
    <script>
        $('#echarts-line-chart').css('width', $('.wrapper wrapper-content').width());

        $(function () {
            var lineChart = echarts.init(document.getElementById("echarts-line-chart"));
            var lineoption = {
                title: {
                    text: '平台数据统计'
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: ['交易金额', '交易数量', '新增用户']
                },
//                grid: {
//                    x: 40,
//                    x2: 40,
//                    y2: 24
//                },
                calculable: true,
                xAxis: [
                    {
                        type: 'category',
                        boundaryGap: false,
                        data: ['周一', '周二', '周三', '周四', '周五', '周六', '周日']
                    }
                ],
                yAxis: [
                    {
                        type: 'value',
                        axisLabel: {
//                            formatter: '{value} °C'
                        }
                    }
                ],
                series: [
                    {
                        name: '交易金额',
                        type: 'line',
                        data: {!! \GuzzleHttp\json_encode($demandSum) !!},
                        markPoint: {
                            data: [
                                {type: 'max', name: '最大值'},
                                {type: 'min', name: '最小值'}
                            ]
                        }
                    },
                    {
                        name: '交易数量',
                        type: 'line',
                        data: {!! \GuzzleHttp\json_encode($demandCount) !!},
                        markPoint: {
                            data: [
                                {type: 'max', name: '最大值'},
                                {type: 'min', name: '最小值'}
                            ]
                        }
                    },
                    {
                        name: '新增用户',
                        type: 'line',
                        data: {!! \GuzzleHttp\json_encode($userCount) !!},
                        markPoint: {
                            data: [
                                {type: 'max', name: '最大值'},
                                {type: 'min', name: '最小值'}
                            ]
                        }
                    }
                ]
            };
            lineChart.setOption(lineoption);
            $(window).resize(lineChart.resize);
        });
    </script>
@stop
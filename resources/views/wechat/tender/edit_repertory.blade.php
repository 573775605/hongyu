@extends('wechat.layout.master')

@section('title','修改报价库存')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/AddSubtract.css')}}"/>
@stop

@section('content')
    <form action="" method="post" id="form">
        {!! csrf_field() !!}
        <dl class="offers clearfix">
            <dt class="mt5">库存数量：</dt>
            <dd>
                <div class="NBnumall clearfix ">
                    <span class="reduce"></span>
                    <input class="NBnumtext quantity" type="number" name="repertory" value="{{request('repertory',$tender->repertory)}}">
                    <span class="plus"></span>
                </div>
            </dd>
        </dl>

        <dl class="offers clearfix">
            <dt class="mt5">代购有效期：</dt>
            <dd>
                <div class="NBnumall clearfix  ">
                    <span class="reduce"></span>
                    <input class="NBnumtext quantity" type="number" name="day" value="{{request('day',$tender->getDay())}}">
                    <span class="timedate mr10">天</span>
                    <span class="plus"></span>
                </div>
                <div class="NBnumall clearfix mt15 ">
                    <span class="reduce"></span>
                    <input class="NBnumtext quantity" type="number" name="hour" value="{{request('hour',$tender->getHour())}}">
                    <span class="timedate mr10">时</span>
                    <span class="plus"></span>
                </div>
            </dd>
        </dl>
        <a class="redbtn90">
            <input type="submit" value="确认修改"/>
        </a>
    </form>
@stop

@section('js')
    <script>
        function changeCount(obj, count, defaultVal) { //改变数量
            var nowCount = $(obj).find('.quantity').val();
            nowCount = parseInt(nowCount);
            if (nowCount + count > 0) {
                $(obj).find('.quantity').val(nowCount + count);
            } else {
                $(obj).find('.quantity').val(defaultVal);
            }
        }

        $('.plus').click(function () {//加
            var divObj = $(this).parent('.NBnumall');
            changeCount(divObj, 1, 1);
        })
        $('.reduce').click(function () {//减
            var divObj = $(this).parent('.NBnumall');
            if ($(divObj).find('.quantity').attr('name') == 'day') {
                changeCount(divObj, -1, 0);
            } else {
                changeCount(divObj, -1, 1);
            }
        })
    </script>
@stop
@extends('wechat.layout.master')

@section('title','需求评价')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/start.css')}}"/>
@stop

@section('content')
    <dl class="dlword clearfix">
        <dt class="">与描述相符：</dt>
        <dd>
            <ul class="clickstart cstart1 mt12" id="goods_grade">
                <li grade="1"></li>
                <li grade="2"></li>
                <li grade="3"></li>
                <li grade="4"></li>
                <li grade="5"></li>
            </ul>
        </dd>
    </dl>

    <dl class="dlword clearfix">
        <dt class="">服务态度：</dt>
        <dd>
            <ul class="clickstart cstart2 mt12" id="service_grade">
                <li grade="1"></li>
                <li grade="2"></li>
                <li grade="3"></li>
                <li grade="4"></li>
                <li grade="5"></li>
            </ul>
        </dd>
    </dl>

    <dl class="dlword clearfix">
        <dt class="">发货速度：</dt>
        <dd>
            <ul class="clickstart cstart3 mt12" id="deliver_grade">
                <li grade="1"></li>
                <li grade="2"></li>
                <li grade="3"></li>
                <li grade="4"></li>
                <li grade="5"></li>
            </ul>
        </dd>
    </dl>

    <dl class="dlword clearfix">
        <dt class="">物流服务：</dt>
        <dd>
            <ul class="clickstart cstart4 mt12" id="logistics_grade">
                <li grade="1"></li>
                <li grade="2"></li>
                <li grade="3"></li>
                <li grade="4"></li>
                <li grade="5"></li>
            </ul>
        </dd>
    </dl>
    <form action="" method="post">
        {!! csrf_field()!!}
        <input type="hidden" name="goods_grade" value="0">
        <input type="hidden" name="service_grade" value="0">
        <input type="hidden" name="deliver_grade" value="0">
        <input type="hidden" name="logistics_grade" value="0">
        <dl class="offers clearfix">
            <dt class="mt5">评价：</dt>
            <dd>
                <div class="OrderLotextarea">
                    <textarea placeholder="输入评价.." style="width: 100%;" name="content"></textarea>
                </div>
            </dd>
        </dl>
        <a class="redbtn90">
            <input type="submit" value="确认"/>
        </a>
    </form>

@stop

@section('js')
    <script src="{{asset('asset/ext/layer/layer.min.js')}}"></script>
    <script>
        function clickstarts(element) {
            $(element).find('li').on('mouseover', function () { //评星
                $(this).addClass("hasStart");
                $(this).prevAll().addClass("hasStart");
                $(this).nextAll().removeClass('hasStart');
            })
        }
        clickstarts(".cstart1");
        clickstarts(".cstart2");
        clickstarts(".cstart3");
        clickstarts(".cstart4");
        $(function () {
            $('#goods_grade li').click(function () {
                var grade = $(this).attr('grade');
                $('input[name=goods_grade]').val(grade);
            });

            $('#service_grade li').click(function () {
                var grade = $(this).attr('grade');
                $('input[name=service_grade]').val(grade);
            });

            $('#deliver_grade li').click(function () {
                var grade = $(this).attr('grade');
                $('input[name=deliver_grade]').val(grade);
            });

            $('#logistics_grade li').click(function () {
                var grade = $(this).attr('grade');
                $('input[name=logistics_grade]').val(grade);
            });
        })
    </script>
@stop
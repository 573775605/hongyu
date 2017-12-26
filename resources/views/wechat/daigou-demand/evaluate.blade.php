@extends('wechat.layout.master')

@section('title','需求评价')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/start.css')}}"/>
@stop

@section('content')
    <dl class="dlword clearfix">
        <dt class="">评分：</dt>
        <dd>
            <ul class="clickstart cstart1 mt12" id="grade">
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
        <input type="hidden" name="grade" value="0">
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
        $(function () {
            $('#grade li').click(function () {
                var grade = $(this).attr('grade');
                $('input[name=grade]').val(grade);
            });
        })
    </script>
@stop
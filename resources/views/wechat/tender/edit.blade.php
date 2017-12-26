@extends('wechat.layout.master')

@section('title','修改报价')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/AddSubtract.css')}}"/>
@stop

@section('content')
    <form action="{{url('wechat/tender/edit-sub/'.$tender->id)}}" method="post" id="form">
        {!! csrf_field() !!}
        <input type="hidden" name="hotboom_lng" value="{{request('hotboom_lng')?:$tender->hotboom_lng}}">
        <input type="hidden" name="hotboom_lat" value="{{request('hotboom_lat')?:$tender->hotboom_lat}}">
        <input type="hidden" name="hotboom_store_name" value="{{request('hotboom_store_name')?:$tender->hotboom_store_name}}">
        <input type="hidden" name="type" value="{{request('type')?:$tender->type}}">
        @if(request('advantage'))
            @foreach(request('advantage',[]) as $k=>$v)
                @if(isset($v['select']))
                    @foreach($v['select'] as $v1)
                        <input type="hidden" name="advantage[{{$k}}][select][]" value="{{$v1}}">
                    @endforeach
                @endif
                <input type="hidden" name="advantage[{{$k}}][other]" value="{{$v['other']}}">
            @endforeach
        @else
            @foreach($tender->quoteAdvantage as $v)
                @foreach(json_decode($v->label,true) as $v1)
                    <input type="hidden" name="advantage[{{$v->name}}][select][]" value="{{$v1}}">
                @endforeach
                <input type="hidden" name="advantage[{{$v->name}}][other]" value="{{$v->other}}">
            @endforeach
        @endif
        <dl class="offers clearfix">
            <dt class="mt12"><em>*</em>报价金额(元)：</dt>
            <dd>
                <div class="border Daddress">
                    <input type="text" placeholder="您代购该订单收取的总价款" name="quote" value="{{request('quote')?:$tender->quote}}"/>
                </div>
            </dd>
        </dl>

        <dl class="offers clearfix">
            <dt class="mt12"><em>*</em>邮费：</dt>
            <dd>
                <div class="border Daddress">
                    <input type="text" placeholder="0" name="express_price" value="{{request('express_price')?:$tender->express_price}}"/>
                </div>
            </dd>
        </dl>
        <dl class="offers clearfix">
            <dt class="mt5"><em>*</em>报价优势：</dt>
            <dd>
                <a class="btnsqueryellow2">
                    <input type="button" value="选择" onclick="selectAdvantage()"/>
                </a>
            </dd>
        </dl>
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
    </form>

    <a class="redbtn90">
        <input type="button" value="确认报价" onclick="submitQuote()"/>
    </a>
@stop

@section('js')
    <script>
        //选择报价优势
        function selectAdvantage() {
            var url = '{{url('wechat/tender/select-advantage?tender_id='.$tender->id)}}'
            $('#form').attr('action', url);
            $('#form').submit();
        }
        //提交报价
        function submitQuote() {
            {{--var url = '{{url('wechat/tender/submit')}}'--}}
            {{--$('#form').attr('action', url);--}}
            $('#form').submit();
        }

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
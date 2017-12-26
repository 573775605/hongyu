@extends('wechat.layout.master')

@section('title','选择报价优势')

@section('css')
    <style>
        .hotboom-radio {
            display: none;
        }
    </style>
@stop

@section('content')
    <form action="{{request('tender_id')?url('wechat/tender/edit/'.request('tender_id')):url('wechat/tender/index')}}" method="post" id="form">
        {!! csrf_field() !!}
        <input type="hidden" name="select_type" value="other_store">
        @foreach(request()->input() as $k=>$v)
            @if($k!='advantage')
                <input type="hidden" name="{{$k}}" value="{{$v}}">
            @endif
        @endforeach
        <p class="Badvantagetit">
            货品来源 <em>（二选一）</em>
        </p>
        <div class="p3">
            <div class="laiyuan clearfix mb10">
                @if(request('type'))
                    <label class="laiyuanL {{request('type')=='raw-hotboom'?'active':''}}">
                        <input class="hotboom-radio" type="radio" name="type" value="raw-hotboom" {{request('type')=='raw-hotboom'?'checked':''}}>
                        原路代购
                    </label>
                    <label class="laiyuanR {{request('type')=='other-hotboom'?'active':''}}">
                        <input class="hotboom-radio" type="radio" name="type" value="other-hotboom" {{request('type')=='other-hotboom'?'checked':''}}>
                        其他店铺
                    </label>
                @elseif(isset($tender))
                    <label class="laiyuanL {{$tender->type=='raw-hotboom'?'active':''}}">
                        <input class="hotboom-radio" type="radio" name="type" value="raw-hotboom" {{$tender->type=='raw-hotboom'?'checked':''}}>
                        原路代购
                    </label>
                    <label class="laiyuanR {{$tender->type=='other-hotboom'?'active':''}}">
                        <input class="hotboom-radio" type="radio" name="type" value="other-hotboom" {{$tender->type=='other-hotboom'?'checked':''}}>
                        其他店铺
                    </label>
                @else
                    <label class="laiyuanL active">
                        <input class="hotboom-radio" type="radio" name="type" value="raw-hotboom" checked>
                        原路代购
                    </label>
                    <label class="laiyuanR">
                        <input class="hotboom-radio" type="radio" name="type" value="other-hotboom">
                        其他店铺
                    </label>
                @endif
            </div>
        </div>
        <div class="LYcont">
            <div class="LYconts"></div>
            <div class="LYconts">
                <div class="p3">
                    <div class="border mb10">
                        <input class="inputfz" type="text" name="hotboom_store_name" value="{{request('hotboom_store_name')}}" placeholder="粘贴其他店铺链接或填写实体店铺名称"/>
                    </div>
                    <div class="XQadress jiantou border" onclick="selectSite()">
                        实体店定位
                    </div>
                </div>
            </div>
            @foreach($rows as $v)
                <p class="Badvantagetit">
                    {{$v->name}} <em>（可多选）</em>
                </p>
                <div class="p3">
                    <div class="box clearfix">
                        @foreach(json_decode($v->label) as $v1)
                            <span class="checkbox_item checkbox_itemW">
                            @if(request('tender_id'))
                                    <label class="check_label {{in_array($v1,$label)?'checked on':''}}">
            <input type="checkbox" name="advantage[{{$v->name}}][select][]" value="{{$v1}}" {{in_array($v1,$label)?'checked':''}}/>
                <em class="checkbox_text">{{$v1}}</em>
            </label>
                                @else
                                    <label class="check_label">
            <input type="checkbox" name="advantage[{{$v->name}}][select][]" value="{{$v1}}"/>
                <em class="checkbox_text">{{$v1}}</em>
            </label>
                                @endif
                        </span>
                        @endforeach
                    </div>

                    <div class="border">
                        <input class="inputfz" type="text" name="advantage[{{$v->name}}][other]" placeholder="其他"/>
                    </div>
                </div>
            @endforeach

            <div class="redbtn90">
                <input type="submit" value="确认"/>
            </div>
        </div>
    </form>
@stop

@section('mui-js')
@stop
@section('js')
    <script>
        function selectSite() {
            var url = '{{url('wechat/issue/select-site')}}';
            $('#form').attr('action', url);
            $('#form').submit();
        }

        $(function () {
            $(".checkbox_text").click(function () {
                if ($(this).parent().hasClass('on')) {
                    $(this).parent().removeClass('on');
                } else {
                    $(this).parent().addClass('on');
                }
            });
            //选择购买商家位置
            $('#select-site').click(function () {
                var url = '{{url('wechat/tender/select-store-site?tender_id='.request('tender_id'))}}';
                $('#form').attr('action', url);
                $('#form').submit();
            });

            $(".laiyuan label").click(function () {
                var i = $(".laiyuan label").index($(this));
                $(".laiyuan label").removeClass("active");
                $(this).addClass("active");
                $(".LYcont .LYconts").removeClass('active')
                $(".LYcont .LYconts").eq(i).addClass("active");
            })
            $(".LYcont .LYconts").eq($('.laiyuan input').index($('.hotboom-radio:checked'))).addClass("active");

        })
    </script>
@stop
@extends('wechat.layout.master')

@section('title','选择货源')

@section('css')
    <style>
        .mui-row.mui-fullscreen > [class*="mui-col-"] {
            height: 100%;
        }

        .mui-col-xs-3, .mui-col-xs-9 {
            overflow-y: auto;
            height: 100%;
        }

        .mui-segmented-control .mui-control-item {
            line-height: 50px;
            width: 100%;
        }

        .mui-control-content {
            display: block;
        }

        .mui-segmented-control.mui-segmented-control-inverted .mui-control-item.mui-active {
            background-color: #fff;
        }

        #segmentedControlContents {
            background-color: #fff;
        }

        .mui-segmented-control.mui-segmented-control-inverted .mui-control-item.mui-active {
            background: transparent;
        }

        .mui-segmented-control.mui-segmented-control-inverted .mui-control-item {
            background-color: #fff;
        }

        .mui-segmented-control.mui-segmented-control-inverted.mui-segmented-control-vertical .mui-control-item,
        .mui-segmented-control.mui-segmented-control-inverted.mui-segmented-control-vertical .mui-control-item.mui-active {
            border-bottom: 1px solid #f1f1f1;
        }

        .mui-control-content {
            display: none;
        }

        #segmentedControlContents .mui-control-content.active {
            display: block;
        }
    </style>
@stop
@section('body','bgf9 mui-ios')
@section('content')
    <div class="mui-content mui-row mui-fullscreen">
        <div class="mui-col-xs-3">
            <div id="segmentedControls" class="Listnav mui-segmented-control mui-segmented-control-inverted mui-segmented-control-vertical">
                @foreach($rows->whereLoose('level',1)->values() as $k=>$v)
                    <a class="mui-control-item {{$k?'':'mui-active'}}">{{$v->name}}</a>
                @endforeach
            </div>
        </div>
        <div id="segmentedControlContents" class="mui-col-xs-9">
            @foreach($rows->whereLoose('level',1)->values() as $k=>$v)
                <div id="content" class="mui-control-content {{$k?'':'mui-active'}}">
                    <ul class="mui-table-view ListR ListPading">
                        @foreach($rows as $v1)
                            @if($v1->parent_id==$v->id)
                                @if(request('goods_id'))
                                    <li>
                                        <a href="{{url('wechat/demand/edit/'.request('goods_id').'?source='.$v1->name.'&source_id='.$v1->id)}}">
                                            <div class="Listimg"><img src="{{$v1->img->url or ''}}"/></div>
                                            <p class="listword2">{{$v1->name}}</p>
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{url('wechat/issue/index?source='.$v1->name.'&source_id='.$v1->id)}}">
                                            <div class="Listimg"><img src="{{$v1->img->url or ''}}"/></div>
                                            <p class="listword2">{{$v1->name}}</p>
                                        </a>
                                    </li>
                                @endif
                            @endif
                        @endforeach

                    </ul>
                </div>
            @endforeach
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function () {
            var Listimgw = $(".Listimg").width();
            $(".Listimg").css("height", Listimgw);

            $("#segmentedControls a").click(function () {//列表切换
                var i = $("#segmentedControls a").index($(this));
                $("#segmentedControls a").removeClass("mui-active");
                $(this).addClass("mui-active");
                $("#segmentedControlContents div.mui-control-content").removeClass("mui-active");
                $("#segmentedControlContents div.mui-control-content").eq(i).addClass("mui-active");
            })
        })
    </script>
@stop
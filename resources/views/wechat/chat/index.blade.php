@extends('wechat.layout.master')

@section('title','聊天消息')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/js/remove/jquery.mobile-1.4.3.min.css')}}">

    <style type="text/css">
        .ui-page-theme-a a, html .ui-bar-a a, html .ui-body-a a, html body .ui-group-theme-a a {
            font-weight: 400;
        }

        .ui-page-theme-a .ui-btn:active, html .ui-bar-a .ui-btn:active, html .ui-body-a .ui-btn:active, html body .ui-group-theme-a .ui-btn:active, html head + body .ui-btn.ui-btn-a:active {
            background: #fff;
        }

        .ui-page-theme-a .ui-btn, html .ui-bar-a .ui-btn, html .ui-body-a .ui-btn, html body .ui-group-theme-a .ui-btn, html head + body .ui-btn.ui-btn-a, .ui-page-theme-a .ui-btn:visited, html .ui-bar-a .ui-btn:visited, html .ui-body-a .ui-btn:visited, html body .ui-group-theme-a .ui-btn:visited, html head + body .ui-btn.ui-btn-a:visited {
            background: #fff;
        }

        .ui-listview > .ui-li-static.ui-last-child, .ui-listview > .ui-li-divider.ui-last-child, .ui-listview > li.ui-last-child > a.ui-btn {
            border-bottom-width: 0px;
        }

        .ui-listview > li.ui-last-child img:first-child:not(.ui-li-icon) {
            -webkit-border-bottom-left-radius: 50%;
            border-bottom-left-radius: 50%;
        }

        jquery.mobile-1

        .4
        .3
        .min.css:

        3
        .ui-listview > li.ui-first-child img:first-child:not(.ui-li-icon) {
            -webkit-border-top-left-radius: 50%;
            border-top-left-radius: 50%;
        }

        .ui-listview > li.ui-last-child img:first-child:not(.ui-li-icon) {
            -webkit-border-bottom-left-radius: 50%;
            border-bottom-left-radius: 50%;
        }

        .ui-listview > li.ui-first-child img:first-child:not(.ui-li-icon) {
            -webkit-border-top-left-radius: 50%;
            border-top-left-radius: 50%;
        }

        .swipe-delete li {
            background: #fff !important;
        }

        .behind {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            right: 0;
        }

        .behind a.ui-btn {
            width: 100px;
            margin: 0px;
            font-size: 15px;
            float: right;
            border: none;
            height: 70px;
            line-height: 70px;
        }
.ui-btn{    padding:0;border: none;}
        .behind a.delete-btn, .behind a.delete-btn:active, .behind a.delete-btn:visited, .behind a.delete-btn:focus, .behind a.delete-btn:hover {
            color: white;
            background-color: red;
            text-shadow: none;

        }

        .behind a.ui-btn.pull-left {
            float: left;
        }

        .behind a.edit-btn, .behind a.edit-btn:active, .behind a.edit-btn:visited, .behind a.edit-btn:focus, .behind a.edit-btn:hover {
            color: white;
            background-color: orange;
            text-shadow: none;
        }

        li {
            list-style: none;
        }

        .listnew {
            height: 70px;
            padding:3%;
            width: 94%;
            border-bottom: 1px solid #F1F1F1;
            background-color: #fff;
            display: inline-block;
        }

        .listnewimg {
            width: 50px;
            height: 50px;
            margin-right: 10px;
            float: left;
        }

        .listnewimg img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
        }

        .listnewword {
            float: left;
            width: 80%;
            position: relative;
        }

        .listname {
            width: 50%;
            font-size: 15px;
            color: #333333;
        }

        .listtime {
            width: 50%;
            font-size: 11px;
            color: #BBBBBB;
            text-align: right;
            line-height: 21px;
        }

        .listnewwordS {
            font-size: 12px;
            color: #BBBBBB;
            height: 31px;
        }

        .listnewnumber {
            padding: 2px 0px;
            min-width: 26px;
            min-height: 26px;
            text-align: center;
            background: red;
            position: absolute;
            bottom: 0;
            right: 0;
            font-size: 14px;
            color: #fff;
            border-radius: 50%;
            -border-radius: 50%;
            border-radius: 50%;
        }
        .ui-listview>.ui-li-static, .ui-listview>.ui-li-divider, .ui-listview>li>a.ui-btn{border: none;}
    </style>
@stop

@section('content')
    @foreach($log as $v)

        <ul data-role="listview" class="swipe-delete">
            <li>
                <div class="behind">
                    <a href="javascript:removeChat('{{route('chatDelete',['id'=>$v->id])}}')" class="ui-btn delete-btn">删除</a>
                </div>
                <a class="listnew clearfix" data-ajax="false" style="display: block;width: 100%;" href="{{url('wechat/chat/message/'.($user->id!=$v->send_user_id?$v->send_user_id:$v->accept_user_id))}}">
                    <div class="listnewimg"><img src="{{$v->acceptUser->img_url or ''}}" alt=""/></div>
                    <div class="listnewword">
                        <div class="clearfix">
                            <div class="fl listname"><span class="ellipsis1">{{$v->acceptUser->nickname or ''}}</span></div>
                            <div class="fr listtime">{{$v->create_time}}</div>
                        </div>
                        <div class="listnewwordS ellipsis2">
                            {{$v->first_message}}
                        </div>
                        @if($v->unread_count)
                            <span class="listnewnumber">{{$v->unread_count}}</span>
                        @endif
                    </div>
                </a>
            </li>
        </ul>

    @endforeach
@stop



@section('js')
    <script src="{{asset('asset/ext/dropload/dropload.min.js')}}"></script>
    <script src="{{asset('asset/wechat/js/remove/jquery.mobile-1.4.3.min.js')}}" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        function removeChat(url) {
            $.ajax({
                type: 'DELETE',
                url: url,
                data: {_token: '{{ csrf_token() }}'},
                dataType: 'json',
                success: function (data) {
                    if (data.status != 1) {
                        layer.msg('删除失败' + data.message);
                        return false;
                    } else {
                        location.reload();
                    }
                },
                error: function (xhr, type) {
                    layer.msg('删除失败' + xhr.message);
                },
            });
        }
        $(function () {

            function prevent_default(e) {
                e.preventDefault();
            }

            function disable_scroll() {
                $(document).on('touchmove', prevent_default);
            }

            function enable_scroll() {
                $(document).unbind('touchmove', prevent_default)
            }


            var x;
            $('.swipe-delete li > a')
                .on('touchstart', function (e) {
                    console.log(e.originalEvent.pageX)
                    $('.swipe-delete li > a').css('left', '0px') // close em all
                    $(e.currentTarget).addClass('open')
                    x = e.originalEvent.targetTouches[0].pageX // anchor point
                })
                .on('touchmove', function (e) {
                    var change = e.originalEvent.targetTouches[0].pageX - x
                    change = Math.min(Math.max(-100, change), 0) // restrict to -100px left, 0px right
                    e.currentTarget.style.left = change + 'px'
                    if (change < -10) disable_scroll() // disable scroll once we hit 10px horizontal slide
                })
                .on('touchend', function (e) {
                    var left = parseInt(e.currentTarget.style.left)
                    var new_left;
                    if (left < -35) {
                        new_left = '-100px'
                    } else if (left > 35) {
                        new_left = '100px'
                    } else {
                        new_left = '0px'
                    }
                    // e.currentTarget.style.left = new_left
                    $(e.currentTarget).animate({left: new_left}, 200)
                    enable_scroll()
                });

            {{--$('li .delete-btn').on('touchend', function (e) {--}}
                {{--e.preventDefault();--}}
                {{--console.log($(this).attr('url'));return;--}}
                {{--$.ajax({--}}
                    {{--type: 'DELETE',--}}
                    {{--url: $(this).attr('url'),--}}
                    {{--data: {_token: '{{ csrf_token() }}'},--}}
                    {{--dataType: 'json',--}}
                    {{--success: function (data) {--}}
                        {{--if (data.status != 1) {--}}
                            {{--layer.msg('删除失败' + data.message);--}}
                            {{--return false;--}}
                        {{--} else {--}}
                            {{--location.reload();--}}
                        {{--}--}}
                    {{--},--}}
                    {{--error: function (xhr, type) {--}}
                        {{--layer.msg('删除失败' + xhr.message);--}}
                    {{--},--}}
                {{--});--}}
            {{--})--}}

        });
    </script>
    <script>
        $(function () {
            if ($(".listnewnumber").text().length > 3) {
                $(".listnewnumber").html("...");
                $(".listnewnumber").css({"height": "26px", "line-height": "11px"});
            }
        })
    </script>
@stop
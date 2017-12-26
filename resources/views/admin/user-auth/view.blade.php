@extends('admin.layout.master')

@section('title','审核资料详情')

@section('css')
    <link href="{{asset('asset/admin/css/plugins/blueimp/css/blueimp-gallery.min.css')}}" rel="stylesheet">
@stop

@section('content')
    <div class="ibox-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="m-b-md">
                    <a href="javascript:history.go(-1)" class="btn btn-primary pull-right" style="width: 80px;height: 100%;margin-bottom: 0px;">返回</a>
                    <h2>审核资料详情</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5" id="cluster_info">
                <dl class="dl-horizontal">

                    <dt>用户昵称：</dt>
                    <dd>{{$row->user->nickname or ''}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>姓名：</dt>
                    <dd>{{$row->name}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>手机号：</dt>
                    <dd>{{$row->mobile}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>省份证号：</dt>
                    <dd>{{$row->idcard}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>提交时间：</dt>
                    <dd>{{$row->create_time}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>审核时间：</dt>
                    <dd>{{$row->check_time}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>状态：</dt>
                    <dd>{{$status[$row->status] or ''}}</dd>
                    <div class="hr-line-dashed"></div>
                </dl>
            </div>
            <div class="feed-element">
                <strong>身份证图片</strong>
                <div id="links">
                    <a href="{{$row->frontImg->url or ''}}" title="身份证正面">
                        <img alt="身份证正面" class="feed-photo" src="{{$row->frontImg->url or ''}}">
                    </a>
                    <a href="{{$row->reverseImg->url or ''}}" title="身份证反面">
                        <img alt="身份证反面" class="feed-photo" src="{{$row->reverseImg->url or ''}}">
                    </a>
                </div>

                <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
                    <div class="slides" style="width: 37944px;"></div>
                    <h3 class="title">身份证图片</h3>
                    <a class="prev">‹</a>
                    <a class="next">›</a>
                    <a class="close">×</a>
                    <a class="play-pause"></a>
                    <ol class="indicator"></ol>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{asset('asset/admin/js/plugins/blueimp/jquery.blueimp-gallery.min.js')}}"></script>
    <script>
        document.getElementById('links').onclick = function (event) {
            event = event || window.event;
            var target = event.target || event.srcElement,
                link = target.src ? target.parentNode : target,
                options = {index: link, event: event},
                links = this.getElementsByTagName('a');
            blueimp.Gallery(links, options);
        };

    </script>
@stop
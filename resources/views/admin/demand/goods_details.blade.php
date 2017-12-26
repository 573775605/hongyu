@extends('admin.layout.master')

@section('title','商品详情')

@section('css')
    <link href="{{asset('asset/admin/css/plugins/blueimp/css/blueimp-gallery.min.css')}}" rel="stylesheet">
@stop

@section('content')
    <div class="ibox-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="m-b-md">
                    <a href="javascript:history.go(-1)" class="btn btn-primary pull-right" style="width: 80px;height: 100%;margin-bottom: 0px;">返回</a>
                    <h2>商品详情</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5" id="cluster_info">
                <dl class="dl-horizontal">

                    <dt>商品名称：</dt>
                    <dd>{{$goods->name}}</dd>
                    <div class="hr-line-dashed"></div>

                    {{--<dt>商品规格：</dt>--}}
                    {{--<dd>{{$goods->sku_name}}</dd>--}}
                    {{--<div class="hr-line-dashed"></div>--}}

                    <dt>商品分类：</dt>
                    <dd>{{$goods->goodsCategory->name or ''}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>货源：</dt>
                    <dd>{{$goods->source}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>商品单价：</dt>
                    <dd>{{$goods->known_unit_price}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>购买数量：</dt>
                    <dd>{{$goods->count}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>指定商家：</dt>
                    <dd>{{$goods->getSite()}} {{$goods->store_name}}</dd>
                    <div class="hr-line-dashed"></div>

                    <dt>备注说明：</dt>
                    <dd>{{$goods->remark}}</dd>
                    <div class="hr-line-dashed"></div>
                </dl>
            </div>
            <div class="feed-element">
                <strong>商品图片</strong>
                <div id="links">
                    @foreach($goods->imgs as $v)
                        <a href="{{$v->url}}" title="商品图片">
                            <img alt="商品图片" class="feed-photo" src="{{$v->url}}">
                        </a>
                    @endforeach
                </div>

                <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
                    <div class="slides" style="width: 37944px;"></div>
                    <h3 class="title">商品图片</h3>
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
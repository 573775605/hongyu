@extends('wechat.layout.master')

@section('title','物流跟踪')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/mingxi.css')}}"/>
@stop

@section('content')
    <div id="dropload">
        <ul class="MlevelList" id="list" style="width: 100%">
            @foreach($rows as $v)
                <li>
                    <p class="MlevelListword1">{{$v['AcceptTime']}}</p>
                    <div class="MlevelListword2" style="width: 100%">
                        <dl class="MXdlall2 borderB clearfix">
                            <dd style="padding: 10px 0;font-size: 14px;">{{$v['AcceptStation']}}</dd>
                        </dl>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@stop

@section('js')

@stop
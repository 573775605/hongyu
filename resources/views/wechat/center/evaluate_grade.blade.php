@extends('wechat.layout.master')

@section('title','我的评分等级')

@section('content')
    <div id="testel">
        <a href="{{url('wechat/center/evaluate-grade-log?type=issue')}}" class="disb jiantou  ">
            <dl class="OrderLogistics3 clearfix">
                <dt>红利需求等级：</dt>
                <dd>
                    <div class="Bstart{{$user->daigou_evaluate_avg_grade}}">

                    </div>
                </dd>
            </dl>
        </a>

        <a href="{{url('wechat/center/evaluate-grade-log?type=hotboom')}}" class="disb jiantou  ">
            <dl class="OrderLogistics3 clearfix">
                <dt>红利分享等级：</dt>
                <dd>
                    <div class="Bstart{{$user->evaluate_avg_grade}}">

                    </div>
                </dd>
            </dl>
        </a>
    </div>
@stop
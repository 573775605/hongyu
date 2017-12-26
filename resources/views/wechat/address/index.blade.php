@extends('wechat.layout.master')

@section('title','收货地址列表')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/adress.css')}}"/>
@stop

@section('body','bgf6')

@section('content')
    <ul class=" adresswrite ">
        @if(request('type')=='issue-demand')
            @foreach($rows as $v)
                <li class="checkhid1 {{$v->is_default?'jiantour':''}}" onclick="location.href='{{url('wechat/issue/index?action=type&address_id='.$v->id)}}'">
                    <p class="clearfix f15c1f "><span class="fl">收货人：{{$v->name}}</span><span class="fr">{{$v->phone}}</span></p>
                    <p class="ellipsisTwo f12c64 mtb5 addMO">
                        {!! $v->is_default?'<em class="Mo">[默认]</em>':'' !!}收货地址：{{$v->province.$v->city.$v->area.$v->address}}
                    </p>
                </li>
            @endforeach
        @elseif(request('type')=='copy-demand')
            @foreach($rows as $v)
                <li class="checkhid1 {{$v->is_default?'jiantour':''}}" onclick="location.href='{{url('wechat/demand/copy-demand?address_id='.$v->id)}}'">
                    <p class="clearfix f15c1f "><span class="fl">收货人：{{$v->name}}</span><span class="fr">{{$v->phone}}</span></p>
                    <p class="ellipsisTwo f12c64 mtb5 addMO">
                        {!! $v->is_default?'<em class="Mo">[默认]</em>':'' !!}收货地址：{{$v->province.$v->city.$v->area.$v->address}}
                    </p>
                </li>
            @endforeach
        @else
            @foreach($rows as $v)
                <li class="checkhid1">
                    <p class="clearfix f15c1f "><span class="fl">收货人：{{$v->name}}</span><span class="fr">{{$v->phone}}</span></p>
                    <p class="ellipsisTwo f12c64 mtb5 addMO">
                        {!! $v->is_default?'<em class="Mo">[默认]</em>':'' !!}收货地址：{{$v->province.$v->city.$v->area.$v->address}}
                    </p>
                    <div class="clearfix bianji">
                        <a class="fr" href="{{url('wechat/address/edit/'.$v->id)}}">
                            <em class="write">编辑</em>
                        </a>
                        <span class="fr"><em class="del" onclick="removeAddress({{$v->id}})">删除</em></span>
                        @if(!$v->is_default)
                            <span class="fr setMo" onclick="setDefault({{$v->id}})">设为默认</span>
                        @endif
                    </div>
                </li>
            @endforeach
        @endif
    </ul>

    <div class="addAdress" onclick="location.href='{{url('wechat/address/add?type='.request('type'))}}'">
        <input type="button" value="新增收件人地址"/>
    </div>
@stop

@section('js')
    <script src="{{asset('asset/ext/layer/layer.min.js')}}"></script>
    <script type="text/javascript">
        function setDefault(id) {
            $.post("{{url('wechat/address/set-default')}}/" + id,
                {_token: '{{csrf_token()}}'},
                function (data, status) {
                    if (data.status != 1) {
                        layer.msg(data.message);
                    } else {
                        location.reload();
                    }
                });
        }

        function removeAddress(id) {
            if (confirm('你确定要删除吗？')) {
                $.post("{{url('wechat/address/remove')}}/" + id,
                    {_token: '{{csrf_token()}}'},
                    function (data, status) {
                        if (data.status != 1) {
                            layer.msg(data.message);
                        } else {
                            location.reload();
                        }
                    });
            }
        }
    </script>
@stop

@extends('wechat.layout.master')

@section('title','银行卡列表')

@section('content')
    <div style="height:10px;"></div>
    <div class="bgfff">
        @foreach($rows as $v)
            <div class="addcarall">
                <dl class="addcar clearfix">
                    <dt class="clearfix">
                    <div class="fl">姓名：</div>
                    <div class="fl" style="width: 80%;">
                        <span class="ellipsis1 addcarword1">{{$v->name}}</span>
                    </div>
                    </dt>
                    <dd>银行：<span class="addcarword1">{{$v->bank_name}}</span></dd>
                </dl>
                <dl class="addcar clearfix">
                    <dt class="clearfix">
                    <div class="fl">
                        卡号：
                    </div>
                    <div class="fl">
                        <span class="ellipsis1 addcarword1">{{$v->account}}</span>
                    </div>
                    </dt>
                    <dd onclick="removeNumber({{$v->id}})"><em class="delcar">删除</em></dd>
                </dl>
            </div>
        @endforeach
    </div>
    <a class="redbtn90" href="{{url('wechat/wallet/add-bank')}}">
        <input type="button" value="添加"/>
    </a>
@stop

@section('js')
    <script>
        function removeNumber(id) {
            if (confirm('确定要删除此银行卡')) {
                $.post("{{url('wechat/wallet/remove-bank')}}/" + id,
                    {_token: '{{csrf_token()}}'},
                    function (data, status) {
                        if (data.status != 1) {
                            alert(data.message);
                        } else {
                            location.reload();
                        }
                    });
            }
        }
    </script>
@stop
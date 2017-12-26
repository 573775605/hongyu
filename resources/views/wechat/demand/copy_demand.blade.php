@extends('wechat.layout.master')

@section('title','跟单需求')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/AddSubtract.css')}}"/>
@stop

@section('content')
    <p class="fabuing">收件人地址</p>
    <a class="XQ2adress " href="{{url('wechat/address?type=copy-demand')}}">
        <div class="clearfix XQ2adressword1">
            <div class="fl">收货人：{{$address->name}}</div>
            <div class="fr">{{$address->phone}}</div>
        </div>
        <div class="XQ2adressword2 ellipsis2">
            收货地址：{{$address->province.$address->city.$address->area.$address->address}}
        </div>
    </a>
    <form action="" method="post" onsubmit="return checkForm()">
        {!! csrf_field() !!}
        <input type="hidden" name="address_id" value="{{$address->id}}">
        <dl class="offers clearfix">
            <dt class="mt5">备注说明：</dt>
            <dd>
                <div class="border ">
                    <input type="text" name="remark" placeholder="如颜色、规格、尺寸、发票等"/>
                </div>
            </dd>
        </dl>

        <dl class="offers clearfix">
            <dt class="mt5">需求数量：</dt>
            <dd>
                <div class="NBnumall clearfix ">
                    <span class="reduce"></span>
                    <input class="NBnumtext quantity" type="number" name="count" value="1">
                    <span class="plus"></span>
                </div>
            </dd>
        </dl>
        <a class="Bluebtn90">
            <input type="submit" name="" id="" value="确认跟单"/>
        </a>
    </form>
@stop

@section('js')
    <script>
        var flag = false;
        function checkForm() {
            if (flag === true) {
                return false;
            }
            flag = true;
            return true;
        }
        function changeCount(obj, count, defaultVal) { //改变数量
            var nowCount = $(obj).find('.quantity').val();
            nowCount = parseInt(nowCount) + count;
            if (nowCount > 0) {
                if (nowCount >{{$repertory?:1}}) {
                    $(obj).find('.quantity').val({{$repertory?:1}});
                } else {
                    $(obj).find('.quantity').val(nowCount);
                }
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
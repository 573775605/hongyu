@if($type=='balance')
    @foreach($rows as $v)
        <li>
            <p class="MlevelListword1">{{$v->create_time}}</p>
            <div class="MlevelListword2">
                @if($v->demand_id)
                    <dl class="MXdlall borderB clearfix">
                        <dt>订单号：</dt>
                        <dd>{{$v->demand->order_number}}</dd>
                    </dl>
                @endif
                <dl class="MXdlall clearfix">
                    <dt>{{$v->remark}}：</dt>
                    <dd><span class="{{$v->change_balance>0?'Mlevelgreen':'Mlevelred'}}">¥{{$v->change_balance}}</span></dd>
                </dl>
            </div>
        </li>
    @endforeach
@elseif($type=='pledge')
    @foreach($rows as $v)
        <li>
            <p class="MlevelListword1">{{$v->create_time}}</p>
            <div class="MlevelListword2">
                @if($v->demand_id)
                    <dl class="MXdlall borderB clearfix">
                        <dt>订单号：</dt>
                        <dd>{{$v->demand->order_number}}</dd>
                    </dl>
                @endif
                <dl class="MXdlall clearfix">
                    <dt>{{$v->remark}}：</dt>
                    <dd><span class="{{$v->change_pledge>0?'Mlevelgreen':'Mlevelred'}}">¥{{$v->change_pledge}}</span></dd>
                </dl>
            </div>
        </li>
    @endforeach
@elseif($type=='hotboom-balance')
    @foreach($rows as $v)
        <li>
            <p class="MlevelListword1">{{$v->create_time}}</p>
            <div class="MlevelListword2">
                @if($v->demand_id)
                    <dl class="MXdlall borderB clearfix">
                        <dt>订单号：</dt>
                        <dd>{{$v->demand->order_number}}</dd>
                    </dl>
                @endif
                <dl class="MXdlall clearfix">
                    <dt>{{$v->remark}}：</dt>
                    <dd><span class="{{$v->change_balance>0?'Mlevelgreen':'Mlevelred'}}">¥{{$v->change_balance}}</span></dd>
                </dl>
            </div>
        </li>
    @endforeach
@elseif($type=='spare')
    @foreach($rows as $v)
        <li>
            <p class="MlevelListword1">{{$v->create_time}}</p>
            <div class="MlevelListword2">
                <dl class="MXdlall borderB clearfix">
                    <dt>订单号：</dt>
                    <dd>{{$v->demand->order_number or ''}}</dd>
                </dl>
                <dl class="MXdlall borderB clearfix">
                    <dt>已知订单总额：</dt>
                    <dd><span class="Mlevelred">¥{{$v->demand->known_price or ''}}</span></dd>
                </dl>
                <dl class="MXdlall borderB clearfix">
                    <dt>支付代购总额：</dt>
                    <dd><span class="Mlevelyellow">¥{{$v->demand->price or ''}}</span></dd>
                </dl>
                <dl class="MXdlall  clearfix">
                    <dt>节省金额：</dt>
                    <dd><span class="Mlevelgreen">¥{{$v->change_price}}</span></dd>
                </dl>
            </div>
        </li>
    @endforeach
@endif
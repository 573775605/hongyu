@foreach($evaluate as $v)
    <li>
        <p class="MlevelListword1">{{$v->create_time}}</p>
        <div class="MlevelListword2">
            <dl class="MXdlall borderB clearfix">
                <dt>订单号：</dt>
                <dd>{{$v->demand->order_number or ''}}</dd>
            </dl>

            <dl class="MXdlall clearfix">
                <dt>购买商品获得：</dt>
                @if(request('type')=='issue')
                    <dd><span class="Mlevelgreen">+ {{$v->grade}}</span></dd>
                @else
                    <dd><span class="Mlevelgreen">+ {{$v->avg_grade}}</span></dd>
                @endif
            </dl>
        </div>
    </li>
@endforeach
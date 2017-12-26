@foreach($rows as $v)
<li class="clearfix">
    <div class="evaluateUlimg">
        <img src="{{$v->evaluateUser->img_url or ''}}"/>
    </div>
    <div class="evaluateUlR">
        <div class="clearfix evaluateUltit">
            <div class="fl evaluateUltit1">
                <span class="ellipsis1">{{$v->evaluateUser->nickname or ''}}</span>
            </div>
            <div class="fr evaluateUltit2">
                <span class="ellipsis1">{{$v->create_time}}</span>
            </div>
        </div>
        <div class="evaluateUltit3 ellipsis1">
            {{$v->content}}
        </div>
    </div>
</li>
@endforeach
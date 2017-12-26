@foreach($message as $v)
    <div class="clearfix mt10">
        <div class="fl XQdata">
            {{$v->create_time}}
        </div>
        <div class="fr">
            <div class="XQbtnselectred" onclick="delMessage({{$v->id}})">
                <input type="button" value="删除"/>
            </div>
        </div>
    </div>
    <div class="XQnewcontall">
        <div class="XQnewcontit ellipsis1">
            {{$v->title}}
        </div>
        <div class="XQnewcont">
            {{$v->content}}
        </div>
    </div>
@endforeach
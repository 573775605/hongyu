@foreach($message as $v)
    @if($user->id==$v->send_user_id)
        <div class="clearfix chartcont">
            <div class="touxiangimgR">
                <img src="{{$v->sendUser->img_url or ''}}"/>
            </div>
            <div class="fr chartmine">
                @if(filter_var($v->content,FILTER_VALIDATE_URL))
                    <a href="{{$v->content}}">{{$v->content}}</a>
                @else
                    <input type="text" readonly="readonly" value="{{$v->content}}">
                @endif
                @if($v->img)
                    <img src="{{$v->img->url}}"/>
                @endif
            </div>
            <div class="clearfix"></div>
            <p class="fr chartMtime">{{$v->create_time}}</p>
        </div>
    @else
        <div class="clearfix chartcont">
            <div class="touxiangimgL">
                <img src="{{$v->sendUser->img_url or ''}}"/>
            </div>
            <div class="fl chartother">
                @if(filter_var($v->content,FILTER_VALIDATE_URL))
                    <a href="{{$v->content}}">{{$v->content}}</a>
                @else
                    <input type="text" readonly="readonly" value="{{$v->content}}">
                @endif
                @if($v->img)
                    <img src="{{$v->img->url}}"/>
                @endif
            </div>
            <div class="clearfix"></div>
            <p class="fl chartOtime">{{$v->create_time}}</p>
        </div>
    @endif
@endforeach

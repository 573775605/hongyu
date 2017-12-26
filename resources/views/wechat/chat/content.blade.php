<div class="clearfix chartcont">
    <div class="touxiangimgR">
        <img src="{{$user->img_url or ''}}"/>
    </div>
    <div class="fr chartmine">
        {{$content->content}}
        @if($content->img)
            <img src="{{$content->img->url}}"/>
        @endif
    </div>
    <div class="clearfix"></div>
    <p class="fr chartMtime">{{$content->create_time}}</p>
</div>
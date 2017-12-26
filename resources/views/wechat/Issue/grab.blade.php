<input type="hidden" name="goods_name" value="{{$result['name'] or ''}}">
<input type="hidden" name="price" value="{{$result['price'] or ''}}">
<input type="hidden" name="link" value="{{$url}}">
<input type="hidden" name="domain" value="{{$domain}}">
@if(!empty($result['img']))
    @foreach($result['img'] as $k=>$v)
        <input type="hidden" name="imgs[{{$k}}][id]" value="{{$v['id'] or ''}}">
        <input type="hidden" name="imgs[{{$k}}][url]" value="{{$v['url'] or ''}}">
    @endforeach
@endif
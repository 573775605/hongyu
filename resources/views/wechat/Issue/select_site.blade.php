<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>商家搜索</title>
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/public.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/mui.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('asset/wechat/css/index.css')}}"/>
    <style type="text/css">
        * {
            margin: 0px;
            padding: 0px;
        }

        body, button, input, select, textarea {
            font: 12px/16px Verdana, Helvetica, Arial, sans-serif;
        }

        #container {
            min-width: 603px;
            min-height: 767px;
        }

        #icon {
            width: 50px;
            height: 50px;
            position: fixed;
            bottom: 0;
            left: 0;

        }
    </style>
</head>
<body>
<div class=" searchtopmap">
    <div class="clearfix"    style=" padding: 10px 3%;">
    <p style="color: red;font-size: 10px;">*单击商家所在地图区块选中位置(备注:搜索商家位置请加上省/市名称)</p>

    <div class="fl searchmap">
        <input type="text" placeholder="请输入省市+详细地址" id="keyword">
    </div>
    <div class="fr redcityfabu" style="width: 28%">
        <input type="button" value="搜索" onclick="search()">
    </div>
    </div>
</div>
</div>
    @if(request('select_type')=='other_store')
        <form action="{{url('wechat/tender/select-advantage?tender_id='.request('tender_id'))}}" method="post" id="form">
            @foreach(request()->input() as $k=>$v)
                @if($k!='advantage')
                    <input type="hidden" name="{{$k}}" value="{{$v}}">
                @endif
            @endforeach
        </form>
    @endif
</div>
<div id="container" style="width: 100%!important;"></div>
<img src="{{asset('asset/wechat/img/location-icon.png')}}" alt="" id="icon">
</body>
</html>
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<script type="text/javascript" src="https://apis.map.qq.com/tools/geolocation/min?key={{env('TENCENT_MAP_KEY')}}&referer={{env('TENCENT_MAP_NAME')}}"></script>
<script src="{{asset('asset/wechat/js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
<script>
    var center = new qq.maps.LatLng({{$user->data->lat?:31.226059}}, {{$user->data->lng?:121.496475}});
    //地图内容
    var map = new qq.maps.Map(document.getElementById("container"), {
        center: center,
        scrollwheel: true,
        zoom: 15
    });
    //定位对象
    var geolocation = new qq.maps.Geolocation();
    geolocation.getIpLocation(function (location) {
        center = new qq.maps.LatLng({{$user->data->lat?:'location.lat'}}, {{$user->data->lng?:'location.lng'}})
        map.panTo(center);
        {{--var anchor = new qq.maps.Point(0, 39),--}}
        {{--size = new qq.maps.Size(50, 80),--}}
        {{--origin = new qq.maps.Point(0, 0),--}}
        {{--icon = new qq.maps.MarkerImage(--}}
        {{--"{{asset('asset/wechat/img/location.png')}}",--}}
        {{--);--}}
        {{--var marker = new qq.maps.Marker({--}}
        {{--map: map,--}}
        {{--position: center--}}
        {{--});--}}
        {{--marker.setIcon(icon);--}}
    }, function () {

    });

    $('#icon').click(function () {
        map.panTo(center);
    });

    function search() {
        var keyword = $('#keyword').val();
        if (keyword == '') {
            alert('请输入关键字');
            return false;
        }
//        searchService.setLocation("成都");
        searchService.search(keyword);
    }
    //添加定位控件
    map.controls[qq.maps.ControlPosition.LEFT_CENTER].push(document.getElementById('icon'));
    //绑定单击事件添加参数
    @if(request('select_type')=='issue_store')
    qq.maps.event.addListener(map, 'click', function (event) {
        var lat = event.latLng.getLat().toFixed(6);
        var lng = event.latLng.getLng().toFixed(6);
        if (confirm('确认商家位置吗?')) {
                    @if(request('goods_id'))
            var url = '{{url('wechat/demand/edit/'.request('goods_id'))}}?store_lng=' + lng + '&store_lat=' + lat;
                    @else
            var url = '{{url('wechat/issue/index')}}?store_lng=' + lng + '&store_lat=' + lat;
            @endif
                location.href = url;
        }
    });
    @else
    qq.maps.event.addListener(map, 'click', function (event) {
        var lat = event.latLng.getLat().toFixed(6);
        var lng = event.latLng.getLng().toFixed(6);
        if (confirm('确认商家位置吗?')) {
            $('input[name=hotboom_lng]').val(lng);
            $('input[name=hotboom_lat]').val(lat);
            $('#form').submit();
        }
    });
    @endif
    //关键字搜索
    var latlngBounds = new qq.maps.LatLngBounds();
    var searchService = new qq.maps.SearchService({
        pageCapacity: 5,
        complete: function (results) {
            console.log(results);
            var pois = results.detail.pois;
            if (typeof(pois) == 'undefined') {
                alert('没有搜索结果,请输入详细关键字');
                return false;
            }
            for (var i = 0, l = pois.length; i < l; i++) {
                var poi = pois[i];
//                latlngBounds.extend(poi.latLng);
                var marker = new qq.maps.Marker({
                    map: map,
                    position: poi.latLng
                });
                var text = new qq.maps.Label({
                    position: poi.latLng,
                    map: map,
                    content: poi.address
                });

//                marker.setTitle(i + 1);
//
//                markers.push(marker);
            }
//            map.fitBounds(latlngBounds);
            map.setCenter(poi.latLng);
        },
        error: function () {
            alert("出错了。");
        }
    });
</script>


<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <link rel="stylesheet" type="text/css" href="{{asset('asset/web/css/jquery.fullPage.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('asset/web/css/public.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('asset/web/css/index.css')}}"/>
</head>
<body>

<div id="fullpage">


    <!--固定导航-->
    <div class="menu fr clearfix">
        <ul class="menuall">
            <li class="fl">
                <div class="logoimg">
                    <img src="{{asset('asset/web/img/1.png')}}"/>
                </div>
            </li>
            <ul class="fr">
                <Li data-menuanchor="page1" class="active"><a href="#page1">首页</a></Li>
                <Li data-menuanchor="page2"><a href="#page2">关于我们</a></Li>
                <Li data-menuanchor="page3"><a href="#page3">意见反馈</a></Li>
            </ul>
        </ul>
    </div>

    <div class="section clearfix">
        <div class="bgimg">
        </div>

        <div class="bottomword">
            <p>
                © 2015-2017 www.c2c.com.cn All Rights Reserved. 红鱼 版权所有
            </p>
        </div>
    </div>
    <div class="section">
        <div class="bgimg2">
        </div>

        <div class="w800 bgimg2cont">
            <div class="slogo">
                <img src="{{asset('asset/web/img/6.png')}}"/>
            </div>
            <div class="clearfix aboutusall">
                <div class="fl aboutusword">
                    红鱼网是国内首家以需求为导向的个人红利对接平台，为全国用户提供健康、合规和公平的一站式服务。在红鱼，消费用户可以获得额外折扣，而红利用户可以实现资源转让。
                    红鱼网背靠实力雄厚的上海三将科技有限公司，由一批具有互联网多年深耕经验的团队运营，积极响应李克强总理倡导的分享经济理念，推动资源共享，让平台用户充分享受互联网经济带来的收获和便利。
                    红鱼网还特别注意保护用户隐私，承诺不泄漏任何消费用户或红利的个人信息，用户双方在红鱼可以尽情、安全的交易。
                </div>
                <div class="fr aboutusimg">
                    <img src="{{asset('asset/web/img/4.png')}}" width="80%"/>
                </div>
            </div>

        </div>

        <div class="bottomword">
            <p>
                © 2015-2017 www.c2c.com.cn All Rights Reserved. 红鱼 版权所有
            </p>
        </div>
    </div>
    <div class="section">
        <div class="bgimg3"></div>

        <div class="w800 bgimg3cont">
            <div class="slogo">
                <img src="{{asset('asset/web/img/7.png')}}"/>
            </div>

            <ul class="qusetion">
                <li>
                    <div class="inputext">
                        <input type="text" placeholder="你的姓名"/>
                    </div>
                </li>
                <li>
                    <div class="inputext">
                        <input type="number" placeholder="你的电话"/>
                    </div>
                </li>
                <li>
                    <div class="fankui">
                        <textarea placeholder="你所反馈的问题..."></textarea>
                    </div>
                </li>
                <li>
                    <div class="tijiao">
                        <input type="button" value="提交"/>
                    </div>
                </li>
            </ul>

        </div>

        <div class="bottomword">
            <p>
                © 2015-2017 www.c2c.com.cn All Rights Reserved. 红鱼 版权所有
            </p>
        </div>
    </div>

</div>

<script type="text/javascript" src="{{asset('asset/web/js/jquery-1.11.1.js')}}"></script>
<script type="text/javascript" src="{{asset('asset/web/js/jquery.fullPage.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {

        $('#fullpage').fullpage({

            sectionsColor: ['orange', '#5c7ff1', 'green', '#cccccc'], //控制每个section的背景颜色

            controlArrow: true,   //是否隐藏左右滑块的箭头(默认为true)

            verticalCentered: true,  //内容是否垂直居中(默认为true)

            css3: true, //是否使用 CSS3 transforms 滚动(默认为false)

            resize: false, //字体是否随着窗口缩放而缩放(默认为false)

            scrolllingSpeed: 1000,  //滚动速度，单位为毫秒(默认为700)

            anchors: ['page1', 'page2', 'page3'],  //定义锚链接(值不能和页面中任意的id或name相同，尤其是在ie下，定义时不需要加#)

            lockAnchors: false,  //是否锁定锚链接，默认为false。设置weitrue时，锚链接anchors属性也没有效果。

            loopBottom: false,  //滚动到最底部后是否滚回顶部(默认为false)

            loopTop: false, //滚动到最顶部后是否滚底部

            loopHorizontal: false,//左右滑块是否循环滑动

            autoScrolling: true, // 是否使用插件的滚动方式，如果选择 false，则会出现浏览器自带的滚动条

            scrollBar: false,//是否显示滚动条，为true是一滚动就是一整屏

            fixedElements: ".logo", //固定元素

            menu: ".menu",

            keyboardScrolling: true, //是否使用键盘方向键导航(默认为true)

            keyboardScrolling: true, //页面是否循环滚动（默认为false）

            navigation: true, //是否显示项目导航（默认为false）

            navigationTooltips: ["page1", "page2", "page3"],//项目导航的 tip

            navigationColor: '#d3d5e0', //项目导航的颜色

            slidesNavigation: true,

        });

    });
</script>

</body>
</html>

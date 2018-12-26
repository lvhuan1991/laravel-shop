<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{my_config('website.site_name')}}</title>
    <link rel="icon" type="text/css" href="{{asset('org/home')}}/icon.ico"/>
    <script src="{{asset('org/home')}}/js/jquery-1.10.1.min.js" type="text/javascript" charset="utf-8"></script>
    @stack('css')
    {{--@stack('js')--}}
    {{--放这里会造成vue不解析，放到下面去--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        })
    </script>
    <link rel="stylesheet" href="{{asset ('org/layui/css/layui.css')}}">
</head>

<body>
<!--头部开始-->
<div id="top">
    <!--头部灰条就开始-->
    <div class="topbox">
        <div class="main">
            <div class="topleft fl">
                <a href="javascript:;">欢迎来到冰雨商城</a>
                <a href="#">设为首页</a>
                <a href="#">收藏本站</a>
                <a href="#">帮助中心</a>
                <a href="#" class='last'><i></i>手机商城</a>
            </div>
            <div class="topright fr">
                <div class="login fl">
                    @auth()
                        {{--<a href="#" class="avatar avatar-sm avatar-online dropdown-toggle" role="button"--}}
                        {{--data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                        {{--<img src="{{auth()->user()->icon}}" alt="..." class="avatar-img rounded-circle">--}}
                        {{--</a>--}}
                        <a href="{{route('home.personal_center')}}">{{auth ()->user ()->name}}</a>
                        <a href="{{route('user.logout',['from'=>url ()->full()])}}">注销</a>
                    @else
                        <a href="{{route('user.login',['from'=>url ()->full()])}}">登录</a>
                        <a href="{{route('user.register')}}">注册</a>
                    @endauth
                </div>
                <span class="fl">|</span>
                <div class="fcode fl">

                    <a href="{{route('home.personal_center',['from'=>url()->full()])}}">我的订单</a>
                </div>
            </div>
        </div>
    </div>
    <!--头部灰条结束-->

    <!--logo区域开始-->
    <div class="logoRegion">
        <div class="main">
            <div class="logo">
                <a href="{{route('index')}}"><img src="{{asset('org/home')}}/images/360logo.png"/></a>
            </div>
            <div class="seachRegion">
                <div class="seach fl">
                    <form action="{{route('home.search')}}">
                        <input type="text" name="sid" class="seachtxt fl" value="{{request()->query('sid')}}" placeholder="搜索..."/>
                        <input type="submit" class="btn" value=""/>
                    </form>
                    <p class="searchkey">
                        @foreach($_keywords as $keyword)
                            <a href="{{route('home.search',['sid'=>$keyword['sid']])}}">{{$keyword['sid']}}</a>
                        @endforeach
                    </p>

                </div>
                <div class="topshopcart fr">
                    <a href="{{route('home.cart.index',['from'=>url()->full()])}}" class="header-cart"><i></i>我的购物车<span class="cart-size">(0)</span></a>
                    <div class="cart-tips">
                        请
                        <a href="">登录</a>后查看您的购物车。
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--logo区域结束-->
    <!--导航开始-->
    <div class="navbox">
        <div class="main">
            <h5 class="fl"><a href=""><i></i>全部智能酷品</a></h5>
            <ul class="menu fl">
                @foreach($_categories as $category)
                    <li class="menulist">
                        <a href="{{route('home.list',['list'=>$category['id']])}}">{{$category['name']}}</a>
                        @if($category->good->count() !=0)
                            <div class="menuHiden">
                                <ul class="product">
                                    {{--@foreach($category->good as $good)--}}
                                    @foreach($category->good()->limit(5)->get() as $good)
                                        <li>
                                            <a href="{{route('home.content',['content'=>$good['id']])}}"><img
                                                    src="{{$good->list_pic}}" alt=""/></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>

        </div>
        {{--左侧二级菜单--}}
        @yield('menu')
    </div>
    <!--导航结束-->
    <div class="clear"></div>
    <!--banner开始 轮播图-->
@yield('swiper')
<!--banner结束-->
</div>
<!--头部结束-->
<!--中间开始-->
@yield('content')
<!--中间结束-->

<!--尾部开始-->
<div class="mod-footer">
    <div class="foot-bannerw">
        <div class="foot-banner clearfix">
            <div class="banner-item">
                <a href="#" target="_blank" data-monitor="home_foot_days7"><i class="icon1">7</i>7天无理由退货</a>
            </div>
            <div class="banner-item">
                <a href="#" target="_blank" data-monitor="home_foot_days15"><i class="icon2">15</i>15天免费换货</a>
            </div>
            <div class="banner-item"><i class="icon3">包</i>满99元包邮</div>
            <div class="banner-item">
                <a href="#" target="_blank" data-monitor="home_foot_moblie"><i class="icon4">服</i>手机特色服务</a>
            </div>
        </div>
    </div>
    <div class="foot-containerw">
        <div class="foot-container clearfix">
            <dl class="foot-con">
                <dt data-monitor="home_foot_freshman">帮助中心</dt>
                <dd data-monitor="home_help_freshman">
                    <a target="_blank" href="#" rel="nofollow">用户注册</a>
                </dd>
                <dd>
                    <a target="_blank" href="#" rel="nofollow">用户登录与密码找回</a>
                </dd>
                <dd>
                    <a target="_blank" href="#" rel="nofollow">购买指南</a>
                </dd>
                <dd>
                    <a target="_blank" href="#" rel="nofollow">支付方式</a>
                </dd>
                <dd>
                    <a target="_blank" href="#" rel="nofollow">配送与说明</a>
                </dd>
            </dl>
            <dl class="foot-con">
                <dt data-monitor="home_foot_help">售后服务</dt>
                <dd data-monitor="home_help_help">
                    <a target="_blank" href="#">7 日无理由退货</a>
                </dd>
                <dd>
                    <a target="_blank" href="#" rel="nofollow">质量问题 15 日内换货</a>
                </dd>
                <dd>
                    <a target="_blank" href="#" rel="nofollow">保修条款</a>
                </dd>
                <dd>
                    <a target="_blank" href="#" rel="nofollow">服务流程</a>
                </dd>
                <dd>
                    <a target="_blank" href="#" rel="nofollow">安迷之家</a>
                </dd>
            </dl>
            <dl class="foot-con">
                <dt data-monitor="home_foot_guide">特色服务</dt>
                <dd data-monitor="home_help_guide">
                    <a target="_blank" href="#" rel="nofollow">F码通道</a>
                </dd>
                <dd>
                    <a target="_blank" href="#" rel="nofollow">免费试用</a>
                </dd>
                <dd>
                    <a target="_blank" href="#" rel="nofollow">360 生态</a>
                </dd>
                <dd>
                    <a target="_blank" href="#" rel="nofollow">一元夺宝</a>
                </dd>
            </dl>
            <dl class="foot-con">
                <dt data-monitor="home_foot_tuiguang">推广合作</dt>
                <dd data-monitor="home_help_try">
                    <a target="_blank" href="#" rel="nofollow">商品入驻</a>
                </dd>
                <dd>
                    <a target="_blank" href="#" rel="nofollow">大客户采购</a>
                </dd>
            </dl>
            <dl class="foot-con">
                <dt data-monitor="home_foot_try">关注360商城</dt>
                <dd data-monitor="home_help_try">
                    <a target="_blank" href="#" rel="nofollow">360商城大事记</a>
                </dd>
            </dl>

        </div>
    </div>
    <div class="footer-copyright">冰雨商城 ©2016-2018 BYCMS工作室版权所有 京ICP备000001号-43</div>
</div>
<!--尾部结束-->

<!--右边底部返回顶部-->
<div class="slidebar" id="slidebar">
    <ul>
        <li class="topback">
            <a href="javascript:;"></a>
        </li>
    </ul>
</div>
<!--右边底部返回顶部结束-->
@stack('js')
@include('layouts.message')
{{--@stack('js')放在这里会被layui和layer的js造成冲突加载不到所以放他上面--}}
</body>

</html>

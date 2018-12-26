<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="icon" type="text/css" href="{{asset('org/home')}}/icon.ico"/>
    <link rel="stylesheet" type="text/css" href="{{asset('org/home')}}/css/index.css" />
    <script src="{{asset('org/home')}}/js/jquery-1.10.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('org/home')}}/js/list.js" type="text/javascript" charset="utf-8"></script>
</head>

<body>
<div class="regcontent">
    <div class="layout">

        <form action="{{route('user.login',['from'=>request()->query('from')])}}" method="post">
            @csrf
            <div class="reglogo">
                <a href="{{route('index')}}"><img src="{{asset('org/home')}}/images/360logo.png" /></a>
                <span>帐号登录</span>
            </div>
            <div class="reginput">
                <div class="username"><input type="text" name="name" placeholder="请输入用户名" required="required" /></div>
                <div class="email"><input type="text" name="account" placeholder="请输入手机/邮箱" required="" /></div>
                <div class="password"><input type="password" name="password" placeholder="请输入密码" required="" /></div>
                {{--<div class="code"><input type="" name="code" id="" value="" class="codeimg" placeholder="请输入验证码" required="required" /><img src="{{asset('org/home')}}/images/car.jpg" /></div>--}}
                <div class="remember">
                    <input id="" type="checkbox" name="remember" >
                    <label for="checkbox-signup"> Remember me </label>
                </div>

            </div>
            <div class="btn"><input type="submit" id="" name="" value="登录" /></div>
        </form>

        <div class="waring">
            <span>没有账号，<a href="{{route('user.register')}}">请注册后登录</a></span>
            <span><a href="{{route('user.forget_password')}}">忘记密码</a></span>
        </div>
    </div>
</div>
{{--成功和错误的提示框--}}
@include('layouts.message')
</body>

</html>

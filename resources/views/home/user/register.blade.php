<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="icon" type="text/css" href="{{asset('org/home')}}/icon.ico"/>
    <link rel="stylesheet" type="text/css" href="{{asset('org/home')}}/css/index.css"/>
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{asset('org/home')}}/js/jquery-1.10.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('org/home')}}/js/list.js" type="text/javascript" charset="utf-8"></script>
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
</head>

<body style="background: #f5f5f5;">
<div class="regcontent">
    <div class="layout">

        <form action="{{route('user.register.from')}}" method="post">
            @csrf
            <div class="reglogo">
                <a href="{{route('index')}}"><img src="{{asset('org/home')}}/images/360logo.png"/></a>
                <span>帐号注册</span>
            </div>
            <div class="reginput">

                <div class="username"><input type="text" name="name" placeholder="请输入用户名" required="required"/></div>
                <div class="account"><input type="text" name="account" id="account" placeholder="请输入邮箱/手机"
                                            required="required" value="{{old('name')}}"/>
                </div>
                <div class="password"><input type="password" name="password" placeholder="请输入密码" required="required"/>
                </div>
                <div class="password"><input type="password" name="password_confirmation" placeholder="请确认密码"
                                             required="required"/></div>
                <div class="code">
                    <input type="" name="code" id="" value="" class="codeimg" placeholder="请输入验证码" required="required"/>
                    {{--<img src="{{asset('org/home')}}/images/car.jpg" />--}}
                    <input type="button" name="codes" onclick="settime(this);" id="btns" value="获取验证码"
                           style="width: 90px;height: 48px;margin-left: 10px"/>

                </div>

            </div>
            <div class="btn"><input type="submit" value="注册"/></div>
        </form>
        <div class="other">
            <div class="regline"></div>
            <div class="regzi">其他方式登录</div>
        </div>
        <div class="regqq">
            <div class="regbian">
                <a href=""></a>
            </div>
        </div>
        <div class="waring">
            <span>已有账号，<a href="{{route('user.login')}}">请直接登录</a></span>
            <span>忘记密码<a href="">密码找回</a></span>
        </div>
    </div>
</div>
@include('layouts.message')
<script src="{{asset ('org/layer/layer.js')}}"></script>
<script>
    //自己写的异步方法
    $('#btns').click(function () {
        let account = $('#account').val();
        $.post("{{route ('util.code.send')}}", {account: account}, function (res) {
            //console.log(res);
            if (res.code == 1) {
                layer.msg(res.message);//类ui提示框  参考手册
            }
        }, 'json');

        //检测验证码格式是否为邮箱格式
        if (/.+@.+/.test(account) || /^[0-9]{11}$/.test(account)) {
        }else{
            swal({
                text: '邮箱或手机号格式有误',
                icon: "warning",
                button: false
            });
            return;
        }
    });




    //验证码倒计时
    var countdown = 60;

    function settime(obj) {
        if (countdown == 0) {
            obj.removeAttribute("disabled");
            obj.value = "获取验证码";
            countdown = 60;
            return false;
        } else {
            obj.setAttribute("disabled", true);
            obj.value = "重新发送(" + countdown + ")";
            countdown--;
        }
        setTimeout(function () {
            settime(obj);
        }, 1000)
    }
</script>
</body>

</html>

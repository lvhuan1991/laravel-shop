<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>更新地址</title>
    <!-- Favicon icon -->
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('org/assets/')}}/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->

    <link href="{{asset('org/assets/css')}}/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{asset('org/assets/css')}}/colors/blue.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<section id="wrapper">
    <div class="login-register" style="background-image:url(/org/assets/images/background/login-register.jpg);">
        <div class="login-box card">
            <div class="card-body">
                <form method="post" action="{{route('home.order.update',$order)}}">
                    @csrf @method('PUT')
                    <div class="form-group">
                        <label for="exampleInputEmail1">联系人</label>
                        <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="">
                        <label for="exampleInputEmail1">所在城市</label>
                        <input type="text" name="city" class="form-control" id="exampleInputEmail1" placeholder="">
                        <label for="exampleInputEmail1">详细地址</label>
                        <input type="text" name="address" class="form-control" id="exampleInputEmail1" placeholder="">
                        <label for="exampleInputEmail1">联系电话</label>
                        <input type="text" name="phone" class="form-control" id="exampleInputEmail1" placeholder="">
                    </div>
                    <button type="submit" class="btn btn-primary">保存</button>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{asset('org/assets/')}}/plugins/jquery/jquery.min.js"></script>
<script src="{{asset('org/assets/')}}/plugins/bootstrap/js/popper.min.js"></script>
<script src="{{asset('org/assets/')}}/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="{{asset('org/assets/js')}}/jquery.slimscroll.js"></script>
<script src="{{asset('org/assets/js')}}/waves.js"></script>
<script src="{{asset('org/assets/js')}}/sidebarmenu.js"></script>
<script src="{{asset('org/assets/')}}/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="{{asset('org/assets/')}}/plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="{{asset('org/assets/js')}}/custom.min.js"></script>
<script src="{{asset('org/assets/')}}/plugins/styleswitcher/jQuery.style.switcher.js"></script>
@include('layouts.message')
</body>

</html>

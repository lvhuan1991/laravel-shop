{{--<div class="orderleft">--}}
{{--<div class="ordertitle">--}}
{{--<h1 style="background: white;color: black;font-weight: 700;border-bottom: 1px dashed #cccccc">个人中心</h1>--}}
{{--<ul>--}}
{{--<li class="{{ active_class(if_route('home.personal_center'),'personalCenter_active','') }}">--}}
{{--<a href="">我的订单<span>&gt;</span></a>--}}
{{--</li>--}}
{{--<li class="{{ active_class(if_route('home.user.edit'),'personalCenter_active','') }}">--}}
{{--<a href="{{route('home.user.edit',auth()->user())}}">个人信息<span>&gt;</span></a>--}}
{{--</li>--}}
{{--<li class="{{ active_class(if_route('home.address.index') || if_route('home.address.create') || if_route('home.address.edit'),'personalCenter_active','') }}">--}}
{{--<a href="{{route('home.address.index')}}">管理地址<span>&gt;</span></a>--}}
{{--</li>--}}
{{--</ul>--}}
{{--</div>--}}
{{--</div>--}}
{{--<style>--}}
{{--.personalCenter_active {--}}
{{--background: #23ac38 !important;--}}
{{--}--}}
{{--.personalCenter_active a{--}}
{{--color: #fff !important;--}}
{{--}--}}
{{--.personalCenter_active a span{--}}
{{--color: #fff !important;--}}
{{--}--}}
{{--</style>--}}

<div class="orderleft">
    <div class="ordertitle">
        <h1 style="background: white;color: black;font-weight: 700;border-bottom: 1px dashed #cccccc">个人中心</h1>
        <ul>
            <li class="{{ active_class(if_route('home.personal_center'),'active','') }}">
                <a href="{{route('home.personal_center',auth()->user())}}" class="geren_active">我的订单<span>&gt;</span></a>
            </li>
            <li class="{{ active_class(if_route('user.edit'),'active','') }}">
                <a href="{{route('user.edit',auth()->user())}}" class="geren_active">个人信息<span>&gt;</span></a>
            </li>
            <li class="{{ active_class(if_route('home.address.index') || if_route('home.address.create') || if_route('home.address.edit'),'active','') }}">
            <a href="{{route('home.address.index')}}" class="geren_active">管理地址<span>&gt;</span></a>
            </li>
        </ul>
    </div>
</div>

<style>
    .active{
        background: #2C7BE5 !important;
    }
    .geren_active{
        color: #313031 !important;
    }
</style>

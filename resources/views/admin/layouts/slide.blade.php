<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User profile -->
        <div class="user-profile"
             style="background: url({{asset('org/assets/')}}/images/background/user-info.jpg) no-repeat;">
            <!-- User profile image -->
            <div class="profile-img"><img src="{{asset('org/assets/')}}/images/users/profile.png" alt="user"/></div>
            <!-- User profile text-->
            <div class="profile-text"><a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown"
                                         role="button" aria-haspopup="true" aria-expanded="true">Markarn Doe</a>
                <div class="dropdown-menu animated flipInY">
                    <a href="#" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
                    <a href="#" class="dropdown-item"><i class="ti-wallet"></i> My Balance</a>
                    <a href="#" class="dropdown-item"><i class="ti-email"></i> Inbox</a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item"><i class="ti-settings"></i> Account Setting</a>
                    <div class="dropdown-divider"></div>
                    <a href="login.html" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                </div>
            </div>
        </div>
        <!-- End User profile text-->
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-small-cap">后台管理</li>
                <li class="active">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="true"><i
                            class="mdi mdi-gauge"></i><span class="hide-menu">商城系统 </span></a>
                    <ul aria-expanded="true" class="collapse">
                        <li><a href="{{route('admin.category.index')}}">栏目管理</a></li>
                        <li><a href="{{route('admin.good.index')}}">商品管理</a></li>
                        <li><a href="{{route('admin.order.index')}}">订单管理</a></li>
                    </ul>
                </li>
                <li >
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="mdi mdi-settings"></i>
                        <span class="hide-menu">配置管理</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        {{--<li ><a href="{{route('admin.config.create',['type'=>'website'])}}" class="active">站点配置</a></li>--}}
                        <li><a href="{{route('admin.config.index',['type'=>'upload'])}}">上传配置</a></li>
                        <li><a href="{{route('admin.config.index',['type'=>'website'])}}">站点配置</a></li>
                        <li><a href="{{route('admin.config.index',['type'=>'mail'])}}">邮件配置</a></li>
                    </ul>
                </li>
                <li >
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="mdi mdi-settings"></i>
                        <span class="hide-menu">权限管理</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        {{--<li ><a href="{{route('admin.config.create',['type'=>'website'])}}" class="active">站点配置</a></li>--}}
                        <li><a href="{{route('admin.admin.index')}}">用户管理</a></li>
                        <li><a href="{{route('admin.role.index')}}">角色管理</a></li>
                        <li><a href="{{route('admin.permission')}}">权限管理</a></li>
                    </ul>
                </li>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
    <!-- Bottom points-->
    <div class="sidebar-footer">
        <!-- item-->
        <a href="" class="link" data-toggle="tooltip" title="Settings"><i class="ti-settings"></i></a>
        <!-- item-->
        <a href="" class="link" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a>
        <!-- item-->
        <a href="" class="link" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a>
    </div>
    <!-- End Bottom points-->
</aside>

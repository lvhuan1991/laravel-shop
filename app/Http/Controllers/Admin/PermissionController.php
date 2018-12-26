<?php

namespace App\Http\Controllers\Admin;

use App\Models\Module;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    //加载权限管理展示页面
    public function index()
    {
        //加了个拦截
        admin_has_permission('Admin-permission');//类似于laravel里面的策略
        $modules=Module::all();//获取所有数据
        return view( 'admin.permission.index' , compact( 'modules' ) );
    }
    //清除缓存
    public function forgetPermissionCache(){
        admin_has_permission('Admin-permission');//类似于laravel里面的策略
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        return back()->with( 'success' , '缓存清除成功' );
    }
}

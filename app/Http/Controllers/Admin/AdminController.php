<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{

    public function index()
    {
        admin_has_permission('Admin-index');
        $admins = Admin::all();//获取所有数据
        //dd($admins);
        $admins = Admin::paginate(8);//获取所有数据并分页每页八条
        //dd($admins);
        return view('admin.admin.index',compact('admins'));
    }

    public function create()
    {
        admin_has_permission('Admin-index');
        return view('admin.admin.create');
    }

    public function store(Request $request,Admin $admin)
    {
        admin_has_permission('Admin-index');
        $admin->username=$request->username;
        $admin->password=bcrypt($request->password);
        $admin->save();
        return redirect()->route('admin.admin.index')->with('success','添加成功');
    }

    public function show(Admin $admin)
    {
        //
    }

    public function edit(Admin $admin)
    {
        admin_has_permission('Admin-index');
        return view('admin.admin.edit',compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        admin_has_permission('Admin-index');
        $admin->username=$request->username;
        $admin->password=bcrypt($request->password);
        $admin->save();
        return redirect()->route('admin.admin.index')->with('success','修改成功');
    }

    public function destroy(Admin $admin)
    {
        admin_has_permission('Admin-index');//拦截地址栏进入的用户
        //$this->authorize('delete',$admin);//拦截不能删除站长【这里不能用、这样走的前台用户默认的user】
        auth('admin')->user()->can('delete',$admin);//因为走的后台用户
        $admin->delete();
        return redirect()->route('admin.admin.index')->with('success','删除成功');
    }
    //加载设置角色模板页面
    public function adminSetRoleCreate(Admin $admin){
        admin_has_permission('Admin-index');
        $roles=Role::all();//获取所有角色
        //$admin=Admin::all();路由给了参数 还是在括号里面写
        return view('admin.admin.set_role',compact('roles','admin'));
    }
    //提交
    public function adminSetRoleStore(Request $request,Admin $admin){
        admin_has_permission('Admin-index');
        $admin->syncRoles($request->roles);//给用户设置角色
        return redirect()->route('admin.admin.index')->with('success','OK');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Module;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{

    public function index()
    {
        admin_has_permission('Admin-role');//类似于laravel里面的策略
        $roles=Role::paginate(8);
        return view('admin.role.index',compact('roles'));
    }

    public function create()
    {
        admin_has_permission('Admin-role');//类似于laravel里面的策略
        $roles=Role::paginate(8);
        return view('admin.role.create');
    }

    public function store(Request $request,Role $role)
    {
        admin_has_permission('Admin-role');//类似于laravel里面的策略
        //dd($request->all());
        $role->title=$request->title;
        $role['name']=$request['name'];
        $role->guard_name='admin';
        $role->save();
        return redirect()->route('admin.role.index')->with('success','添加成功');
    }

    public function edit(Role $role)
    {
        admin_has_permission('Admin-role');//类似于laravel里面的策略
        return view('admin.role.edit',compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        //dd($request->all());
        admin_has_permission('Admin-role');//拦截地址栏修改
        //$this->authorize('update',$role);//不能这样写了   和以前不一样了
        auth('admin')->user()->can('update',$role);//拦截不能修改站长
        #第一个参数是指策略控制器类(RolePolicy)中的(update)方法；另外将update方法里面的User模型改成了Admin模型
        #第二个参数是指App\Providers\AuthServiceProvider类中的$policies属性值Role::class=>RolePolicy::class
        $role->title=$request->title;
        $role->name=$request->name;
        $role->save();
        return redirect()->route('admin.role.index')->with('success','编辑成功');
    }

    public function destroy(Role $role)
    {
        admin_has_permission('Admin-role');//拦截地址栏进入的用户
        //$this->authorize( 'delete' , $role );这里不能用、这样走的前台用户默认的user
        auth('admin')->user()->can('delete',$role);//拦截不能修改站长
        //dd($role->all()->toArray());
        $role->delete();
        return back()->with('success','删除成功');
    }

    public function show(Role $role)
    {
        admin_has_permission('Admin-role');//拦截地址栏进入的用户
        //dd($role->all());
        $modules=Module::all();
        return view('admin.role.set_role_permission',compact('role','modules'));
    }

    public function setRolePermission(Role $role,Request $request){
        //dd($role->all()->toArray());
        admin_has_permission('Admin-role');//拦截地址栏进入的用户
        auth('admin')->user()->can('delete' , $role );//拦截不能修改站长
        #https://github.com/spatie/laravel-permission#installation
        $role->syncPermissions( $request->permissions );//给角色设置权限👆
        return back()->with( 'success' , '操作成功' );
    }
}

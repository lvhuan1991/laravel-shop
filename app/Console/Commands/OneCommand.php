<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\Module;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class OneCommand extends Command
{

    protected $signature = 'one:command';

    protected $description = '这里是命令的描述';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        //users 用户表
        //model_has_roles 用户 角色中间表
        //roles 角色表
        //role_has_permission 角色 权限中间表
        //permissions 权限表

        //在生成的权限迁移文件:permissions表增加title module 字段
        //在roles表增加 title 字段
        //自行创建迁移文件 modules:title(模块中文名称)  name(模块英文标识) permissions(记录模块所有权限)
        //=======================================//
        //扫描出 app/Http/Controllers里面所有文件以及文件夹
        $modules=glob('app/Http/Controllers/*');
        //dump($modules);
        foreach($modules as $module){
            //dump($module);//不能用dd、那样只能打印出来一条
            if(is_dir($module . '/System')){
                //dump($module);//  app/Http/Controllers/Admin
                $moduleName=basename($module);
                //dump($moduleName);//Admin
                $config = include $module . '/System/config.php';
                //dump($config);//打印出config.php里面的返回值
                $permissions=include $module . '/System/permission.php';
                //dump($permissions);//打印出permission.php里面的返回值
                Module::firstOrNew(['name'=>$moduleName])->fill([
                    'title'=>$config['app'],
                    'permissions'=>$permissions,
                ])->save();
                //dump($permissions);
                foreach($permissions as $permission){
                    Permission::firstOrNew(['name'=>$moduleName . '-' .$permission['name']])->fill([
                        'title'=>$permission['title'],
                        'module'=>$moduleName,
                        'guard_name'=>'admin'
                    ])->save();
                }
            }
        }
        //=======================================//
        //给指定一个用户设置站长角色,站长角色要拥有所有权限
        //设置一个角色填充文件,系统初始需要有一个站长角色
        //1.将所有权限设置给站长这个角色
        //找到站长这个角色对象
        $role=Role::where('name','webmaster')->first();
        //dump($permissions);dd($role);
        $permissions=Permission::pluck('name');//获取一列的值
        //dd($permissions);
        //给角色同步权限
        $role->syncPermissions($permissions);//role_has_permissions表生成数据
        //2.获得设置成站长的那个用户
        $user=Admin::find(1);//把Admin表里面的第一个用户是站长
        //dump($user);
        //给用同步权限
        //注意如果执行报错:App\User 模型中未定义assignRole,解决办法:需要在 Admin 模型中引入HasRoles类
        $user->assignRole('webmaster');
        //清除权限缓存
        \Artisan::call( 'permission:cache-reset' );
        //命令执行成功提示信息
        $this->info( 'permission one successfully' );
    }
}

<?php

namespace App\Policies;

use App\Models\Admin;
use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function view(User $user, Role $role)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(Admin $admin, Role $role)
    {
        //dd($admin);//是当前登录的管理员
        //dd($role);//是当前需要更新的角色管理员
        return $role['name'] != 'webmaster';//意思是不能更新修改站长
    }

    public function delete(Admin $admin, Role $role)
    {
        return $role['name'] != 'webmaster';
    }

    public function restore(User $user, Role $role)
    {
        //
    }

    public function forceDelete(User $user, Role $role)
    {
        //
    }
}

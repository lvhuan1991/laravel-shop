<?php

namespace App;

use App\Models\Address;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = [
//        'name', 'email', 'password','email_verified_at','token','icon'
//    ];
    protected $guarded=['account','password_confirmation','code'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    //用户模型和地址管理模型关联起来 正向一对多
    public function address(){
        return $this->hasMany(Address::class);
    }
}

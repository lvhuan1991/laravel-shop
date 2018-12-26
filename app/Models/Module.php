<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    //protected $fillable=[];
    protected $guarded=[];
    #手册https://laravel-china.org/docs/laravel/5.7/eloquent-mutators/2297#array-and-json-casting
    protected $casts = ['permissions'=>'array'];
}

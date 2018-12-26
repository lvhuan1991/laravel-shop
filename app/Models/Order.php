<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //订单模型和订单详情(即加购的商品)模型（这些加购的商品统称一个订单）
    public function orderDetail(){
        return $this->hasMany(OrderDetail::class);
    }
    //订单与用户关联
    public function user(){
        return $this->belongsTo(User::class);
    }
}

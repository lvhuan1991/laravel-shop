<?php

namespace App\Http\Controllers\Home;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PersonalCenterController extends CommonController
{
    public function __construct()
    {
        $this->middleware('auth',['except' => [],]);
        //因为如要执行父级构造方法,运行父级构造方法,不然当前构造方法会覆盖父级构造方法
        parent::__construct();
    }

    public function index()
    {
        //获取当前登录用户的全部订单数据
        $orders=Order::where('user_id',auth()->id())->paginate(10);
        //dd($order);
        return view('home.personal_center.index',compact('orders'));
    }
}

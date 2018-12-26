<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    public function index(Order $order)
    {
        $orders = Order::paginate(10);//所有订单、如果需要排序的话加个latest方法
        return view('admin.order.index',compact('orders'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Order $order)
    {
        return view('admin.order.show',compact('order'));
    }

    public function edit(Order $order)
    {
        $order->status=4;
        $order->save();
        return back()->with('success','修改成功');
    }

    public function update(Request $request, Order $order)
    {
        //
    }

    public function destroy(Order $order)
    {
        //
    }
}

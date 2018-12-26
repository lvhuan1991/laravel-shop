<?php

namespace App\Http\Controllers\Home;


use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends CommonController
{
    public function __construct(){
        $this->middleware('auth',['except'=>[]]);
        parent::__construct();//调用父级构造方法
        //因为如要执行父级构造方法,运行父级构造方法,不然当前构造方法会覆盖父级构造方法
    }

    public function index(Order $order,Request $request)
    {
        $orders = $order->all();
        //dd($orders->toArray());
        //获取地址栏 $ids(字符串) 参数
        $ids = $request->query('ids');
        //dd($ids);
        //$ids 是加入购物车模板里面的一个变量,通过地址栏跟过来的,指的是所选中支付的商品id
        $orders = Cart::whereIn('id',explode(',',$ids))->get();
        //dd($orders->toArray());
        //计算总价(模板页面需要统计总价)
        $totalPrice=0;
        //循环订单里面的具体商品
        foreach($orders as $order){
            $totalPrice += $order['num'] * $order['price'];
        }
        //获取当前用户所有收货地址(订单表里面加了user_id字段)
        $addresses=Address::where('user_id',auth()->id())->get();
        //dd($addresses);
        //获取当前用户默认地址
        $defaultAddress=Address::where('user_id',auth()->id())->where('is_default',1)->first();
        //dd($defaultAddress);
        return view('home.order.index',compact('orders','totalPrice','addresses','defaultAddress'));
    }

    public function create()
    {

    }

    public function store(Request $request,Order $order)
    {
        //异步传输请求过来的两个数据
        //dd($request->all());
        //根据购物车 ids 获取所有数据(也就是说ids 只是id里面的一部分 用whereIn来帅选)
        $cartData=Cart::whereIn('id',explode(',',$request->ids))->get();
        //根据这些数据来循环得出订单的总价
        $total_price=0;$total_number=0;
        foreach($cartData as $v){
            $total_price += $v['price']*$v['num'];
        }
        //dd($total_price);
        //接下来要创建两张表(订单表和详情表、用事务来处理：任何一个表出了问题都会提交不了，直接回滚)
        \DB::beginTransaction();//开启事务
        //创建订单表(没有在模型里面设置允许写入字段 就在方法里面写)
        $order->number=time().str_random(7);
        $order->total_price=$total_price;
        $order->total_num=count($cartData);
        $order->user_id=auth()->id();
        $order->address_id=$request->address_id;
        $order->status=1;
        $order->save();
        //创建订单详情表
        foreach($cartData as $v){
            $orderDetail = new OrderDetail();//记住每次实例化他都是空的、执行添加|不是空的话save就执行更新
            //所以必须在循环里面实例化、还有在事务没有关闭之前是不会添加到数据库里面去的、所以save了数据库没数据
            //dump($orderDetail->toArray());
            $orderDetail->order_id = $order->id;
            $orderDetail->title = $v['title'];
            $orderDetail->price = $v['price'];
            $orderDetail->pic = $v['pic'];
            $orderDetail->num = $v['num'];
            $orderDetail->spec = $v['spec'];
            $orderDetail->good_id = $v['good_id'];
            $orderDetail->spec_id = $v['spec_id'];
            $orderDetail->save();
            //dump($orderDetail->toArray());
        }
        //die;
        //清除购物车对应数据(因为要付款了)
        Cart::whereIn('id',explode(',',$request->ids))->where('user_id',auth()->id())->delete();
        \DB::commit();//关闭事务
        //因为是异步请求  给出返回状态码code
        return ['code'=>1,'msg'=>'提交成功','number'=>$order->number];
    }

    public function show(Order $order){
        return view('home.order.show',compact('order'));
    }
    public function edit(Order $order)
    {
        $order->status=5;
        $order->save();
        return back()->with('success','操作成功');
    }

    public function update(Request $request, Order $order)
    {


    }

    public function destroy(Order $order)
    {
        $order->delete();
        return back()->with('success','删除了');
    }
}

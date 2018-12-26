<?php

namespace App\Http\Controllers\Home;

use App\Models\Cart;
use App\Models\Good;
use App\Models\Spec;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends CommonController
{
    public function __construct(){
        $this->middleware('auth',[
            'except'=>[],//除了谁不需要登录验证、这里的意思是谁都需要登录验证
            //'only'=>['所有的方法']两个写法效果一样
        ]);
        //因为如要执行父级构造方法,运行父级构造方法,不然当前构造方法会覆盖父级构造方法
        parent::__construct();
    }
    public function index()
    {
//        $carts = Cart::all();
        //获取当前用户购物车所有数据
        $carts = Cart::where('user_id',auth()->id())->get();
        //dd($carts->toArray());
        foreach($carts as $k=>$cart){
            $carts[$k]['checked'] = false;
        }
        return view('home.cart.index',compact('carts'));
    }

    public function create()
    {
        //购物车不需要加载模板
    }

    public function store(Request $request,Cart $cart)
    {
        $good = Good::find($request->id); //根据商品 id 获取商品数据
        //根据规格 id 获取规格数据
        $spec = Spec::find($request->spec);
        $newCart = Cart::where('user_id',auth()->id())->where('good_id',$request->id)
            ->where('spec_id',$request->spec)->first();
        if(!$newCart){
            //执行购物车添加
            $cart->pic    =$good->list_pic;
            $cart->good_id=$request->id;
            $cart->title  =$good->title;
            $cart->spec   =$spec->spec;
            $cart->price  =$good->price;
            $cart->num    =$request->num;
            $cart->user_id=auth()->id();
            $cart->spec_id=$request->spec;
            $cart->save();
        }else{
            $newCart->num = (int)$newCart['num'] + (int)$request->num;
            $newCart->save();
        }
        return ['code'=>1,'msg'=>'添加成功'];//这个状态码会返回到content(index页面)ajax
        //然后传入到异步请求成功时的回调函数
    }

    public function show(Cart $cart)
    {
        //
    }

    public function edit(Cart $cart)
    {
        //
    }

    public function update(Request $request, Cart $cart)
    {
        //dd($request->all());//打印num值
        //dd($cart->all()->toArray());//购物车所有数据
        //Cart::save();//报错：Non-static method静态法 不能用静态方法？？
        $cart['num'] = $request['num'];
        //$cart->update($request->all());//报错Add [num] to fillable property to allow mass assignment on [App\Models\Cart].
        //$cart->update(['num'=>$request->num]);//报错：同上
        $cart->save();
        return ['code'=>1,'msg'=>'更改成功'];
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return ['code'=>1,'msg'=>'删掉了'];

    }
}

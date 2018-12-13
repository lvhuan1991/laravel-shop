<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
//    public function __construct(){
//        //这句话意思是如果没有登录的情况下就不能走index方法
//        $this->middleware('admin.auth',['only'=>['index']]);
//    }

    public function index(){
        return view('admin.login.index');//加载登录模板页面
    }
    //后台登录
    public function login(Request $request){
        //dd($request->all());
        //1.自定义守卫 config/auth.php  [guards , providers]
        //2.Admin 模型需要继承Authenticatable(可认证的)类,参考默认 User 模型
        //因为Admin模型特殊，他需要获取到用户的信息令牌、所以他需要继承Authenticatable
        //3.必须制定看守器

        if(\Auth::guard('admin')->attempt(['username'=>$request->username,
            'password'=>$request->password],$request->remember)){
            return redirect()->route('admin.index')->with('success','登录ok');
        }
        return redirect()->back()->with('danger','用户名或密码不正确');

//        if(\Auth::guard('admin')->attempt($request->username,$request->password,$request->remember)){
//            return redirect()->route('admin.index')->with('success','登录ok');
//        }
//        return redirect()->back()->with('danger','用户名或密码不正确');
    }
    public function logout(){
        \Auth::guard('admin')->logout();//加这句又什么用？
        return redirect()->route('admin.login');
    }
}

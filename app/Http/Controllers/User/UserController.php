<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Home\CommonController;
use App\Http\Requests\RegisterRequest;
use App\Notifications\ResetPasswordNotification;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends CommonController
{
    public function __construct(){

        $this->middleware('auth',[
            'only'=>['show','edit','personalInformation']
        ]);
        parent::__construct();//调用父级构造方法
        //因为如要执行父级构造方法,运行父级构造方法,不然当前构造方法会覆盖父级构造方法
    }
    public function register()
    {

        return view('home.user.register');
    }

    public function registerFrom(RegisterRequest $request)
    {
        //dd($request->all());
        //将数据存储到数据表
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);//密码加密
        $data['token'] = str_random(50);//给每个注册用户随机一个字符串
        //$data['email_verified_at'] = now();//获取当前时间
        //之前是只有邮箱注册 选择加了手机所以得做判断
        if(filter_var($data['account'],FILTER_VALIDATE_EMAIL)){
            $data['email_verified_at'] = now();//获取当前时间
            $data['email']=$data['account'];
        }else{
            $data['phone_verified_at'] = now();//获取当前时间
            $data['phone']=$data['account'];
            $data['email']='';
        }
        //dd($data);
        User::create($data);//将数据写入数据表中
        //dd(1);
        //模型事件，需要再注册之后，把email_verified_at字段事件自动处理
        //提示并且跳转
        return redirect()->route('user.login')->with('success','注册成功');
    }

    public function login()
    {
        return view('home.user.login');
    }

    public function loginFrom(Request $request)
    {
//        dd($request->remember);
//        dd($request->from);
        //手册:表单验证验证拦截(下面这样写就不用再创建拦截请求类了)
        $this->validate($request,[
            //'email' => 'email|required',
            'account' => 'required',
            'password' => 'required|min:3'
        ],[
                //'email.email' => '邮箱格式不正确',
                'account.required' => '请输入账号',
                //'name.required' => '请输入用户名',
                'password.required' => '请输入登录密码',
                'password.min' => '密码不得少于3位置'
            ]
        );
        //执行登录
        //手册：用户认证
        //$credentials = $request->only('email','password','name');
        if(filter_var($request['account'],FILTER_VALIDATE_EMAIL)){
            $credentials['email']=$request['account'];
        }else{
            $credentials['phone']=$request['account'];
        }
        $credentials=$request->only('password','name');
        //$credentials['password']=$request['password'];//和上面写法结果一样吗？
        if(\Auth::attempt($credentials,$request->remember)){
            //登录成功，跳转到首页
            if($request->from){
                return redirect($request->from)->with('success','登录成功');
            }
            return redirect('/')->with('success','登录成功');
        }
        return redirect()->back()->with('danger','用户名密码不正确');
    }

    public function logout()
    {
        \Auth::logout();//走的是默认的守卫  如果是后台退出得加后台守卫
        return redirect()->route('index');
    }
    //忘记密码
    public function forgetPasswordView(){
        return view('home.user.forget_password');
    }
    //发送邮件进入重置密码
    public function forgetPassword(Request $request){
        //表单验证
        $this->validate($request,['email'=>'required|email'],[
            'email.required'=>'请输入邮箱',
            'email.email'=>'邮箱格式不对',
        ]);
        //根据用户提交来的邮箱去数据表查找数据
        $user=User::where('email',$request->email)->first();
        //dd($user->toArray());
        if($user){
            //发邮件
            $user->notify(new ResetPasswordNotification($user->token));
            return back()->with('success','邮件已发送');
        }
        return back()->with('danger','该邮箱未注册');
    }
    //收到邮件之后点击链接进行密码重置
    public function resetPasswordView($token){
        $user=User::where( 'token' , $token )->first();
        if( !$user ){
            return redirect( '/' );//拦截如果没有token值就返回首页
        }
        return view('home.user.reset_password',compact('token'));
    }
    public function resetPassword($token,Request $request){
        //dd(1);
        //表单验证
        $this->validate($request,['password'=>'required|confirmed'],[
            'password.required'=>'请输入密码',
            'password.confirmed'=>'两次输入密码不一致',
        ]);
        $user=User::where('token',$token)->first();
        //拦截防止手动输入地址栏的用户 让他返回首页
        if(!$user){
            return redirect('/');
        }
        //密码加密
        $user->password=bcrypt($request->password);
        $user->save();
        return redirect()->route('user.login')->with('success','密码修改成功');
    }
    //个人中心
    public function show(User $user)
    {
        return view('home.personal_center.show');
    }
    //个人信息
    public function edit(User $user)
    {
        return view('home.personal_center.edit');
    }
    //提交个人信息
    public function personalInformation(User $user,Request $request){
        //echo 1;
        //dd($user->toArray());
//        dd($request->all());
        auth()->user()->update([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'phone'=>$request['phone'],
            'province'=>$request['province'],
            'city'=>$request['city'],
            'district'=>$request['district'],
            'detail'=>$request['detail'],
            'sex'=>$request['sex'],
            'birthday'=>$request['birthday']
        ]);
        return back()->with('success','OK');
    }
}

<?php

namespace App\Http\Controllers\Util;

use App\Notifications\RegisterNotify;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Qcloud\Sms\SmsSingleSender;
class CodeController extends Controller
{
    //发送验证码
    public function send(Request $request)
    {
        //获得所有请求数据
        //dd($request->all());
        //dd($request->username);
        //随机四位验证码
        $account = \request ()->account;//request函数,在使用的时候可以不加命名空间
        $code = $this->random();
//        dd($account);
        //dd($code);
        if(filter_var($account,FILTER_VALIDATE_EMAIL)){
            //说明是邮箱
            //发送验证码（手册：消息通知）
            $user = User::firstOrNew(['email'=>$account]);//user模型对象
            //dd($user->toArray());
            //需要创建通知类:php artisan make:notification  RegisterNotify
            $user->notify(new RegisterNotify($code));
            //dd(1);
        }else{
            //手机号
            //引入我们自己创建的函数、自动加载config里面的文件
            $appid=config('qcloudsms.appid');//config()是系统内置的一个函数
            $appkey=config('qcloudsms.appkey');
            $phoneNumbers=$account;//需要发送短信的手机号码
            //dd($appkey);
            $templateId=186769;// 短信模板ID，需要在短信应用中申请
            $smsSign = "吕欢的个人笔记";//使用真实的已申请的签名，签名参数使用的是`签名内容`
            try {
                $ssender = new SmsSingleSender($appid, $appkey);
                $result = $ssender->send(0, "86", $phoneNumbers,
                    "【吕欢的个人笔记】{$code}为您的登录验证码，请于10分钟内填写。如非本人操作，请忽略本短信。", "", "");
                $rsp = json_decode($result);
                //dd($rsp);
            } catch(\Exception $e) {
                //echo var_dump($e);
                return ['code'=>0,'message'=>'短信发送失败,请联系管理员'];
            }
        }

        //将验证码存入到session中
        session()->put('code',$code);
        //返回数据
        return ['code' => 1, 'message' => '验证码发送成功'];
    }

    //随机获取4位数字验证码
    private function random( $len=4 )
    {
        $str = '';
        for($i=0;$i<$len;$i++){
            $str .= mt_rand(0,9);
        }
        return $str;
    }
}

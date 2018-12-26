<?php

namespace App\Http\Controllers\Home;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

require_once public_path('')."/org/wechat_pay_php_sdk_v3.0.9/example/WxPay.NativePay.php";

class PayController extends CommonController
{
    public function __construct()
    {
        $this->middleware('auth',[
                'except' => ['notify'],
            ]
        );
        //因为如要执行父级构造方法,运行父级构造方法,不然当前构造方法会覆盖父级构造方法
        parent::__construct();
    }

    public function index(Request $request)
    {
        //根据订单号(自己在模板里面新添加的number属性)来获取订单数据
        $order = Order::where('number',$request->number)->first();
        if($order['status'] != 1){
            return redirect()->route('home.order.show',$order)->with('danger','当前订单已支付');
        }
        //============生成位置支付二维码==========//
        //1.必须要服务器环境下测试
        //2.框架的时区要设置 PRC
        $input = new \WxPayUnifiedOrder();
        $input->SetBody("金牌商城");
        //订单号需要写进去👇
        $input->SetAttach("$request->number");
        $input->SetOut_trade_no("sdkphp123456789".date("YmdHis"));
        $input->SetTotal_fee("1");
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis",time()+600));
        $input->SetGoods_tag("test");
        //设置通知路由👇
        $input->SetNotify_url(route('home.notify'));
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id("123456789");
        $notify = new \NativePay();
        $result = $notify->GetPayUrl($input);
        //dd($result);//所有页面上的结果到这里打印看
        $url2 = $result["code_url"];
        return view('home.pay.index',compact('order','url2'));
    }
    //微信支付之后回调通知
    //******该方法不可以刷新浏览器测试,需要扫码支付测试
    //******该方法不能做登录拦截
    //******不可以有csrf 令牌验证
    public function notify()
    {
        //dd(100);通过postman测试的
        //接受微信 post 通知我们的数据
        $result = simplexml_load_string(file_get_contents('php://input'),'simpleXmlElement',LIBXML_NOCDATA);
        //将以上微信返回的数据写入文件
        file_put_contents('b.php',var_export($result,true));
        Order::where('number',$result->attach)->update(['status' => 2]);
        //告诉微信我们已经收到通知 代码参考 https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=9_7&index=8
        echo "<xml>
   <return_code><![CDATA[SUCCESS]]></return_code>
   <return_msg><![CDATA[OK]]></return_msg>
</xml>";
        return true;

    }

    /**
     * 检测订单是否已经支付
     * @return array
     */
    public function checkOrderStatus()
    {
        $number = \request()->number;
        $order = Order::where('number',$number)->first();
        if($order['status'] == 2){
            //说明已经支付
            return ['code'=>1,'msg'=>'已支付'];
        }else{
            //说明未支付
            return ['code'=>0,'msg'=>'未支付'];
        }
    }
}

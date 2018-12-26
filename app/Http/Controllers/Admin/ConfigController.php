<?php

namespace App\Http\Controllers\Admin;

use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    //加载模板页面
    public function index($name)
    {
        //测试 my_config函数
        //dd(my_config('uploasasdad.size'));
        //获取配置项数据
        //firstOrNew手册位置: Eloquent ORM-->快读入门
        $config = Config::firstOrNew(
            ['name'=>$name]
        );
        //dd($config['data']);
        return view('admin.config.change_'.$name,compact('name','config'));
    }

    public function update(Request $request,$name)
    {
        //updateOrCreate 执行更新或者添加
        //updateOrCreate手册位置: Eloquent ORM-->快读入门
        $res = Config::updateOrCreate(
            ['name'=>$name],//查询条件
            //注意:$request->all()是数组,直接写入数据表报错
            //需要借助模型属性 cates
            ['name'=>$name,'data'=>$request->all()]//更新或者添加的数据
        );
        hd_edit_env($request->all());
        //跳转
        return back()->with('success','配置项更新成功');
    }

}

<?php

namespace App\Http\Controllers\Util;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    public function upload(Request $request){
        //必须打印所有 request 请求的数据,需要知道上传文件 name
        dd($request->all());
        //$request->file('上传文件表单 name')
    }
}

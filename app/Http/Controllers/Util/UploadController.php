<?php

namespace App\Http\Controllers\Util;

use App\Exceptions\UploadException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        //dd(100);
        //打印所有 request 请求的数据,需要知道上传文件 name
        //dd($request->all());
        $file = $request->file('file');
        if($file){
            //dd(11);
            $this->checkType($file);
            $this->checkSize($file);
            //$path = $file->store('上传文件存储目录','磁盘:filesystems 文件里面看disks');
            //上传需要 php 扩展:fileinfo
            $path = $file->store('upload','upload');
            //dd($path);
            return [
                "code" => 0,
                "msg" => '',
                "data" => [
                    "src" => '/'.$path
                ],
            ];
        }
    }

    private function checkSize($file)
    {
        //$file->getSize();//获取上传文件大小
        if($file->getSize()> my_config('upload.upload_size')){
            throw new UploadException('上传文件过大');
        }
    }

    private function checkType($file)

    {
        //dd(1);
        //$file->getClientOriginalExtension  ();//上传文件的扩展名
        //$file->getClientOriginalName ();//上传文件在客户端文件名
        if(!in_array(strtolower($file->getClientOriginalExtension()),explode('|',my_config('upload.upload_type')))){
            throw new UploadException('上传类型不允许');
        }
    }
}

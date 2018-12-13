<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
//    public function __construct(){
//        //这句话意思是如果没有登录的情况下就不能走index方法
//        $this->middleware('admin.auth',['only'=>['index']]);
//    }
    public function index(){
        return view('admin.index.index');
    }
}

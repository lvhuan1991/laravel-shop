<?php

namespace App\Http\Controllers\Home;

use App\Models\Category;
use App\Models\Good;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListController extends CommonController
{
    public function index($list,Category $category){
        //获取所有栏目数据
        $categories=Category::all()->toArray();
        //获取当前栏目下所有子栏目商品
        $sonIds=$category->getSon($categories,$list);
        //将子集追加进去
        $sonIds[]=$list;
        //获取在sonIds里面所有商品
        $goods=Good::whereIn('category_id',$sonIds);
        if(\request()->query('price')=='asc'){
            $goods=$goods->orderBy('price','asc');
        }
        if(\request()->query('price')=='desc'){
            $goods=$goods->orderBy('price','desc');
        }
        $goods=$goods->orderBy('created_at','desc')->paginate(10);
        //获取当前栏目所有儿子栏目
        $sonCategoy = Category::where('pid',$list)->get();
        //面包屑(递归找父)
        $fatherData = $category->getFacher($categories,$list);
        //数组翻转
        $fatherData = array_reverse ($fatherData);
        //dump($fatherData);
        return view('home.list.index',compact('goods','list','sonCategoy','fatherData'));
    }
}

<?php

namespace App\Http\Controllers\Home;

use App\Models\Category;
use App\Models\Good;
use App\Models\Home;
use App\Models\Keyword;
use Houdunwang\Arr\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends CommonController
{
    public function index(Category $category)
    {
        $categories = Category::all()->toArray();
        //获取所有栏目数据。 左侧菜单数据
        $categoryData = (new Arr())->channelLevel($categories,$pid = 0,$html = "&nbsp;",$fieldPri = 'id',$fieldPid = 'pid');
        //        dd($categoryData);
        //轮播图右侧随机两个商品
        $good = Good::inRandomOrder()->limit(2)->get();
        //        dd($good->toArray());
        //获取最近发布的五个商品
        $latestGood = Good::latest()->limit(5)->get();
        //第一楼层
        //找家用电子所有子集数据
        $sonIds = $category->getSon($categories,1);
        $sonIds[] = 1;
        //        dd($sonIds);
        $oneFloor = [
            'name' => '家用电器',
            'data' => Good::whereIn('category_id',$sonIds)->get()
        ];
        //第二楼数据
        Category::$temp = [];
        $sonIds = $category->getSon($categories,21);
        $sonIds[] = 21;
        $twoFloor = [
            'name' => '手机/运营商/数码',
            'data' => Good::whereIn('category_id',$sonIds)->get()
        ];
        //新品速递
        $newGoods = Good::latest()->limit(15)->get();

        return view('home.index.index',compact('oneFloor','categoryData','good','latestGood','newGoods','twoFloor','contentsd'));
    }

    /**
     * 搜索
     * 创建关键词表 模型
     */
    public function search(Request $request)
    {
        //dd($request->all());
        //获取搜索词
        $sid = $request->query('sid');
        //在数据表中查找当前关键词是否存在
        $keyword = Keyword::where('sid',$sid)->first();
        if($keyword){
            //如果已经存在,让搜索次数+1
            $keyword->increment('click');
        }
        else{
            //如果搜索词不存在,进行添加
            Keyword::create(['sid' => $sid]);
        }
        $goods = Good::search($sid)->paginate(10);
        return view('home.index.search',compact('goods','sid'));
    }

    public function qqBack()
    {
        echo 1;
    }

}

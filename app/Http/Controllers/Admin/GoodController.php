<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GoodRequest;
use App\Models\Category;
use App\Models\Good;
use App\Models\Spec;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodController extends Controller
{
    public function index(Good $good)
    {
        $goods = Good::all();
        //dd($goods->toArray());
        return view('admin.good.index',compact('goods'));
    }

    public function create(Category $category)
    {
        //获取所有的栏目
        $categories = $category->getTreeData( Category::all()->toArray() );
        return view('admin.good.create',compact('categories'));
    }

    public function store(GoodRequest $request,Good $good)
    {
        //dd($request->all());
        $data = $request->all();
        $data['user_id']=auth('admin')->id();
        $specs=json_decode($data['specs'],true);//转为数组
        //dd($specs);
        //计算商品总数量
        $total=0;
        foreach($specs as $v){
            $total += $v['total'];
        }
        $data['total']=$total;
        //执行完成 create 之后,返回当前添加数据对象
        $good=$good->create($data);
        //dd($good->toArray());
        //添加商品详情表
        foreach($specs as $v){
            $spec = new Spec();
            $spec->spec = $v['spec'];
            $spec->total = $v['total'];
            $spec->good_id = $good->id;
            $spec->save();
        }
        return redirect()->route('admin.good.index')->with('success','添加成功');
    }

    public function show(Good $good)
    {
        //
    }

    public function edit(Good $good,Category $category)
    {
        //dd($category->all());
        $categories = $category->getTreeData(Category::all()->toArray());
        //dd($good->toArray());
        //dd($categories);
        return view('admin.good.edit',compact('good','categories'));
    }

    public function update(GoodRequest $request, Good $good)
    {
//dd($good->specs->toArray());
        $good->update($request->all());
        //dd($good->toArray());
        return redirect()->route('admin.good.index')->with('success','操作成功');
    }

    public function destroy(Good $good)
    {
        $good->delete();
        return back()->with('success','删除成功');
    }
}

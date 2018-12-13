<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    public function index(Category $category)
    {
        //树状结构:https://packagist.org/packages/houdunwang/arr
        //安装方式:composer require houdunwang/arr
        //$categories = $category->toArray();
        $categories = $category->getTreeData(Category::all()->toArray());
        //dd($categories);
        return view('admin.category.index',compact('categories'));
    }

    public function create(Category $category)
    {
        //获取所有栏目数据,用于循环到添加页面父级栏目
        $categories = $category->getTreeData(Category::all()->toArray());
        //dd($categories);
        return view('admin.category.create',compact('categories'));
    }

    public function store(CategoryRequest $request,Category $category)
    {
        //Category::create($request->all());//这个相当于下面的三句，但是又问题
        //因为没有在模型里面填写$fillable字段
        $category->name = $request->name;
        $category['pid'] = $request['pid'];
        $category->save();
        return redirect()->route('admin.category.index')->with('success','栏目添加成功');
    }

    public function edit(Category $category)
    {
        $categories = $category->getEditCategorys($category['id']);
        //dd($categories);
        return view('admin.category.edit',compact('category','categories'));
    }

    public function update(Request $request,Category $category)
    {
        //Category::update($request->all());//为什么不能这样用呢？因为没有在模型里面填写$fillable字段
        $category->name = $request->name;
        $category->pid = $request->pid;
        $category->save();
        return redirect()->route('admin.category.index')->with('success','栏目编辑成功');
    }

    public function destroy(Category $category)
    {
        if(Category::where('pid',$category['id'])->first()){
            return redirect()->back()->with('danger','请先删除子集数据');
        }
        $category->delete();
        return redirect()->route('admin.category.index')->with('success','操作成功');
    }
}

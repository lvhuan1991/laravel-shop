<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\AddressRequest;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddressController extends CommonController
{
    public function __construct()
    {
        $this->middleware( 'auth' , [
            'except'=>[] ,
        ] );
        //因为如要执行父级构造方法,运行父级构造方法,不然当前构造方法会覆盖父级构造方法
        parent::__construct();
    }

    public function index()
    {
        //获取所有地址数据
        $addresses=Address::get();
        //dd($addresses);
        return view('home.address.index',compact('addresses'));
    }

    public function create()
    {
        return view('home.address.create');
    }

    public function store(AddressRequest $request,Address $address)
    {
        //如果不关联直接创建就没有user_id
        $address = auth()->user()->address()->create($request->all());
        //dd($request->all());
        //$address = $address->create($request->all());
        //$address->update(['user_id'=>auth()->id()]);
        //dd($address);
        //将其他数据默认地址修改
        if($request->is_default){
            Address::where('user_id',auth()->id())->where('id','!=',$address['id'])->update(['is_default'=>0]);
        }

        return redirect()->route('home.address.index')->with('success','添加成功');
    }

    public function show(Address $address)
    {
        //
    }

    public function edit(Address $address)
    {
        //
    }

    public function update(AddressRequest $request, Address $address)
    {
        //
    }

    public function destroy(Address $address)
    {
        //
    }
}

@extends('admin.layouts.master')
@section('content')
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">首页</a></li>
                <li class="breadcrumb-item active">商品管理</li>
            </ol>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-b-0">
            <h4 class="card-title">商品管理</h4>
        </div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs customtab" role="tablist">
            <li class="nav-item">
                <a class="nav-link " href="{{route('admin.good.index')}}">
                    <span class="hidden-sm-up"><i class="ti-home"></i></span>
                    <span class="hidden-xs-down">商品列表</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{route('admin.good.create')}}">
                    <span class="hidden-sm-up"><i class="ti-user"></i></span> <span
                        class="hidden-xs-down">添加商品</span>
                </a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="card-header"></div>
            <div class="card-body">
                <form action="{{route('admin.good.store')}}" method="post"
                      class="form-horizontal ">
                @csrf
                    <div class="row">
                        <div class="col-6">
                            <!--/row-->
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">商品名称</label>
                                <div class="col-md-9">
                                    <input type="text" placeholder="请输入商品名称" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">商品价格</label>
                                <div class="col-md-9">
                                    <input type="number" placeholder="请输入商品价格" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">所属分类</label>
                                <div class="col-md-9">
                                    <select class="form-control custom-select" data-placeholder="Choose a good"
                                            tabindex="1">
                                        <option value="">请选择分类</option>
                                        @foreach($categories as $category)
                                            {{--<option value="{{$category['id']}}">{{$category['name']}}</option>--}}
                                            <option value="{{$category['id']}}">{!! $category['_name'] !!}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-control-feedback"> 请选择父级商品</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">商品列表图片</label>
                                <div class="col-md-9">
                                    <div class="layui-upload-drag" id="test10">
                                        <i class="layui-icon"></i>
                                        <p>点击上传，或将文件拖拽到此处</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">商品图册</label>
                                <div class="col-md-9">
                                    <div class="layui-upload">
                                        <button type="button" class="layui-btn" id="test2">多图片上传</button>
                                        <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                                            <div class="layui-upload-list" id="demo2"></div>
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">商品描述</label>
                                <div class="col-md-9">
                                    <textarea class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">商品详情</label>
                                <div class="col-md-9">
                                    <textarea id="demo" style="display: none;"></textarea>

                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">规格名称</label>
                                        <div class="col-md-9">
                                            <input type="text" placeholder="14寸 64G 内存" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">库存</label>
                                        <div class="col-md-9">
                                            <input type="text" placeholder="100" class="form-control">
                                        </div>
                                    </div>
                                    <button class="btn btn-danger btn-sm pull-right" type="button">删除</button>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">规格名称</label>
                                        <div class="col-md-9">
                                            <input type="text" placeholder="14寸 64G 内存" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">库存</label>
                                        <div class="col-md-9">
                                            <input type="text" placeholder="100" class="form-control">
                                        </div>
                                    </div>
                                    <button class="btn btn-danger btn-sm pull-right" type="button">删除</button>
                                </div>
                            </div>
                            <div class="">
                                <button type="button" class="btn btn-success">添加规格</button>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn btn-success">保存数据</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('org/layui/css/layui.css')}}">
@endpush
@push('js')
    <script src="{{asset('org/layui/layui.js')}}"></script>
    <script>
        layui.use('upload', function(){
            var $ = layui.jquery
                ,upload = layui.upload;

            // //普通图片上传
            // var uploadInst = upload.render({
            //     elem: '#test1'
            //     ,url: '/upload/'
            //     ,before: function(obj){
            //         //预读本地文件示例，不支持ie8
            //         obj.preview(function(index, file, result){
            //             $('#demo1').attr('src', result); //图片链接（base64）
            //         });
            //     }
            //     ,done: function(res){
            //         //如果上传失败
            //         if(res.code > 0){
            //             return layer.msg('上传失败');
            //         }
            //         //上传成功
            //     }
            //     ,error: function(){
            //         //演示失败状态，并实现重传
            //         var demoText = $('#demoText');
            //         demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
            //         demoText.find('.demo-reload').on('click', function(){
            //             uploadInst.upload();
            //         });
            //     }
            // });

            //拖拽上传
            upload.render({
                //参数选项参考：https://www.layui.com/doc/modules/upload.html

                elem: '#test10'   //指向容器选择器，如：elem: '#id'。也可以是DOM对象
                //,data: {}
                //,headers: {}//接口的请求头。如：headers: {token: 'sasasas'}。注：该参数为 layui 2.2.6 开始新增
                ,url: '{{route('util.upload')}}'    //服务端上传接口
                ,size: 60000      //限制文件大小，单位 KB
                ,accept: 'images' //{指定允许上传时校验的文件类型，可选：images（图片）、file（所有文件）、video（视频）、audio（音频）}
                ,acceptMime: 'image/jpg, image/png' //规定打开文件选择框时，筛选出的文件类型
                ,exts: 'jpg|png'  //允许上传的文件后缀。一般结合 accept 参数类设定
                ,drag:true        //是否接受拖拽的文件上传，设置 false 可禁用。不支持ie8/9
                ,done: function(res){
                    console.log(res)
                }
            });
        });
    </script>
@endpush

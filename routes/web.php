<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//laravel欢迎界面
//Route::get('/', function () {
//    return view('welcome');
//});
//前台首页
Route::get('/','Home\HomeController@index')->name('index');
//后台首页
Route::get('admin/index','Admin\IndexController@index')->name('admin.index');
//后台登录与退出
Route::get('admin/login','Admin\LoginController@index')->name('admin.login');
Route::post('admin/login','Admin\LoginController@login')->name('admin.login');
Route::get('admin/logout','Admin\LoginController@logout')->name('admin.logout');

Route::group(['prefix'=>'admin','namespace'=>'Admin','as'=>'admin.'],function(){
    //后台栏目管理
    Route::resource('category','CategoryController');
    //后台商品管理
    Route::resource('good','GoodController');
});

//工具类
Route::group(['prefix'=>'util','namespace'=>'Util','as'=>'util.'],function(){
    //上传(注意只有资源路由不需要取小名、其他的都可以取小名)
    Route::any('upload','UploadController@upload')->name('upload');
});

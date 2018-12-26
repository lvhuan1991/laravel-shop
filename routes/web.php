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
//前台路由
Route::group(['prefix'=>'home','namespace'=>'Home','as'=>'home.'],function(){
    Route::get('/','HomeController@index')->name('home');
    Route::get('list/{list}','ListController@index')->name('list');
    Route::get('content/{content}','ContentController@index')->name('content');
    //前台搜索管理
    Route::get('search','HomeController@search')->name('search');
    //根据规格请求对应的库存
    Route::post('spec_to_get_total','ContentController@specGetTotal')->name('spec_to_get_total');
    //购物车
    Route::resource('cart','CartController');
    //订单管理
    Route::resource('order','OrderController');
    //个人中心
    Route::get('personal_center','PersonalCenterController@index')->name('personal_center');
    //收货地址管理
    Route::resource('address','AddressController');
    //支付模板页面
    Route::get( 'pay' , 'PayController@index' )->name( 'pay' );
    //检测订单是否支付
    Route::post('check_roder_status','PayController@checkOrderStatus')->name('check_roder_status');
    //微信支付回调通知
    Route::any('notify','PayController@notify')->name('notify');
    Route::get('qq_back','HomeController@qqBack')->name('qq_back');
});
//前台用户管理：登录、注册、退出、忘记密码、密码重置、个人信息
Route::group(['prefix'=>'user','namespace'=>'User','as'=>'user.'],function(){
    Route::get('login','UserController@login')->name('login');
    Route::post('login','UserController@loginFrom')->name('login');
    Route::get('register','UserController@register')->name('register');
    Route::post('register.from','UserController@registerFrom')->name('register.from');
    Route::get('logout','UserController@logout')->name('logout');
    Route::get('forget_password','UserController@forgetPasswordView')->name('forget_password');
    Route::post('forget_password','UserController@forgetPassword')->name('forget_password');
    Route::get('reset_password/{token}','UserController@resetPasswordView')->name('reset_password');
    Route::post('reset_password_post/{token}','UserController@resetPassword')->name('reset_password_post');
    //个人中心：个人信息
    Route::get('edit','UserController@edit')->name('edit');
    Route::post('personal_information','UserController@personalInformation')->name('personal_information');

});
//后台首页
Route::get('admin/index','Admin\IndexController@index')->name('admin.index');
//后台登录与退出
Route::get('admin/login','Admin\LoginController@index')->name('admin.login');
Route::post('admin/login','Admin\LoginController@login')->name('admin.login');
Route::get('admin/logout','Admin\LoginController@logout')->name('admin.logout');
//后台给了登录拦截(调用中间件拦截)
Route::group(['middleware'=>['admin.auth'],'prefix'=>'admin','namespace'=>'Admin','as'=>'admin.'],function(){
    //后台栏目管理
    Route::resource('category','CategoryController');
    //后台商品管理
    Route::resource('good','GoodController');
    //后台订单管理
    Route::resource('order','OrderController');
    //后台配置项管理
    //Route::resource('config','ConfigController');//这样写有问题跟不了参数 参数是自带的
    Route::get('config/index/{name}','ConfigController@index')->name('config.index');
    Route::post('config/update/{name}','ConfigController@update')->name('config.update');
    //后台用户(管理员)管理
    Route::resource('admin','AdminController');
    //给后台用户(管理员)设置角色
    Route::get('admin_set_role_create/{admin}','AdminController@adminSetRoleCreate')->name('admin_set_role_create');
    Route::post('admin_set_role_store/{admin}','AdminController@adminSetRoleStore')->name('admin_set_role_store');
    //后台角色管理、
    Route::resource('role','RoleController');
    //给后台角色设置权限/带一个参数知道具体角色
    Route::post('set_role_permission/{role}','RoleController@setRolePermission')->name('set_role_permission');
    //后台权限管理:主要是展示给管理员看的
    Route::get('permission','PermissionController@index')->name('permission');
    //清除后台权限缓存
    Route::get( 'forget_permission_cache' , 'PermissionController@forgetPermissionCache' )->name( 'forget_permission_cache' );

});

//工具类
Route::group(['prefix'=>'util','namespace'=>'Util','as'=>'util.'],function(){
    //上传(注意只有资源路由不需要取小名、其他的都可以取小名)
    Route::any('upload','UploadController@upload')->name('upload');
    //发送验证码
    Route::any('/code/send','CodeController@send')->name('code.send');
});

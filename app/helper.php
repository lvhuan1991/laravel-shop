<?php
//辅助函数

if(!function_exists('my_config')){
    //帮助读取后台配置项数据
    function my_config($var)
    {
        //dd($var);
        static $cache = [];
        $info = explode('.',$var);
        //dump($info);
        if(!$cache){
            //清空所有缓存
            //Cache::flush();
            //获取缓存中config_cache数据,如果数据不存在,那么会以第二个参数作为默认值
            $cache = Cache::get('config_cache',function(){
                return \App\Models\Config::pluck('data','name');
            }
            );
            //dump($cache);
        }
        //dd($cache[$info[0]][$info[1]]);
        //isset($cache[$info[0]][$info[1]])?$cache[$info[0]][$info[1]]:''
        return $cache[$info[0]][$info[1]]??'';
    }
}

if(!function_exists('admin_has_permission')){
    function admin_has_permission($permission)
    {
        if(is_array($permission)){
            if(!auth('admin')->user()->hasAnyPermission($permission)){
                throw  new \App\Exceptions\PermissionException('不准进去,再进去打死你丫的!!!');
            }
        }
        //hasAnyPermission和hasPermissionTo请参考手册用户之权限或者👇
        #https://github.com/spatie/laravel-permission#installation
        if(is_string($permission)){
            if(!auth('admin')->user()->hasPermissionTo($permission)){
                throw  new \App\Exceptions\PermissionException('不准进去,再进去打死你丫的!!!');
            }
        }
    }
}

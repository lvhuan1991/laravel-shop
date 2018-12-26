<?php

namespace App\Http\Middleware;

use Closure;

class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //验证如果没有登录、就返回登录页面
        if(!auth('admin')->check()){
            return redirect()->route('admin.login')->with('success','请先登录');
        }
        return $next($request);
    }
}

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
        //验证如果不是登录后台就返回登录页面
        if(!auth()->check()){
            return redirect()->route('admin.login');
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;

class AuthenticateOnceWithBasicAuth
{
    /**
     * 处理传入的请求
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, $next)
    {
        dd(Auth::onceBasic());
        if(Auth::onceBasic()){
            return json_encode(['code'=>401,'message'=>'need login']);
        }else{
            return $next($request);
        }
        //return Auth::onceBasic() ?: $next($request);
    }

}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthorizationRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;


class AuthorizationController extends Controller
{
    //

    public function store(AuthorizationRequest $request)
    {
        $credentials['account'] = $request->account;
        $credentials['password'] = $request->password;

        if(!$token = Auth::guard('api')->attempt($credentials)){
            return response()->error('用户名或密码错误');
        }else{
            return response()->success('登录成功',['access_token' => $token]);
        }
        
    }

    public function update()
    {
        $token = auth('api')->refresh();
        return $this->responseWithToken($token);
    }

    public function destroy()
    {
        auth('api')->logout();
        return response(null, 204);
    }

    protected function responseWithToken($token){
        return response()->success('红牛彩票',[
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }
}

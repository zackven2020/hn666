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
            throw new AuthenticationException('用户名或密码错误');
        }
        return response()->json(['code' => 200,'message' => '红牛彩票提供','access_token' => $token]);
        //return $this->responseWithToken($token)->setStatusCode(200);
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
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }
}

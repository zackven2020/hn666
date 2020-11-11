<?php
namespace App\Http\Controllers\Api;

use App\Models\Member;
use App\Http\Resources\UserResource;
use App\Http\Requests\Api\MemberRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Cache;

class MemberController extends Controller
{
    public function store(MemberRequest $request)
    {
        $verifyData = Cache::get($request->verification_key);

       if (!$verifyData) {
           abort(403, '验证码已失效');
        }

        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            // 返回401
            throw new AuthenticationException('验证码错误');
        }

        $user = Member::create([
            'account' => $request->account,
            'phone' => $verifyData['phone'],
            'password' => bcrypt($request->password),
        ]);

        // 清除验证码缓存
        Cache::forget($request->verification_key);

        return new UserResource($user);
    }
    
    
}

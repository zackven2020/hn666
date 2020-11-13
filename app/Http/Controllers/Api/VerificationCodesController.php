<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\VerificationCodeRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Overtrue\EasySms\EasySms;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request, EasySms $easySms)
    {
        $captchaData = Cache::get($request->captcha_key);

        if(!$captchaData){
            abort(403, '图片验证码已失效');
        }

        if(!hash_equals(strtoupper($captchaData['code']), strtoupper($request->captcha_code))){
            // 验证错误就清除缓存
            Cache::forget($request->captcha_code);
            throw new AuthenticationException('验证码错误');
        }

        $phone = $captchaData['phone'];

        //  标记特殊号码段，不需要发短信
        if(Str::startsWith($phone,'13800138')){
            $code = $mark = "0000";
        }else{
            $code = str_pad(rand(1,9999),4,0, STR_PAD_LEFT);
            Log::info("$phone 的验证码是: $code");
            try{
                $result = $easySms->send($phone, [
                    'template' => config('easysms.gateways.aliyun.templates.register'),
                    'data' => [
                        'code' => $code
                    ],
                ]);
            }catch (NoGatewayAvailableException $exception){
                $message = $exception->getException('aliyun')->getMessage();
                abort(500,$message?:'短信发送异常');
            }
        }

        $key = 'verificationCode_'.Str::random(15);
        $expiredAt = now()->addMinutes(30);

        // 缓存验证码， 30分钟有效
        Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);

        // 清除图片验证码缓存
        Cache::forget($request->captcha_code);
        return response()->json([
            'key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
            'mark' => $mark??NULL
        ])->setStatusCode(201);
    }

}

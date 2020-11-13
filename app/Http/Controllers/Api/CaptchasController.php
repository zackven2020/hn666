<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Gregwar\Captcha\CaptchaBuilder;
use App\Http\Requests\Api\CaptchaRequest;

class CaptchasController extends Controller
{
    public function store(CaptchaRequest $request, CaptchaBuilder $captchaBuilder)
    {
        $key = 'captcha-'.Str::random(15);
        $phone = $request->phone;
        $captchaBuilder->setTextColor(255,255,255);
        $captchaBuilder->setBackgroundColor(25, 137, 250);
        $captcha = $captchaBuilder->build($width = 80, $height = 30, $font = null);
        
        $expiredAt = now()->addMinutes(2);
        \Cache::put($key, ['phone' => $phone, 'code' => $captcha->getPhrase()], $expiredAt);

        $result = [
            'captcha_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
            'captcha_image_content' => $captcha->inline()
        ];

        return response()->json(['code' => 200,'message' => '红牛彩票提供','data' => $result]);
    }
}

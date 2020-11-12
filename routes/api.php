<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\NoticeController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\LotteryController;
use App\Http\Controllers\Api\CaptchasController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\AuthorizationController;
use App\Http\Controllers\Api\VerificationCodesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->namespace('Api')->name('api.v1.')->group(function() {

    // 一分钟 10 次 【低频次接口】
    Route::middleware('throttle:' . config('api.throttling.sign'))->group(function (){
        // 短信验证码
        Route::post('verificationCodes', [VerificationCodesController::class,'store'])->name('VerificationCodes.store');
        // 用户注册
        Route::post('users', [MemberController::class,'store'])->name('users.store');

    });

    //每分钟限制访问30次
    Route::middleware('throttle:' . config('api.throttling.access'))->group(function () {
        // banner
        Route::post('banner-lists',[BannerController::class,'lists'])->name('banner.lists');
        // 彩种
        Route::post('lottery-lists',[LotteryController::class,'lists'])->name('lottery.lists');
        // 菜单
        Route::post('lottery-menu-lists',[LotteryController::class,'menuLists'])->name('lottery.menuLists');
        // 获取彩票信息
        Route::post('lottery-info',[LotteryController::class,'info'])->name('lottery.info');
        // 开奖期号
        Route::post('current-issue',[LotteryController::class,'currentSaleIssue'])->name('lottery.currentSaleIssue');
        // 获取彩票玩法规则
        Route::post('lottery-rule-info',[LotteryController::class,'rule'])->name('lottery.rule');
        // 通知
        Route::post('notice-lists',[NoticeController::class,'lists'])->name('notice.lists');

        // 图片验证码
        Route::post('captchas', [CaptchasController::class,'store'])->name('captchas.store');

        // 用户登录
        Route::post('authorizations',[AuthorizationController::class,'store'])->name('api.authorizations.store');
        // 刷新 token
        Route::put('authorizations/current', [AuthorizationController::class,'update'])->name('authorizations.update');
        // 删除 token
        Route::delete('authorizations/current',[AuthorizationController::class,'destroy'])->name('authorizations.destroy');
    });

    //需要授权的接口
    Route::middleware(['auth.jwt','throttle:' . config('api.throttling.access')])->group(function(){
        // 订单
        Route::post('init-order', [OrderController::class,'initOrder'])->name('order.initOrder');
    });

});

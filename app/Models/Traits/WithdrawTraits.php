<?php

namespace App\Models\Traits;

use App\Models\Withdraw as BaseWithdraw;
use Cache;
use phpDocumentor\Reflection\Types\Collection;


trait WithdrawTraits
{
    protected static $withdraw_key = 'withdraw_key';
    protected static $times_key    = '60';
    protected static $totalWithdraw = 'total_withdraw'; // 系统会员出金总金额


    public static function withdraw()
    {
        return Cache::remember(self::$withdraw_key, self::$times_key, function(){

            return BaseWithdraw::get();
        });
    }


    /***
     * 查询系统总出金和代理下的会员当日出金
     * @param null $dayAgentInfo  某个代理入金数据
     * @param null $time          是否查询当天数据
     * @return mixed
     */
    public static function todayWithdraw($dayAgentInfo = null, $time = null)
    {
        $withdraw = collect(self::withdraw());

        // 如果不为null，就是查询某个代理会员的出金记录
        if ($dayAgentInfo) {
            return $dayAgentInfo->pluck('day_deposit')->sum();
        }

        if ($time) {
            $withdraw = $withdraw->whereBetween('created_at', [
                getDayStartDate(), getDayEndDate()
            ]);
        }

        return $withdraw->where('status', 1)->pluck('money')->sum();
    }



    
}
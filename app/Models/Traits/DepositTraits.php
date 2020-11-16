<?php

namespace App\Models\Traits;

use App\Models\Deposit;
use Cache;


trait DepositTraits
{
    protected static $withdraw_key = 'deposit_key';
    protected static $times_key    = '60';
    protected static $totalWithdraw = 'total_deposit'; // 系统会员出金总金额


    public static function deposit()
    {
        return Cache::remember(self::$withdraw_key, self::$times_key, function(){

            return Deposit::get();
        });
    }


    /***
     * 查询系统总入金和代理下的会员当日入金
     * @param null $agentId 代理ID
     * @return mixed
     */
    public static function todayDeposit($dayAgentInfo = null, $time = null)
    {
        $deposit = collect(self::deposit());

        // 如果不为null，就是查询某个代理会员的出金记录
        if ($dayAgentInfo) {
            return $dayAgentInfo->pluck('day_deposit')->sum();
        }

        if ($time) {
            $deposit = $deposit->whereBetween('created_at', [
                getDayStartDate(), getDayEndDate()
            ]);
        }

        return $deposit->where('status', 1)->pluck('money')->sum();
    }



    
}
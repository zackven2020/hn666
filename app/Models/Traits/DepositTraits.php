<?php

namespace App\Models\Traits;

use App\Models\Deposit;
use Cache;


trait DepositTraits
{
    protected static $withdraw_key = 'deposit_key';
    protected static $times_key    = '60';
    protected static $totalWithdraw = 'total_deposit'; // 系统会员出金总金额


    public function deposit()
    {
        return Cache::remember(self::$withdraw_key, self::$times_key, function(){

            return $this->get();
        });
    }


    /***
     * 查询系统总入金和代理下的会员当日入金
     * @param null $agentId 代理ID
     * @return mixed
     */
    public function todayDeposit($time = null)
    {
        $deposit = collect($this->deposit());

        if ($time) {
            $deposit = $deposit->whereBetween('created_at', [
                getDayStartDate(), getDayEndDate()
            ]);
        }

        return $deposit;
    }



    
}
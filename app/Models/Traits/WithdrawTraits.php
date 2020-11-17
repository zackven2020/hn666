<?php

namespace App\Models\Traits;

use Cache;


trait WithdrawTraits
{
    protected static $withdraw_key = 'withdraw_key';
    protected static $times_key    = '60';
    protected static $totalWithdraw = 'total_withdraw'; // 系统会员出金总金额


    public function withdraw()
    {
        return Cache::remember(self::$withdraw_key, self::$times_key, function(){

            return $this->get();
        });
    }


    /***
     * 查询系统总出金和代理下的会员当日出金
     * @param null $dayAgentInfo  某个代理入金数据
     * @param null $time          是否查询当天数据
     * @return mixed
     */
    public function todayWithdraw($time = null)
    {
        $withdraw = collect($this->withdraw());

        if ($time) {
            $withdraw = $withdraw->whereBetween('created_at', [
                getDayStartDate(), getDayEndDate()
            ]);
        }

        return $withdraw;
    }



    
}
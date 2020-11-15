<?php

namespace App\Models\Traits;

use App\Models\Withdraw as BaseWithdraw;
use Cache;


trait WithdrawTraits
{
    protected static $withdraw_key = 'withdraw_key';
    protected static $times_key    = '60';


    public static function withdraw($start = 0, $end = 0)
    {
        return Cache::remember(self::$withdraw_key, self::$times_key, function(){

            return BaseWithdraw::get();
        });
    }


    /***
     * 查询系统总出金和代理下的会员当日出金
     * @param null $agentId 代理ID
     * @return mixed
     */
    public static function todayWithdraw($agentId = null, $start = 0, $end = 0)
    {
        $withdraw = collect(self::withdraw());

        // 如果不为null，就是查询某个代理会员的出金记录
        if ($agentId) {
            $agentInfo = AgentInfoTraits::dayAgentInfo($agentId);
            if ($agentInfo) {
                return $agentInfo['day_withdraw'];
            }
            $withdraw->whereBetween('created_at', [
                getDayStartDate($start), getDayEndDate($end)
            ])->where('user_id', MemberTraits::getMemberId($agentId));
        }
        return $withdraw->where('status', 1)->pluck('money')->sum();
    }



    
}
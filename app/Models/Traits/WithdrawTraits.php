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
            ])->where('user_id', self::getMemberId($agentId));
        }
        return $withdraw->where('status', 1)->pluck('money')->sum();
    }


    /***
     * 获取指定代理下的出金会员ID
     * @param $agentId
     * @return \Illuminate\Support\Collection|\Tightenco\Collect\Support\Collection
     */
    public static function getMemberId($agentId)
    {
        // 所有代理帐号
        $agentAll = getAgentCache();
        // 所有会员帐号
        $memberAll = getMemberCache();

        $agentIds = getMemberTeamId($agentAll, $agentId);
        $member   = collect($memberAll)->whereIn('agent_id', $agentIds);

        return $member->pluck('id');
    }


    
}
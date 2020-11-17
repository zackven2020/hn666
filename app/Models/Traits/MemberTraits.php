<?php

namespace App\Models\Traits;

use Cache;


trait MemberTraits
{
    protected static $member_key = 'member_key';
    protected static $times_key    = '60';


    public function member()
    {
        return Cache::remember(self::$member_key, self::$times_key, function(){

            return $this->get();
        });
    }


    /***
     * 获取指定代理下的所有会员ID
     * @param $agentId
     * @return \Illuminate\Support\Collection|\Tightenco\Collect\Support\Collection
     */
    public function getMemberId($agentId)
    {
        // 所有代理帐号
        $agentAll = getAgentCache();
        // 所有会员帐号
        $memberAll = $this->todayMember();

        $agentIds = getMemberTeamId($agentAll, $agentId);
        $member   = collect($memberAll)->whereIn('agent_id', $agentIds);

        return $member;
    }



    /***
     * 查询系统当天注册会员和全部会员
     * @param null $agentId 代理ID
     * @return mixed
     */
    public function todayMember($time = null)
    {
        $member = collect($this->member());

        if ($time) {
            $member = $member->whereBetween('created_at', [
                getDayStartDate(), getDayEndDate()
            ]);
        }
        return $member;
    }
    
}
<?php

namespace App\Models\Traits;

use App\Models\Member;
use Cache;


trait MemberTraits
{
    protected static $member_key = 'member_key';
    protected static $times_key    = '60';


    public static function member()
    {
        return Cache::remember(self::$member_key, self::$times_key, function(){

            return Member::get();
        });
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



    /***
     * 查询系统总入金和代理下的会员当日入金
     * @param null $agentId 代理ID
     * @return mixed
     */
    public static function todayMember($time = null)
    {
        $member = collect(self::member());

        if ($time) {
            $member = $member->whereBetween('created_at', [
                getDayStartDate(), getDayEndDate()
            ]);
        }
        return $member->count();
    }
    
}
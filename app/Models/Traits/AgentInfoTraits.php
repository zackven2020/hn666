<?php

namespace App\Models\Traits;

use Cache;
use App\Models\AgentInfo;



trait AgentInfoTraits
{
    protected static $withdraw_key = 'agentinfo_key';
    protected static $times_key    = '60';


    public static function agentInfo()
    {
        return Cache::remember(self::$withdraw_key, self::$times_key, function(){
            return AgentInfo::get();
        });
    }


    public static function dayAgentInfo($agentId = null, $time = true)
    {
        $agentInfo = collect(self::agentInfo());

        if ($agentId) {
            $agentInfo->where('agent_id', $agentId);
        }
        if ($time) {
            $agentInfo->whereBetween('created_at', [getDayStartDate(), getDayEndDate()]);
        }
        return $agentInfo;
    }







    
}
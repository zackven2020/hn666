<?php

namespace App\Models\Traits;

use Cache;
use App\Models\AgentInfo;



trait AgentInfoTraits
{
    protected static $withdraw_key = 'agentinfo_key';
    protected static $times_key    = '60';


    public function agentInfo()
    {
        return Cache::remember(self::$withdraw_key, self::$times_key, function(){
            return $this->get();
        });
    }


    /***
     * 获取今日代理数据
     * @param null $agentId  指定代理ID
     * @param bool $time     指定查询时间段，默认为今天
     * @param int $start     开始时间，当天后退多少天，0为当天 00:00:00
     * @param int $end       结束时间，当天前进多少天，0为当天 23:59:59
     * @return \Illuminate\Support\Collection|\Tightenco\Collect\Support\Collection
     */
    public function dayAgentInfo($agentId = null, $time = true, $start = 0, $end = 0)
    {
        $agentInfo = collect($this->agentInfo());

        if ($agentId) {
            $agentInfo = $agentInfo->where('agent_id', $agentId);
        }

        if ($time) {
            $agentInfo = $agentInfo->whereBetween('created_at', [getDayStartDate($start), getDayEndDate($end)]);
        }
        return $agentInfo;
    }







    
}
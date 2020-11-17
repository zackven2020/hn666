<?php

namespace App\Jobs;

use App\Models\Agent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Member;
use App\Models\Deposit;
use App\Models\Withdraw;



class AgentInfoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $agent;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Agent $agent, $ttl = 5)
    {
        $this->agent = $agent;
        $this->delay($ttl);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $result = $this->agent->agentInfo()->whereBetween('created_at', [
            getDayStartDate(), getDayEndDate()
        ])->first();

        if (!$result) {
            $agentInfo = $this->agent->agentInfo()->make($this->handleData());
            $agentInfo->agent()->associate($this->agent);
            $agentInfo->save();
        }else{
            $result->update($this->handleData());
        }
    }



    public function handleData()
    {
        $memberId = (new Member())->getMemberId($this->agent->id);
        // 代理会员当天存款
        $deposit  = (new Deposit())->todayDeposit(true)->whereIn('user_id', $memberId->pluck('id'))->where('status', 1)
                    ->where('money_type', 1)->sum('money');
        // 代理会员当天出金
        $withdraw  = (new Withdraw())->todayWithdraw(true)->whereIn('user_id', $memberId->pluck('id'))->where('status', 1)
                    ->where('money_type', 1)->sum('money');
        // 当天赢亏
        $day_withdraw = $withdraw - $withdraw;
        // 代理今日 下级升代理
        $dayAgent = $this->agent->childrenModule()->whereBetween('created_at', [
            getDayStartDate(), getDayEndDate()
        ])->count();
        // 代理今日直推会员
        $dayMember = $this->agent->member()->whereBetween('created_at', [
            getDayStartDate(), getDayEndDate()
        ])->count();

        return [
            'day_deposit'   => $deposit,
            'day_withdraw'  => $withdraw,
            'win_and_lose'  => $day_withdraw,
            'day_agent'     => $dayAgent,
            'day_member'    => $dayMember,
            'day_total_member'=> $memberId->count(),
        ];
    }
}

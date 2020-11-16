<?php

namespace App\Jobs;

use App\Models\Agent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;




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

        if ($result) {
            $agentInfo = $this->agent->agentInfo()->make([
                'day_deposit'=> 1,
                'day_withdraw'=> 1,
                'win_and_lose'=> 1,
                'day_agent'=> 1,
                'day_member'=> 1,
                'day_total_member'=> 1,
            ]);
            $agentInfo->agent()->associate($this->agent);
            $agentInfo->save();
        }
        //
    }
}

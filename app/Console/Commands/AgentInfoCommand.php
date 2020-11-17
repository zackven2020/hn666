<?php

namespace App\Console\Commands;

use App\Models\Agent;
use Illuminate\Console\Command;
use App\Models\AgentInfo;
use App\Jobs\AgentInfoJob;
use Carbon\Carbon;



class AgentInfoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:agent-info';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成代理用户每日信息数据';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::channel('command')->info(Carbon::now()->toDateTimeString() . '/ 测试一下');
        $Agent = Agent::query()->get();
        foreach ($Agent as $k=>$v) {
            dispatch(new AgentInfoJob($v))->onQueue('agent_info_job');
        }
    }


}

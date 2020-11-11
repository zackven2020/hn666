<?php

namespace App\Console\Commands;

use App\Models\CliWork;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProtectSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lottery:protect';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '守护进程';

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
        $cli_works = CliWork::query()->where('status',1)->pluck('name');

        foreach ($cli_works as $work){
            // 检测该进程是否活跃  如果redis或者redis保存时间超过30秒， 则视为进程中断，重新发起进程
            if(Cache::has($work) && time() - Cache::get($work) < 60){
                Log::channel('protect')->info(" 进程状态良好 $work ");
            }else{
                Log::channel('protect')->info(" 重新拉起进程 $work ");
                // 往下走，程序就不会结束了，一直循环到挂为止
                switch ($work){
                    case 'cli_api_urls':
                        $schedule = new OepnLottery();
                        $schedule->handle();
                        break;
                    default:
                        break;
                }
                
            }
        }

    }
}

<?php

namespace App\Console\Commands;

use App\Models\GameList;
use App\Models\OpenHistory;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;


class OepnLottery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lottery:open';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '开奖';

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
        //$this->kernel_log('定时任务获取结果 ===begin====');
        //echo 444;die;
        //while (true){
        try{
            $game_list = $this->get_url_list();
            //$this->kernel_log('定时任务获取结 $game_list' . json_encode($game_list));
            $result_data = $this->multi_curl($game_list);
            $this->save_to_database($result_data);
            Cache::put('cli_api_urls',time());
            Log::channel('api_urls')->info(Cache::get('cli_api_urls').' -- 采集完毕');
        }catch (\Exception $exception){
            Log::channel('cli_works')->error($exception);
            Log::channel('cli_works')->error(json_encode($result_data));
        }
        //$this->kernel_log('定时任务获取结 ===end====');
            //sleep(5);
        //}
    }
    
    public function kernel_log($msg){
        //一定加$monolog这两句，不然会打印两份日志
        $monolog = Log::getMonolog();
        $monolog->popHandler();
        //  Log::useDailyFiles(storage_path('logs/error/test.log'));
        //  Log::useFiles(storage_path('logs/kernel_log/kernel.log'));
         Log::useDailyFiles(storage_path('/logs/kernel_log/kernel.log'));
         
        //  Log::emergency("系统挂掉了");
        //  Log::alert("数据库访问异常");
        //  Log::critical("系统出现未知错误");
        //  Log::error("指定变量不存在");
        //  Log::warning("该方法已经被废弃");
        //  Log::notice("用户在异地登录");
        //  Log::debug("调试信息");
         Log::info($msg);
        
     }


    /**
     * 获取需要被执行的 URLS
     * @param $ignore_status array 默认只执行状态为 1 的接口 api_url
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|mixed
     */
    public function get_url_list($ignore_status = [1])
    {
        $key_name = 'api_game_list'.date('H');

        if(Cache::has($key_name)){
            $redis_game_list = Cache::get($key_name);
        }else{
            $redis_game_list = GameList::query()
                ->whereIn('api_status',$ignore_status)
                ->whereNotNull('api_url')
                ->get()
                ->map(function ($item){
                    if(empty($item->start_at) || empty($item->end_at)){
                        return $item;
                    }
                    $start_at = strtotime(date('Y-m-d '.$item->start_at));
                    $end_at = strtotime(date('Y-m-d '.$item->end_at));
                    if($start_at < time() && time() < $end_at){
                        return $item;
                    }
                })->filter()->pluck('api_url');
            Cache::put($key_name,$redis_game_list,60*60);
        }
        return $redis_game_list;
    }

    /**
     * 多线程获取 api 接口
     * @param $urls
     * @return array
     */
    public function multi_curl($urls)
    {
        //1、初始化一个批处理handle
        $mh = curl_multi_init();

        //2、往批处理handle 添加curl_init来的子handle
        foreach ($urls as $i => $url) {
            $conn[$i] = curl_init($url);
            curl_setopt($conn[$i], CURLOPT_HEADER, 0);
            curl_setopt($conn[$i], CURLOPT_CONNECTTIMEOUT, 5);  // 5秒超时
            curl_setopt($conn[$i], CURLOPT_RETURNTRANSFER, true);
            curl_multi_add_handle($mh, $conn[$i]);
        }

        //3、并发执行，直到全部结束。
        do {
            curl_multi_exec($mh, $active);
        } while ($active > 0);

        //4、获取结果
        $data = [];
        foreach ($urls as $i => $url) {
            array_push($data,curl_multi_getcontent($conn[$i]));
        }

        //5、移除子handle，并close子handle
        foreach ($urls as $i => $url) {
            curl_multi_remove_handle($mh,$conn[$i]);
            curl_close($conn[$i]);
        }

        //6、关闭批处理handle
        curl_multi_close($mh);

        return $data;
    }

    public function save_to_database($data)
    {
        if(is_array($data) && !empty($data)){
            foreach ($data as $item){
                $item = json_decode($item,true);
                $item_data = $item['data'];
                $item_code = $item['code'];

                $item_code = str_replace('cqssc','cqhlsx',$item_code);
                $item_code = str_replace('mlaft168','xyft',$item_code);
                $item_code = str_replace('hk6','xglhc',$item_code);
                $item_code = str_replace('am6','amlhc',$item_code);

                foreach ($item_data as $single_item){
                    $query_data = [
                        'game_type'=>$item_code,
                        'term'=>$single_item['expect'],
                        'number'=>$single_item['opencode'],
                        'add_time'=>$single_item['opentime'],
                        'term_time'=>$single_item['opentimestamp'],
                    ];
                    OpenHistory::query()->firstOrCreate($query_data,$query_data);
                }
            }
        }
    }
}

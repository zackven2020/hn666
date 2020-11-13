<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 获取缓存内容
     * @param $cache_name
     * @return mixed|string
     */
    public function getCache($cache_name)
    {
        $cache_name .= Carbon::today()->toDateString();
        if(Cache::get($cache_name)){
            return Cache::get($cache_name);
        }else{
            return '';
        }
    }

    /**
     * 存入缓存内容
     * @param $cache_name
     * @param $data
     * @param float|int $time
     */
    public function setCache($cache_name, $data, $time = 60*60*24)
    {
        Cache::put($cache_name,$data,$time);
    }
}

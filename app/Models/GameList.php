<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class GameList extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'game_list';

    public function wanfa()
    {
        return $this->hasMany(Wanfa::class,'parent_game_id','id');
    }
    
    /**
     * 计算当前开奖期号
     * @desc 比官网要早开 2分钟
     * 1 系统投注开始时间 saleOpenTime
     * 2 系统投注结束时间 saleEndTime
     * 3 实际开奖时间 openTime
     * 4 距离下次时间 slotTime
     * 5 投注期号 issue
     * 
     * @params $name 彩票名称
     */
    public static function calcNextOpenIssue($name){
    	switch (strtolower($name)) {
    		case 'pk10':
    		    //每20分钟开一次
    		    $step = 1200;
    		    //每天开44期
    		    $len = 44;
    		    //初始化信息
    		    $initIssue = 750996;
        		$initTime = 1602293310;
    		    //每天早上9:30开始
    		    $dayStartTime = strtotime(date('Y-m-d 9:30'));
    		    //每天晚上11:50结束
    		    $dayEndTime = strtotime(date('Y-m-d 23:50'));
    		    
    		    $currentTime = time();
    		 
    		    
    		    //向上取整
    		    $diffDay = ceil(($currentTime - $initTime) / 86400);
    		    if($diffDay > 0){
    		        //每天开44期
    		        $initIssue += $diffDay * 44;
    		        $initTime += $diffDay * 86400;
    		    }
    		    
    		    if ($currentTime > $dayEndTime) {
    		        //如果当前时间大于最后一次开奖时间
    		        $extIssue = 0;
        			$currentIssue = $initIssue + $extIssue;
        			$saleOpenTime = strtotime(date("Y-m-d 9:30",strtotime("+1 day"))) - 90;
        			$saleEndTime  = $saleOpenTime + $step;
        			$openTime = $dayStartTime;
        			$endTime  = $openTime + $step;
        			$slotTime = $saleOpenTime - $currentTime;
        			$isShow = 0;
    		    }elseif ($currentTime < $dayStartTime) {
        			$currentIssue = $initIssue;
        			$saleOpenTime = $dayStartTime - 90;
        			$saleEndTime  = $saleOpenTime + $step;
        			$openTime = $dayStartTime;
        			$endTime  = $openTime + $step;
        			$slotTime = $saleOpenTime - $currentTime;
        			$isShow = 0;
    		    }else{
    		        $extIssue = ceil(($currentTime - $dayStartTime) / $step);
        			$currentIssue = $initIssue + $extIssue - $len;
        			$saleOpenTime = $dayStartTime + $extIssue * $step - 90;
        			$saleEndTime  = $saleOpenTime + $step;
        			$openTime = $dayStartTime + $extIssue * $step;
        			$endTime  = $openTime + $step;
        			$slotTime = $saleOpenTime - $currentTime;
        			$isShow = 0;
    		    }
    			
    			$data = [
    			    'sale' =>  0,
    			    'isShow' =>  ($saleOpenTime - $currentTime) < 0 ? 0 : 1,//是否展示
                    'issue' =>  $currentIssue,//期号
                    'endTime' => $saleEndTime,//停止投注时间
                    'startTime' =>  $saleOpenTime,//开始投注时间
                    'openTime' => ($openTime - $currentTime) * 1000,//开奖剩余时间
                    'slotTime' => $slotTime * 1000
                    ];
    			break;
    		default:
    			$data = [
    			    'isShow' => 1,
                    'endTime' => 1602322110000,
                    'isLow' =>  0,
                    'issue' =>  "751020",
                    'sale' =>  0,
                    'startTime' =>  1602320910000,
                    'slotTime' => 1200000
                    ];
    			break;
    	}
    	
    	return $data;
    }

}

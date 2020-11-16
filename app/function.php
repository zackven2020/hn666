<?php


use Carbon\Carbon;
use App\Models\Agent;
use App\Models\Member;



/**
 * 计算自身下的所有会员,返回所有ID
 * @param $members
 * @param $id
 * @param $times 传过来的时间
 */
function getMemberTeamId($members, int $id , $pid = 'parent_id'){
    $Teams = array($id);//最终结果
    $mids = array($id);//第一次执行时候的用户id
    do{
        $othermids = array();
        $state = false;
        foreach ($mids as $v) {
            foreach($members as $k => $memeber) {
                if($memeber[$pid] == $v){
                    $Teams[]        = $memeber['id'];//找到我的下级立即添加到最终结果中
                    $othermids[]    = $memeber['id'];//将我的下级id保存起来用来下轮循环他的下级
                    //unset($members[$k]);// 从大数组里删除 ，运行要快100倍
                    $state=true;
                }
            }
        }
        $mids = $othermids; //foreach中找到的我的下级集合,用来下次循环
    }while($state == true);

    return $Teams;
}


/***
 * 获取几号的开启时间日期 2020-11-13 00:00:00
 * @param int $num 往后几天
 * @return string
 */
function getDayStartDate($num = 0){
    return Carbon::today()->subDays($num)->toDateTimeString();
}


/***
 * 获取几号的结束时间日期
 * 2020-11-13 23:59:59
 * @param int $num 往后几天
 * @return string
 */
function getDayEndDate($num = 0){
    return Carbon::today()->endofDay($num)->toDateTimeString();
}


/***
 * 获取所有代理帐号
 * @return mixed
 */
function getAgentCache(){
    return \Cache::remember('agent_cache', 60, function(){
        return Agent::get();
    });
}

/***
 * 获取所有会员帐号
 * @return mixed
 */
function getMemberCache(){
    return \Cache::remember('member_cache', 60, function(){
        return Member::get();
    });
}


/***
 * 设置系统参数缓存
 * @param array $arr
 * @return mixed
 */
function setSysCacheArray(array $arr = []) {
    $result =  \Cache::remember('set_cache_sys_array', 60, function(){
        return [];
    });
    $arrResult = array_merge($result, $arr);
    \Cache::put('set_cache_sys_array', $arrResult, 600);
    return \Cache::get('set_cache_sys_array');
}


/***
 * 检测系统是否有某个变量
 * @param string $str
 * @return mixed
 */
function verifSysCacheArray($str = '') {
    $result = \Cache::get('set_cache_sys_array');

    if (isset($result[$str])) {
        return \Cache::get('set_cache_sys_array');
    }

    return null;
}





<?php


/**
 * 计算自身下的所有会员,返回所有ID
 * @param $members
 * @param $id
 * @param $times 传过来的时间
 */
function getMemberTeamId($members, $id , $pid = 'parent_id'){
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
                    unset($members[$k]);// 从大数组里删除 ，运行要快100倍
                    $state=true;
                }
            }
        }
        $mids = $othermids; //foreach中找到的我的下级集合,用来下次循环
    }while($state == true);

    return $Teams;
}




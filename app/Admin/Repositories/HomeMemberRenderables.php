<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-8-11
 * Time: 11:59
 */

namespace App\Admin\Repositories;

use Illuminate\Contracts\Support\Renderable;
use App\Models\Traits\DepositTraits;
use App\Models\Traits\WithdrawTraits;
use App\Models\Traits\MemberTraits;
use App\Models\Traits\AgentInfoTraits;




class HomeMemberRenderables implements Renderable
{

    public function render()
    {
        $totalWithdraw = $this->data();

        return view('admin.admin_user.header', compact('totalWithdraw'))->render();
    }


    /***
     * @return mixed|null
     */
    public function data()
    {
        // 系统会员今日出金
        if (! verifSysCacheArray('day_withdraw')) { //判断有没有对应出金缓存
            $totalWithdraw = setSysCacheArray([
                'day_withdraw' => AgentInfoTraits::dayAgentInfo(2, false)->sum('day_withdraw')
            ]);// 存入缓存
        }

        // 系统会员总出金
        if (! verifSysCacheArray('total_withdraw')) { //判断有没有对应出金缓存
            $totalWithdraw = setSysCacheArray([
                'total_withdraw' => WithdrawTraits::todayWithdraw()
            ]);// 存入缓存
        }

        // 系统会员总入金
        if (! verifSysCacheArray('total_deposit')) { //判断有没有对应出金缓存
            $totalWithdraw = setSysCacheArray([
                'total_deposit' => DepositTraits::todayDeposit()
            ]);// 存入缓存
        }

        // 系统会员今日入金
        if (! verifSysCacheArray('day_deposit')) { //判断有没有对应出金缓存
            $totalWithdraw = setSysCacheArray([
                'day_deposit' => AgentInfoTraits::dayAgentInfo(null, false)->sum('day_deposit')
            ]);// 存入缓存
        }
        // 系统会员总数
        if (! verifSysCacheArray('total_member')) { //判断有没有对应出金缓存
            $totalWithdraw = setSysCacheArray([
                'total_member' => MemberTraits::todayMember()
            ]);// 存入缓存
        }
        // 系统会员今日注册
        if (!$totalWithdraw = verifSysCacheArray('day_member')) { //判断有没有对应出金缓存
            $totalWithdraw = setSysCacheArray([
                'day_member' => MemberTraits::todayMember(true)
            ]);// 存入缓存
        }

        return $totalWithdraw;
    }


}

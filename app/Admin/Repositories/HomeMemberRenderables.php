<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-8-11
 * Time: 11:59
 */

namespace App\Admin\Repositories;

use Illuminate\Contracts\Support\Renderable;
use App\Models\Member;
use App\Models\Deposit;
use App\Models\Withdraw;



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
        // 系统总入金
        if (! verifSysCacheArray('total_deposit')) { //判断有没有对应出金缓存
            $totalWithdraw = setSysCacheArray([
                'total_deposit' => (new Deposit())->todayDeposit()->where('status', 1)
                                    ->where('money_type', 1)->pluck('money')->sum()
            ]);// 存入缓存
        }

        // 系统总出金
        if (! verifSysCacheArray('total_withdraw')) { //判断有没有对应出金缓存
            $totalWithdraw = setSysCacheArray([
                'total_withdraw' => (new Withdraw())->todayWithdraw()->where('status', 1)
                                    ->where('money_type', 1)->pluck('money')->sum()
            ]);// 存入缓存
        }

        // 系统今日入金
        if (! verifSysCacheArray('day_deposit')) { //判断有没有对应出金缓存
            $totalWithdraw = setSysCacheArray([
                'day_deposit' => (new Deposit())->todayDeposit(true)->where('status', 1)
                                    ->where('money_type', 1)->pluck('money')->sum()
            ]);// 存入缓存

        }
        // 系统今日出金
        if (! verifSysCacheArray('day_withdraw')) { //判断有没有对应出金缓存
            $totalWithdraw = setSysCacheArray([
                'day_withdraw' => (new Withdraw())->todayWithdraw(true)->where('status', 1)
                                    ->where('money_type', 1)->pluck('money')->sum()
            ]);// 存入缓存
        }

        // 系统会员总数
        if (! verifSysCacheArray('total_member')) { //判断有没有对应出金缓存
            $totalWithdraw = setSysCacheArray([
                'total_member' => (new Member())->todayMember()->count()
            ]);// 存入缓存
        }
        // 系统会员今日注册
        if (!$totalWithdraw = verifSysCacheArray('day_member')) { //判断有没有对应出金缓存
            $totalWithdraw  = setSysCacheArray([
                'day_member' => (new Member())->todayMember(true)->count()
            ]);// 存入缓存
        }

        return $totalWithdraw;
    }


}

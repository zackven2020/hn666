<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-8-11
 * Time: 11:59
 */

namespace App\Admin\Repositories;

use Illuminate\Contracts\Support\Renderable;
use App\Models\Withdraw;
use App\Models\Deposit;
use App\Models\Member;
use App\Models\Agent;
use App\Models\Traits\WithdrawTraits;


class HomeMemberRenderables implements Renderable
{

    public function render()
    {
        $withdraw = WithdrawTraits::todayWithdraw();

        return view('admin.admin_user.header', compact('withdraw'))->render();
    }




}

<?php

namespace App\Admin\Modal;

use App\Models\Agent;
use App\Models\Member;
use Carbon\Carbon;
use Dcat\Admin\Support\LazyRenderable;
use Dcat\Admin\Widgets\Table;
use Cache;
use App\Models\Deposit;
use App\Models\Withdraw;



class AgentDetailsModal extends LazyRenderable
{
    public function render()
    {
        // 获取ID
        $id = $this->key;

        // 所有代理帐号
        $agentAll = getAgentCache();

        // 所有会员帐号
        $memberAll = Member::make()->member(); // 所有会员

        //今日充值
        $dayDeposit = Cache::remember('deposit_cache', 60, function(){
            return Deposit::whereBetween('created_at', [
                Carbon::now()->toDateString(),
                Carbon::now()->toDateTimeString()
            ])->get();
        });


        //今日出金
        $dayWithdraw = Cache::remember('withdraw_cache', 60, function(){
            return Withdraw::whereBetween('created_at',  [
                Carbon::now()->toDateString(),
                Carbon::now()->toDateTimeString()
            ])->get();
        });

        //代理详情
        $agentIds       = getMemberTeamId($agentAll, $id);
        $agentCount     = collect($agentIds)->count() - 1;
        $agentMember    = collect($agentAll)->where('id', $id)->first()->member->count();
        $member         = collect($memberAll)->whereIn('agent_id', $agentIds);

        //充值详情
        $Deposit = collect($dayDeposit)->whereIn('user_id', $member->pluck('id'));
        //出金详情
        $Withdraw = collect($dayWithdraw)->whereIn('user_id', $member->pluck('id'));
        $win_and_lose  = $Deposit->sum('money') - $Withdraw->sum('money');

        return <<<a
            <div class="row">
                <style>
                .rows{
                    display:flex;
                    margin-left: 30px;
                }
                .card{
                    width:200px;
                    display:flex;
                    margin-bottom: 1rem !important;
                }
                .card-header{
                    margin-bottom: 0.8rem;
                }
                .metrics {
                    display:flex;
                    justify-content:flex-end;
                    padding:4px;
                    margin-bottom: 0.6rem;
                    text-align: center;
                }
                .product-result {
                    flex:2;
                }
                .product-result:first-child{
                    text-align: left;
                }
                </style>
              <div class="col-md-12 rows">
                <div id="metric-card-qSJoBMP9" class="card">
                  <div class="card-header d-flex justify-content-between align-items-start pb-0">
                    <div>
                      <h4 class="card-title mb-1">代理详情</h4>
                      <div class="metric-header"></div>
                    </div>
                  </div>
                  <div class="metric-content">
                    <div class="metrics">
                      <div class="product-result">
                        <i class="fa fa-circle-o text-bold-700 text-primary"></i>
                        <span class="">代理人数</span>
                      </div>
                      <div class="product-result">
                         <span>$agentCount</span>
                      </div>
                    </div>
                    <div class="metrics">
                      <div class="product-result">
                        <i class="fa fa-circle-o text-bold-700 text-warning"></i>
                        <span class="">直推会员</span>
                      </div>
                      <div class="product-result">
                         <span>$agentMember</span>
                      </div>
                    </div>
                    <div class="metrics">
                      <div class="product-result">
                        <i class="fa fa-circle-o text-bold-700 text-danger"></i>
                        <span class="">团队人数</span>
                      </div>
                      <div class="product-result">
                         <span>{$member->count()}</span>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div id="metric-card-qSJoBMP9" class="card" >
                  <div class="card-header d-flex justify-content-between align-items-start pb-0">
                    <div>
                      <h4 class="card-title mb-1">金额详情</h4>
                      <div class="metric-header"></div>
                    </div>
                  </div>
                  <div class="metric-content">
                    <div class="metrics">
                      <div class="product-result">
                        <i class="fa fa-circle-o text-bold-700 text-primary"></i>
                        <span class="">代理人数</span>
                      </div>
                      <div class="product-result">
                         <span>233</span>
                      </div>
                    </div>
                    <div class="metrics">
                      <div class="product-result">
                        <i class="fa fa-circle-o text-bold-700 text-warning"></i>
                        <span class="">代理人数</span>
                      </div>
                      <div class="product-result">
                         <span>233</span>
                      </div>
                    </div>
                    <div class="metrics">
                      <div class="product-result">
                        <i class="fa fa-circle-o text-bold-700 text-danger"></i>
                        <span class="">代理人数</span>
                      </div>
                      <div class="product-result">
                         <span>233</span>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div id="metric-card-qSJoBMP9" class="card" >
                  <div class="card-header d-flex justify-content-between align-items-start pb-0">
                    <div>
                      <h4 class="card-title mb-1">充值详情</h4>
                      <div class="metric-header"></div>
                    </div>
                  </div>
                  <div class="metric-content">
                    <div class="metrics">
                      <div class="product-result">
                        <i class="fa fa-circle-o text-bold-700 text-primary"></i>
                        <span class="">当日总存款</span>
                      </div>
                      <div class="product-result">
                         <span>{$Deposit->sum('money')}</span>
                      </div>
                    </div>
                    <div class="metrics">
                      <div class="product-result">
                        <i class="fa fa-circle-o text-bold-700 text-warning"></i>
                        <span class="">当日总取款</span>
                      </div>
                      <div class="product-result">
                         <span>{$Withdraw->sum('money')}</span>
                      </div>
                    </div>
                    <div class="metrics">
                      <div class="product-result">
                        <i class="fa fa-circle-o text-bold-700 text-danger"></i>
                        <span class="">当日盈亏</span>
                      </div>
                      <div class="product-result">
                         <span>{$win_and_lose}</span>
                      </div>
                    </div>
                  </div>
                </div>
                
              </div>
            </div>
a;


        $titles = [
            'Title',
            'name',
            'invate_url',
        ];

        return Table::make($titles, $data);
    }
}
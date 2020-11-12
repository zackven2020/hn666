<?php

namespace App\Admin\Modal;

use App\Models\Agent;
use Dcat\Admin\Support\LazyRenderable;
use Dcat\Admin\Widgets\Table;


class AgentDetailsModal extends LazyRenderable
{
    public function render()
    {
        // 获取ID
        $id = $this->key;

        // 获取其他自定义参数
        $type = $this->post_type;

        $data = Agent::where('id', $type)
            ->get(['title', 'name', 'invate_url'])
            ->toArray();


        return <<<a
            <div class="row">
                <style>
                .rows{
                    display:flex;
                    margin-left: 10px;
                }
</style>
              <div class="col-md-12 rows">
                <div id="metric-card-qSJoBMP9" class="card" style="min-height:250px;">
                  <div class="card-header d-flex justify-content-between align-items-start pb-0">
                    <div>
                      <h4 class="card-title mb-1">Product Orders</h4>
                      <div class="metric-header"></div>
                    </div>
                  </div>
                  
                  <div class="metric-content">
                    <div class="card-content">
                      <div class="row">
                        <div class="metric-content col-sm-5">
                          <div class="col-12 d-flex flex-column flex-wrap text-center" style="max-width: 220px">
                            <div class="chart-info d-flex justify-content-between mb-1 mt-2">
                              <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-primary"></i>
                                <span class="text-bold-600 ml-50">Finished</span></div>
                              <div class="product-result">
                                <span>23043</span></div>
                            </div>
                            <div class="chart-info d-flex justify-content-between mb-1">
                              <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-warning"></i>
                                <span class="text-bold-600 ml-50">Pending</span></div>
                              <div class="product-result">
                                <span>14658</span></div>
                            </div>
                            <div class="chart-info d-flex justify-content-between mb-1">
                              <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-danger"></i>
                                <span class="text-bold-600 ml-50">Rejected</span></div>
                              <div class="product-result">
                                <span>4758</span></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="metric-footer"></div>
                    </div>
                  </div>
                </div>
                
                <div id="metric-card-qSJoBMP9" class="card" style="min-height:250px;">
                  <div class="card-header d-flex justify-content-between align-items-start pb-0">
                    <div>
                      <h4 class="card-title mb-1">Product Orders</h4>
                      <div class="metric-header"></div>
                    </div>
                  </div>
                  <div class="metric-content">
                    <div class="card-content">
                      <div class="row">
                        <div class="metric-content col-sm-5">
                          <div class="col-12 d-flex flex-column flex-wrap text-center" style="max-width: 220px">
                            <div class="chart-info d-flex justify-content-between mb-1 mt-2">
                              <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-primary"></i>
                                <span class="text-bold-600 ml-50">Finished</span></div>
                              <div class="product-result">
                                <span>23043</span></div>
                            </div>
                            <div class="chart-info d-flex justify-content-between mb-1">
                              <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-warning"></i>
                                <span class="text-bold-600 ml-50">Pending</span></div>
                              <div class="product-result">
                                <span>14658</span></div>
                            </div>
                            <div class="chart-info d-flex justify-content-between mb-1">
                              <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-danger"></i>
                                <span class="text-bold-600 ml-50">Rejected</span></div>
                              <div class="product-result">
                                <span>4758</span></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="metric-footer"></div>
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
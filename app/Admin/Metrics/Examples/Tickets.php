<?php

namespace App\Admin\Metrics\Examples;


use App\Models\Deposit;
use App\Models\Member;
use App\Models\Withdraw;
use Carbon\Carbon;
use Dcat\Admin\Widgets\Metrics\RadialBar;
use Illuminate\Http\Request;

class Tickets extends RadialBar
{
    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        parent::init();

        $this->title('活躍度分析');
        $this->height(400);
        $this->chartHeight(300);
        $this->chartLabels('活躍會員占比');
        $this->dropdown([
            '7' => '最近七天',
            '28' => '最近28天',
            '30' => '最近一個月',
            '365' => '最近一年',
        ]);
    }

    /**
     * 处理请求
     *
     * @param Request $request
     *
     * @return mixed|void
     */
    public function handle(Request $request)
    {
        switch ($request->get('option')) {
            case '365':
                $days = 365;
                break;
            case '30':
                $days = 30;
                break;
            case '28':
                $days = 28;
                break;
            case '7':
            default:
                $days = 7;
                break;
        }
        $all = Member::query()->count();
        $actived_member = Member::query()
            ->where('updated_at','>', Carbon::today()->subDays($days)->toDateTimeString());
        $deposit = Deposit::query()
            ->where('updated_at','>', Carbon::today()->subDays($days)->toDateTimeString());
        $withdraw = Withdraw::query()
            ->where('updated_at','>', Carbon::today()->subDays($days)->toDateTimeString());

        $this->withContent($actived_member->count());
        $this->withFooter(
            $all,
            $deposit->sum('money').'/'.$deposit->count(),
            $withdraw->sum('money').'/'.$withdraw->count()
        );
        // 图表数据
        $this->withChart(($actived_member->count()/$all)*100);
    }




    /**
     * 设置图表数据.
     *
     * @param int $data
     *
     * @return $this
     */
    public function withChart(int $data)
    {
        return $this->chart([
            'series' => [$data],
        ]);
    }

    /**
     * 卡片内容
     * @param string $content
     * @return $this
     */
    public function withContent($content)
    {
        return $this->content(
            <<<HTML
<div class="d-flex flex-column flex-wrap text-center">
    <h1 class="font-lg-2 mt-2 mb-0">{$content}</h1>
    <small>活躍會員數</small>
</div>
HTML
        );
    }


    /**
     * 卡片底部内容.
     *
     * @param string $new
     * @param string $open
     * @param string $response
     *
     * @return $this
     */
    public function withFooter($new, $open, $response)
    {
        return $this->footer(
            <<<HTML
<div class="d-flex justify-content-between p-1" style="padding-top: 0!important;">
    <div class="text-center">
        <p>會員總數</p>
        <span class="font-lg-1">{$new}</span>
    </div>
    <div class="text-center">
        <p>儲值額度 / 儲值次數 </p>
        <span class="font-lg-1">{$open}</span>
    </div>
    <div class="text-center">
        <p>提款額度 / 提款次數 </p>
        <span class="font-lg-1">{$response}</span>
    </div>
</div>
HTML
        );
    }
}

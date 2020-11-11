<?php

namespace App\Admin\Metrics\Examples;

use App\Models\Deposit;
use App\Models\Withdraw;
use Carbon\Carbon;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Bar;
use http\Header\Parser;
use Illuminate\Http\Request;

class Sessions extends Bar
{
    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        parent::init();

        $color = Admin::color();

        $dark35 = $color->dark35();

        // 卡片内容宽度
        $this->contentWidth(5, 7);
        // 标题
        $this->title('收益分析');
        // 设置下拉选项
        $this->dropdown([
            '7' => '最近七天',
            '28' => '最近28天',
            '30' => '最近一個月',
            '365' => '最近一年',
        ]);
//        // 设置图表颜色
//        $this->chartColors([
//            $dark35,
//            $dark35,
//            $color->primary(),
//            $dark35,
//            $dark35,
//            $dark35
//        ]);
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
        $totalDeposit = Deposit::query()
            ->where('created_at','>',Carbon::today()->subDays($days)->toDateTimeString())
            ->where('status',1)
            ->sum('money');
        $totalWithdraw = Withdraw::query()
            ->where('created_at','>',Carbon::today()->subDays($days)->toDateTimeString())
            ->where('status',1)
            ->sum('money');
        $lirun = ($totalDeposit-$totalWithdraw);
        if($lirun > 10000){
            $lirun = round(($totalDeposit-$totalWithdraw) / 1000 / $days ,2) . 'K';
        }else{
            $lirun = round(($totalDeposit-$totalWithdraw) / $days, 2);
        }

        // 卡片内容
        $this->withContent($lirun, '每日盈利');

        $sql = "SELECT DATE_FORMAT(created_at,'%Y%m%d') AS days,SUM('money') AS num FROM member WHERE created_at > '$days' GROUP BY days;";
        $rs = \DB::select($sql);
        $this->withChart(collect($rs)->pluck('num','days')->toArray());

        // 图表数据
        $this->withChart([
            [
                'name' => 'Sessions',
                'data' => [75, 125, 225, 175, 125, 75, 25],
            ],
        ]);
    }

    /**
     * 设置图表数据.
     *
     * @param array $data
     *
     * @return $this
     */
    public function withChart(array $data)
    {
        return $this->chart([
            'series' => $data,
        ]);
    }

    /**
     * 设置卡片内容.
     *
     * @param string $title
     * @param string $value
     * @param string $style
     *
     * @return $this
     */
    public function withContent($title, $value, $style = 'success')
    {
        // 根据选项显示
        $label = strtolower(
            $this->dropdown[request()->option] ?? '七日周期内'
        );

        $minHeight = '183px';

        return $this->content(
            <<<HTML
<div class="d-flex p-1 flex-column justify-content-between" style="padding-top: 0;width: 100%;height: 100%;min-height: {$minHeight}">
    <div class="text-left">
        <h1 class="font-lg-2 mt-2 mb-0">{$title}</h1>
        <h5 class="font-medium-2" style="margin-top: 10px;">
            <span class="text-{$style}">{$value} </span>
        </h5>
    </div>

    <a href="/admin/stat" class="btn btn-primary shadow waves-effect waves-light">查看更多<i class="feather icon-chevrons-right"></i></a>
</div>
HTML
        );
    }
}

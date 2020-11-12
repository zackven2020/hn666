<?php

namespace App\Admin\Metrics\Examples;

use App\Models\Member;
use Carbon\Carbon;
use Dcat\Admin\Widgets\Metrics\Line;
use Illuminate\Http\Request;

class NewUsers extends Line
{
    /**
     * 初始化卡片内容
     *
     * @return void
     */
    protected function init()
    {
        parent::init();

        $this->title('新用戶增長');
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
        $generator = function ($len, $min = 10, $max = 300) {
            for ($i = 0; $i <= $len; $i++) {
                yield mt_rand($min, $max);
            }
        };

        switch ($request->get('option')) {
            case '365':
                $days = Carbon::today()->subDays(365)->toDateTimeString();
                $newUsersCount = Member::query()->where('created_at','>',$days)->count();
                $this->withContent($newUsersCount);

                $sql = "SELECT DATE_FORMAT(created_at,'%Y%m%d') AS days,COUNT(*) AS num FROM member WHERE created_at > '$days' GROUP BY days;";
                $rs = \DB::select($sql);
                $this->withChart(collect($rs)->pluck('num','days')->toArray());
                break;
            case '30':
                $days = Carbon::today()->subDays(30)->toDateTimeString();
                $newUsersCount = Member::query()->where('created_at','>',$days)->count();
                $this->withContent($newUsersCount);

                $sql = "SELECT DATE_FORMAT(created_at,'%Y%m%d') AS days,COUNT(*) AS num FROM member WHERE created_at > '$days' GROUP BY days;";
                $rs = \DB::select($sql);
                $this->withChart(collect($rs)->pluck('num','days')->toArray());
                break;
            case '28':
                $days = Carbon::today()->subDays(28)->toDateTimeString();
                $newUsersCount = Member::query()->where('created_at','>',$days)->count();
                $this->withContent($newUsersCount);

                $sql = "SELECT DATE_FORMAT(created_at,'%Y%m%d') AS days,COUNT(*) AS num FROM member WHERE created_at > '$days' GROUP BY days;";
                $rs = \DB::select($sql);
                $this->withChart(collect($rs)->pluck('num','days')->toArray());
                break;
            case '7':
            default:
                $days = Carbon::today()->subDays(7)->toDateTimeString();
                $newUsersCount = Member::query()->where('created_at','>',$days)->count();
                $this->withContent($newUsersCount);

                $sql = "SELECT DATE_FORMAT(created_at,'%Y%m%d') AS days,COUNT(*) AS num FROM member WHERE created_at > '$days' GROUP BY days;";
                $rs = \DB::select($sql);
                $this->withChart(collect($rs)->pluck('num','days')->toArray());
        }
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
            'series' => [
                [
                    'name' => '新增用戶',
                    'data' => array_values($data),
                ],
            ],
        ]);
    }

    /**
     * 设置卡片内容.
     *
     * @param string $content
     *
     * @return $this
     */
    public function withContent($content)
    {
        return $this->content(
            <<<HTML
<div class="d-flex justify-content-between align-items-center mt-1" style="margin-bottom: 2px">
    <h2 class="ml-1 font-lg-1">{$content}</h2>
    <span class="mb-0 mr-1 text-80">{$this->title}</span>
</div>
HTML
        );
    }
}

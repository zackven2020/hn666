<?php

namespace App\Admin\Metrics\Examples;

use Dcat\Admin\Widgets\Metrics\RadialBar;
use Illuminate\Http\Request;

class Notify
{
    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        return view('admin::dashboard.title');
    }
}

<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Examples;
use App\Admin\Metrics\Examples\Dashboard;
use App\Http\Controllers\Controller;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;


class HomeController extends BaseController
{
    public function index(Content $content)
    {
        return $content
            ->header('主页')
            ->description('在线看板')
            ->body(function (Row $row) {
                $row->column(6, function (Column $column) {

                    $column->row(Dashboard::title());
                    $column->row(new Examples\Tickets());
                    $column->row(new Examples\Ticketser());
                });

                $row->column(6, function (Column $column) {
                    $column->row(function (Row $row) {
                        $row->column(6, new Examples\NewUsers());
                        $row->column(6, new Examples\NewDevices());
                    });

                    $column->row(new Examples\Sessions());
                    $column->row(new Examples\ProductOrders());
                });
            });
    }
}

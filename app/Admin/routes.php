<?php

use App\Models\GameList;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    $router->get('/auth/undefined',function (){
       return redirect('/admin');
    });

    // 重寫 員工管理 路由
    $router->resource('auth/users','UserController');

    // 會員管理
    $router->resource('member','MemberController');

    // 代理管理
    $router->resource('agent','AgentController');

    // 儲值管理
    $router->resource('deposited','DepositController');
    $router->resource('depositing','DepositController')->except(['index']);
    $router->get('depositing','DepositController@ing')->name('index');
    // 出金管理
    $router->resource('withdrawed','WithdrawController');
    $router->resource('withdrawing','WithdrawController')->except(['index']);
    $router->get('withdrawing','WithdrawController@ing')->name('index');

    // 數據分析
    $router->resource('stat','StatController');

    // 運營管理
    $router->resource('gamelist','GameListController');
    $router->resource('open_history','OpenHistoryController');
    $router->resource('bet_record','BetRecordsController');
    $router->resource('wanfa','WanfaController');
    $router->resource('game_category','GameCategoryController');

    // 站點配置
    $router->resource('system','SystemController');

    // 文章管理
    $router->resource('article','ArticleController');

    // 进程管理
    $router->resource('cli','CliWorkController');

    $router->get('test',function (){
        $open = new \App\Console\Commands\OepnLottery();
        $open->handle();
    });
});

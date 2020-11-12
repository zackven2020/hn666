<?php

use Illuminate\Support\Facades\Route;

use App\Models\Agent;
use Carbon\Carbon;
use App\Models\Deposit;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function ($id = 2) {

    dd(Carbon::now()->toDateString(), Carbon::now()->toDateTimeString());
    $agentAll = Cache::remember('agent_caches', 1, function(){
        return Agent::get();
    });

    $a = ['id'=>'aaa', 'parent_id'=>999];


    dd($agentAll, 123, $a);
    Cache::put('agent_cache', $as);

    //$agentIds       = getMemberTeamId($agentAll, $id);
    $a = getMemberTeamId($agentAll, $id);
    $b = getMemberTeamId($agentAll, 2);
    $c = getMemberTeamId($agentAll, $id);
    dd($a, $b, $c, $id);
});

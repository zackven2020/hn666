<?php

use Illuminate\Support\Facades\Route;

use App\Models\Agent;
use Carbon\Carbon;
use App\Models\Deposit;
use App\Models\Withdraw;
use App\Models\Traits\WithdrawTraits;

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

    dd(Deposit::make()->todayDeposit(), (new Deposit())->todayDeposit());

    dd('fdsafdsafds');
    $a = ['a'=>123];

    dd(\Cache::get('fdsafdsa'));

    dd(Carbon::today()->endofDay(0)->toDateTimeString());

});

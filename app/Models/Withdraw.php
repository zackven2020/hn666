<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\WithdrawTraits;



class Withdraw extends Model
{
	use HasDateTimeFormatter, WithdrawTraits;


    protected $table = 'withdraw';



}

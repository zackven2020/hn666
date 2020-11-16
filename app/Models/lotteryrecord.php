<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class lotteryrecord extends Model
{
	use HasDateTimeFormatter;
	protected $table = 'lotteryrecord';

	public function gameType(){
	    return $this->belongsTo(Gamelist::class,'gametype','id');
    }

}

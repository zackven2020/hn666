<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class lotteryhistory extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'lotteryhistory';

    public function gameType(){
        return $this->belongsTo(Gamelist::class,'gametype','id');
    }

    protected $fillable = ["*"];

}

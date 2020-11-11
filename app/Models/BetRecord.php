<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class BetRecord extends Model
{
	use HasDateTimeFormatter;
	protected $table = 'bet_record';

	public function gameType(){
	    return $this->belongsTo(GameList::class,'gametype','id');
    }

}

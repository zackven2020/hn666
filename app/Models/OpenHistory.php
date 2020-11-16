<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class OpenHistory extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'open_history';

    public function gameType(){
        return $this->belongsTo(GameList::class,'game_type','id');
    }

    protected $fillable = ["game_type",'term','number','add_time','term_time'];

}

<?php

namespace App\Models\Game;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class pk10history extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'pk10history';

}

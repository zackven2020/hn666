<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class GameCategory extends Model
{
	use HasDateTimeFormatter,ModelTree;

    protected $table = 'game_category';

    public function lists()
    {
        return $this->hasMany(GameList::class,'category','title');
    }

}

<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class CliWork extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'cli_work';
    
}

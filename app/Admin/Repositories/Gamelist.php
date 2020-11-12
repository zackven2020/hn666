<?php

namespace App\Admin\Repositories;

use App\Models\GameList as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Gamelist extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}

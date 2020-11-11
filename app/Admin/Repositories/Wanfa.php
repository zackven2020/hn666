<?php

namespace App\Admin\Repositories;

use App\Models\Wanfa as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Wanfa extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}

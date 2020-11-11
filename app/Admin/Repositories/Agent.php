<?php

namespace App\Admin\Repositories;

use App\Models\Agent as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Agent extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}

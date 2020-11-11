<?php

namespace App\Admin\Repositories;

use App\Models\Deposit as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Deposit extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}

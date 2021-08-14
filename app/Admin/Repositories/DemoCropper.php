<?php

namespace App\Admin\Repositories;

use App\Models\DemoCropper as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class DemoCropper extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}

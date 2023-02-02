<?php

namespace App\Base;

use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    protected Model $model;

    public function __construct()
    {
        $this->model = app($this->model());
    }

    abstract function model(): string;
}

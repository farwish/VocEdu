<?php

namespace App\Basics;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    /** @var Model $model */
    protected $model;

    /** @var DatabaseManager $dbManager This is DB facade reference */
    protected $dbManager;

    /** @var Builder $query */
    protected $query;

    public function __construct(Model $model, DatabaseManager $dbManager)
    {
        $this->model = $model;

        $this->dbManager = $dbManager;
    }

    public function getDbManager()
    {
        return $this->dbManager;
    }

    public function newModel()
    {
        return $this->model->newInstance();
    }

    public function getModel()
    {
        return $this->model;
    }

    public function newQuery()
    {
        $this->query = $this->model->newQuery();

        return $this->query;
    }

    public function getQuery()
    {
        return $this->query;
    }
}

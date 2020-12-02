<?php

namespace App\Repositories;

use App\Basics\BaseRepository;
use App\Enums\AppMenuEnum;
use App\Models\AppMenu;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model;

class AppMenuRepository extends BaseRepository
{
    public function __construct(AppMenu $model, DatabaseManager $dbManager)
    {
        parent::__construct($model, $dbManager);
    }

    /**
     * App Menu list
     *
     * @return array
     */
    public function list()
    {
        return $this->newQuery()
            ->select(['id', 'title', 'sub_title as subTitle', 'icon', 'color', 'sub_lock as subLock', 'slug', 'parent_id'])
            ->where('status', AppMenuEnum::STATUS_NORMAL)
            ->get()
            ->toTree()
            ->toArray()
        ;
    }
}

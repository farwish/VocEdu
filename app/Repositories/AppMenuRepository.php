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
     * @param int $categoryId
     *
     * @return array
     */
    public function list(int $categoryId)
    {
        $qb = $this->newQuery()
            ->select(['id', 'title', 'sub_title as subTitle', 'icon', 'color', 'next_format as nextFormat', 'slag', 'category_id as categoryId'])
            ->where('status', AppMenuEnum::STATUS_NORMAL)
        ;

        $arr = $qb
            ->where('category_id', $categoryId)
            ->orWhereNull('category_id')
            ->orderBy('sort', 'DESC')
            ->get()
            ->toArray();
        ;

        $globalMenus = $categoryMenus = [];
        if ($arr) {
            foreach ($arr as &$item) {
                if (! $item['categoryId']) {
                    unset($item['categoryId']);
                    $globalMenus[] = $item;
                } else {
                    unset($item['categoryId']);
                    $categoryMenus[] = $item;
                }
            }
        }

        return $categoryMenus ? $categoryMenus : $globalMenus;
    }
}

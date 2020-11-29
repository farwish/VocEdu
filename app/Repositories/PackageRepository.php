<?php

namespace App\Repositories;

use App\Basics\BaseRepository;
use App\Enums\PackageEnum;
use App\Models\Category;
use App\Models\Package;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model;

class PackageRepository extends BaseRepository
{
    public function __construct(Package $model, DatabaseManager $dbManager)
    {
        parent::__construct($model, $dbManager);
    }

    /**
     * Package list
     *
     * @param $categoryId
     *
     * @return array
     */
    public function list($categoryId)
    {
        $packageList = $this->newQuery()
            ->select([
                'id', 'name', 'explain', 'price', 'ori_price AS oriPrice', 'expire_mode', 'duration',
            ])
            ->where('category_id', $categoryId)
            ->where('list_status', PackageEnum::LIST_STATUS_NORMAL)
            ->orderBy('sort', 'DESC')
            ->get();

        /** @var Category $currentCategory */
        $currentCategory = app(CategoryRepository::class)->newQuery()->find($categoryId);
        $currentCategoryExamTime = $currentCategory->getAttribute('exam_time');

        /** @var Category $parentCategory */
        $parentCategory = app(CategoryRepository::class)->newQuery()->find($currentCategory->getAttribute('parent_id'));
        $parentCategoryExamTime = $parentCategory->getAttribute('exam_time');

        if ($packageList->isNotEmpty()) {
            $packageList->each(function ($item, $key) use ($currentCategory, $currentCategoryExamTime, $parentCategory, $parentCategoryExamTime) {
                /** @var Package $item */
                if (empty($item['oriPrice']) || intval($item['oriPrice']) < 0) {
                    $item['oriPrice'] = $item['price'];
                }

                if ($item['expire_mode'] == PackageEnum::EXPIRE_MODE_FIXED) {
                    $item['expireDate'] = now()->addYears(intval($item['duration']))->toDateString();
                } else {
                    if ($currentCategory && $currentCategoryExamTime) {
                        $item['expireDate'] = $currentCategoryExamTime->format('Y-m-d');
                    } else if ($parentCategory && $parentCategoryExamTime) {
                        $item['expireDate'] = $parentCategoryExamTime->format('Y-m-d');
                    }
                }

                $tabs = $item->tabs()->get()->pluck('name');
                $item['serviceContent'] = $tabs ? $tabs->join(',') : '';

                unset($item['expire_mode'], $item['duration']);
            });
        }

        return $packageList->toArray();
    }
}

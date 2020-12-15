<?php

namespace App\Repositories;

use App\Enums\PackageEnum;
use App\Models\Category;
use App\Basics\BaseRepository;
use App\Models\Member;
use App\Models\Package;
use Illuminate\Database\DatabaseManager;

class CategoryRepository extends BaseRepository
{
    public function __construct(Category $model, DatabaseManager $dbManager)
    {
        parent::__construct($model, $dbManager);
    }

    /**
     * category list
     *
     * @param int|null $pid
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function list(?int $pid)
    {
        $builder = $this->model->newQuery()->select('id', 'name');

        if (! $pid) {
            // All root category
            return $builder
                ->whereNull('parent_id')
                ->get();
        } else {
            return $builder
                ->where('parent_id', $pid)
                ->get();
        }
    }

    /**
     * category of member's open
     *
     * usage example:
     * $expiredAt = $categoryMember ? $categoryMember->pivot->expired_at : '-',
     *
     * @param Category $category
     * @param Member $member
     *
     * @return mixed
     */
    public function categoryMember(Category $category, Member $member)
    {
        return $category->members()
            ->withPivot('expired_at')
            ->wherePivot('member_id', '=', $member->getAttribute('id'))
            ->wherePivot('expired_at', '>', now()->toDateTimeString())
            ->first()
        ;
    }

    /**
     * My open category
     *
     * @param Member $member
     *
     * @return array
     */
    public function categoryMemberMyAll(Member $member)
    {
        $res = $member->categories()
            ->select(['category_id', 'name'])
            ->withPivot('expired_at')
            ->wherePivot('expired_at', '>', now()->toDateTimeString())
            ->get()
            ->toArray()
        ;

        foreach ($res as &$item) {
            $item['categoryId'] = $item['category_id'];
            $item['expiredAt'] = $item['pivot']['expired_at'];
            unset(
                $item['category_id'],
                $item['pivot'],
            );
        }
        unset($item);

        return $res;
    }

    /**
     * Open category
     *
     * @param int $cid
     * @param int $kid package_id
     * @param Member $member
     *
     * @return bool
     */
    public function saveCategoryMember(int $cid, int $kid, Member $member)
    {
        $memberHasCategory = $member->categories()
            ->withPivot('expired_at')
            ->wherePivot('category_id', '=', $cid)
            ->first();

        if ($memberHasCategory) {
            return false;
            // update many to many relation fields
            // $oldOne->setAttribute('expired_at', now()->addDays(366));
            // return $oldOne->save();
        } else {
            /** @var Category $currentCategory */
            $currentCategory = app(CategoryRepository::class)->newQuery()->find($cid);

            $currentCategoryExamTime = $currentCategory ? $currentCategory->getAttribute('exam_time') : null;

            $parentCategoryId = $currentCategory ? $currentCategory->getAttribute('parent_id') : null;

            /** @var Category $parentCategory */
            $parentCategory = app(CategoryRepository::class)->newQuery()->find($parentCategoryId);
            $parentCategoryExamTime = $parentCategory ? $parentCategory->getAttribute('exam_time') : null;

            /** @var Package $package */
            $package = app(PackageRepository::class)->newQuery()->find($kid);
            $item = $package ? $package->toArray() : 'a';

            if ($item) {
                $expiredAt = '';

                if ($item['expire_mode'] == PackageEnum::EXPIRE_MODE_FIXED) {
                    $expiredAt = now()->addYears(intval($item['duration']))->toDateTimeString();
                } else {
                    if ($currentCategory && $currentCategoryExamTime) {
                        $expiredAt = $currentCategoryExamTime->format('Y-m-d H:i:s');
                    } else if ($parentCategory && $parentCategoryExamTime) {
                        $expiredAt = $parentCategoryExamTime->format('Y-m-d H:i:s');
                    }
                }

                $member->categories()->attach($cid, [
                    'expired_at' => $expiredAt,
                ]);
            }

            return true;
        }
    }

    public function searchLastCategoryByName(string $name)
    {
        return $this->newQuery()
            ->select(['id', 'name'])
            ->whereIsLeaf()
            ->where('name', 'like', "%{$name}%")
            ->get();
    }

    public function tree(?int $pid)
    {
        $builder = $this->model->newQuery();

        if (! $pid) {
            return $this->list($pid);
        } else {
            $cateValues = [];

            $traverse = function ($categories, $prefix = '—') use (&$traverse, &$cateValues) {
                /** @var Category $category */
                foreach ($categories as $category) {
                    if (! $category->getAttribute('parent_id')) {
                        // Root category do not add prefix
                        $rootPrefix = '';
                    } else {
                        $rootPrefix = '|' . $prefix;
                    }
                    $cateValues[$category->getAttribute('id')] = $rootPrefix . ' ' . $category->name;

                    $sunPrefix = $prefix . $rootPrefix;
                    $traverse($category->children, $sunPrefix);
                }
            };

            $category = $builder->find($pid);
            $nodes = $category->getDescendants()->toTree();
            $traverse($nodes);

            $retValues = [];
            if ($cateValues) {
                foreach ($cateValues as $id => $name) {
                    $retValues[] = [
                        'id' => $id,
                        'name' => $name,
                    ];
                }
            }
            return $retValues;
        }
    }
}

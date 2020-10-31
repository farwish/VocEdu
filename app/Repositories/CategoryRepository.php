<?php

namespace App\Repositories;

use App\Models\Category;
use App\Basics\BaseRepository;
use App\Models\Member;
use Illuminate\Database\DatabaseManager;

class CategoryRepository extends BaseRepository
{
    public function __construct(Category $model, DatabaseManager $dbManager)
    {
        parent::__construct($model, $dbManager);
    }

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
     * category of member buys
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
            unset($item['pivot']['member_id'], $item['pivot']['category_id']);
        }
        unset($item);

        return $res;
    }

    public function saveCategoryMember(int $cid, Member $member)
    {
        $category = $this->newQuery()->find($cid);

        $oldOne = $category->members()
            ->withPivot('expired_at')
            ->wherePivot('member_id', '=', $member->getAttribute('id'))
            ->first();

        if ($oldOne) {
            $oldOne->setAttribute('expired_at', now()->addDays(366));
            return $oldOne->save();
        } else {
            $category->members()->attach($member->getAttribute('id'), [
                'expired_at' => now()->addDays(366),
            ]);
            return true;
        }
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

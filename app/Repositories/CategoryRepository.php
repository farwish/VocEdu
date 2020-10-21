<?php

namespace App\Repositories;

use App\Models\Category;
use App\Basics\BaseRepository;
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

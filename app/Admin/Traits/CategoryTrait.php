<?php

namespace App\Admin\Traits;

use App\Models\Category as CategoryModel;

trait CategoryTrait
{
    public function categoryTree()
    {
        $cateValues = [];

        $traverse = function ($categories, $prefix = '—') use (&$traverse, &$cateValues) {
            /** @var CategoryModel $category */
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

        $nodes = CategoryModel::get()->toTree();
        $traverse($nodes);

        return $cateValues;
    }
}

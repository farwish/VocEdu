<?php

namespace App\Admin\Traits;

use App\Models\AppMenu as AppMenuModel;
use App\Models\Category as CategoryModel;

trait AppMenuTrait
{
    public function appMenuTree()
    {
        $cateValues = [];

        $traverse = function ($menus, $prefix = '—') use (&$traverse, &$cateValues) {
            /** @var CategoryModel $category */
            foreach ($menus as $menu) {
                if (! $menu->getAttribute('parent_id')) {
                    // Root category do not add prefix
                    $rootPrefix = '';
                } else {
                    $rootPrefix = '|' . $prefix;
                }
                $cateValues[$menu->getAttribute('id')] = $rootPrefix . ' ' . $menu->title;

                $sunPrefix = $prefix . $rootPrefix;
                $traverse($menu->children, $sunPrefix);
            }
        };

        $nodes = AppMenuModel::get()->toTree();
        $traverse($nodes);

        return $cateValues;
    }
}

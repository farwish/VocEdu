<?php

namespace App\Admin\Traits;

use App\Models\Chapter as ChapterModel;

trait ChapterTrait
{
    public function chapterTree(?int $categoryId)
    {
        $chapterValues = [];

        $traverse = function ($chapters, $prefix = '—') use (&$traverse, &$chapterValues) {
            /** @var ChapterModel $chapter */
            foreach ($chapters as $chapter) {
                if (! $chapter->getAttribute('parent_id')) {
                    // Root category do not add prefix
                    $rootPrefix = '';
                } else {
                    $rootPrefix = '|' . $prefix;
                }
                $chapterValues[$chapter->getAttribute('id')] = $rootPrefix . ' ' . $chapter->name;

                $sunPrefix = $prefix . $rootPrefix;
                $traverse($chapter->children, $sunPrefix);
            }
        };

        if ($categoryId) {
            $nodes = ChapterModel::query()->where('category_id', $categoryId)->get()->toTree();
        } else {
            $nodes = ChapterModel::query()->get()->toTree();
        }
        $traverse($nodes);

        return $chapterValues;
    }
}

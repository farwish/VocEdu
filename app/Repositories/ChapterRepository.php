<?php

namespace App\Repositories;

use App\Basics\BaseRepository;
use App\Models\Chapter;
use Illuminate\Database\DatabaseManager;

class ChapterRepository extends BaseRepository
{
    public function __construct(Chapter $model, DatabaseManager $dbManager)
    {
        parent::__construct($model, $dbManager);
    }

    public function tree(int $categoryId)
    {
        $chapterValues = [];

        $traverse = function ($chapters, $prefix = '—') use (&$traverse, &$chapterValues) {
            /** @var Chapter $chapter */
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

        $nodes = Chapter::query()->where('category_id', $categoryId)->get()->toTree();
        $traverse($nodes);

        $retValues = [];
        if ($chapterValues) {
            foreach ($chapterValues as $id => $name) {
                $retValues[] = [
                    'id' => $id,
                    'name' => $name,
                ];
            }
        }
        return $retValues;
    }
}

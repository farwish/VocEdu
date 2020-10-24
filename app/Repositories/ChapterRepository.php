<?php

namespace App\Repositories;

use App\Basics\BaseRepository;
use App\Enums\ChapterEnum;
use App\Models\Chapter;
use App\Models\Question;
use Illuminate\Database\DatabaseManager;

class ChapterRepository extends BaseRepository
{
    public function __construct(Chapter $model, DatabaseManager $dbManager)
    {
        parent::__construct($model, $dbManager);
    }

    public function list(int $categoryId, ?int $parentChapterId = null)
    {
        $builder = $this->model->newQuery()
            ->select('id', 'name')
            ->where('category_id', $categoryId)
        ;

        if (! $parentChapterId) {
            $builder->whereNull('parent_id');
        } else {
            $builder->where('parent_id', $parentChapterId);
        }

        return $builder
            ->get();
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

        $data = Chapter::query()
            ->where('category_id', $categoryId)
            ->where('status', ChapterEnum::STATUS_SHOWN)
            ->get();
        $nodes = $data->toTree();
        $traverse($nodes);

        // Trans for data contains column: id, name, parent_id

        $idToParentCollection = $data->pluck('parent_id', 'id');

        $chapterQuestionCountCollection = Question::query()
            ->select($this->dbManager->raw('count(*) as chapter_question_count, chapter_id'))
            ->whereIn('chapter_id', $idToParentCollection->keys())
            ->groupBy('chapter_id')
            ->pluck('chapter_question_count', 'chapter_id');

        $retValues = [];
        if ($chapterValues) {
            foreach ($chapterValues as $id => $name) {
                $retValues[] = [
                    'id' => $id,
                    'name' => $name,
                    'parent_id' => $idToParentCollection[$id] ?? null,
                    'count' => $chapterQuestionCountCollection[$id] ?? 0,
                ];
            }
        }
        return $retValues;
    }
}

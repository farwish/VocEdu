<?php

namespace App\Repositories;

use App\Basics\BaseRepository;
use App\Models\Question;
use Illuminate\Database\DatabaseManager;

class QuestionRepository extends BaseRepository
{
    public function __construct(Question $question, DatabaseManager $dbManager)
    {
        parent::__construct($question, $dbManager);
    }

    /**
     * Question that with largest sort number is first question.
     *
     * @param int $categoryId
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function firstSeriesNumberQuestion(int $categoryId)
    {
        return $this->newQuery()
            ->where('category_id', $categoryId)
            ->orderBy('sort', 'DESC')
            ->first();
    }
}

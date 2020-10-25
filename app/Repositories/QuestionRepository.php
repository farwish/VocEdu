<?php

namespace App\Repositories;

use App\Basics\BaseRepository;
use App\Enums\PatternEnum;
use App\Enums\QuestionEnum;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Member;
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

    /**
     * 提卡
     * 章节下的题，校验用户是否购买
     *
     * @param Member $member
     * @param int $chapterId
     *
     * @return array
     */
    public function questionOfChapter(Member $member, int $chapterId): array
    {
        /** @var Chapter $chapter */
        $chapter = app(ChapterRepository::class)->newQuery()->find($chapterId);

        /** @var Category $category */
        $category = $chapter->category()->first();

        // check category is open by member
        $categoryOfMember = app(CategoryRepository::class)
            ->categoryOfMember($category, $member);

        $qb = $this->newQuery()
            ->select(['id'])
            ->where('chapter_id', $chapterId)
            ->orderBy('sort', 'DESC');

        if (! $categoryOfMember) {
            $qb->limit(4);
        }

        return [
            'questionIds' => $qb->get()->toArray(),
            'openStatus' => $categoryOfMember ? 1 : 0,
        ];
    }

    public function detail(int $questionId)
    {
        /** @var Question $question */
        $question = $this->newQuery()
            ->find($questionId)
        ;

        $question->setAttribute('difficulty', QuestionEnum::$difficulty[ $question->getAttribute('difficulty') ]);

        $pattern = $question->pattern()->first();
        $classify = $pattern->getAttribute('classify');

        if (PatternEnum::OBJECTIVE_CLASSIFY_JUDGE == $classify) {
            $rightAnswer = $question->getAttribute('right_answer');
            $question->setAttribute('right_answer', QuestionEnum::$rightAnswer[ $rightAnswer ]);
        }

        return $question;
    }
}

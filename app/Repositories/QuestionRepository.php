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
     * 题卡
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
        $categoryMember = app(CategoryRepository::class)
            ->categoryMember($category, $member);

        $qb = $this->newQuery()
            ->select(['id'])
            ->where('chapter_id', $chapterId)
            ->orderBy('sort', 'DESC')
            ->orderBy('id', 'ASC')
        ;

        if (! $categoryMember) {
            $qb->limit(4);
        }

        $questionList = $qb->get()->toArray();

        // Questions that has Done
        $hasRecordsQuestionIds = app(PractiseRecordRepository::class)
            ->hasRecordsAndAnswerQuestionIds(
                $member,
                $category->getAttribute('id'),
                array_column($questionList, 'id')
            );

        foreach ($questionList as &$item) {
            if (in_array($item['id'], $hasRecordsQuestionIds)) {
                $item['done'] = true;
            } else {
                $item['done'] = false;
            }
        }
        unset($item);

        return [
            'questionList' => $questionList,
            'openStatus' => $categoryMember ? 1 : 0,
        ];
    }

    public function detail(Member $member, int $questionId)
    {
        /** @var Question $question */
        $question = $this->newQuery()
            ->find($questionId)
        ;

        $question->setAttribute('difficulty', QuestionEnum::$difficulty[ $question->getAttribute('difficulty') ]);

        if (! $question->getAttribute('analysis')) {
            $question->setAttribute('analysis', '本题没有解析');
        }

        $pattern = $question->pattern()->first();
        $classify = $pattern->getAttribute('classify');
        if (PatternEnum::OBJECTIVE_CLASSIFY_JUDGE == $classify) {
            $question->setAttribute('option_answer', QuestionEnum::$judgeAnswer);
        }

        $question->setAttribute('patternClassify', $classify);
        $question->setAttribute('patternType', $pattern->getAttribute('type'));

        $categoryId = $question->category()->first()->getAttribute('id');
        $practiseRecord = app(PractiseRecordRepository::class)->specificRecordInfo($member, $categoryId, $questionId);
        $recordReplyAnswer = ($practiseRecord && !is_null($practiseRecord->getAttribute('reply_answer')))
                ? $practiseRecord->getAttribute('reply_answer')
                : '';

        unset($question['created_at'], $question['updated_at'], $question['pattern_id']);

        $questionDetailArr = $question->toArray();
        unset($question);

        $questionDetailArr['optionAnswer'] = $questionDetailArr['option_answer'];
        $questionDetailArr['rightAnswer'] = $questionDetailArr['right_answer'];
        $questionDetailArr['categoryId'] = $questionDetailArr['category_id'];
        $questionDetailArr['chapterId'] = $questionDetailArr['chapter_id'];
        unset(
            $questionDetailArr['option_answer'],
            $questionDetailArr['right_answer'],
            $questionDetailArr['category_id'],
            $questionDetailArr['chapter_id'],
        );

        return [
            'questionDetail' => $questionDetailArr,
            'recordReplyAnswer' => $recordReplyAnswer,
        ];
    }
}

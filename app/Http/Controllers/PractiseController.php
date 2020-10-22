<?php

namespace App\Http\Controllers;

use App\Http\Requests\PractiseRecordSave;
use App\Repositories\PractiseCollectRepository;
use App\Repositories\PractiseNoteRepository;
use App\Repositories\PractiseRecordRepository;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;

class PractiseController extends Controller
{
    /**
     * Only prepend and update, without delete.
     *
     * @param PractiseRecordSave $request
     * @param PractiseRecordRepository $practiseRecordRepository
     * @param QuestionRepository $questionRepository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function recordSave(PractiseRecordSave $request,
                               PractiseRecordRepository $practiseRecordRepository,
                               QuestionRepository $questionRepository)
    {
        $validated = $request->validated();

        $member = $request->user('api');
        $categoryId = $validated['category_id'];

        $questionId = $validated['question_id'] ?? null;
        $replyAnswer = $validated['reply_answer'] ?? null;

        if (! $questionId) {
            $specificRecordInfo = $practiseRecordRepository->specificRecordInfo($member, $categoryId);

            if ($specificRecordInfo) {
                // Find last record its question_id
                $questionId = $specificRecordInfo->getAttribute('question_id');
            } else {
                // Or fill first question_id as default.
                $question = $questionRepository->firstSeriesNumberQuestion($categoryId);
                $questionId = $question ? $question->getAttribute('id') : null;

                if (! $questionId) {
                    return $this->failure('该科目下没有题目 ！');
                }
            }
        }

        // Actually saving.
        $bool = $practiseRecordRepository->recordSave($member, $categoryId, $questionId, $replyAnswer);
        return $bool ? $this->success() : $this->failure();
    }

    public function recordInfo(Request $request, PractiseRecordRepository $practiseRecordRepository)
    {
        $member = $request->user('api');

        $recordInfo = $practiseRecordRepository->recordInfo($member);

        return $this->success($recordInfo);
    }

    public function recordSummary(Request $request, PractiseRecordRepository $practiseRecordRepository)
    {
        $member = $request->user('api');

        $summary = $practiseRecordRepository->recordSummary($member);

        return $this->success($summary);
    }

    /**
     * Current subject basic info
     *
     * @param Request $request
     * @param PractiseRecordRepository $practiseRecordRepository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentSubject(Request $request, PractiseRecordRepository $practiseRecordRepository)
    {
        $member = $request->user('api');

        $currentSubject = $practiseRecordRepository->currentSubjectInfo($member);

        return $this->success($currentSubject);
    }
}

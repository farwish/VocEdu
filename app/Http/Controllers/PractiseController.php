<?php

namespace App\Http\Controllers;

use App\Http\Requests\PractiseRecordInfo;
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
            $theRecordInfo = $practiseRecordRepository->theRecordInfo($member, $categoryId);

            if ($theRecordInfo) {
                // Do nothing about exists category when without question_id.
                return $this->success();
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
        $bool = $practiseRecordRepository->save($member, $categoryId, $questionId, $replyAnswer);
        return $bool ? $this->success() : $this->failure();
    }

    public function recordInfo(Request $request, PractiseRecordRepository $practiseRecordRepository)
    {
        $member = $request->user('api');

        $practiseRecordInfo = $practiseRecordRepository->practiseRecordInfo($member);

        return $this->success($practiseRecordInfo);
    }

    public function wrongsCount(PractiseRecordInfo $request, PractiseRecordRepository $practiseRecordRepository)
    {
        $member = $request->user('api');

        $validated = $request->validated();
        $categoryId = $validated['category_id'];

        $practiseWrongsCount = $practiseRecordRepository->practiseWrongsCount($member, $categoryId);

        return $this->success($practiseWrongsCount);
    }

    public function collectsCount(PractiseRecordInfo $request, PractiseCollectRepository $practiseCollectRepository)
    {
        $member = $request->user('api');

        $validated = $request->validated();
        $categoryId = $validated['category_id'];

        $practiseCollectsCount = $practiseCollectRepository->practiseCollectsCount($member, $categoryId);

        return $this->success($practiseCollectsCount);
    }

    public function notesCount(PractiseRecordInfo $request, PractiseNoteRepository $practiseNoteRepository)
    {
        $member = $request->user('api');

        $validated = $request->validated();
        $categoryId = $validated['category_id'];

        $practiseNotesCount = $practiseNoteRepository->practiseNotesCount($member, $categoryId);

        return $this->success($practiseNotesCount);
    }
}

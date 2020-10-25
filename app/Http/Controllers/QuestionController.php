<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionDetail;
use App\Http\Requests\QuestionIndex;
use App\Http\Requests\QuestionNoteInfo;
use App\Http\Requests\QuestionNoteSave;
use App\Repositories\PractiseNoteRepository;
use App\Repositories\QuestionRepository;

class QuestionController extends Controller
{
    public function index(QuestionIndex $request,
                          QuestionRepository $questionRepository)
    {
        $validated = $request->validated();

        $member = $request->user('api');
        $chapterId = $validated['cid'];

        $data = $questionRepository->questionOfChapter($member, $chapterId);

        return $this->success($data);
    }

    public function detail(QuestionDetail $request,
                           QuestionRepository $questionRepository)
    {
        $validated = $request->validated();

        $member = $request->user('api');
        $qid = $validated['qid'];

        $question = $questionRepository->detail($member, $qid);

        return $this->success($question);
    }

    public function noteSave(QuestionNoteSave $request, PractiseNoteRepository $practiseNoteRepository)
    {
        $validated = $request->validated();

        $member = $request->user('api');
        $qid = $validated['qid'];
        $note = $validated['note'];

        $bool = $practiseNoteRepository->saveNote($member, $qid, $note);

        return $bool ? $this->success() : $this->failure();
    }

    public function noteInfo(QuestionNoteInfo $request, PractiseNoteRepository $practiseNoteRepository)
    {
        $validated = $request->validated();

        $member = $request->user('api');
        $qid = $validated['qid'];

        $data = $practiseNoteRepository->info($member, $qid);

        return $this->success($data);
    }
}

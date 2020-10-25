<?php

namespace App\Repositories;

use App\Basics\BaseRepository;
use App\Models\Member;
use App\Models\PractiseNote;
use App\Models\Question;
use Illuminate\Database\DatabaseManager;

class PractiseNoteRepository extends BaseRepository
{
    public function __construct(PractiseNote $practiseNote, DatabaseManager $dbManager)
    {
        parent::__construct($practiseNote, $dbManager);
    }

    /**
     * Notes count
     *
     * @param Member $member
     * @param int $categoryId
     *
     * @return int
     */
    public function practiseNotesCount(Member $member, int $categoryId)
    {
        return $this->newQuery()
            ->where('member_id', $member->getAttribute('id'))
            ->where('category_id', $categoryId)
            ->count('id');
    }

    public function saveNote(Member $member, int $questionId, string $note)
    {
        $practiseNote = $this->newQuery()
            ->where('member_id', $member->getAttribute('id'))
            ->where('question_id', $questionId)
            ->first();

        if ($practiseNote) {
            $practiseNote->setAttribute('note', $note);
        } else {
            $practiseNote = $this->newModel();

            $practiseNote->setAttribute('member_id', $member->getAttribute('id'));
            $practiseNote->setAttribute('question_id', $questionId);
            $practiseNote->setAttribute('note', $note);

            /** @var Question $question */
            $question = app(QuestionRepository::class)->newQuery()->find($questionId);
            $category = $question->category()->first();
            $practiseNote->setAttribute('category_id', $category->getAttribute('id'));
        }

        return $practiseNote->save();
    }

    public function info(Member $member, int $questionId): array
    {
        $practiseNote = $this->newQuery()
            ->select(['note'])
            ->where('member_id', $member->getAttribute('id'))
            ->where('question_id', $questionId)
            ->first();

        if ($practiseNote) {
            return $practiseNote->toArray();
        }

        return [];
    }
}

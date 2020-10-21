<?php

namespace App\Repositories;

use App\Basics\BaseRepository;
use App\Models\Member;
use App\Models\PractiseNote;
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
}

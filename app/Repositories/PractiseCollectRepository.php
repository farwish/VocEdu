<?php

namespace App\Repositories;

use App\Basics\BaseRepository;
use App\Models\Member;
use App\Models\PractiseCollect;
use Illuminate\Database\DatabaseManager;

class PractiseCollectRepository extends BaseRepository
{
    public function __construct(PractiseCollect $practiseCollect, DatabaseManager $dbManager)
    {
        parent::__construct($practiseCollect, $dbManager);
    }

    // 收藏数
    public function practiseCollectsCount(Member $member, int $categoryId)
    {
        return $this->newQuery()
            ->where('member_id', $member->getAttribute('id'))
            ->where('category_id', $categoryId)
            ->count('id');
    }
}

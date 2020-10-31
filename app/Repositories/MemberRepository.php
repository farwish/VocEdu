<?php

namespace App\Repositories;

use App\Basics\BaseRepository;
use App\Models\Member;
use Illuminate\Database\DatabaseManager;

class MemberRepository extends BaseRepository
{
    public function __construct(Member $model, DatabaseManager $dbManager)
    {
        parent::__construct($model, $dbManager);
    }
}

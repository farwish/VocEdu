<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'exam_member', 'member_id', 'exam_id');
    }
}

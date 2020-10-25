<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use HasFactory;
    use NodeTrait;

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function papers()
    {
        return $this->hasMany(Paper::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function practiseRecords()
    {
        return $this->hasMany(PractiseRecord::class);
    }

    public function practiseCollects()
    {
        return $this->hasMany(PractiseCollect::class);
    }

    public function practiseNotes()
    {
        return $this->hasMany(PractiseNote::class);
    }

    // 开通科目题库的用户
    public function members()
    {
        return $this->belongsToMany(Member::class);
    }
}

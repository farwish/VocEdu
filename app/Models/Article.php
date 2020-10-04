<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    public function guides()
    {
        return $this->hasMany(Exam::class, 'guide_id', 'id');
    }

    public function outlines()
    {
        return $this->hasMany(Exam::class, 'outline_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function guides()
    {
        return $this->hasMany(Exam::class, 'guide_id', 'id');
    }

    public function outlines()
    {
        return $this->hasMany(Exam::class, 'outline_id', 'id');
    }

    public function explains()
    {
        return $this->hasMany(Package::class, 'explain_id', 'id');
    }
}

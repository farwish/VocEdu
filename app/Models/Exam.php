<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    public function paper()
    {
        return $this->belongsTo(Paper::class);
    }

    public function guide()
    {
        return $this->belongsTo(Article::class, 'guide_id', 'id');
    }

    public function outline()
    {
        return $this->belongsTo(Article::class, 'outline_id', 'id');
    }

    public function members()
    {
        return $this->belongsToMany(Member::class);
    }
}

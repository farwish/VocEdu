<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    public function paper()
    {
        return $this->hasOne(Paper::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class);
    }
}

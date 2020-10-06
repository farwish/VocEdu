<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    public function explain()
    {
        return $this->belongsTo(Article::class, 'explain_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function videos()
    {
        return $this->belongsToMany(Video::class);
    }

    public function suites()
    {
        return $this->belongsToMany(Suite::class);
    }
}

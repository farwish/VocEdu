<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Chapter extends Model
{
    use HasFactory;
    use NodeTrait;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

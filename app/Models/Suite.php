<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suite extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class);
    }

    public function papers()
    {
        return $this->belongsToMany(Paper::class, 'suite_paper', 'suite_id', 'paper_id');
    }
}

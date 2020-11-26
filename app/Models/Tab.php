<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tab extends Model
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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    public function papers()
    {
        return $this->belongsToMany(Paper::class);
    }

    public function videos()
    {
        return $this->belongsToMany(Video::class);
    }
}

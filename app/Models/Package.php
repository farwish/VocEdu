<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $casts = [
        'list_datetime' => 'datetime',
        'list_off_datetime' => 'datetime',
    ];

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

    public function tabs()
    {
        return $this->belongsToMany(Tab::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function papers()
    {
        return $this->belongsToMany(Paper::class);
    }

    public function setOptionAnswerAttribute($option)
    {
        $this->attributes['option_answer'] = json_encode($option, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function getOptionAnswerAttribute($value)
    {
         return json_decode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Member extends Authenticatable implements JWTSubject
{
    use HasFactory;

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'exam_member', 'member_id', 'exam_id');
    }

    public function practiseRecords()
    {
        return $this->hasMany(PractiseRecord::class);
    }

    public function practiseCollects()
    {
        return $this->hasMany(PractiseCollect::class);
    }

    public function practiseNotes()
    {
        return $this->hasMany(PractiseNote::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}

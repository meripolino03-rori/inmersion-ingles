<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

use App\Models\User;
use App\Models\School;
use App\Models\Assignment;

#[Fillable(['user_id', 'school_id'])]

class Teacher extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'teacher_id',
        'cycle_id',
        'section',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function cycle()
    {
        return $this->belongsTo(Cycle::class);
    }

    public function studentAssignments()
    {
        return $this->hasMany(StudentAssignment::class);
    }
}

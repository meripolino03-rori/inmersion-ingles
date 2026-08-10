<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['student_id', 'placement_exam_id', 'level', 'plan', 'active'])]

class StudyPlan extends Model
{
    protected $casts = [
        'plan'   => 'array',
        'active' => 'boolean',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function placementExam()
    {
        return $this->belongsTo(PlacementExam::class);
    }

    public function challenges()
    {
        return $this->hasMany(Challenge::class);
    }
}

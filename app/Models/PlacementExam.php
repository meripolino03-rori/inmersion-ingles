<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['student_id', 'attempt', 'answers', 'assigned_level', 'strengths', 'weaknesses', 'ai_analysis', 'taken_at'])]

class PlacementExam extends Model
{
    protected $casts = [
        'answers'    => 'array',
        'strengths'  => 'array',
        'weaknesses' => 'array',
        'taken_at'   => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function studyPlan()
    {
        return $this->hasOne(StudyPlan::class);
    }
}

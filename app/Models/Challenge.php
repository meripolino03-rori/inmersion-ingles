<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Support\Facades\Auth;

#[Fillable(['student_id', 'study_plan_id', 'skill', 'type', 'level', 'content', 'student_response', 'speech_transcript', 'ai_feedback', 'ai_score', 'status'])]

class Challenge extends Model
{
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function studyPlan()
    {
        return $this->belongsTo(StudyPlan::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope('school', function ($query) {
            $user = Auth::user();
            if ($user && $user->hasRole('teacher')) {
                $schoolId = $user->teacher?->school_id;
                if ($schoolId) {
                    $query->whereHas(
                        'student',
                        fn($q) =>
                        $q->where('school_id', $schoolId)
                    );
                }
            }
        });
    }
}

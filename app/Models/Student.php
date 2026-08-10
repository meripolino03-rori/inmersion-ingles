<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['user_id', 'cycle_id', 'school_id', 'code'])]

class Student extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cycle()
    {
        return $this->belongsTo(Cycle::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function studentAssignments()
    {
        return $this->hasMany(StudentAssignment::class);
    }

    public function placementExams()
    {
        return $this->hasMany(PlacementExam::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope('school', function ($query) {
            /** @var \App\Models\User|null $user */
            $user = Auth::user();

            // Admin ve todo sin filtro
            if (!$user || $user->hasRole('admin')) return;

            if ($user->hasRole('teacher')) {
                $teacher = $user->teacher;

                $studentIds = \App\Models\StudentAssignment::whereHas(
                    'assignment',
                    fn($q) =>
                    $q->where('teacher_id', $teacher->id)
                )->pluck('student_id');

                if ($studentIds->isNotEmpty()) {
                    $query->whereIn('id', $studentIds);
                } else {
                    $query->where('school_id', $teacher->school_id);
                }
            }
        });
    }
}

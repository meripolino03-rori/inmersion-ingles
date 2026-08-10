<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['evaluation_id', 'student_id', 'scores', 'total', 'feedback'])]

class Grade extends Model
{
    protected $casts = [
        'scores' => 'array',
        'total'  => 'float',
    ];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
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

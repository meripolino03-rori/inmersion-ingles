<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['rubric_id', 'unit_id', 'title', 'type', 'date', 'weight'])]

class Evaluation extends Model
{
    public function rubric()
    {
        return $this->belongsTo(Rubric::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function totalByStudent($studentId)
    {
        return $this->grades()
            ->where('student_id', $studentId)
            ->sum('score');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['type', 'description'])]

class Rubric extends Model
{
    public function criteria()
    {
        return $this->hasMany(Criterion::class)->orderBy('order');
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}

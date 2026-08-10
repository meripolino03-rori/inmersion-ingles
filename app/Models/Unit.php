<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['cycle_id', 'name', 'number'])]

class Unit extends Model
{
    public function cycle()
    {
        return $this->belongsTo(Cycle::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function practices()
    {
        return $this->hasMany(Practice::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}

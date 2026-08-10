<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;


#[Fillable(['name', 'year', 'semester', 'active'])]

class Cycle extends Model
{
    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}

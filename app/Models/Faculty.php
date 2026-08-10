<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name'])]

class Faculty extends Model
{
    public function schools()
    {
        return $this->hasMany(School::class);
    }
}

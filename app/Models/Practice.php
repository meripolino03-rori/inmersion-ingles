<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['unit_id', 'title', 'platform', 'url'])]

class Practice extends Model
{
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}

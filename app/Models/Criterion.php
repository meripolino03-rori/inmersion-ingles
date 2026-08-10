<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['rubric_id', 'name', 'description', 'order'])]

class Criterion extends Model
{
    // ← Orden automático al crear
    protected static function booted(): void
    {
        static::creating(function ($criterion) {
            if (!$criterion->order) {
                $criterion->order = static::where('rubric_id', $criterion->rubric_id)
                    ->max('order') + 1;
            }
        });

        // ← Reordenar al eliminar para no dejar huecos
        static::deleted(function ($criterion) {
            static::where('rubric_id', $criterion->rubric_id)
                ->orderBy('order')
                ->get()
                ->each(function ($c, $i) {
                    $c->update(['order' => $i + 1]);
                });
        });
    }

    // ← Siempre ordenar por order
    protected static function boot(): void
    {
        parent::boot();
    }

    // Scope por defecto ordenado
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function rubric()
    {
        return $this->belongsTo(Rubric::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}

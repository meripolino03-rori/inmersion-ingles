<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Panel;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]


class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // public function canAccessPanel(Panel $panel): bool
    // {
    //     return $this->hasRoleInsensitive(['admin', 'writer', 'moderador']); // usamos el nuevo método insenistive
    // }

    public function canAccessPanel(Panel $panel): bool
    {
        // Solo permitimos entrar al panel /admin si tiene el rol adecuado
        //return $this->hasRoleInsensitive(['admin', 'docente']);
        return true;
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    // 👇 AQUÍ VA
    public function hasRoleInsensitive($roles): bool
    {
        $roles = collect((array) $roles)
            ->map(fn($r) => strtolower($r))
            ->toArray();

        return $this->getRoleNames()
            ->map(fn($r) => strtolower($r))
            ->intersect($roles)
            ->isNotEmpty();
    }
}

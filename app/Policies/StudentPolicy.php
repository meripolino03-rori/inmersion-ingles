<?php

namespace App\Policies;

use App\Models\User;

class StudentPolicy extends BasePolicy
{
    // El docente PUEDE ver la lista de alumnos
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'teacher']);
    }

    // El docente PUEDE ver el perfil de un alumno específico
    public function view(User $user, $model): bool
    {
        return $user->hasAnyRole(['admin', 'teacher']);
    }

    // El docente NO PUEDE crear alumnos (Solo Admin)
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    // El docente NO PUEDE editar alumnos (Solo Admin)
    public function update(User $user, $model): bool
    {
        return $user->hasRole('admin');
    }

    // El docente NO PUEDE borrar alumnos (Solo Admin)
    public function delete(User $user, $model): bool
    {
        return $user->hasRole('admin');
    }
}

<?php
namespace App\Policies;

use App\Models\User;

class BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'teacher']);
    }

    public function view(User $user, $model): bool
    {
        return $user->hasAnyRole(['admin', 'teacher']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'teacher']);
    }

    public function update(User $user, $model): bool
    {
        return $user->hasAnyRole(['admin', 'teacher']);
    }

    public function delete(User $user, $model): bool
    {
        return $user->hasRole('admin');
    }
}
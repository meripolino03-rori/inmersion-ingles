<?php
namespace App\Policies;

use App\Models\User;

class AdminPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function view(User $user, $model): bool
    {
        return $user->hasRole('admin');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, $model): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, $model): bool
    {
        return $user->hasRole('admin');
    }
}

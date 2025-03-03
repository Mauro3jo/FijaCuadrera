<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Hipico;
use Illuminate\Auth\Access\HandlesAuthorization;

class HipicoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the hipico can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the hipico can view the model.
     */
    public function view(User $user, Hipico $model): bool
    {
        return true;
    }

    /**
     * Determine whether the hipico can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the hipico can update the model.
     */
    public function update(User $user, Hipico $model): bool
    {
        return true;
    }

    /**
     * Determine whether the hipico can delete the model.
     */
    public function delete(User $user, Hipico $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the hipico can restore the model.
     */
    public function restore(User $user, Hipico $model): bool
    {
        return false;
    }

    /**
     * Determine whether the hipico can permanently delete the model.
     */
    public function forceDelete(User $user, Hipico $model): bool
    {
        return false;
    }
}

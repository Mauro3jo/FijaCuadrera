<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Caballo;
use Illuminate\Auth\Access\HandlesAuthorization;

class CaballoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the caballo can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the caballo can view the model.
     */
    public function view(User $user, Caballo $model): bool
    {
        return true;
    }

    /**
     * Determine whether the caballo can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the caballo can update the model.
     */
    public function update(User $user, Caballo $model): bool
    {
        return true;
    }

    /**
     * Determine whether the caballo can delete the model.
     */
    public function delete(User $user, Caballo $model): bool
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
     * Determine whether the caballo can restore the model.
     */
    public function restore(User $user, Caballo $model): bool
    {
        return false;
    }

    /**
     * Determine whether the caballo can permanently delete the model.
     */
    public function forceDelete(User $user, Caballo $model): bool
    {
        return false;
    }
}

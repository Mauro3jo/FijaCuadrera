<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ApuestaPollaUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApuestaPollaUserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the apuestaPollaUser can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the apuestaPollaUser can view the model.
     */
    public function view(User $user, ApuestaPollaUser $model): bool
    {
        return true;
    }

    /**
     * Determine whether the apuestaPollaUser can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the apuestaPollaUser can update the model.
     */
    public function update(User $user, ApuestaPollaUser $model): bool
    {
        return true;
    }

    /**
     * Determine whether the apuestaPollaUser can delete the model.
     */
    public function delete(User $user, ApuestaPollaUser $model): bool
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
     * Determine whether the apuestaPollaUser can restore the model.
     */
    public function restore(User $user, ApuestaPollaUser $model): bool
    {
        return false;
    }

    /**
     * Determine whether the apuestaPollaUser can permanently delete the model.
     */
    public function forceDelete(User $user, ApuestaPollaUser $model): bool
    {
        return false;
    }
}

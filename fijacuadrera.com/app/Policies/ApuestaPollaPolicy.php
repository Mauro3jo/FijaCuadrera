<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ApuestaPolla;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApuestaPollaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the apuestaPolla can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the apuestaPolla can view the model.
     */
    public function view(User $user, ApuestaPolla $model): bool
    {
        return true;
    }

    /**
     * Determine whether the apuestaPolla can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the apuestaPolla can update the model.
     */
    public function update(User $user, ApuestaPolla $model): bool
    {
        return true;
    }

    /**
     * Determine whether the apuestaPolla can delete the model.
     */
    public function delete(User $user, ApuestaPolla $model): bool
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
     * Determine whether the apuestaPolla can restore the model.
     */
    public function restore(User $user, ApuestaPolla $model): bool
    {
        return false;
    }

    /**
     * Determine whether the apuestaPolla can permanently delete the model.
     */
    public function forceDelete(User $user, ApuestaPolla $model): bool
    {
        return false;
    }
}

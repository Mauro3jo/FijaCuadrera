<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Carrera;
use Illuminate\Auth\Access\HandlesAuthorization;

class CarreraPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the carrera can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the carrera can view the model.
     */
    public function view(User $user, Carrera $model): bool
    {
        return true;
    }

    /**
     * Determine whether the carrera can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the carrera can update the model.
     */
    public function update(User $user, Carrera $model): bool
    {
        return true;
    }

    /**
     * Determine whether the carrera can delete the model.
     */
    public function delete(User $user, Carrera $model): bool
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
     * Determine whether the carrera can restore the model.
     */
    public function restore(User $user, Carrera $model): bool
    {
        return false;
    }

    /**
     * Determine whether the carrera can permanently delete the model.
     */
    public function forceDelete(User $user, Carrera $model): bool
    {
        return false;
    }
}

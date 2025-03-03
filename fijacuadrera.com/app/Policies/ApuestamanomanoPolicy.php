<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Apuestamanomano;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApuestamanomanoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the apuestamanomano can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the apuestamanomano can view the model.
     */
    public function view(User $user, Apuestamanomano $model): bool
    {
        return true;
    }

    /**
     * Determine whether the apuestamanomano can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the apuestamanomano can update the model.
     */
    public function update(User $user, Apuestamanomano $model): bool
    {
        return true;
    }

    /**
     * Determine whether the apuestamanomano can delete the model.
     */
    public function delete(User $user, Apuestamanomano $model): bool
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
     * Determine whether the apuestamanomano can restore the model.
     */
    public function restore(User $user, Apuestamanomano $model): bool
    {
        return false;
    }

    /**
     * Determine whether the apuestamanomano can permanently delete the model.
     */
    public function forceDelete(User $user, Apuestamanomano $model): bool
    {
        return false;
    }
}

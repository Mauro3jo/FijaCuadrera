<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Formapago;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormapagoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the formapago can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the formapago can view the model.
     */
    public function view(User $user, Formapago $model): bool
    {
        return true;
    }

    /**
     * Determine whether the formapago can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the formapago can update the model.
     */
    public function update(User $user, Formapago $model): bool
    {
        return true;
    }

    /**
     * Determine whether the formapago can delete the model.
     */
    public function delete(User $user, Formapago $model): bool
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
     * Determine whether the formapago can restore the model.
     */
    public function restore(User $user, Formapago $model): bool
    {
        return false;
    }

    /**
     * Determine whether the formapago can permanently delete the model.
     */
    public function forceDelete(User $user, Formapago $model): bool
    {
        return false;
    }
}

<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Contacto;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the contacto can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the contacto can view the model.
     */
    public function view(User $user, Contacto $model): bool
    {
        return true;
    }

    /**
     * Determine whether the contacto can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the contacto can update the model.
     */
    public function update(User $user, Contacto $model): bool
    {
        return true;
    }

    /**
     * Determine whether the contacto can delete the model.
     */
    public function delete(User $user, Contacto $model): bool
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
     * Determine whether the contacto can restore the model.
     */
    public function restore(User $user, Contacto $model): bool
    {
        return false;
    }

    /**
     * Determine whether the contacto can permanently delete the model.
     */
    public function forceDelete(User $user, Contacto $model): bool
    {
        return false;
    }
}

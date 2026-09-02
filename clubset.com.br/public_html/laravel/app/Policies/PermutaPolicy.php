<?php

namespace App\Policies;

use App\Models\Permuta;
use App\Models\User;

class PermutaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Permuta $permuta): bool
    {
        return $permuta->ownOrLinkedBy($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Permuta $permuta): bool
    {
        return $permuta->ownedBy($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Permuta $permuta): bool
    {
        return $permuta->ownedBy($user);
    }
}

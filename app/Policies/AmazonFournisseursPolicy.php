<?php

namespace App\Policies;

use App\Models\User;
use App\Models\amazon_fournisseurs;
use Illuminate\Auth\Access\Response;

class AmazonFournisseursPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, amazon_fournisseurs $amazonFournisseurs): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, amazon_fournisseurs $amazonFournisseurs): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, amazon_fournisseurs $amazonFournisseurs): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, amazon_fournisseurs $amazonFournisseurs): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, amazon_fournisseurs $amazonFournisseurs): bool
    {
        //
    }
}

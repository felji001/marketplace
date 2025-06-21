<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        // Only producers can view their own products list
        return $user->hasRole('producer');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product)
    {
        // Anyone can view individual products (for catalog)
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        // Only producers can create products
        return $user->hasRole('producer');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product)
    {
        // Only the product owner (producer) or admin can update
        return $user->hasRole('admin') ||
               ($user->hasRole('producer') && $user->id === $product->user_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product)
    {
        // Only the product owner (producer) or admin can delete
        return $user->hasRole('admin') ||
               ($user->hasRole('producer') && $user->id === $product->user_id);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Product $product)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Product $product)
    {
        //
    }
}

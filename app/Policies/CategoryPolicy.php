<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        // Admins and producers can view categories (producers need to see them for product creation)
        return $user->hasAnyRole(['admin', 'producer']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Category $category)
    {
        // Anyone can view categories (for browsing)
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        // Only admins can create categories
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Category $category)
    {
        // Only admins can update categories
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Category $category)
    {
        // Only admins can delete categories
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Category $category)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Category $category)
    {
        //
    }
}

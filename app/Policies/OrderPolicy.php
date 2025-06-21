<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        // Users can view their own orders
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order)
    {
        // Users can only view their own orders, admins can view all
        return $user->hasRole('admin') || $user->id === $order->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        // Only buyers can create orders
        return $user->hasRole('buyer');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Order $order)
    {
        // Users can update their own orders (status changes), admins can update all
        return $user->hasRole('admin') || $user->id === $order->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Order $order)
    {
        // Only admins can delete orders
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can cancel the order.
     */
    public function cancel(User $user, Order $order)
    {
        // Users can cancel their own orders if cancellable, admins can cancel any
        return ($user->id === $order->user_id && $order->canBeCancelled()) || 
               $user->hasRole('admin');
    }
}

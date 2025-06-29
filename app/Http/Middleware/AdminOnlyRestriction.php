<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOnlyRestriction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        // If user is not authenticated, let other middleware handle it
        if (!$user) {
            return $next($request);
        }

        // If user has admin role but no other roles (admin-only user)
        if ($user->hasRole('admin') && !$user->hasAnyRole(['producer', 'buyer'])) {
            // List of routes that admin-only users should not access
            $restrictedRoutes = [
                'products.create',
                'products.store', 
                'products.edit',
                'products.update',
                'products.destroy',
                'orders.create',
                'orders.store',
                'orders.show',
                'orders.index',
                'orders.cancel',
                'cart.*',
                'checkout.*'
            ];

            $currentRoute = $request->route()->getName();
            
            // Check if current route is restricted for admin-only users
            foreach ($restrictedRoutes as $restrictedRoute) {
                if (fnmatch($restrictedRoute, $currentRoute)) {
                    return redirect()->route('admin.dashboard')
                        ->with('error', 'Access denied. Admin users cannot access marketplace features.');
                }
            }
        }

        return $next($request);
    }
}

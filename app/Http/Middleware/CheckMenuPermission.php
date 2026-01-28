<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\MenuItem;

class CheckMenuPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // If not logged in, let the auth middleware handle it
        if (!$user) {
            return $next($request);
        }

        // Check if role is active
        if ($user->role && !$user->role->is_active) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login')->withErrors([
                'email' => 'Your account role has been deactivated. Please contact support.'
            ]);
        }

        // Super admins have access to everything
        if ($user->role && $user->role->slug === 'super-admin') {
            return $next($request);
        }

        $currentRouteName = $request->route()->getName();

        // List of routes that are always accessible to any logged-in user
        $publicRoutes = [
            'dashboard',
            'profile.index',
            'profile.update',
            'profile.password.update',
            'logout',
            'account.index',
            'account.deactivate',
            'account.delete',
        ];

        if (in_array($currentRouteName, $publicRoutes)) {
            return $next($request);
        }

        // Get all menu items assigned to this user's role
        $assignedRoutes = $user->role->menuItems()
            ->whereNotNull('route')
            ->pluck('route')
            ->toArray();

        // Check if the current route matches an assigned route exactly
        if (in_array($currentRouteName, $assignedRoutes)) {
            return $next($request);
        }

        // Check for specific logical groupings (e.g., permissions management routes tied to roles/settings)
        $relatedRoutes = [
            'permissions.index' => ['roles.index', 'settings.index'],
            'permissions.edit' => ['roles.index', 'settings.index'],
            'permissions.update' => ['roles.index', 'settings.index'],
        ];

        if (isset($relatedRoutes[$currentRouteName])) {
            foreach ($relatedRoutes[$currentRouteName] as $requiredRoute) {
                if (in_array($requiredRoute, $assignedRoutes)) {
                    return $next($request);
                }
            }
        }

        // Check for resource routes (e.g., if user has 'users.index', allow 'users.create', 'users.edit', etc.)
        // We do this by checking if the base name (everything before the first dot) matches an assigned route's base
        $baseRoute = explode('.', $currentRouteName)[0];
        foreach ($assignedRoutes as $assignedRoute) {
            $assignedBase = explode('.', $assignedRoute)[0];
            if ($baseRoute === $assignedBase && $assignedBase !== '') {
                return $next($request);
            }
        }

        // If a route is NOT in the menu_items table at all, should we allow it?
        // To be strict: No. But to be practical for now: 
        // Let's see if the route name exists in any role's menu items. 
        // If NO role has this route in their menu, it might be a new or internal route.
        $isManagedRoute = MenuItem::where('route', $currentRouteName)
            ->orWhere('route', 'like', $baseRoute . '.%')
            ->exists();
            
        if (!$isManagedRoute) {
            return $next($request);
        }

        // If we get here, the user doesn't have permission
        return response()->view('errors.403', [], 403);
    }
}

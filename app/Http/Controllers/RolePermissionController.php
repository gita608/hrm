<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Role;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of roles to manage permissions.
     */
    public function index()
    {
        $roles = Role::where('is_active', true)->get();
        return view('pages.permissions.index', compact('roles'));
    }

    /**
     * Show the permissions (menu items) for a specific role.
     */
    public function permissions(Role $role)
    {
        // Get all menu items structured as tree (root items with children)
        $menuItems = MenuItem::whereNull('parent_id')
            ->with(['children' => function($query) {
                $query->orderBy('order');
            }])
            ->orderBy('order')
            ->get();
            
        // Get currently assigned menu item IDs for this role
        $roleMenuItems = $role->menuItems()->pluck('menu_items.id')->toArray();

        return view('pages.permissions.permissions', compact('role', 'menuItems', 'roleMenuItems'));
    }

    /**
     * Update the permissions (menu items) for a specific role.
     */
    public function updatePermissions(Request $request, Role $role)
    {
        $validated = $request->validate([
            'menu_items' => 'nullable|array',
            'menu_items.*' => 'exists:menu_items,id'
        ]);

        $menuItemIds = $request->input('menu_items', []);
        
        // Sync the menu items with the role
        $role->menuItems()->sync($menuItemIds);

        return redirect()->route('permissions.index')
            ->with('success', 'Permissions updated successfully for ' . $role->name);
    }
}

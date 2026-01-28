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
        
        // Always include Dashboard (ID 2) by default for all roles
        if (!in_array(2, $menuItemIds)) {
            $menuItemIds[] = 2;
        }
        
        if (!empty($menuItemIds)) {
            // Automatically find and add Titles associated with these items
            $selectedItems = MenuItem::whereIn('id', $menuItemIds)->get();
            $allTitles = MenuItem::where('type', 'title')->orderBy('order')->get();
            
            $additionalIds = [];
            foreach ($selectedItems as $item) {
                // Find the nearest title with an order less than or equal to this item
                $nearestTitle = MenuItem::where('type', 'title')
                    ->where('order', '<=', $item->order)
                    ->orderBy('order', 'desc')
                    ->first();
                
                if ($nearestTitle) {
                    $additionalIds[] = $nearestTitle->id;
                }
            }
            
            $menuItemIds = array_unique(array_merge($menuItemIds, $additionalIds));
        }
        
        // Sync the menu items with the role
        $role->menuItems()->sync($menuItemIds);

        return redirect()->route('permissions.index')
            ->with('success', 'Permissions updated successfully for ' . $role->name);
    }
}

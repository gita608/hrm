<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function getMenu()
    {
        $user = auth()->user();
        if (!$user || !$user->role) {
            return collect();
        }

        $role = $user->role;

        // If super-admin, show all active menus
        if ($role->slug === 'super-admin') {
            return MenuItem::root()
                ->with(['children' => function ($query) {
                    $query->active();
                }])
                ->active()
                ->get();
        }

        // Get root menu items assigned to this role, with their assigned children
        $menuItems = MenuItem::root()
            ->whereHas('roles', function ($query) use ($role) {
                $query->where('roles.id', $role->id);
            })
            ->with(['children' => function ($query) use ($role) {
                $query->whereHas('roles', function ($q) use ($role) {
                    $q->where('roles.id', $role->id);
                })->active()->orderBy('order');
            }])
            ->active()
            ->get();

        return $menuItems;
    }

    public function index()
    {
        $menuItems = MenuItem::with('parent')->orderBy('order')->get();
        return view('admin.menu-items.index', compact('menuItems'));
    }

    public function create()
    {
        $parents = MenuItem::whereNull('parent_id')->get();
        return view('admin.menu-items.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'route' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menu_items,id',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        MenuItem::create($validated);

        return redirect()->route('menu-items.index')
            ->with('success', 'Menu item created successfully.');
    }

    public function edit(MenuItem $menuItem)
    {
        $parents = MenuItem::whereNull('parent_id')
            ->where('id', '!=', $menuItem->id)
            ->get();
        return view('admin.menu-items.edit', compact('menuItem', 'parents'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'route' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menu_items,id',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $menuItem->update($validated);

        return redirect()->route('menu-items.index')
            ->with('success', 'Menu item updated successfully.');
    }

    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();

        return redirect()->route('menu-items.index')
            ->with('success', 'Menu item deleted successfully.');
    }
}

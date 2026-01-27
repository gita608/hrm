<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function getMenu()
    {
        // Get all root menu items with their children
        $menuItems = MenuItem::root()
            ->with(['children' => function ($query) {
                $query->active();
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

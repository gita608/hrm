<?php

namespace App\Http\Controllers;

use App\Models\AssetCategory;
use Illuminate\Http\Request;

class AssetCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AssetCategory::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status == 'active');
        }

        $categories = $query->orderBy('created_at', 'desc')->get();

        return view('pages.assets.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.assets.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255|unique:asset_categories,code',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        AssetCategory::create($validated);

        return redirect()->route('assets.categories.index')->with('success', 'Asset category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = AssetCategory::withCount('assets')->findOrFail($id);
        return view('pages.assets.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = AssetCategory::findOrFail($id);
        return view('pages.assets.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = AssetCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255|unique:asset_categories,code,' . $id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $category->update($validated);

        return redirect()->route('assets.categories.index')->with('success', 'Asset category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = AssetCategory::findOrFail($id);
        
        // Check if category has assets
        if ($category->assets()->count() > 0) {
            return redirect()->route('assets.categories.index')->with('error', 'Cannot delete category that has assigned assets.');
        }

        $category->delete();

        return redirect()->route('assets.categories.index')->with('success', 'Asset category deleted successfully.');
    }
}

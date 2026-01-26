<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\User;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Asset::with(['category', 'assignedUser']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by assigned user
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        $assets = $query->orderBy('created_at', 'desc')->get();
        $categories = AssetCategory::where('is_active', true)->orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('pages.assets.index', compact('assets', 'categories', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = AssetCategory::where('is_active', true)->orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('pages.assets.create', compact('categories', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'asset_code' => 'nullable|string|max:255|unique:assets,asset_code',
            'category_id' => 'nullable|exists:asset_categories,id',
            'serial_number' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'purchase_price' => 'nullable|numeric|min:0',
            'purchase_date' => 'nullable|date',
            'warranty_expiry_date' => 'nullable|date|after_or_equal:purchase_date',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'required|in:available,assigned,maintenance,retired',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Asset::create($validated);

        return redirect()->route('assets.index')->with('success', 'Asset created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $asset = Asset::with(['category', 'assignedUser'])->findOrFail($id);

        return view('pages.assets.show', compact('asset'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $asset = Asset::findOrFail($id);
        $categories = AssetCategory::where('is_active', true)->orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('pages.assets.edit', compact('asset', 'categories', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $asset = Asset::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'asset_code' => 'nullable|string|max:255|unique:assets,asset_code,'.$id,
            'category_id' => 'nullable|exists:asset_categories,id',
            'serial_number' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'purchase_price' => 'nullable|numeric|min:0',
            'purchase_date' => 'nullable|date',
            'warranty_expiry_date' => 'nullable|date|after_or_equal:purchase_date',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'required|in:available,assigned,maintenance,retired',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $asset->update($validated);

        return redirect()->route('assets.index')->with('success', 'Asset updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();

        return redirect()->route('assets.index')->with('success', 'Asset deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\TrainingType;
use Illuminate\Http\Request;

class TrainingTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TrainingType::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status == 'active');
        }

        $trainingTypes = $query->orderBy('created_at', 'desc')->get();

        return view('pages.training.types.index', compact('trainingTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.training.types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255|unique:training_types,code',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        TrainingType::create($validated);

        return redirect()->route('training.types.index')->with('success', 'Training type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $trainingType = TrainingType::withCount('trainings')->findOrFail($id);

        return view('pages.training.types.show', compact('trainingType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $trainingType = TrainingType::findOrFail($id);

        return view('pages.training.types.edit', compact('trainingType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $trainingType = TrainingType::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255|unique:training_types,code,'.$id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $trainingType->update($validated);

        return redirect()->route('training.types.index')->with('success', 'Training type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $trainingType = TrainingType::findOrFail($id);

        // Check if training type has trainings
        if ($trainingType->trainings()->count() > 0) {
            return redirect()->route('training.types.index')->with('error', 'Cannot delete training type that has assigned trainings.');
        }

        $trainingType->delete();

        return redirect()->route('training.types.index')->with('success', 'Training type deleted successfully.');
    }
}

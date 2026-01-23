<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Trainer::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status == 'active');
        }

        $trainers = $query->orderBy('created_at', 'desc')->get();

        return view('pages.trainers.index', compact('trainers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.trainers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:trainers,email',
            'phone' => 'nullable|string|max:20',
            'expertise' => 'nullable|string',
            'bio' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Trainer::create($validated);

        return redirect()->route('trainers.index')->with('success', 'Trainer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $trainer = Trainer::withCount('trainings')->findOrFail($id);
        return view('pages.trainers.show', compact('trainer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $trainer = Trainer::findOrFail($id);
        return view('pages.trainers.edit', compact('trainer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $trainer = Trainer::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:trainers,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'expertise' => 'nullable|string',
            'bio' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $trainer->update($validated);

        return redirect()->route('trainers.index')->with('success', 'Trainer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $trainer = Trainer::findOrFail($id);
        $trainer->delete();

        return redirect()->route('trainers.index')->with('success', 'Trainer deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\TrainingType;
use App\Models\Trainer;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Training::with(['trainingType', 'trainer']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by training type
        if ($request->filled('training_type_id')) {
            $query->where('training_type_id', $request->training_type_id);
        }

        // Filter by trainer
        if ($request->filled('trainer_id')) {
            $query->where('trainer_id', $request->trainer_id);
        }

        $trainings = $query->orderBy('created_at', 'desc')->get();
        $trainingTypes = TrainingType::where('is_active', true)->orderBy('name')->get();
        $trainers = Trainer::where('is_active', true)->orderBy('name')->get();

        return view('pages.training.index', compact('trainings', 'trainingTypes', 'trainers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $trainingTypes = TrainingType::where('is_active', true)->orderBy('name')->get();
        $trainers = Trainer::where('is_active', true)->orderBy('name')->get();
        return view('pages.training.create', compact('trainingTypes', 'trainers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'training_type_id' => 'nullable|exists:training_types,id',
            'trainer_id' => 'nullable|exists:trainers,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
            'status' => 'required|in:scheduled,ongoing,completed,cancelled',
            'location' => 'nullable|string|max:255',
            'max_participants' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            // UAE-specific fields
            'uae_labor_law_compliance' => 'boolean',
        ]);

        Training::create($validated);

        return redirect()->route('training.index')->with('success', 'Training created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $training = Training::with(['trainingType', 'trainer'])->findOrFail($id);
        return view('pages.training.show', compact('training'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $training = Training::findOrFail($id);
        $trainingTypes = TrainingType::where('is_active', true)->orderBy('name')->get();
        $trainers = Trainer::where('is_active', true)->orderBy('name')->get();
        return view('pages.training.edit', compact('training', 'trainingTypes', 'trainers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $training = Training::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'training_type_id' => 'nullable|exists:training_types,id',
            'trainer_id' => 'nullable|exists:trainers,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
            'status' => 'required|in:scheduled,ongoing,completed,cancelled',
            'location' => 'nullable|string|max:255',
            'max_participants' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            // UAE-specific fields
            'uae_labor_law_compliance' => 'boolean',
        ]);

        $training->update($validated);

        return redirect()->route('training.index')->with('success', 'Training updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $training = Training::findOrFail($id);
        $training->delete();

        return redirect()->route('training.index')->with('success', 'Training deleted successfully.');
    }
}

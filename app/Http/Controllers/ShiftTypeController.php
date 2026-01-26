<?php

namespace App\Http\Controllers;

use App\Models\ShiftType;
use Illuminate\Http\Request;

class ShiftTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shiftTypes = ShiftType::orderBy('name')->get();

        return view('pages.schedule.shift-types.index', compact('shiftTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.schedule.shift-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        ShiftType::create($validated);

        return redirect()->route('shift-types.index')->with('success', 'Shift type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $shiftType = ShiftType::findOrFail($id);

        return view('pages.schedule.shift-types.show', compact('shiftType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $shiftType = ShiftType::findOrFail($id);

        return view('pages.schedule.shift-types.edit', compact('shiftType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $shiftType = ShiftType::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        $shiftType->update($validated);

        return redirect()->route('shift-types.index')->with('success', 'Shift type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $shiftType = ShiftType::findOrFail($id);
        
        // Check if shift type is being used
        if ($shiftType->schedules()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete shift type that is being used in schedules.');
        }

        $shiftType->delete();

        return redirect()->route('shift-types.index')->with('success', 'Shift type deleted successfully.');
    }
}

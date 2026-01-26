<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    /**
     * Store a newly created leave type.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:leave_types,name',
            'days_per_year' => 'required|integer|min:0',
            'is_paid' => 'boolean',
            'requires_approval' => 'boolean',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = \Str::slug($validated['name']);

        LeaveType::create($validated);

        return redirect()->route('leaves.settings')->with('success', 'Leave type created successfully.');
    }

    /**
     * Update the specified leave type.
     */
    public function update(Request $request, string $id)
    {
        $leaveType = LeaveType::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:leave_types,name,' . $id,
            'days_per_year' => 'required|integer|min:0',
            'is_paid' => 'boolean',
            'requires_approval' => 'boolean',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = \Str::slug($validated['name']);

        $leaveType->update($validated);

        return redirect()->route('leaves.settings')->with('success', 'Leave type updated successfully.');
    }

    /**
     * Remove the specified leave type.
     */
    public function destroy(string $id)
    {
        $leaveType = LeaveType::findOrFail($id);

        // Check if leave type has any leaves
        if ($leaveType->leaves()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete leave type that has associated leave requests.');
        }

        $leaveType->delete();

        return redirect()->route('leaves.settings')->with('success', 'Leave type deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Termination;
use App\Models\User;
use Illuminate\Http\Request;

class TerminationController extends Controller
{
    public function index(Request $request)
    {
        $query = Termination::with('employee');

        // Filter by employee
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('termination_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('termination_date', '<=', $request->date_to);
        }

        $terminations = $query->orderBy('termination_date', 'desc')->get();
        $employees = User::orderBy('name')->get();

        return view('pages.terminations.index', compact('terminations', 'employees'));
    }

    public function create()
    {
        $employees = User::orderBy('name')->get();
        return view('pages.terminations.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'termination_date' => 'required|date',
            'notice_date' => 'nullable|date',
            'type' => 'required|in:voluntary,involuntary,retirement,end_of_contract,other',
            'reason' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Termination::create($validated);

        return redirect()->route('terminations.index')->with('success', 'Termination created successfully.');
    }

    public function show(string $id)
    {
        $termination = Termination::with('employee')->findOrFail($id);
        return view('pages.terminations.show', compact('termination'));
    }

    public function edit(string $id)
    {
        $termination = Termination::findOrFail($id);
        $employees = User::orderBy('name')->get();
        return view('pages.terminations.edit', compact('termination', 'employees'));
    }

    public function update(Request $request, string $id)
    {
        $termination = Termination::findOrFail($id);

        $validated = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'termination_date' => 'required|date',
            'notice_date' => 'nullable|date',
            'type' => 'required|in:voluntary,involuntary,retirement,end_of_contract,other',
            'reason' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $termination->update($validated);

        return redirect()->route('terminations.index')->with('success', 'Termination updated successfully.');
    }

    public function destroy(string $id)
    {
        $termination = Termination::findOrFail($id);
        $termination->delete();

        return redirect()->route('terminations.index')->with('success', 'Termination deleted successfully.');
    }
}

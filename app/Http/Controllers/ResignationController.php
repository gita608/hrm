<?php

namespace App\Http\Controllers;

use App\Models\Resignation;
use App\Models\User;
use Illuminate\Http\Request;

class ResignationController extends Controller
{
    public function index(Request $request)
    {
        $query = Resignation::with('employee');

        // Filter by employee
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('resignation_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('resignation_date', '<=', $request->date_to);
        }

        $resignations = $query->orderBy('resignation_date', 'desc')->get();
        $employees = User::orderBy('name')->get();

        return view('pages.resignations.index', compact('resignations', 'employees'));
    }

    public function create()
    {
        $employees = User::orderBy('name')->get();
        return view('pages.resignations.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'resignation_date' => 'required|date',
            'notice_date' => 'nullable|date',
            'last_working_day' => 'nullable|date|after_or_equal:resignation_date',
            'reason' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,accepted,rejected,withdrawn',
            'is_active' => 'boolean',
        ]);

        Resignation::create($validated);

        return redirect()->route('resignations.index')->with('success', 'Resignation created successfully.');
    }

    public function show(string $id)
    {
        $resignation = Resignation::with('employee')->findOrFail($id);
        return view('pages.resignations.show', compact('resignation'));
    }

    public function edit(string $id)
    {
        $resignation = Resignation::findOrFail($id);
        $employees = User::orderBy('name')->get();
        return view('pages.resignations.edit', compact('resignation', 'employees'));
    }

    public function update(Request $request, string $id)
    {
        $resignation = Resignation::findOrFail($id);

        $validated = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'resignation_date' => 'required|date',
            'notice_date' => 'nullable|date',
            'last_working_day' => 'nullable|date|after_or_equal:resignation_date',
            'reason' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,accepted,rejected,withdrawn',
            'is_active' => 'boolean',
        ]);

        $resignation->update($validated);

        return redirect()->route('resignations.index')->with('success', 'Resignation updated successfully.');
    }

    public function destroy(string $id)
    {
        $resignation = Resignation::findOrFail($id);
        $resignation->delete();

        return redirect()->route('resignations.index')->with('success', 'Resignation deleted successfully.');
    }
}

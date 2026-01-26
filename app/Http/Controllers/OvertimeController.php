<?php

namespace App\Http\Controllers;

use App\Models\Overtime;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OvertimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Overtime::with(['employee', 'approver']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by employee
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        $overtimes = $query->orderBy('date', 'desc')->orderBy('created_at', 'desc')->get();
        $employees = User::whereHas('role', function($q) {
            $q->where('name', '!=', 'admin');
        })->orWhereDoesntHave('role')->orderBy('name')->get();

        return view('pages.overtime.index', compact('overtimes', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = User::whereHas('role', function($q) {
            $q->where('name', '!=', 'admin');
        })->orWhereDoesntHave('role')->orderBy('name')->get();

        return view('pages.overtime.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'reason' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Calculate hours
        $start = Carbon::parse($validated['date'] . ' ' . $validated['start_time']);
        $end = Carbon::parse($validated['date'] . ' ' . $validated['end_time']);
        $validated['hours'] = round($end->diffInMinutes($start) / 60, 2);

        Overtime::create($validated);

        return redirect()->route('overtime.index')->with('success', 'Overtime request created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $overtime = Overtime::with(['employee', 'approver'])->findOrFail($id);

        return view('pages.overtime.show', compact('overtime'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $overtime = Overtime::findOrFail($id);
        $employees = User::whereHas('role', function($q) {
            $q->where('name', '!=', 'admin');
        })->orWhereDoesntHave('role')->orderBy('name')->get();

        return view('pages.overtime.edit', compact('overtime', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $overtime = Overtime::findOrFail($id);

        $validated = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'reason' => 'nullable|string|max:500',
            'status' => 'required|in:pending,approved,rejected',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Calculate hours
        $start = Carbon::parse($validated['date'] . ' ' . $validated['start_time']);
        $end = Carbon::parse($validated['date'] . ' ' . $validated['end_time']);
        $validated['hours'] = round($end->diffInMinutes($start) / 60, 2);

        // Update approval info if status changed
        if ($validated['status'] != $overtime->status && $validated['status'] != 'pending') {
            $validated['approved_by'] = auth()->id();
            $validated['approved_at'] = now();
        } elseif ($validated['status'] == 'pending') {
            $validated['approved_by'] = null;
            $validated['approved_at'] = null;
        }

        $overtime->update($validated);

        return redirect()->route('overtime.index')->with('success', 'Overtime request updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $overtime = Overtime::findOrFail($id);
        $overtime->delete();

        return redirect()->route('overtime.index')->with('success', 'Overtime request deleted successfully.');
    }

    /**
     * Approve overtime request.
     */
    public function approve(Request $request, string $id)
    {
        $overtime = Overtime::findOrFail($id);
        
        $overtime->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Overtime request approved successfully.');
    }

    /**
     * Reject overtime request.
     */
    public function reject(Request $request, string $id)
    {
        $overtime = Overtime::findOrFail($id);
        
        $validated = $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $overtime->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'notes' => $validated['notes'] ?? $overtime->notes,
        ]);

        return redirect()->back()->with('success', 'Overtime request rejected successfully.');
    }
}

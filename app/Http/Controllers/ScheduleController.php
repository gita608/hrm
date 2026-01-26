<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\ShiftType;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Schedule::with(['employee', 'shiftType']);

        // Filter by employee
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        // Filter by shift type
        if ($request->filled('shift_type_id')) {
            $query->where('shift_type_id', $request->shift_type_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        // Default to current week if no date filter
        if (!$request->filled('date_from') && !$request->filled('date_to')) {
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();
            $query->whereBetween('date', [$startOfWeek, $endOfWeek]);
        }

        $schedules = $query->orderBy('date', 'asc')->orderBy('start_time', 'asc')->get();
        $employees = User::whereHas('role', function($q) {
            $q->where('name', '!=', 'admin');
        })->orWhereDoesntHave('role')->orderBy('name')->get();
        $shiftTypes = ShiftType::where('is_active', true)->orderBy('name')->get();

        return view('pages.schedule.index', compact('schedules', 'employees', 'shiftTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = User::whereHas('role', function($q) {
            $q->where('name', '!=', 'admin');
        })->orWhereDoesntHave('role')->orderBy('name')->get();
        $shiftTypes = ShiftType::where('is_active', true)->orderBy('name')->get();

        return view('pages.schedule.create', compact('employees', 'shiftTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'shift_type_id' => 'required|exists:shift_types,id',
            'date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'status' => 'required|in:scheduled,completed,cancelled,absent',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Check if schedule already exists for this employee and date
        $existingSchedule = Schedule::where('employee_id', $validated['employee_id'])
            ->where('date', $validated['date'])
            ->first();

        if ($existingSchedule) {
            return redirect()->back()->withInput()->with('error', 'A schedule already exists for this employee on this date.');
        }

        // If start_time and end_time are not provided, use shift type defaults
        if (!$validated['start_time'] || !$validated['end_time']) {
            $shiftType = ShiftType::findOrFail($validated['shift_type_id']);
            $validated['start_time'] = $shiftType->start_time->format('H:i');
            $validated['end_time'] = $shiftType->end_time->format('H:i');
        }

        Schedule::create($validated);

        return redirect()->route('schedule.index')->with('success', 'Schedule created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $schedule = Schedule::with(['employee', 'shiftType'])->findOrFail($id);

        return view('pages.schedule.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        $employees = User::whereHas('role', function($q) {
            $q->where('name', '!=', 'admin');
        })->orWhereDoesntHave('role')->orderBy('name')->get();
        $shiftTypes = ShiftType::where('is_active', true)->orderBy('name')->get();

        return view('pages.schedule.edit', compact('schedule', 'employees', 'shiftTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $schedule = Schedule::findOrFail($id);

        $validated = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'shift_type_id' => 'required|exists:shift_types,id',
            'date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'status' => 'required|in:scheduled,completed,cancelled,absent',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Check if schedule already exists for this employee and date (excluding current)
        $existingSchedule = Schedule::where('employee_id', $validated['employee_id'])
            ->where('date', $validated['date'])
            ->where('id', '!=', $id)
            ->first();

        if ($existingSchedule) {
            return redirect()->back()->withInput()->with('error', 'A schedule already exists for this employee on this date.');
        }

        // If start_time and end_time are not provided, use shift type defaults
        if (!$validated['start_time'] || !$validated['end_time']) {
            $shiftType = ShiftType::findOrFail($validated['shift_type_id']);
            $validated['start_time'] = $shiftType->start_time->format('H:i');
            $validated['end_time'] = $shiftType->end_time->format('H:i');
        }

        $schedule->update($validated);

        return redirect()->route('schedule.index')->with('success', 'Schedule updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('schedule.index')->with('success', 'Schedule deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display attendance list (Admin view).
     */
    public function adminIndex(Request $request)
    {
        $query = Attendance::with(['employee']);

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

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Default to current month if no date filters
        if (!$request->hasAny(['date_from', 'date_to'])) {
            $query->whereMonth('date', Carbon::now()->month)
                  ->whereYear('date', Carbon::now()->year);
        }

        $attendances = $query->orderBy('date', 'desc')->orderBy('created_at', 'desc')->get();
        $employees = User::orderBy('name')->get();

        return view('pages.attendance.admin', compact('attendances', 'employees'));
    }

    /**
     * Display attendance list (Employee view).
     */
    public function employeeIndex(Request $request)
    {
        $query = Attendance::where('employee_id', auth()->id());

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        // Default to current month if no date filters
        if (!$request->hasAny(['date_from', 'date_to'])) {
            $query->whereMonth('date', Carbon::now()->month)
                  ->whereYear('date', Carbon::now()->year);
        }

        $attendances = $query->orderBy('date', 'desc')->get();

        return view('pages.attendance.employee', compact('attendances'));
    }

    /**
     * Store a newly created attendance record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i|after:check_in',
            'break_start' => 'nullable|date_format:H:i',
            'break_end' => 'nullable|date_format:H:i|after:break_start',
            'status' => 'required|in:present,absent,half_day,late,on_leave',
            'notes' => 'nullable|string',
        ]);

        // Calculate total hours and break duration
        if ($validated['check_in'] && $validated['check_out']) {
            $checkIn = Carbon::parse($validated['date'] . ' ' . $validated['check_in']);
            $checkOut = Carbon::parse($validated['date'] . ' ' . $validated['check_out']);
            $totalMinutes = $checkOut->diffInMinutes($checkIn);

            if ($validated['break_start'] && $validated['break_end']) {
                $breakStart = Carbon::parse($validated['date'] . ' ' . $validated['break_start']);
                $breakEnd = Carbon::parse($validated['date'] . ' ' . $validated['break_end']);
                $breakMinutes = $breakEnd->diffInMinutes($breakStart);
                $validated['break_duration'] = $breakMinutes;
                $validated['total_hours'] = $totalMinutes - $breakMinutes;
            } else {
                $validated['total_hours'] = $totalMinutes;
            }
        }

        Attendance::updateOrCreate(
            [
                'employee_id' => $validated['employee_id'],
                'date' => $validated['date'],
            ],
            $validated
        );

        return redirect()->back()->with('success', 'Attendance recorded successfully.');
    }

    /**
     * Update the specified attendance record.
     */
    public function update(Request $request, string $id)
    {
        $attendance = Attendance::findOrFail($id);

        $validated = $request->validate([
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
            'break_start' => 'nullable|date_format:H:i',
            'break_end' => 'nullable|date_format:H:i',
            'status' => 'required|in:present,absent,half_day,late,on_leave',
            'notes' => 'nullable|string',
        ]);

        // Calculate total hours and break duration
        if ($validated['check_in'] && $validated['check_out']) {
            // Parse times - they come as H:i format from form, add :00 for seconds
            $checkIn = Carbon::parse($attendance->date->format('Y-m-d') . ' ' . $validated['check_in'] . ':00');
            $checkOut = Carbon::parse($attendance->date->format('Y-m-d') . ' ' . $validated['check_out'] . ':00');
            
            // Handle case where check_out might be next day (e.g., night shift)
            if ($checkOut->lt($checkIn)) {
                $checkOut->addDay();
            }
            
            $totalMinutes = $checkOut->diffInMinutes($checkIn);

            if ($validated['break_start'] && $validated['break_end']) {
                $breakStart = Carbon::parse($attendance->date->format('Y-m-d') . ' ' . $validated['break_start'] . ':00');
                $breakEnd = Carbon::parse($attendance->date->format('Y-m-d') . ' ' . $validated['break_end'] . ':00');
                
                // Handle case where break_end might be next day
                if ($breakEnd->lt($breakStart)) {
                    $breakEnd->addDay();
                }
                
                $breakMinutes = $breakEnd->diffInMinutes($breakStart);
                $validated['break_duration'] = $breakMinutes;
                $validated['total_hours'] = $totalMinutes - $breakMinutes;
            } else {
                $validated['total_hours'] = $totalMinutes;
            }
        }
        
        // Convert time inputs to H:i:s format for storage
        if (isset($validated['check_in']) && $validated['check_in']) {
            $validated['check_in'] = $validated['check_in'] . ':00';
        }
        if (isset($validated['check_out']) && $validated['check_out']) {
            $validated['check_out'] = $validated['check_out'] . ':00';
        }
        if (isset($validated['break_start']) && $validated['break_start']) {
            $validated['break_start'] = $validated['break_start'] . ':00';
        }
        if (isset($validated['break_end']) && $validated['break_end']) {
            $validated['break_end'] = $validated['break_end'] . ':00';
        }

        $attendance->update($validated);

        return redirect()->back()->with('success', 'Attendance updated successfully.');
    }

    /**
     * Check in for today.
     */
    public function checkIn()
    {
        $today = Carbon::today();
        
        $attendance = Attendance::firstOrCreate(
            [
                'employee_id' => auth()->id(),
                'date' => $today,
            ],
            [
                'status' => 'present',
            ]
        );

        if ($attendance->check_in) {
            return redirect()->back()->with('error', 'You have already checked in today.');
        }

        $attendance->update([
            'check_in' => Carbon::now()->format('H:i:s'),
            'status' => 'present',
        ]);

        return redirect()->back()->with('success', 'Checked in successfully.');
    }

    /**
     * Check out for today.
     */
    public function checkOut()
    {
        $today = Carbon::today();
        
        $attendance = Attendance::where('employee_id', auth()->id())
            ->where('date', $today)
            ->first();

        if (!$attendance) {
            return redirect()->back()->with('error', 'Please check in first.');
        }

        if ($attendance->check_out) {
            return redirect()->back()->with('error', 'You have already checked out today.');
        }

        $checkOutTime = Carbon::now();
        
        // check_in is stored as time (H:i:s), combine with date for calculation
        $checkInTime = Carbon::parse($attendance->date->format('Y-m-d') . ' ' . $attendance->check_in);
        $totalMinutes = $checkOutTime->diffInMinutes($checkInTime);

        // Subtract break duration if exists
        if ($attendance->break_duration) {
            $totalMinutes -= $attendance->break_duration;
        }

        $attendance->update([
            'check_out' => $checkOutTime->format('H:i:s'),
            'total_hours' => $totalMinutes,
        ]);

        return redirect()->back()->with('success', 'Checked out successfully.');
    }
}

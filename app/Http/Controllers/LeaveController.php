<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    /**
     * Display leave list (Admin view).
     */
    public function index(Request $request)
    {
        $query = Leave::with(['employee', 'leaveType', 'approver']);

        // Filter by employee
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by leave type
        if ($request->filled('leave_type_id')) {
            $query->where('leave_type_id', $request->leave_type_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('from_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('to_date', '<=', $request->date_to);
        }

        $leaves = $query->orderBy('created_at', 'desc')->get();
        $employees = User::orderBy('name')->get();
        $leaveTypes = LeaveType::where('is_active', true)->orderBy('name')->get();

        return view('pages.leaves.index', compact('leaves', 'employees', 'leaveTypes'));
    }

    /**
     * Display leave list (Employee view).
     */
    public function employeeIndex(Request $request)
    {
        $query = Leave::with(['leaveType', 'approver'])
            ->where('employee_id', auth()->id());

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $leaves = $query->orderBy('created_at', 'desc')->get();
        $leaveTypes = LeaveType::where('is_active', true)->orderBy('name')->get();

        return view('pages.leaves.employee', compact('leaves', 'leaveTypes'));
    }

    /**
     * Show the form for creating a new leave request.
     */
    public function create()
    {
        $leaveTypes = LeaveType::where('is_active', true)->orderBy('name')->get();

        return view('pages.leaves.create', compact('leaveTypes'));
    }

    /**
     * Store a newly created leave request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'from_date' => 'required|date|after_or_equal:today',
            'to_date' => 'required|date|after_or_equal:from_date',
            'reason' => 'required|string|max:1000',
        ]);

        $fromDate = Carbon::parse($validated['from_date']);
        $toDate = Carbon::parse($validated['to_date']);
        $days = $fromDate->diffInDays($toDate) + 1; // Include both start and end dates

        // Check available leave balance
        $leaveType = LeaveType::findOrFail($validated['leave_type_id']);
        $usedLeaves = Leave::where('employee_id', auth()->id())
            ->where('leave_type_id', $validated['leave_type_id'])
            ->where('status', 'approved')
            ->whereYear('from_date', Carbon::now()->year)
            ->sum('days');

        $availableDays = $leaveType->days_per_year - $usedLeaves;

        if ($days > $availableDays) {
            return redirect()->back()->with('error', "You only have {$availableDays} days available for this leave type.");
        }

        Leave::create([
            'employee_id' => auth()->id(),
            'leave_type_id' => $validated['leave_type_id'],
            'from_date' => $validated['from_date'],
            'to_date' => $validated['to_date'],
            'days' => $days,
            'reason' => $validated['reason'],
            'status' => $leaveType->requires_approval ? 'pending' : 'approved',
        ]);

        return redirect()->route('leaves.employee')->with('success', 'Leave request submitted successfully.');
    }

    /**
     * Approve a leave request.
     */
    public function approve(Request $request, string $id)
    {
        $leave = Leave::findOrFail($id);

        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $leave->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => Carbon::now(),
            'admin_notes' => $validated['admin_notes'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Leave request approved successfully.');
    }

    /**
     * Reject a leave request.
     */
    public function reject(Request $request, string $id)
    {
        $leave = Leave::findOrFail($id);

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:1000',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $leave->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => Carbon::now(),
            'rejection_reason' => $validated['rejection_reason'],
            'admin_notes' => $validated['admin_notes'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Leave request rejected.');
    }

    /**
     * Cancel a leave request.
     */
    public function cancel(string $id)
    {
        $leave = Leave::findOrFail($id);

        if ($leave->employee_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        if ($leave->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending leave requests can be cancelled.');
        }

        $leave->update([
            'status' => 'cancelled',
        ]);

        return redirect()->back()->with('success', 'Leave request cancelled successfully.');
    }

    /**
     * Display leave settings (Leave Types management).
     */
    public function settings()
    {
        $leaveTypes = LeaveType::orderBy('name')->get();

        return view('pages.leaves.settings', compact('leaveTypes'));
    }
}

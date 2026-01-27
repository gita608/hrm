<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use App\Models\Leave;
use App\Models\JobPosting;
use App\Models\Candidate;
use App\Models\Department;
use App\Models\Training;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();

        $totalEmployees = User::count();
        $todayAttendance = Attendance::whereDate('date', $today)->count();
        $monthlyAttendance = Attendance::whereBetween('date', [$monthStart, $monthEnd])->count();
        $attendancePercentage = $totalEmployees > 0 ? round(($todayAttendance / $totalEmployees) * 100) : 0;

        $attendanceStats = [
            'present' => Attendance::whereDate('date', $today)->where('status', 'present')->count(),
            'late' => Attendance::whereDate('date', $today)->where('status', 'late')->count(),
            'absent' => Attendance::whereDate('date', $today)->where('status', 'absent')->count(),
            'on_leave' => Attendance::whereDate('date', $today)->where('status', 'on_leave')->count(),
        ];

        $totalAttendanceCount = array_sum($attendanceStats);
        $attendancePercentages = [
            'present' => $totalAttendanceCount > 0 ? round(($attendanceStats['present'] / $totalAttendanceCount) * 100) : 0,
            'late' => $totalAttendanceCount > 0 ? round(($attendanceStats['late'] / $totalAttendanceCount) * 100) : 0,
            'absent' => $totalAttendanceCount > 0 ? round(($attendanceStats['absent'] / $totalAttendanceCount) * 100) : 0,
            'on_leave' => $totalAttendanceCount > 0 ? round(($attendanceStats['on_leave'] / $totalAttendanceCount) * 100) : 0,
        ];

        $recentClockIns = Attendance::with('employee')
            ->whereDate('date', $today)
            ->whereNotNull('check_in')
            ->orderBy('check_in', 'desc')
            ->limit(5)
            ->get();

        $pendingLeaves = Leave::where('status', 'pending')->count();
        $totalLeaves = Leave::whereMonth('created_at', Carbon::now()->month)->count();
        $approvedLeaves = Leave::where('status', 'approved')->whereMonth('created_at', Carbon::now()->month)->count();
        $leaveProgress = $totalLeaves > 0 ? round(($approvedLeaves / $totalLeaves) * 100) : 0;

        $activeJobs = JobPosting::where('status', 'open')->count();
        $totalCandidates = Candidate::count();
        $shortlistedCandidates = Candidate::where('status', 'shortlisted')->count();
        $hiredCandidates = Candidate::where('status', 'hired')->whereMonth('created_at', Carbon::now()->month)->count();

        $totalDepartments = Department::where('is_active', true)->count();
        $newHires = User::whereMonth('created_at', Carbon::now()->month)->count();

        $upcomingTrainings = Training::where('status', 'scheduled')
            ->whereDate('start_date', '>=', $today)
            ->whereDate('start_date', '<=', Carbon::now()->addDays(7))
            ->count();

        return view('pages.dashboard', compact(
            'totalEmployees',
            'todayAttendance',
            'monthlyAttendance',
            'attendancePercentage',
            'attendanceStats',
            'attendancePercentages',
            'recentClockIns',
            'pendingLeaves',
            'totalLeaves',
            'approvedLeaves',
            'leaveProgress',
            'activeJobs',
            'totalCandidates',
            'shortlistedCandidates',
            'hiredCandidates',
            'totalDepartments',
            'newHires',
            'upcomingTrainings'
        ));
    }
}
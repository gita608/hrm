<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get current date and month start/end
        $today = Carbon::today();
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();

        // Get attendance statistics
        $totalEmployees = User::count();
        $todayAttendance = Attendance::whereDate('date', $today)->count();
        $monthlyAttendance = Attendance::whereBetween('date', [$monthStart, $monthEnd])->count();
        $attendancePercentage = $totalEmployees > 0 ? round(($todayAttendance / $totalEmployees) * 100) : 0;

        // Get attendance status breakdown
        $attendanceStats = [
            'present' => Attendance::whereDate('date', $today)->where('status', 'present')->count(),
            'late' => Attendance::whereDate('date', $today)->where('status', 'late')->count(),
            'absent' => Attendance::whereDate('date', $today)->where('status', 'absent')->count(),
            'on_leave' => Attendance::whereDate('date', $today)->where('status', 'on_leave')->count(),
        ];

        // Calculate attendance percentages
        $totalAttendanceCount = array_sum($attendanceStats);
        $attendancePercentages = [
            'present' => $totalAttendanceCount > 0 ? round(($attendanceStats['present'] / $totalAttendanceCount) * 100) : 0,
            'late' => $totalAttendanceCount > 0 ? round(($attendanceStats['late'] / $totalAttendanceCount) * 100) : 0,
            'absent' => $totalAttendanceCount > 0 ? round(($attendanceStats['absent'] / $totalAttendanceCount) * 100) : 0,
            'on_leave' => $totalAttendanceCount > 0 ? round(($attendanceStats['on_leave'] / $totalAttendanceCount) * 100) : 0,
        ];

        // Get recent clock-ins
        $recentClockIns = Attendance::with('employee')
            ->whereDate('date', $today)
            ->whereNotNull('check_in')
            ->orderBy('check_in', 'desc')
            ->limit(5)
            ->get();

        return view('pages.dashboard', compact(
            'totalEmployees',
            'todayAttendance',
            'monthlyAttendance',
            'attendancePercentage',
            'attendanceStats',
            'attendancePercentages',
            'recentClockIns'
        ));
    }
}
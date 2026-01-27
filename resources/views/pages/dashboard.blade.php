@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<style>
    .dash-header-card {
        background: linear-gradient(135deg, #f26522 0%, #ff8c52 100%);
        border-radius: 24px;
        padding: 40px;
        border: none;
        position: relative;
        overflow: hidden;
        margin-bottom: 30px;
        box-shadow: 0 20px 40px rgba(242, 101, 34, 0.15);
    }

    .dash-header-card::before {
        content: "";
        position: absolute;
        top: -50px;
        right: -50px;
        width: 250px;
        height: 250px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .dash-header-card::after {
        content: "";
        position: absolute;
        bottom: -30px;
        left: 20%;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 24px;
        border: 1px solid #f1f1f1;
        height: 100%;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border-color: rgba(242, 101, 34, 0.2);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 20px;
    }

    .chart-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #f1f1f1;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        padding: 25px;
        height: 100%;
    }

    .recent-activity-item {
        padding: 15px;
        border-radius: 16px;
        transition: all 0.2s;
        border: 1px solid transparent;
        margin-bottom: 10px;
    }

    .recent-activity-item:hover {
        background: #fcfcfc;
        border-color: #f1f1f1;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }

    .progress-compact {
        height: 6px;
        border-radius: 3px;
        background: #f1f1f1;
    }

    .progress-compact .progress-bar {
        border-radius: 3px;
    }

    .welcome-avatar {
        width: 85px;
        height: 85px;
        border-radius: 24px;
        border: 4px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
</style>

<!-- Welcome Section -->
<div class="dash-header-card">
    <div class="row align-items-center g-4">
        <div class="col-auto">
            <img src="{{ asset('assets/img/profiles/avatar-31.jpg') }}" class="welcome-avatar" alt="User">
        </div>
        <div class="col text-white">
            <h5 class="opacity-75 fw-medium mb-1">Welcome back,</h5>
            <h2 class="fw-bold mb-2">{{ Auth::user()->name }} 👋</h2>
            <p class="mb-0 opacity-80 fs-15 lh-base">
                Your HRM system is running smoothly. There are <span class="fw-bold text-white">{{ $pendingApprovals ?? 0 }}</span> pending 
                approvals and <span class="fw-bold text-white">{{ $leaveRequests ?? 0 }}</span> active leave requests today.
            </p>
        </div>
        <div class="col-lg-auto text-end">
            <a href="{{ route('profile.index') }}" class="btn btn-white bg-white text-primary rounded-pill px-4 fw-bold shadow-sm">
                View My Profile
            </a>
        </div>
    </div>
</div>

<!-- Quick Stats Row -->
<div class="row g-4 mb-4">
    <!-- Attendance -->
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="stat-icon bg-primary-transparent text-primary">
                        <i class="ti ti-calendar-check"></i>
                    </div>
                    <h5 class="text-muted fs-14 fw-semibold mb-1">Daily Attendance</h5>
                    <h3 class="fw-bold mb-0">{{ $todayAttendance }} <span class="fs-13 text-muted fw-normal">/ {{ $totalEmployees }}</span></h3>
                </div>
                <div class="text-end">
                    <span class="badge bg-success-transparent text-success rounded-pill px-2 py-1 fs-11">
                        <i class="ti ti-trending-up"></i> {{ $attendancePercentage }}%
                    </span>
                </div>
            </div>
            <div class="mt-4">
                <div class="progress progress-compact mb-2">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $attendancePercentage }}%"></div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fs-12 text-muted">Current status</span>
                    <a href="{{ route('attendance.admin') }}" class="text-primary fs-12 fw-bold text-decoration-none">View Report</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaves -->
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="stat-icon bg-success-transparent text-success">
                        <i class="ti ti-plane-departure"></i>
                    </div>
                    <h5 class="text-muted fs-14 fw-semibold mb-1">Leave Requests</h5>
                    <h3 class="fw-bold mb-0">{{ $pendingLeaves }} <span class="fs-13 text-muted fw-normal">Pending</span></h3>
                </div>
                <div class="text-end">
                    <span class="badge bg-info-transparent text-info rounded-pill px-2 py-1 fs-11">
                        {{ $totalLeaves }} Total
                    </span>
                </div>
            </div>
            <div class="mt-4">
                <div class="progress progress-compact mb-2">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $leaveProgress }}%"></div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fs-12 text-muted">Approval rate</span>
                    <a href="{{ route('leaves.index') }}" class="text-success fs-12 fw-bold text-decoration-none">Review</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Jobs -->
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="stat-icon bg-warning-transparent text-warning">
                        <i class="ti ti-briefcase"></i>
                    </div>
                    <h5 class="text-muted fs-14 fw-semibold mb-1">Open Positions</h5>
                    <h3 class="fw-bold mb-0">{{ $activeJobs }}</h3>
                </div>
                <div class="text-end text-warning">
                    <i class="ti ti-circle-filled fs-10"></i> Active
                </div>
            </div>
            <div class="mt-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="avatar-group no-margin">
                        @for($i=0; $i<min(4, $totalCandidates); $i++)
                        <div class="avatar avatar-xs avatar-group-item rounded-circle bg-light border-0">
                            <i class="ti ti-user fs-10 text-muted"></i>
                        </div>
                        @endfor
                        @if($totalCandidates > 4)
                        <div class="avatar avatar-xs avatar-group-item rounded-circle bg-primary-transparent text-primary fs-10 fw-bold">+{{ $totalCandidates - 4 }}</div>
                        @endif
                    </div>
                    <span class="fs-12 text-muted">Recent Applicants</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fs-12 text-muted">Hiring pulse</span>
                    <a href="{{ route('jobs.index') }}" class="text-warning fs-12 fw-bold text-decoration-none">Recruitment</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Departments -->
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="stat-icon bg-info-transparent text-info">
                        <i class="ti ti-building-community"></i>
                    </div>
                    <h5 class="text-muted fs-14 fw-semibold mb-1">Active Hires</h5>
                    <h3 class="fw-bold mb-0">{{ $newHires }}</h3>
                </div>
                <div class="text-end">
                    <span class="badge bg-secondary-transparent text-secondary rounded-pill px-2 py-1 fs-11">
                        {{ $totalDepartments }} Depts
                    </span>
                </div>
            </div>
            <div class="mt-4">
                <div class="progress progress-compact mb-2">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 100%"></div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fs-12 text-muted">Structure health</span>
                    <a href="{{ route('employees.index') }}" class="text-info fs-12 fw-bold text-decoration-none">Network</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Attendance Overview -->
    <div class="col-xl-7">
        <div class="chart-card">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h5 class="fw-bold text-dark mb-0">Attendance Analytics</h5>
                <div class="dropdown">
                    <button class="btn btn-soft-light btn-sm rounded-pill px-3" data-bs-toggle="dropdown">
                        This Week <i class="ti ti-chevron-down ms-1"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                        <a class="dropdown-item" href="#">Today</a>
                        <a class="dropdown-item" href="#">This Week</a>
                        <a class="dropdown-item" href="#">This Month</a>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-6 position-relative">
                    <div style="height: 250px;">
                        <canvas id="attendance"></canvas>
                    </div>
                    <div class="position-absolute translate-middle text-center" style="top: 50%; left: 50%;">
                        <p class="fs-12 text-muted mb-0">TOTAL</p>
                        <h3 class="fw-black mb-0">{{ $todayAttendance }}</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-column gap-3 mt-3 mt-md-0">
                        @php
                            $stats = [
                                ['label' => 'Present', 'key' => 'present', 'color' => '#03C95A', 'total' => $todayAttendance],
                                ['label' => 'Late', 'key' => 'late', 'color' => '#0C4B5E', 'total' => $todayAttendance],
                                ['label' => 'On Leave', 'key' => 'on_leave', 'color' => '#FFC107', 'total' => $todayAttendance],
                                ['label' => 'Absent', 'key' => 'absent', 'color' => '#E70D0D', 'total' => $todayAttendance]
                            ];
                        @endphp
                        @foreach($stats as $stat)
                        <div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fs-13 text-muted"><i class="status-dot" style="background: {{ $stat['color'] }}"></i>{{ $stat['label'] }}</span>
                                <span class="fs-13 fw-bold">{{ $attendanceStats[$stat['key']] }}</span>
                            </div>
                            <div class="progress progress-compact">
                                <div class="progress-bar" style="background: {{ $stat['color'] }}; width: {{ $stat['total'] > 0 ? ($attendanceStats[$stat['key']] / $stat['total']) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Clock-ins -->
    <div class="col-xl-5">
        <div class="chart-card">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h5 class="fw-bold text-dark mb-0">Real-time Check-ins</h5>
                <a href="{{ route('attendance.admin') }}" class="btn btn-link text-primary fs-13 fw-bold p-0 text-decoration-none">View Matrix</a>
            </div>
            <div class="scrollable-content" style="max-height: 280px; overflow-y: auto;">
                @forelse($recentClockIns as $attendance)
                <div class="recent-activity-item d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md border-0 bg-soft-primary text-primary rounded-pill fw-bold fs-12">
                            {{ strtoupper(substr($attendance->employee->name, 0, 2)) }}
                        </div>
                        <div class="ms-3">
                            <h6 class="fs-13 fw-bold mb-0 text-dark">{{ $attendance->employee->name }}</h6>
                            <p class="fs-11 text-muted mb-0">{{ $attendance->employee->designation ?? 'Team Member' }}</p>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="fs-13 fw-bold text-dark mb-0">{{ date('h:i A', strtotime($attendance->check_in)) }}</div>
                        <span class="badge bg-{{ $attendance->status == 'late' ? 'warning' : 'success' }}-transparent text-{{ $attendance->status == 'late' ? 'warning' : 'success' }} fs-10 p-1">
                            {{ ucfirst($attendance->status) }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <i class="ti ti-clock-pause fs-40 text-muted opacity-25 mb-3 d-block"></i>
                    <p class="text-muted fs-13">Waiting for daily entries...</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Department Distribution -->
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0 fw-bold text-dark">Staff Distribution Overview</h5>
                    <p class="text-muted mb-0 fs-12">Breakdown of employees across different departments</p>
                </div>
                <span class="badge bg-primary-transparent text-primary rounded-pill px-3 py-2 border-0">
                    <i class="ti ti-chart-dots me-1"></i> Live Metric
                </span>
            </div>
            <div class="card-body pt-0">
                <div id="emp-department-chart" style="min-height: 350px;"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Attendance Chart
if($('#attendance').length > 0) {
    var ctx = document.getElementById('attendance').getContext('2d');
    var attendanceChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Present', 'Late', 'On Leave', 'Absent'],
            datasets: [{
                data: [
                    {{ $attendanceStats['present'] }},
                    {{ $attendanceStats['late'] }},
                    {{ $attendanceStats['on_leave'] }},
                    {{ $attendanceStats['absent'] }}
                ],
                backgroundColor: ['#03C95A', '#0C4B5E', '#FFC107', '#E70D0D'],
                borderWidth: 0,
                cutout: '75%',   
                borderRadius: 20
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            interaction: {
                mode: 'index',
                intersect: false,
            }
        }
    });
}

// Department Chart (Using ApexCharts as per system default)
if($('#emp-department-chart').length > 0) {
    var options = {
        series: [{
            name: 'Employees',
            data: [
                @foreach($departmentStats ?? [] as $stat)
                    {{ $stat->count }},
                @endforeach
                @if(empty($departmentStats)) 12, 18, 5, 8, 14, 20, 10 @endif
            ]
        }],
        chart: {
            height: 350,
            type: 'bar',
            toolbar: { show: false }
        },
        plotOptions: {
            bar: {
                borderRadius: 10,
                columnWidth: '40%',
                distributed: true,
            }
        },
        dataLabels: { enabled: false },
        colors: ['#f26522', '#667eea', '#03C95A', '#FFC107', '#0C4B5E', '#E70D0D', '#03C95A'],
        legend: { show: false },
        xaxis: {
            categories: [
                @foreach($departmentStats ?? [] as $stat)
                    '{{ $stat->name }}',
                @endforeach
                @if(empty($departmentStats)) 'UI/UX', 'Dev', 'Manag', 'HR', 'Test', 'Mark', 'Support' @endif
            ],
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        grid: {
            borderColor: '#f1f1f1',
            strokeDashArray: 4,
            yaxis: { lines: { show: true } }
        }
    };

    var chart = new ApexCharts(document.querySelector("#emp-department-chart"), options);
    chart.render();
}
</script>
@endpush

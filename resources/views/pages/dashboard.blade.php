@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<!-- Breadcrumb -->
<!-- Breadcrumb -->
<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
	<div class="my-auto">
		<h2 class="mb-1 text-dark fw-bold">Dashboard</h2>
		<p class="text-muted mb-0 fs-13">Welcome to your admin control panel</p>
	</div>
	<div class="d-flex align-items-center gap-2">
		<div class="bg-white p-2 rounded-3 shadow-sm text-center">
			<span class="d-block text-muted fs-11 text-uppercase fw-bold">Date</span>
			<span class="d-block text-dark fw-bold fs-13">{{ now()->format('M d, Y') }}</span>
		</div>
	</div>
</div>
<!-- /Breadcrumb -->
<!-- /Breadcrumb -->

<!-- Welcome Wrap -->
<!-- Welcome Wrap -->
<div class="card border-0 shadow-sm rounded-4 mb-4 position-relative overflow-hidden" 
     style="background: linear-gradient(120deg, #667eea 0%, #764ba2 100%);">
    <!-- Decorative Shapes -->
    <div class="position-absolute top-0 end-0 p-5 opacity-10">
        <i class="ti ti-award" style="font-size: 150px; color: white;"></i>
    </div>
    
	<div class="card-body p-4 position-relative">
		<div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
			<div class="d-flex align-items-center">
				<div class="avatar avatar-xxl flex-shrink-0 border border-3 border-white/20 rounded-circle shadow-sm">
					<img src="{{ asset('assets/img/profiles/avatar-31.jpg') }}" class="rounded-circle" alt="img">
				</div>
				<div class="ms-4 text-white">
					<span class="d-block text-white/80 fs-13 fw-medium mb-1">Good Morning,</span>
					<h2 class="mb-1 text-white fw-bold">{{ Auth::user()->name }} 👋</h2>
					<p class="mb-0 text-white/70 fs-14">
						Here's what's happening in your account today.
		                <a href="{{ route('profile.index') }}" class="text-white text-decoration-underline ms-1 opacity-75 hover-opacity-100">View Profile</a>
					</p>
				</div>
			</div>
			
			<div class="d-flex gap-3">
				<div class="bg-white bg-opacity-10 backdrop-blur-md rounded-3 p-3 text-center min-w-100">
					<h3 class="mb-0 text-white fw-bold">{{ $pendingApprovals ?? 0 }}</h3>
					<small class="text-white/80 fs-12">Approvals</small>
				</div>
				<div class="bg-white bg-opacity-10 backdrop-blur-md rounded-3 p-3 text-center min-w-100">
					<h3 class="mb-0 text-white fw-bold">{{ $leaveRequests ?? 0 }}</h3>
					<small class="text-white/80 fs-12">Leaves</small>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /Welcome Wrap -->
<!-- /Welcome Wrap -->

<div class="row">

	<!-- Widget Info -->
	<div class="col-xxl-8 d-flex">
		<div class="row flex-fill">
			<!-- Attendance Card -->
			<div class="col-md-6 col-lg-3 d-flex">
				<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden position-relative hover-lift">
					<div class="card-body">
						<div class="d-flex align-items-center justify-content-between mb-3">
							<div>
								<p class="fs-13 fw-medium text-muted mb-1">Attendance</p>
								<h3 class="fw-bold mb-0 text-dark">{{ $todayAttendance }} <span class="fs-13 text-muted fw-normal">/ {{ $totalEmployees }}</span></h3>
							</div>
							<div class="avatar avatar-md bg-primary-transparent rounded-3 border-0">
								<i class="ti ti-calendar-share fs-20 text-primary"></i>
							</div>
						</div>
						<div class="d-flex align-items-center mt-2">
							<span class="badge bg-{{ $attendancePercentage >= 70 ? 'success' : 'danger' }}-transparent text-{{ $attendancePercentage >= 70 ? 'success' : 'danger' }} rounded-pill border-0 px-2 py-1 fs-11 me-2">
								<i class="ti ti-trending-{{ $attendancePercentage >= 70 ? 'up' : 'down' }} me-1"></i>{{ $attendancePercentage }}%
							</span>
							<a href="{{ route('attendance.admin') }}" class="text-muted fs-12 stretched-link hover-text-primary">View Report</a>
						</div>
					</div>
					<div class="position-absolute bottom-0 start-0 w-100 bg-primary" style="height: 3px; opacity: 0.1;"></div>
				</div>
			</div>

			<!-- Leave Requests Card -->
			<div class="col-md-6 col-lg-3 d-flex">
				<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden position-relative hover-lift">
					<div class="card-body">
						<div class="d-flex align-items-center justify-content-between mb-3">
							<div>
								<p class="fs-13 fw-medium text-muted mb-1">Leaves</p>
								<h3 class="fw-bold mb-0 text-dark">{{ $pendingLeaves }} <span class="fs-13 text-muted fw-normal">/ {{ $totalLeaves }}</span></h3>
							</div>
							<div class="avatar avatar-md bg-success-transparent rounded-3 border-0">
								<i class="ti ti-calendar-time fs-20 text-success"></i>
							</div>
						</div>
						<div class="d-flex align-items-center mt-2">
							<span class="badge bg-{{ $leaveProgress >= 50 ? 'success' : 'warning' }}-transparent text-{{ $leaveProgress >= 50 ? 'success' : 'warning' }} rounded-pill border-0 px-2 py-1 fs-11 me-2">
								<i class="ti ti-chart-pie me-1"></i>{{ $leaveProgress }}%
							</span>
							<a href="{{ route('leaves.index') }}" class="text-muted fs-12 stretched-link hover-text-success">Details</a>
						</div>
					</div>
					<div class="position-absolute bottom-0 start-0 w-100 bg-success" style="height: 3px; opacity: 0.1;"></div>
				</div>
			</div>

			<!-- Active Jobs Card -->
			<div class="col-md-6 col-lg-3 d-flex">
				<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden position-relative hover-lift">
					<div class="card-body">
						<div class="d-flex align-items-center justify-content-between mb-3">
							<div>
								<p class="fs-13 fw-medium text-muted mb-1">Active Jobs</p>
								<h3 class="fw-bold mb-0 text-dark">{{ $activeJobs }}</h3>
							</div>
							<div class="avatar avatar-md bg-warning-transparent rounded-3 border-0">
								<i class="ti ti-briefcase fs-20 text-warning"></i>
							</div>
						</div>
						<div class="d-flex align-items-center mt-2">
							<span class="badge bg-info-transparent text-info rounded-pill border-0 px-2 py-1 fs-11 me-2">
								<i class="ti ti-users me-1"></i>{{ $totalCandidates }}
							</span>
							<a href="{{ route('jobs.index') }}" class="text-muted fs-12 stretched-link hover-text-warning">Candidates</a>
						</div>
					</div>
					<div class="position-absolute bottom-0 start-0 w-100 bg-warning" style="height: 3px; opacity: 0.1;"></div>
				</div>
			</div>

			<!-- New Hires Card -->
			<div class="col-md-6 col-lg-3 d-flex">
				<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden position-relative hover-lift">
					<div class="card-body">
						<div class="d-flex align-items-center justify-content-between mb-3">
							<div>
								<p class="fs-13 fw-medium text-muted mb-1">New Hires</p>
								<h3 class="fw-bold mb-0 text-dark">{{ $newHires }}</h3>
							</div>
							<div class="avatar avatar-md bg-info-transparent rounded-3 border-0">
								<i class="ti ti-users-group fs-20 text-info"></i>
							</div>
						</div>
						<div class="d-flex align-items-center mt-2">
							<span class="badge bg-success-transparent text-success rounded-pill border-0 px-2 py-1 fs-11 me-2">
								<i class="ti ti-building me-1"></i>{{ $totalDepartments }}
							</span>
							<a href="{{ route('employees.index') }}" class="text-muted fs-12 stretched-link hover-text-info">Departments</a>
						</div>
					</div>
					<div class="position-absolute bottom-0 start-0 w-100 bg-info" style="height: 3px; opacity: 0.1;"></div>
				</div>
			</div>

		</div>
	</div>
	<!-- /Widget Info -->

	<!-- Employees By Department -->
	<div class="col-xxl-4 d-flex">
		<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden align-self-stretch">
			<div class="card-header bg-transparent border-0 d-flex align-items-center justify-content-between pt-3 pb-2">
				<h5 class="mb-0 fw-bold text-dark">Department Distribution</h5>
				<span class="badge bg-primary-transparent text-primary rounded-pill">
					<i class="ti ti-trending-up me-1"></i>+20%
				</span>
			</div>
			<div class="card-body">
				<div id="emp-department"></div>
				<div class="mt-3 p-3 bg-light-50 rounded-3 border border-light">
					<p class="fs-13 mb-0 text-muted">
						<i class="ti ti-info-circle me-2 text-primary"></i>
						Employee count increased by <span class="text-success fw-bold">+20%</span> from last week
					</p>
				</div>
			</div>
		</div>
	</div>
	<!-- /Employees By Department -->

</div>

<div class="row">

	<!-- Attendance Overview -->
	<div class="col-xxl-6 col-xl-6 d-flex">
		<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
			<div class="card-header bg-transparent border-0 d-flex align-items-center justify-content-between pt-3 pb-2">
				<h5 class="mb-0 fw-bold text-dark">Attendance Overview</h5>
				<div class="dropdown">
					<button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
						This Week
					</button>
					<div class="dropdown-menu dropdown-menu-end">
						<a class="dropdown-item" href="#">Today</a>
						<a class="dropdown-item" href="#">This Week</a>
						<a class="dropdown-item" href="#">This Month</a>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="row align-items-center">
					<div class="col-md-6 text-center">
						<div class="chartjs-wrapper-demo position-relative mb-4 mb-md-0">
							<canvas id="attendance" height="200"></canvas>
							<div class="position-absolute text-center attendance-canvas" style="top: 50%; left: 50%; transform: translate(-50%, -40%);">
								<p class="fs-12 text-muted mb-0">Total</p>
								<h3 class="fw-bold text-dark">{{ $todayAttendance }}</h3>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<h6 class="mb-3 fw-bold text-dark">Status Breakdown</h6>
						<div class="d-flex align-items-center justify-content-between mb-3">
							<p class="fs-13 mb-0 text-muted"><i class="ti ti-circle-filled text-success fs-10 me-2"></i>Present</p>
							<p class="fs-13 fw-bold text-dark mb-0 ms-2">{{ $attendanceStats['present'] > 0 ? round(($attendanceStats['present'] / $todayAttendance) * 100) : 0 }}%</p>
						</div>
						<div class="d-flex align-items-center justify-content-between mb-3">
							<p class="fs-13 mb-0 text-muted"><i class="ti ti-circle-filled text-secondary fs-10 me-2"></i>Late</p>
							<p class="fs-13 fw-bold text-dark mb-0 ms-2">{{ $attendanceStats['late'] > 0 ? round(($attendanceStats['late'] / $todayAttendance) * 100) : 0 }}%</p>
						</div>
						<div class="d-flex align-items-center justify-content-between mb-3">
							<p class="fs-13 mb-0 text-muted"><i class="ti ti-circle-filled text-warning fs-10 me-2"></i>On Leave</p>
							<p class="fs-13 fw-bold text-dark mb-0 ms-2">{{ $attendanceStats['on_leave'] > 0 ? round(($attendanceStats['on_leave'] / $todayAttendance) * 100) : 0 }}%</p>
						</div>
						<div class="d-flex align-items-center justify-content-between">
							<p class="fs-13 mb-0 text-muted"><i class="ti ti-circle-filled text-danger fs-10 me-2"></i>Absent</p>
							<p class="fs-13 fw-bold text-dark mb-0 ms-2">{{ $attendanceStats['absent'] > 0 ? round(($attendanceStats['absent'] / $todayAttendance) * 100) : 0 }}%</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /Attendance Overview -->

	<!-- Clock-In/Out -->
	<div class="col-xxl-6 col-xl-6 d-flex">
		<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
			<div class="card-header bg-transparent border-0 d-flex align-items-center justify-content-between">
				<h5 class="mb-0 fw-bold text-dark">Recent Clock-In</h5>
				<a href="{{ route('attendance.admin') }}" class="btn btn-sm btn-light fs-12 fw-medium">View All</a>
			</div>
			<div class="card-body pt-0">
				<div class="d-flex align-items-center justify-content-between mb-3 mt-2">
					<span class="badge bg-success-transparent text-success rounded-pill">
						<i class="ti ti-calendar me-1"></i>Today, {{ now()->format('d M') }}
					</span>
					<span class="text-muted fs-12 fw-medium">{{ count($recentClockIns) }} Entries</span>
				</div>
				
				<div class="d-flex flex-column gap-2">
				@forelse($recentClockIns as $attendance)
					<div class="d-flex align-items-center justify-content-between p-3 rounded-3 border border-light bg-light-50 hover-bg-white transition-all">
						<div class="d-flex align-items-center">
							<div class="avatar flex-shrink-0 bg-primary-transparent text-primary rounded-circle fw-bold fs-12">
								{{ strtoupper(substr($attendance->employee->name, 0, 2)) }}
							</div>
							<div class="ms-3">
								<h6 class="fs-13 fw-bold mb-1 text-dark">{{ $attendance->employee->name }}</h6>
								<p class="fs-11 text-muted mb-0">{{ $attendance->employee->designation ?? 'Employee' }}</p>
							</div>
						</div>
						<div>
							<span class="badge bg-{{ $attendance->status == 'late' ? 'warning' : 'success' }}-transparent text-{{ $attendance->status == 'late' ? 'warning' : 'success' }} rounded-pill px-2">
								{{ substr($attendance->check_in, 0, 5) }}
							</span>
						</div>
					</div>
				@empty
					<div class="text-center p-5 bg-light-50 rounded-3 border border-dashed">
						<i class="ti ti-clock-off fs-24 text-muted mb-2"></i>
						<p class="text-muted mb-0 fs-13">No recent clock-ins today</p>
					</div>
				@endforelse
				</div>
			</div>
		</div>
	</div>
	<!-- /Clock-In/Out -->

</div>
@endsection

@push('scripts')
<script>
if($('#attendance').length > 0) {
    var ctx = document.getElementById('attendance').getContext('2d');
    var mySemiDonutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Present', 'Late', 'On Leave', 'Absent'],
            datasets: [{
                label: 'Attendance',
                data: [
                    {{ $attendanceStats['present'] }},
                    {{ $attendanceStats['late'] }},
                    {{ $attendanceStats['on_leave'] }},
                    {{ $attendanceStats['absent'] }}
                ],
                backgroundColor: ['#03C95A', '#0C4B5E', '#FFC107', '#E70D0D'],
                borderWidth: 5,
                borderRadius: 10,
                borderColor: '#fff',
                hoverBorderWidth: 0,
                cutout: '60%',   
            }]
        },
        options: {
            rotation: -100,
            circumference: 200,
            layout: {
                padding: {
                    top: -20,
                    bottom: -20,
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
}
</script>
@endpush

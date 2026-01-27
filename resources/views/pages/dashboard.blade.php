@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<!-- Breadcrumb -->
<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
	<div class="my-auto mb-2">
		<h2 class="mb-1">Admin Dashboard</h2>
	</div>
	<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
		<div class="ms-2 head-icons">
			<a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header">
				<i class="ti ti-chevrons-up"></i>
			</a>
		</div>
	</div>
</div>
<!-- /Breadcrumb -->

<!-- Welcome Wrap -->
<div class="card border-0">
	<div class="card-body d-flex align-items-center justify-content-between flex-wrap pb-1">
		<div class="d-flex align-items-center mb-3">
			<span class="avatar avatar-xl flex-shrink-0">
				<img src="{{ asset('assets/img/profiles/avatar-31.jpg') }}" class="rounded-circle" alt="img">
			</span>
			<div class="ms-3">
				<h3 class="mb-2">Welcome Back, {{ Auth::user()->name }} <a href="{{ route('profile.index') }}" class="edit-icon"><i class="ti ti-edit fs-14"></i></a></h3>
				<p>You have <span class="text-primary text-decoration-underline">{{ $pendingApprovals ?? 0 }}</span> Pending Approvals & <span class="text-primary text-decoration-underline">{{ $leaveRequests ?? 0 }}</span> Leave Requests</p>
		</div>
	</div>
	</div>
</div>
<!-- /Welcome Wrap -->

<div class="row">

	<!-- Widget Info -->
	<div class="col-xxl-8 d-flex">
		<div class="row flex-fill">
			<div class="col-md-3 d-flex">
				<div class="card flex-fill">
					<div class="card-body">
						<span class="avatar rounded-circle bg-primary mb-2">
							<i class="ti ti-calendar-share fs-16"></i>
						</span>
						<h6 class="fs-13 fw-medium text-default mb-1">Attendance Overview</h6>
						<h3 class="mb-3">{{ $todayAttendance }}/{{ $totalEmployees }} <span class="fs-12 fw-medium text-{{ $attendancePercentage >= 70 ? 'success' : 'danger' }}"><i class="fa-solid fa-caret-{{ $attendancePercentage >= 70 ? 'up' : 'down' }} me-1"></i>{{ $attendancePercentage }}%</span></h3>
						<a href="{{ route('attendance.admin') }}" class="link-default">View Details</a>
					</div>
				</div>
	</div>

	</div>
	</div>
	<!-- /Widget Info -->

	<!-- Employees By Department -->
	<div class="col-xxl-4 d-flex">
		<div class="card flex-fill">
			<div class="card-header pb-2">
				<h5 class="mb-2">Employees By Department</h5>
			</div>
			<div class="card-body">
				<div id="emp-department"></div>
				<p class="fs-13"><i class="ti ti-circle-filled me-2 fs-8 text-primary"></i>No of
					Employees increased by <span class="text-success fw-bold">+20%</span> from last Week
				</p>
			</div>
		</div>
	</div>
	<!-- /Employees By Department -->

</div>

<div class="row">

	<!-- Attendance Overview -->
	<div class="col-xxl-4 col-xl-6 d-flex">
		<div class="card flex-fill">
			<div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
				<h5 class="mb-2">Attendance Overview</h5>
				<div class="mb-2">
					<span class="btn btn-white border btn-sm d-inline-flex align-items-center">
						<i class="ti ti-calendar me-1"></i>Today
					</span>
				</div>
			</div>
			<div class="card-body">
				<div class="chartjs-wrapper-demo position-relative mb-4">
					<canvas id="attendance" height="200"></canvas>
					<div class="position-absolute text-center attendance-canvas">
						<p class="fs-13 mb-1">Total Attendance</p>
						<h3>{{ $todayAttendance }}</h3>
					</div>
				</div>
				<h6 class="mb-3">Status</h6>
				<div class="d-flex align-items-center justify-content-between">
					<p class="f-13 mb-2"><i class="ti ti-circle-filled text-success me-1"></i>Present</p>
					<p class="f-13 fw-medium text-gray-9 mb-2">{{ $attendanceStats['present'] > 0 ? round(($attendanceStats['present'] / $todayAttendance) * 100) : 0 }}%</p>
				</div>
				<div class="d-flex align-items-center justify-content-between">
					<p class="f-13 mb-2"><i class="ti ti-circle-filled text-secondary me-1"></i>Late</p>
					<p class="f-13 fw-medium text-gray-9 mb-2">{{ $attendanceStats['late'] > 0 ? round(($attendanceStats['late'] / $todayAttendance) * 100) : 0 }}%</p>
				</div>
				<div class="d-flex align-items-center justify-content-between">
					<p class="f-13 mb-2"><i class="ti ti-circle-filled text-warning me-1"></i>On Leave</p>
					<p class="f-13 fw-medium text-gray-9 mb-2">{{ $attendanceStats['on_leave'] > 0 ? round(($attendanceStats['on_leave'] / $todayAttendance) * 100) : 0 }}%</p>
				</div>
				<div class="d-flex align-items-center justify-content-between mb-2">
					<p class="f-13 mb-2"><i class="ti ti-circle-filled text-danger me-1"></i>Absent</p>
					<p class="f-13 fw-medium text-gray-9 mb-2">{{ $attendanceStats['absent'] > 0 ? round(($attendanceStats['absent'] / $todayAttendance) * 100) : 0 }}%</p>
				</div>
			</div>
		</div>
	</div>
	<!-- /Attendance Overview -->

	<!-- Clock-In/Out -->
	<div class="col-xxl-4 col-xl-6 d-flex">
		<div class="card flex-fill">
			<div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
				<h5 class="mb-2">Clock-In/Out</h5>
				<div class="d-flex align-items-center">
					<span class="btn btn-white border btn-sm d-inline-flex align-items-center">
						<i class="ti ti-calendar me-1"></i>Today
					</span>
				</div>
			</div>
			<div class="card-body">
				@forelse($recentClockIns as $attendance)
					<div class="d-flex align-items-center justify-content-between mb-3 p-2 border border-dashed br-5">
						<div class="d-flex align-items-center">
							<div class="avatar flex-shrink-0 bg-light">
								<span class="text-primary">{{ strtoupper(substr($attendance->employee->name, 0, 2)) }}</span>
							</div>
							<div class="ms-2">
								<h6 class="fs-14 fw-medium text-truncate">{{ $attendance->employee->name }}</h6>
								<p class="fs-13">{{ $attendance->employee->designation ?? 'Employee' }}</p>
							</div>
						</div>
						<div class="d-flex align-items-center">
							<span class="fs-10 fw-medium d-inline-flex align-items-center badge badge-{{ $attendance->status == 'late' ? 'warning' : 'success' }}">
								<i class="ti ti-circle-filled fs-5 me-1"></i>{{ substr($attendance->check_in, 0, 5) }}
							</span>
						</div>
					</div>
				@empty
					<div class="text-center p-3">
						<p class="text-muted mb-0">No recent clock-ins</p>
					</div>
				@endforelse
				<a href="{{ route('attendance.admin') }}" class="btn btn-light btn-md w-100">View All Attendance</a>
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

@extends('layouts.app')

@section('title', 'My Attendance')

@section('content')

	<!-- Page Header -->
	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">My Attendance</h2>
			<p class="text-muted mb-0 fs-13">View your daily attendance and logs</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			@php
				$today = \Carbon\Carbon::today();
				$todayAttendance = \App\Models\Attendance::where('employee_id', auth()->id())
					->where('date', $today)
					->first();
			@endphp
			@if(!$todayAttendance || !$todayAttendance->check_in)
				<form action="{{ route('attendance.checkin') }}" method="POST" class="d-inline">
					@csrf
					<button type="submit" class="btn btn-success rounded-pill shadow-sm py-2 px-3">
						<i class="ti ti-login me-2"></i>Check In
					</button>
				</form>
			@endif
			@if($todayAttendance && $todayAttendance->check_in && !$todayAttendance->check_out)
				<form action="{{ route('attendance.checkout') }}" method="POST" class="d-inline">
					@csrf
					<button type="submit" class="btn btn-danger rounded-pill shadow-sm py-2 px-3">
						<i class="ti ti-logout me-2"></i>Check Out
					</button>
				</form>
			@endif
		</div>
	</div>
	<!-- /Page Header -->

	@if(session('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			{{ session('success') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	@if(session('error'))
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			{{ session('error') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2 d-flex align-items-center justify-content-between flex-wrap row-gap-3">
			<h5 class="mb-0 fw-bold text-dark">Attendance History</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('attendance.employee') }}" class="d-flex align-items-center gap-2 flex-wrap">
					<div>
						<input type="date" name="date_from" class="form-control form-control-sm rounded-pill fs-12 border-light-subtle shadow-none" value="{{ request('date_from') }}" placeholder="From Date" onchange="this.form.submit()">
					</div>
					<div>
						<input type="date" name="date_to" class="form-control form-control-sm rounded-pill fs-12 border-light-subtle shadow-none" value="{{ request('date_to') }}" placeholder="To Date" onchange="this.form.submit()">
					</div>
					@if(request()->hasAny(['date_from', 'date_to']))
						<a href="{{ route('attendance.employee') }}" class="btn btn-sm btn-light rounded-pill px-3 shadow-sm border-0">Clear</a>
					@endif
				</form>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="bg-light-50">
						<tr>
							<th class="ps-3 border-0 text-muted fs-12 fw-medium text-uppercase">#</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Date</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Check In</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Check Out</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Total Hours</th>
							<th class="pe-3 border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
						</tr>
					</thead>
					<tbody>
						@forelse($attendances as $attendance)
							<tr class="border-bottom border-light">
								<td class="ps-3 text-muted fs-12">{{ $loop->iteration }}</td>
								<td class="text-dark fw-bold fs-13">{{ $attendance->date->format('d M Y') }}</td>
								<td class="text-muted fs-13">{{ $attendance->check_in ? substr($attendance->check_in, 0, 5) : '-' }}</td>
								<td class="text-muted fs-13">{{ $attendance->check_out ? substr($attendance->check_out, 0, 5) : '-' }}</td>
								<td>
									@if($attendance->total_hours)
										<span class="badge bg-light text-dark border rounded-pill">{{ floor($attendance->total_hours / 60) }}h {{ $attendance->total_hours % 60 }}m</span>
									@else
										<span class="text-muted">-</span>
									@endif
								</td>
								<td class="pe-3">
									@if($attendance->status == 'present')
										<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-circle-check-filled me-1 fs-10"></i>{{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
										</span>
									@elseif($attendance->status == 'absent')
										<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-circle-x-filled me-1 fs-10"></i>{{ ucfirst($attendance->status) }}
										</span>
									@elseif($attendance->status == 'late')
										<span class="badge bg-warning-transparent text-warning rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-clock-exclamation me-1 fs-10"></i>{{ ucfirst($attendance->status) }}
										</span>
									@else
										<span class="badge bg-info-transparent text-info rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-info-circle-filled me-1 fs-10"></i>{{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
										</span>
									@endif
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="6" class="text-center py-5">
									<div class="d-flex flex-column align-items-center">
										<div class="avatar avatar-xxl bg-light-50 rounded-circle mb-3 text-muted">
											<i class="ti ti-clock-off fs-30"></i>
										</div>
										<h6 class="text-muted mb-0">No attendance records found</h6>
									</div>
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

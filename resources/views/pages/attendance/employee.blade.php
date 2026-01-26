@extends('layouts.app')

@section('title', 'My Attendance')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">My Attendance</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				@php
					$today = \Carbon\Carbon::today();
					$todayAttendance = \App\Models\Attendance::where('employee_id', auth()->id())
						->where('date', $today)
						->first();
				@endphp
				@if(!$todayAttendance || !$todayAttendance->check_in)
					<form action="{{ route('attendance.checkin') }}" method="POST" class="d-inline">
						@csrf
						<button type="submit" class="btn btn-success">
							<i class="ti ti-login me-2"></i>Check In
						</button>
					</form>
				@endif
				@if($todayAttendance && $todayAttendance->check_in && !$todayAttendance->check_out)
					<form action="{{ route('attendance.checkout') }}" method="POST" class="d-inline">
						@csrf
						<button type="submit" class="btn btn-danger">
							<i class="ti ti-logout me-2"></i>Check Out
						</button>
					</form>
				@endif
			</div>
			<div class="head-icons ms-2">
				<a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header">
					<i class="ti ti-chevrons-up"></i>
				</a>
			</div>
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

	<div class="card">
		<div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
			<h5>Attendance History</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('attendance.employee') }}" class="d-flex gap-2 flex-wrap">
					<div>
						<input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}" placeholder="From Date" onchange="this.form.submit()">
					</div>
					<div>
						<input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}" placeholder="To Date" onchange="this.form.submit()">
					</div>
					@if(request()->hasAny(['date_from', 'date_to']))
						<a href="{{ route('attendance.employee') }}" class="btn btn-sm btn-outline-light border">Clear Filters</a>
					@endif
				</form>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="custom-datatable-filter table-responsive">
				<table class="table datatable">
					<thead class="thead-light">
						<tr>
							<th>#</th>
							<th>Date</th>
							<th>Check In</th>
							<th>Check Out</th>
							<th>Total Hours</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						@forelse($attendances as $attendance)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $attendance->date->format('d M Y') }}</td>
								<td>{{ $attendance->check_in ? substr($attendance->check_in, 0, 5) : '-' }}</td>
								<td>{{ $attendance->check_out ? substr($attendance->check_out, 0, 5) : '-' }}</td>
								<td>
									@if($attendance->total_hours)
										{{ floor($attendance->total_hours / 60) }}h {{ $attendance->total_hours % 60 }}m
									@else
										-
									@endif
								</td>
								<td>
									@if($attendance->status == 'present')
										<span class="badge badge-success">{{ ucfirst(str_replace('_', ' ', $attendance->status)) }}</span>
									@elseif($attendance->status == 'absent')
										<span class="badge badge-danger">{{ ucfirst($attendance->status) }}</span>
									@elseif($attendance->status == 'late')
										<span class="badge badge-warning">{{ ucfirst($attendance->status) }}</span>
									@else
										<span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $attendance->status)) }}</span>
									@endif
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="6" class="text-center">No attendance records found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

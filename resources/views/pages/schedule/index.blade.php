@extends('layouts.app')

@section('title', 'Shift & Schedule')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Shift & Schedule</h2>
			<p class="text-muted mb-0 fs-13">Manage employee shifts and work schedules</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('shift-types.index') }}" class="btn btn-outline-primary rounded-pill shadow-sm py-2">
				<i class="ti ti-settings me-1"></i>Shift Types
			</a>
			<a href="{{ route('schedule.create') }}" class="btn btn-primary rounded-pill shadow-sm py-2">
				<i class="ti ti-plus me-1"></i>Add Schedule
			</a>
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

	<div class="row">
		<!-- Total Scheduled -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden position-relative">
				<div class="card-body d-flex align-items-center justify-content-between p-4">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-xl bg-primary-transparent text-primary rounded-circle shadow-sm"><i class="ti ti-calendar-event fs-24"></i></span>
						</div>
						<div class="ms-3 overflow-hidden">
							<p class="fs-13 fw-medium mb-1 text-muted text-truncate text-uppercase ls-1">Total</p>
							<h4 class="mb-0 fw-bold text-dark">{{ $schedules->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Total Scheduled -->

		<!-- Completed -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden position-relative">
				<div class="card-body d-flex align-items-center justify-content-between p-4">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-xl bg-success-transparent text-success rounded-circle shadow-sm"><i class="ti ti-check fs-24"></i></span>
						</div>
						<div class="ms-3 overflow-hidden">
							<p class="fs-13 fw-medium mb-1 text-muted text-truncate text-uppercase ls-1">Completed</p>
							<h4 class="mb-0 fw-bold text-dark">{{ $schedules->where('status', 'completed')->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Completed -->

		<!-- Cancelled -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden position-relative">
				<div class="card-body d-flex align-items-center justify-content-between p-4">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-xl bg-danger-transparent text-danger rounded-circle shadow-sm"><i class="ti ti-x fs-24"></i></span>
						</div>
						<div class="ms-3 overflow-hidden">
							<p class="fs-13 fw-medium mb-1 text-muted text-truncate text-uppercase ls-1">Cancelled</p>
							<h4 class="mb-0 fw-bold text-dark">{{ $schedules->where('status', 'cancelled')->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Cancelled -->

		<!-- Absent -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden position-relative">
				<div class="card-body d-flex align-items-center justify-content-between p-4">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-xl bg-warning-transparent text-warning rounded-circle shadow-sm"><i class="ti ti-alert-triangle fs-24"></i></span>
						</div>
						<div class="ms-3 overflow-hidden">
							<p class="fs-13 fw-medium mb-1 text-muted text-truncate text-uppercase ls-1">Absent</p>
							<h4 class="mb-0 fw-bold text-dark">{{ $schedules->where('status', 'absent')->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Absent -->
	</div>

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2 d-flex align-items-center justify-content-between flex-wrap gap-3">
			<h5 class="mb-0 fw-bold text-dark">Schedule List</h5>
			<div class="d-flex gap-2 flex-wrap align-items-center">
				<form method="GET" action="{{ route('schedule.index') }}" class="d-flex gap-2 flex-wrap align-items-center">
					<div>
						<select name="employee_id" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" onchange="this.form.submit()">
							<option value="">All Employees</option>
							@foreach($employees as $employee)
								<option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<select name="shift_type_id" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" onchange="this.form.submit()">
							<option value="">All Shifts</option>
							@foreach($shiftTypes as $shiftType)
								<option value="{{ $shiftType->id }}" {{ request('shift_type_id') == $shiftType->id ? 'selected' : '' }}>{{ $shiftType->name }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<select name="status" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" onchange="this.form.submit()">
							<option value="">All Status</option>
							<option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
							<option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
							<option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
							<option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
						</select>
					</div>
					<div class="d-flex gap-2 align-items-center">
						<input type="date" name="date_from" class="form-control form-control-sm rounded-pill fs-12 border-light-subtle shadow-none px-3" value="{{ request('date_from') }}" onchange="this.form.submit()">
						<span class="text-muted fs-11">to</span>
						<input type="date" name="date_to" class="form-control form-control-sm rounded-pill fs-12 border-light-subtle shadow-none px-3" value="{{ request('date_to') }}" onchange="this.form.submit()">
					</div>
					@if(request()->hasAny(['employee_id', 'shift_type_id', 'status', 'date_from', 'date_to']))
						<a href="{{ route('schedule.index') }}" class="btn btn-sm btn-light rounded-pill px-3 shadow-none border-0">Clear</a>
					@endif
				</form>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="bg-light-50">
						<tr>
							<th class="ps-3 border-0 text-muted fs-12 fw-medium text-uppercase" style="width: 40px;">#</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Employee</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Schedule Date</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Shift Details</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Working Hours</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($schedules as $schedule)
							<tr class="border-bottom border-light">
								<td class="ps-3 text-muted fs-12">{{ $loop->iteration }}</td>
								<td>
									@if($schedule->employee)
										<div class="d-flex align-items-center">
											<div class="avatar avatar-md bg-primary-transparent text-primary rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold shadow-sm">
												{{ strtoupper(substr($schedule->employee->name, 0, 1)) }}
											</div>
											<div>
												<h6 class="mb-0 fs-14 fw-bold text-dark">{{ $schedule->employee->name }}</h6>
												<span class="fs-12 text-muted">{{ $schedule->employee->employee_id ?? 'EMP-ID' }}</span>
											</div>
										</div>
									@else
										<span class="text-muted">N/A</span>
									@endif
								</td>
								<td>
									<div class="d-flex flex-column">
										<span class="text-dark fw-bold fs-13">{{ $schedule->date->format('d M, Y') }}</span>
										<span class="text-muted fs-12">{{ $schedule->date->format('l') }}</span>
									</div>
								</td>
								<td>
									<span class="badge bg-light text-dark border border-light-subtle rounded-pill fw-medium px-3">
										<i class="ti ti-clock-hour-4 me-1 text-primary"></i>{{ $schedule->shiftType->name ?? 'Default Shift' }}
									</span>
								</td>
								<td class="text-dark fs-13">
									<div class="d-inline-flex align-items-center gap-1">
										<span class="fw-bold">{{ $schedule->start_time ? date('H:i', strtotime($schedule->start_time)) : '--:--' }}</span>
										<span class="text-muted">-</span>
										<span class="fw-bold">{{ $schedule->end_time ? date('H:i', strtotime($schedule->end_time)) : '--:--' }}</span>
									</div>
								</td>
								<td>
									@if($schedule->status == 'completed')
										<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-circle-check-filled me-1 fs-10"></i>Completed
										</span>
									@elseif($schedule->status == 'cancelled')
										<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-circle-x-filled me-1 fs-10"></i>Cancelled
										</span>
									@elseif($schedule->status == 'absent')
										<span class="badge bg-warning-transparent text-warning rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-alert-triangle-filled me-1 fs-10"></i>Absent
										</span>
									@else
										<span class="badge bg-primary-transparent text-primary rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-calendar-check me-1 fs-10"></i>Scheduled
										</span>
									@endif
								</td>
								<td class="pe-3 text-end">
									<div class="d-flex justify-content-end gap-2">
										<a href="{{ route('schedule.show', $schedule->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('schedule.edit', $schedule->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										<form action="{{ route('schedule.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this schedule?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-danger hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="7" class="text-center py-5">
									<div class="d-flex flex-column align-items-center justify-content-center">
										<div class="avatar avatar-xxl bg-light-50 rounded-circle mb-3 text-muted">
											<i class="ti ti-calendar-off fs-30"></i>
										</div>
										<p class="text-muted mb-0">No schedules found matches your criteria.</p>
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

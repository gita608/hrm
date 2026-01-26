@extends('layouts.app')

@section('title', 'Shift & Schedule')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Shift & Schedule</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<a href="{{ route('schedule.create') }}" class="btn btn-primary d-flex align-items-center me-2"><i class="ti ti-circle-plus me-2"></i>Add Schedule</a>
			</div>
			<div class="mb-2">
				<a href="{{ route('shift-types.index') }}" class="btn btn-outline-primary d-flex align-items-center"><i class="ti ti-settings me-2"></i>Manage Shift Types</a>
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
			<h5>Schedule List</h5>
			<div class="d-flex gap-2 flex-wrap">
				<form method="GET" action="{{ route('schedule.index') }}" class="d-flex gap-2">
					<select name="employee_id" class="form-select form-select-sm" style="width: auto;">
						<option value="">All Employees</option>
						@foreach($employees as $employee)
							<option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
						@endforeach
					</select>
					<select name="shift_type_id" class="form-select form-select-sm" style="width: auto;">
						<option value="">All Shift Types</option>
						@foreach($shiftTypes as $shiftType)
							<option value="{{ $shiftType->id }}" {{ request('shift_type_id') == $shiftType->id ? 'selected' : '' }}>{{ $shiftType->name }}</option>
						@endforeach
					</select>
					<select name="status" class="form-select form-select-sm" style="width: auto;">
						<option value="">All Status</option>
						<option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
						<option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
						<option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
						<option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
					</select>
					<input type="date" name="date_from" class="form-control form-control-sm" style="width: auto;" value="{{ request('date_from') }}" placeholder="From Date">
					<input type="date" name="date_to" class="form-control form-control-sm" style="width: auto;" value="{{ request('date_to') }}" placeholder="To Date">
					<button type="submit" class="btn btn-sm btn-outline-primary">Filter</button>
					@if(request()->hasAny(['employee_id', 'shift_type_id', 'status', 'date_from', 'date_to']))
						<a href="{{ route('schedule.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
					@endif
				</form>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="custom-datatable-filter table-responsive">
				<table class="table datatable">
					<thead class="thead-light">
						<tr>
							<th class="no-sort">
								<div class="form-check form-check-md">
									<input class="form-check-input" type="checkbox" id="select-all">
								</div>
							</th>
							<th>#</th>
							<th>Employee</th>
							<th>Date</th>
							<th>Shift Type</th>
							<th>Start Time</th>
							<th>End Time</th>
							<th>Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@forelse($schedules as $schedule)
							<tr>
								<td>
									<div class="form-check form-check-md">
										<input class="form-check-input" type="checkbox" value="{{ $schedule->id }}">
									</div>
								</td>
								<td>{{ $loop->iteration }}</td>
								<td>
									<h6 class="fw-medium"><a href="#">{{ $schedule->employee->name ?? 'N/A' }}</a></h6>
								</td>
								<td>{{ $schedule->date->format('d M Y') }}</td>
								<td>{{ $schedule->shiftType->name ?? 'N/A' }}</td>
								<td>{{ $schedule->start_time ? date('H:i', strtotime($schedule->start_time)) : 'N/A' }}</td>
								<td>{{ $schedule->end_time ? date('H:i', strtotime($schedule->end_time)) : 'N/A' }}</td>
								<td>
									@if($schedule->status == 'completed')
										<span class="badge badge-success d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Completed
										</span>
									@elseif($schedule->status == 'cancelled')
										<span class="badge badge-danger d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Cancelled
										</span>
									@elseif($schedule->status == 'absent')
										<span class="badge badge-warning d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Absent
										</span>
									@else
										<span class="badge badge-info d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Scheduled
										</span>
									@endif
								</td>
								<td>
									<div class="action-icon d-inline-flex">
										<a href="{{ route('schedule.show', $schedule->id) }}" class="me-2" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('schedule.edit', $schedule->id) }}" class="me-2" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										<form action="{{ route('schedule.destroy', $schedule->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this schedule?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-link p-0 text-danger" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="9" class="text-center">No schedules found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

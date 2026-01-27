@extends('layouts.app')

@section('title', 'Overtime')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Overtime Requests</h2>
			<p class="text-muted mb-0 fs-13">Manage employee overtime applications</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('overtime.create') }}" class="btn btn-primary rounded-pill shadow-sm py-2">
				<i class="ti ti-plus me-1"></i>Add Overtime
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

	<div class="row mb-4">
		<!-- Total Requests -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body p-4">
					<div class="d-flex align-items-center justify-content-between">
						<div>
							<p class="text-muted fw-medium mb-1 fs-13">Total Requests</p>
							<h3 class="mb-0 fw-bold text-dark">{{ $overtimes->count() }}</h3>
						</div>
						<div class="avatar avatar-lg bg-primary-transparent text-primary rounded-circle">
							<i class="ti ti-clock-hour-4 fs-24"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Total Requests -->

		<!-- Approved -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body p-4">
					<div class="d-flex align-items-center justify-content-between">
						<div>
							<p class="text-muted fw-medium mb-1 fs-13">Approved</p>
							<h3 class="mb-0 fw-bold text-dark">{{ $overtimes->where('status', 'approved')->count() }}</h3>
						</div>
						<div class="avatar avatar-lg bg-success-transparent text-success rounded-circle">
							<i class="ti ti-check fs-24"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Approved -->

		<!-- Pending -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body p-4">
					<div class="d-flex align-items-center justify-content-between">
						<div>
							<p class="text-muted fw-medium mb-1 fs-13">Pending</p>
							<h3 class="mb-0 fw-bold text-dark">{{ $overtimes->where('status', 'pending')->count() }}</h3>
						</div>
						<div class="avatar avatar-lg bg-warning-transparent text-warning rounded-circle">
							<i class="ti ti-clock-exclamation fs-24"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Pending -->

		<!-- Rejected -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body p-4">
					<div class="d-flex align-items-center justify-content-between">
						<div>
							<p class="text-muted fw-medium mb-1 fs-13">Rejected</p>
							<h3 class="mb-0 fw-bold text-dark">{{ $overtimes->where('status', 'rejected')->count() }}</h3>
						</div>
						<div class="avatar avatar-lg bg-danger-transparent text-danger rounded-circle">
							<i class="ti ti-x fs-24"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Rejected -->
	</div>

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-0 d-flex align-items-center justify-content-between pt-3 pb-2 flex-wrap row-gap-3">
			<h5 class="mb-0 fw-bold text-dark">Overtime List</h5>
			<div class="d-flex gap-2 flex-wrap">
				<form method="GET" action="{{ route('overtime.index') }}" class="d-flex gap-2 align-items-center">
					<select name="status" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" style="width: auto;">
						<option value="">All Status</option>
						<option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
						<option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
						<option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
					</select>
					<select name="employee_id" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" style="width: auto;">
						<option value="">All Employees</option>
						@foreach($employees as $employee)
							<option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
						@endforeach
					</select>
					<button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">Filter</button>
					@if(request()->hasAny(['status', 'employee_id', 'date_from', 'date_to']))
						<a href="{{ route('overtime.index') }}" class="btn btn-sm btn-light rounded-pill px-3">Clear</a>
					@endif
				</form>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="bg-light-50">
						<tr>
							<th class="ps-3 border-0 text-muted fs-12 fw-medium text-uppercase" style="width: 50px;">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="select-all">
								</div>
							</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">#</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Employee</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Date</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Start Time</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">End Time</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Hours</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Reason</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($overtimes as $overtime)
							<tr class="border-bottom border-light">
								<td class="ps-3">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="{{ $overtime->id }}">
									</div>
								</td>
								<td class="text-muted">{{ $loop->iteration }}</td>
								<td>
									@if($overtime->employee)
									<div class="d-flex align-items-center">
										<div class="avatar avatar-xs bg-primary-transparent text-primary rounded-circle me-2 fw-bold">
											{{ strtoupper(substr($overtime->employee->name, 0, 1)) }}
										</div>
										<span class="text-dark fw-bold">{{ $overtime->employee->name }}</span>
									</div>
									@else
										<span class="text-muted">N/A</span>
									@endif
								</td>
								<td class="text-dark">{{ $overtime->date->format('d M Y') }}</td>
								<td class="text-muted">{{ date('H:i', strtotime($overtime->start_time)) }}</td>
								<td class="text-muted">{{ date('H:i', strtotime($overtime->end_time)) }}</td>
								<td class="fw-bold text-dark">{{ number_format($overtime->hours, 2) }} hrs</td>
								<td>
									@if($overtime->status == 'approved')
										<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Approved
										</span>
									@elseif($overtime->status == 'rejected')
										<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Rejected
										</span>
									@else
										<span class="badge bg-warning-transparent text-warning rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Pending
										</span>
									@endif
								</td>
								<td class="text-muted fs-13">{{ Str::limit($overtime->reason ?? 'N/A', 30) }}</td>
								<td class="pe-3 text-end">
									<div class="d-flex justify-content-end gap-2">
										<a href="{{ route('overtime.show', $overtime->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all" data-bs-toggle="tooltip" title="View">
											<i class="ti ti-eye"></i>
										</a>
										<a href="{{ route('overtime.edit', $overtime->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-info hover-text-white transition-all" data-bs-toggle="tooltip" title="Edit">
											<i class="ti ti-edit"></i>
										</a>
										<form action="{{ route('overtime.destroy', $overtime->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this overtime request?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-danger hover-text-white transition-all" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="10" class="text-center py-5">
									<div class="d-flex flex-column align-items-center">
										<div class="avatar avatar-xxl bg-light-50 rounded-circle mb-3 text-muted">
											<i class="ti ti-clock-off fs-30"></i>
										</div>
										<h6 class="text-muted mb-0">No overtime requests found</h6>
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

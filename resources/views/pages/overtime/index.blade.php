@extends('layouts.app')

@section('title', 'Overtime')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Overtime</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<a href="{{ route('overtime.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Overtime</a>
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

	<div class="card">
		<div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
			<h5>Overtime List</h5>
			<div class="d-flex gap-2 flex-wrap">
				<form method="GET" action="{{ route('overtime.index') }}" class="d-flex gap-2">
					<select name="status" class="form-select form-select-sm" style="width: auto;">
						<option value="">All Status</option>
						<option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
						<option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
						<option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
					</select>
					<select name="employee_id" class="form-select form-select-sm" style="width: auto;">
						<option value="">All Employees</option>
						@foreach($employees as $employee)
							<option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
						@endforeach
					</select>
					<button type="submit" class="btn btn-sm btn-outline-primary">Filter</button>
					@if(request()->hasAny(['status', 'employee_id', 'date_from', 'date_to']))
						<a href="{{ route('overtime.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
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
							<th>Start Time</th>
							<th>End Time</th>
							<th>Hours</th>
							<th>Status</th>
							<th>Reason</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@forelse($overtimes as $overtime)
							<tr>
								<td>
									<div class="form-check form-check-md">
										<input class="form-check-input" type="checkbox" value="{{ $overtime->id }}">
									</div>
								</td>
								<td>{{ $loop->iteration }}</td>
								<td>
									<h6 class="fw-medium"><a href="#">{{ $overtime->employee->name ?? 'N/A' }}</a></h6>
								</td>
								<td>{{ $overtime->date->format('d M Y') }}</td>
								<td>{{ date('H:i', strtotime($overtime->start_time)) }}</td>
								<td>{{ date('H:i', strtotime($overtime->end_time)) }}</td>
								<td>{{ number_format($overtime->hours, 2) }} hrs</td>
								<td>
									@if($overtime->status == 'approved')
										<span class="badge badge-success d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Approved
										</span>
									@elseif($overtime->status == 'rejected')
										<span class="badge badge-danger d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Rejected
										</span>
									@else
										<span class="badge badge-warning d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Pending
										</span>
									@endif
								</td>
								<td>{{ Str::limit($overtime->reason ?? 'N/A', 30) }}</td>
								<td>
									<div class="action-icon d-inline-flex">
										<a href="{{ route('overtime.show', $overtime->id) }}" class="me-2" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('overtime.edit', $overtime->id) }}" class="me-2" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										<form action="{{ route('overtime.destroy', $overtime->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this overtime request?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-link p-0 text-danger" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="10" class="text-center">No overtime requests found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

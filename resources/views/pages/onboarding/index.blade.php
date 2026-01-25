@extends('layouts.app')

@section('title', 'Onboarding')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Onboarding</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<a href="{{ route('onboarding.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Onboarding</a>
			</div>
			<div class="head-icons ms-2">
				<a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header">
					<i class="ti ti-chevrons-up"></i>
				</a>
			</div>
		</div>
	</div>
	<!-- /Breadcrumb -->

	@if(session('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			{{ session('success') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	<div class="card">
		<div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
			<h5>Onboarding List</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('onboarding.index') }}" class="d-flex gap-2 flex-wrap">
					<div>
						<select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
							<option value="">All Status</option>
							<option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
							<option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
							<option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
							<option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
						</select>
					</div>
					<div>
						<select name="employee_id" class="form-select form-select-sm" onchange="this.form.submit()">
							<option value="">All Employees</option>
							@foreach($employees as $employee)
								<option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
							@endforeach
						</select>
					</div>
					@if(request()->hasAny(['status', 'employee_id']))
						<a href="{{ route('onboarding.index') }}" class="btn btn-sm btn-outline-light border">Clear Filters</a>
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
							<th>Employee</th>
							<th>Template</th>
							<th>Start Date</th>
							<th>Expected Completion</th>
							<th>Status</th>
							<th>Assigned To</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($onboardings as $onboarding)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>
									<div class="d-flex align-items-center">
										<div class="ms-2">
											<h6 class="fw-medium"><a href="{{ route('onboarding.show', $onboarding->id) }}">{{ $onboarding->employee->name ?? 'N/A' }}</a></h6>
											<span class="d-block mt-1">{{ $onboarding->employee->email ?? 'N/A' }}</span>
										</div>
									</div>
								</td>
								<td>{{ $onboarding->template->name ?? 'N/A' }}</td>
								<td>{{ $onboarding->start_date->format('d M Y') }}</td>
								<td>{{ $onboarding->expected_completion_date ? $onboarding->expected_completion_date->format('d M Y') : 'N/A' }}</td>
								<td>
									@if($onboarding->status == 'completed')
										<span class="badge badge-success d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Completed
										</span>
									@elseif($onboarding->status == 'cancelled')
										<span class="badge badge-danger d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Cancelled
										</span>
									@elseif($onboarding->status == 'in_progress')
										<span class="badge badge-info d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>In Progress
										</span>
									@else
										<span class="badge badge-warning d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Pending
										</span>
									@endif
								</td>
								<td>{{ $onboarding->assignedUser->name ?? 'N/A' }}</td>
								<td>
									<div class="action-icon d-inline-flex">
										<a href="{{ route('onboarding.show', $onboarding->id) }}" class="me-2" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('onboarding.edit', $onboarding->id) }}" class="me-2" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										<form action="{{ route('onboarding.destroy', $onboarding->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this onboarding?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-link p-0 text-danger" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="8" class="text-center">No onboarding records found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

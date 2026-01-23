@extends('layouts.app')

@section('title', 'Jobs')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Jobs</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<a href="{{ route('jobs.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Job</a>
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
			<h5>Jobs List</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('jobs.index') }}" class="d-flex gap-2 flex-wrap">
					<div>
						<select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
							<option value="">All Status</option>
							<option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
							<option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
							<option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
							<option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
						</select>
					</div>
					<div>
						<select name="department_id" class="form-select form-select-sm" onchange="this.form.submit()">
							<option value="">All Departments</option>
							@foreach($departments as $department)
								<option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
							@endforeach
						</select>
					</div>
					@if(request()->hasAny(['status', 'department_id', 'job_type']))
						<a href="{{ route('jobs.index') }}" class="btn btn-sm btn-outline-light border">Clear Filters</a>
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
							<th>Job Code</th>
							<th>Title</th>
							<th>Department</th>
							<th>Positions</th>
							<th>Start Date</th>
							<th>Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@forelse($jobPostings as $job)
							<tr>
								<td>
									<div class="form-check form-check-md">
										<input class="form-check-input" type="checkbox" value="{{ $job->id }}">
									</div>
								</td>
								<td>{{ $job->job_code ?? 'N/A' }}</td>
								<td>
									<h6 class="fw-medium"><a href="#">{{ $job->title }}</a></h6>
								</td>
								<td>{{ $job->department->name ?? 'N/A' }}</td>
								<td>{{ $job->no_of_positions }}</td>
								<td>{{ $job->start_date->format('d M Y') }}</td>
								<td>
									@if($job->status == 'open')
										<span class="badge badge-success d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Open
										</span>
									@elseif($job->status == 'closed')
										<span class="badge badge-danger d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Closed
										</span>
									@elseif($job->status == 'cancelled')
										<span class="badge badge-warning d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Cancelled
										</span>
									@else
										<span class="badge badge-info d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Draft
										</span>
									@endif
								</td>
								<td>
									<div class="action-icon d-inline-flex">
										<a href="{{ route('jobs.show', $job->id) }}" class="me-2" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('jobs.edit', $job->id) }}" class="me-2" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										<form action="{{ route('jobs.destroy', $job->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this job?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-link p-0 text-danger" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="8" class="text-center">No jobs found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

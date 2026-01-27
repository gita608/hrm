@extends('layouts.app')

@section('title', 'Jobs')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Jobs</h2>
			<p class="text-muted mb-0 fs-13">Manage job postings and recruitment</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('jobs.create') }}" class="btn btn-primary rounded-pill shadow-sm py-2 px-3">
				<i class="ti ti-plus me-2"></i>Add Job
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

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2 d-flex align-items-center justify-content-between flex-wrap row-gap-3">
			<h5 class="mb-0 fw-bold text-dark">Jobs List</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('jobs.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
					<div>
						<select name="status" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" onchange="this.form.submit()">
							<option value="">All Status</option>
							<option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
							<option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
							<option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
							<option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
						</select>
					</div>
					<div>
						<select name="department_id" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" onchange="this.form.submit()">
							<option value="">All Departments</option>
							@foreach($departments as $department)
								<option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
							@endforeach
						</select>
					</div>
					@if(request()->hasAny(['status', 'department_id', 'job_type']))
						<a href="{{ route('jobs.index') }}" class="btn btn-sm btn-light rounded-pill px-3">Clear</a>
					@endif
				</form>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="bg-light-50">
						<tr>
							<th class="ps-3 border-0 text-muted fs-12 fw-medium text-uppercase">
								<div class="form-check">
									<input class="form-check-input shadow-none" type="checkbox" id="select-all">
								</div>
							</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">#</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Job Code</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Title</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Department</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Positions</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Start Date</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($jobPostings as $job)
							<tr class="border-bottom border-light">
								<td class="ps-3">
									<div class="form-check">
										<input class="form-check-input shadow-none" type="checkbox" value="{{ $job->id }}">
									</div>
								</td>
								<td class="text-muted">{{ $loop->iteration }}</td>
								<td class="text-muted fw-medium">{{ $job->job_code ?? 'N/A' }}</td>
								<td>
									<h6 class="mb-0 fw-bold"><a href="{{ route('jobs.show', $job->id) }}" class="text-dark text-decoration-none hover-text-primary transition-all">{{ $job->title }}</a></h6>
								</td>
								<td class="text-muted">{{ $job->department->name ?? 'N/A' }}</td>
								<td class="text-muted">{{ $job->no_of_positions }}</td>
								<td class="text-muted">{{ $job->start_date->format('d M Y') }}</td>
								<td>
									@if($job->status == 'open')
										<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Open
										</span>
									@elseif($job->status == 'closed')
										<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Closed
										</span>
									@elseif($job->status == 'cancelled')
										<span class="badge bg-warning-transparent text-warning rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Cancelled
										</span>
									@else
										<span class="badge bg-info-transparent text-info rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Draft
										</span>
									@endif
								</td>
								<td class="pe-3 text-end">
									<div class="d-flex justify-content-end gap-2">
										<a href="{{ route('jobs.show', $job->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										<form action="{{ route('jobs.destroy', $job->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this job?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-danger hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="9" class="text-center py-5">
									<div class="d-flex flex-column align-items-center">
										<div class="avatar avatar-xxl bg-light-50 rounded-circle mb-3 text-muted">
											<i class="ti ti-briefcase-off fs-30"></i>
										</div>
										<h6 class="text-muted mb-0">No jobs found</h6>
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

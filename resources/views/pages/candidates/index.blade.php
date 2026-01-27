@extends('layouts.app')

@section('title', 'Candidates')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Candidates</h2>
			<p class="text-muted mb-0 fs-13">Manage job applications and candidate pipeline</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('candidates.create') }}" class="btn btn-primary rounded-pill shadow-sm py-2 px-3">
				<i class="ti ti-plus me-2"></i>Add Candidate
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
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2 d-flex align-items-center justify-content-between flex-wrap gap-3">
			<h5 class="mb-0 fw-bold text-dark">Candidates List</h5>
			<div class="d-flex align-items-center gap-2 flex-wrap">
				<form method="GET" action="{{ route('candidates.index') }}" class="d-flex gap-2 flex-wrap align-items-center">
					<div>
						<select name="status" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" onchange="this.form.submit()">
							<option value="">All Status</option>
							<option value="app_received" {{ request('status') == 'app_received' ? 'selected' : '' }}>App Received</option>
							<option value="screening" {{ request('status') == 'screening' ? 'selected' : '' }}>Screening</option>
							<option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
							<option value="interviewed" {{ request('status') == 'interviewed' ? 'selected' : '' }}>Interviewed</option>
							<option value="shortlisted" {{ request('status') == 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
							<option value="hired" {{ request('status') == 'hired' ? 'selected' : '' }}>Hired</option>
							<option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
						</select>
					</div>
					<div>
						<select name="job_posting_id" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" onchange="this.form.submit()">
							<option value="">All Jobs</option>
							@foreach($jobPostings as $job)
								<option value="{{ $job->id }}" {{ request('job_posting_id') == $job->id ? 'selected' : '' }}>{{ $job->title }}</option>
							@endforeach
						</select>
					</div>
					@if(request()->hasAny(['status', 'job_posting_id', 'applied_role']))
						<a href="{{ route('candidates.index') }}" class="btn btn-sm btn-light rounded-pill px-3 shadow-none">Clear Filters</a>
					@endif
				</form>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="bg-light-50">
						<tr>
							<th class="ps-3" style="width: 50px;">
								<div class="form-check">
									<input class="form-check-input shadow-none" type="checkbox" id="select-all">
								</div>
							</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">#</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Cand ID</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Candidate</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Applied Role</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Phone</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Applied Date</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($candidates as $candidate)
							<tr class="border-bottom border-light">
								<td class="ps-3">
									<div class="form-check">
										<input class="form-check-input shadow-none" type="checkbox" value="{{ $candidate->id }}">
									</div>
								</td>
								<td class="text-muted fs-12">{{ $loop->iteration }}</td>
								<td class="text-muted fw-medium fs-12">{{ $candidate->candidate_code ?? 'Cand-' . str_pad($candidate->id, 3, '0', STR_PAD_LEFT) }}</td>
								<td>
									<div class="d-flex align-items-center">
										<div class="avatar avatar-md bg-primary-transparent text-primary rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold shadow-sm">
											{{ substr($candidate->first_name, 0, 1) }}{{ substr($candidate->last_name, 0, 1) }}
										</div>
										<div>
											<h6 class="mb-0 fw-bold"><a href="{{ route('candidates.show', $candidate->id) }}" class="text-dark text-decoration-none hover-text-primary transition-all">{{ $candidate->first_name }} {{ $candidate->last_name }}</a></h6>
											<span class="fs-11 text-muted">{{ $candidate->email }}</span>
										</div>
									</div>
								</td>
								<td class="text-dark fs-13">{{ $candidate->applied_role ?? ($candidate->jobPosting->title ?? 'N/A') }}</td>
								<td class="text-muted fs-12">{{ $candidate->phone ?? 'N/A' }}</td>
								<td class="text-muted fs-12 fw-medium">{{ $candidate->applied_date->format('d M Y') }}</td>
								<td>
									@if($candidate->status == 'hired')
										<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Hired
										</span>
									@elseif($candidate->status == 'rejected')
										<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Rejected
										</span>
									@elseif($candidate->status == 'interviewed')
										<span class="badge bg-info-transparent text-info rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Interviewed
										</span>
									@elseif($candidate->status == 'scheduled')
										<span class="badge bg-warning-transparent text-warning rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Scheduled
										</span>
									@else
										<span class="badge bg-light-transparent text-dark border rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>{{ ucfirst(str_replace('_', ' ', $candidate->status)) }}
										</span>
									@endif
								</td>
								<td class="pe-3 text-end">
									<div class="d-flex justify-content-end gap-2">
										<a href="{{ route('candidates.show', $candidate->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="View">
											<i class="ti ti-eye"></i>
										</a>
										<a href="{{ route('candidates.edit', $candidate->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="Edit">
											<i class="ti ti-edit"></i>
										</a>
										<form action="{{ route('candidates.destroy', $candidate->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this candidate?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-danger hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="Delete">
												<i class="ti ti-trash"></i>
											</button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="9" class="text-center py-5">
									<div class="d-flex flex-column align-items-center justify-content-center">
										<div class="avatar avatar-xxl bg-light-50 rounded-circle mb-3 text-muted">
											<i class="ti ti-users-off fs-30"></i>
										</div>
										<p class="text-muted mb-0">No candidates found matching your criteria.</p>
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

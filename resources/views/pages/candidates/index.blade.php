@extends('layouts.app')

@section('title', 'Candidates')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Candidates</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<a href="{{ route('candidates.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Candidate</a>
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
			<h5>Candidates List</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('candidates.index') }}" class="d-flex gap-2 flex-wrap">
					<div>
						<select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
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
						<select name="job_posting_id" class="form-select form-select-sm" onchange="this.form.submit()">
							<option value="">All Jobs</option>
							@foreach($jobPostings as $job)
								<option value="{{ $job->id }}" {{ request('job_posting_id') == $job->id ? 'selected' : '' }}>{{ $job->title }}</option>
							@endforeach
						</select>
					</div>
					@if(request()->hasAny(['status', 'job_posting_id', 'applied_role']))
						<a href="{{ route('candidates.index') }}" class="btn btn-sm btn-outline-light border">Clear Filters</a>
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
							<th>Cand ID</th>
							<th>Candidate</th>
							<th>Applied Role</th>
							<th>Phone</th>
							<th>Applied Date</th>
							<th>Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@forelse($candidates as $candidate)
							<tr>
								<td>
									<div class="form-check form-check-md">
										<input class="form-check-input" type="checkbox" value="{{ $candidate->id }}">
									</div>
								</td>
								<td>{{ $candidate->candidate_code ?? 'Cand-' . str_pad($candidate->id, 3, '0', STR_PAD_LEFT) }}</td>
								<td>
									<div class="d-flex align-items-center file-name-icon">
										<div class="ms-2">
											<h6 class="fw-medium"><a href="#">{{ $candidate->first_name }} {{ $candidate->last_name }}</a></h6>
											<span class="d-block mt-1">{{ $candidate->email }}</span>
										</div>
									</div>
								</td>
								<td>{{ $candidate->applied_role ?? ($candidate->jobPosting->title ?? 'N/A') }}</td>
								<td>{{ $candidate->phone ?? 'N/A' }}</td>
								<td>{{ $candidate->applied_date->format('d M Y') }}</td>
								<td>
									@if($candidate->status == 'hired')
										<span class="badge badge-success d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Hired
										</span>
									@elseif($candidate->status == 'rejected')
										<span class="badge badge-danger d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Rejected
										</span>
									@elseif($candidate->status == 'interviewed')
										<span class="badge badge-info d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Interviewed
										</span>
									@elseif($candidate->status == 'scheduled')
										<span class="badge badge-pink d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Scheduled
										</span>
									@else
										<span class="badge badge-purple d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>{{ ucfirst(str_replace('_', ' ', $candidate->status)) }}
										</span>
									@endif
								</td>
								<td>
									<div class="action-icon d-inline-flex">
										<a href="{{ route('candidates.show', $candidate->id) }}" class="me-2" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('candidates.edit', $candidate->id) }}" class="me-2" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										<form action="{{ route('candidates.destroy', $candidate->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this candidate?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-link p-0 text-danger" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="8" class="text-center">No candidates found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

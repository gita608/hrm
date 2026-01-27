@extends('layouts.app')

@section('title', 'Job Details')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Job Details</h2>
			<p class="text-muted mb-0 fs-13">View job posting information and candidates</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('jobs.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="row">
		<div class="col-md-8">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Job Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Job Code</div>
						<div class="col-md-8 text-dark fw-medium">{{ $jobPosting->job_code ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Title</div>
						<div class="col-md-8 text-dark fw-bold">{{ $jobPosting->title }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Department</div>
						<div class="col-md-8 text-dark">{{ $jobPosting->department->name ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Designation</div>
						<div class="col-md-8 text-dark">{{ $jobPosting->designation->name ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">No. of Positions</div>
						<div class="col-md-8 text-dark">{{ $jobPosting->no_of_positions }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Job Type</div>
						<div class="col-md-8 text-dark">{{ ucfirst(str_replace('_', ' ', $jobPosting->job_type)) }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Experience Level</div>
						<div class="col-md-8 text-dark">{{ $jobPosting->experience_level ? ucfirst($jobPosting->experience_level) : 'N/A' }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Start Date</div>
						<div class="col-md-8 text-dark">{{ $jobPosting->start_date->format('M d, Y') }}</div>
					</div>
					@if($jobPosting->end_date)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">End Date</div>
						<div class="col-md-8 text-dark">{{ $jobPosting->end_date->format('M d, Y') }}</div>
					</div>
					@endif
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Location</div>
						<div class="col-md-8 text-dark">{{ $jobPosting->location ?? 'N/A' }}</div>
					</div>
					@if($jobPosting->uae_emirate)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">UAE Location</div>
						<div class="col-md-8 text-dark">{{ $jobPosting->uae_emirate }}{{ $jobPosting->uae_city ? ', ' . $jobPosting->uae_city : '' }}</div>
					</div>
					@endif
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Visa Sponsorship</div>
						<div class="col-md-8">
							@if($jobPosting->visa_sponsorship)
								<span class="badge bg-success-transparent text-success rounded-pill px-3">Yes</span>
							@else
								<span class="badge bg-light-transparent text-muted border rounded-pill px-3">No</span>
							@endif
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Work Permit Required</div>
						<div class="col-md-8">
							@if($jobPosting->work_permit_required)
								<span class="badge bg-warning-transparent text-warning rounded-pill px-3">Yes</span>
							@else
								<span class="badge bg-light-transparent text-muted border rounded-pill px-3">No</span>
							@endif
						</div>
					</div>
					@if($jobPosting->salary_from || $jobPosting->salary_to)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Salary Range</div>
						<div class="col-md-8 text-dark fw-bold">
							@if($jobPosting->salary_from && $jobPosting->salary_to)
								${{ number_format($jobPosting->salary_from, 2) }} - ${{ number_format($jobPosting->salary_to, 2) }}
							@elseif($jobPosting->salary_from)
								From ${{ number_format($jobPosting->salary_from, 2) }}
							@elseif($jobPosting->salary_to)
								Up to ${{ number_format($jobPosting->salary_to, 2) }}
							@endif
						</div>
					</div>
					@endif
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Status</div>
						<div class="col-md-8">
							@if($jobPosting->status == 'open')
								<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
									<i class="ti ti-point-filled me-1 fs-10"></i>Open
								</span>
							@elseif($jobPosting->status == 'closed')
								<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
									<i class="ti ti-point-filled me-1 fs-10"></i>Closed
								</span>
							@elseif($jobPosting->status == 'cancelled')
								<span class="badge bg-warning-transparent text-warning rounded-pill d-inline-flex align-items-center px-2 py-1">
									<i class="ti ti-point-filled me-1 fs-10"></i>Cancelled
								</span>
							@else
								<span class="badge bg-info-transparent text-info rounded-pill d-inline-flex align-items-center px-2 py-1">
									<i class="ti ti-point-filled me-1 fs-10"></i>Draft
								</span>
							@endif
						</div>
					</div>
					@if($jobPosting->description)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Description</div>
						<div class="col-md-8 text-dark">{{ $jobPosting->description }}</div>
					</div>
					@endif
					@if($jobPosting->requirements)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Requirements</div>
						<div class="col-md-8 text-dark">{{ $jobPosting->requirements }}</div>
					</div>
					@endif
					@if($jobPosting->benefits)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Benefits</div>
						<div class="col-md-8 text-dark">{{ $jobPosting->benefits }}</div>
					</div>
					@endif
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Created At</div>
						<div class="col-md-8 text-muted">{{ $jobPosting->created_at->format('M d, Y H:i') }}</div>
					</div>
					<div class="row">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Updated At</div>
						<div class="col-md-8 text-muted">{{ $jobPosting->updated_at->format('M d, Y H:i') }}</div>
					</div>
				</div>
			</div>

			@if($jobPosting->candidates->count() > 0)
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mt-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Candidates ({{ $jobPosting->candidates->count() }})</h5>
				</div>
				<div class="card-body p-0">
					<div class="table-responsive">
						<table class="table table-hover align-middle mb-0">
							<thead class="bg-light-50">
								<tr>
									<th class="ps-3 border-0 text-muted fs-12 fw-medium text-uppercase">Name</th>
									<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Email</th>
									<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Applied Date</th>
									<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
									<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($jobPosting->candidates as $candidate)
									<tr class="border-bottom border-light">
										<td class="ps-3 text-dark fw-bold">{{ $candidate->first_name }} {{ $candidate->last_name }}</td>
										<td class="text-muted">{{ $candidate->email }}</td>
										<td class="text-muted">{{ $candidate->applied_date->format('M d, Y') }}</td>
										<td>
											@if($candidate->status == 'hired')
												<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
													<i class="ti ti-check me-1 fs-10"></i>{{ ucfirst(str_replace('_', ' ', $candidate->status)) }}
												</span>
											@elseif($candidate->status == 'rejected')
												<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
													<i class="ti ti-x me-1 fs-10"></i>{{ ucfirst($candidate->status) }}
												</span>
											@else
												<span class="badge bg-info-transparent text-info rounded-pill d-inline-flex align-items-center px-2 py-1">
													<i class="ti ti-info-circle me-1 fs-10"></i>{{ ucfirst(str_replace('_', ' ', $candidate->status)) }}
												</span>
											@endif
										</td>
										<td class="pe-3 text-end">
											<a href="{{ route('candidates.show', $candidate->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all shadow-sm" title="View Candidate">
												<i class="ti ti-eye"></i>
											</a>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			@endif
		</div>
		<div class="col-md-4">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body text-center p-4">
					<div class="avatar avatar-xxl mb-3 bg-primary-transparent rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
						<i class="ti ti-briefcase fs-36 text-primary"></i>
					</div>
					<h4 class="mb-1 text-dark fw-bold">{{ $jobPosting->title }}</h4>
					<p class="text-muted mb-4">{{ $jobPosting->department->name ?? 'N/A' }}</p>
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('jobs.edit', $jobPosting->id) }}" class="btn btn-primary rounded-pill shadow-sm py-2">
							<i class="ti ti-edit me-2"></i>Edit Job
						</a>
						<a href="{{ route('candidates.create', ['job_posting_id' => $jobPosting->id]) }}" class="btn btn-success rounded-pill shadow-sm py-2">
							<i class="ti ti-user-plus me-2"></i>Add Candidate
						</a>
						<form action="{{ route('jobs.destroy', $jobPosting->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger rounded-pill w-100 py-2">
								<i class="ti ti-trash me-2"></i>Delete Job
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

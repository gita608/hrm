@extends('layouts.app')

@section('title', 'Candidate Details')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Candidate Details</h2>
			<p class="text-muted mb-0 fs-13">View candidate profile and application details</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('candidates.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="row">
		<div class="col-md-8">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Candidate Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Candidate Code</div>
						<div class="col-md-8 text-dark fw-medium">{{ $candidate->candidate_code ?? 'Cand-' . str_pad($candidate->id, 3, '0', STR_PAD_LEFT) }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Name</div>
						<div class="col-md-8 text-dark fw-bold">{{ $candidate->first_name }} {{ $candidate->last_name }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Email</div>
						<div class="col-md-8 text-dark">{{ $candidate->email }}</div>
					</div>
					@if($candidate->phone)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Phone</div>
						<div class="col-md-8 text-dark">{{ $candidate->phone }}</div>
					</div>
					@endif
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Applied Role</div>
						<div class="col-md-8 text-dark">{{ $candidate->applied_role ?? ($candidate->jobPosting->title ?? 'N/A') }}</div>
					</div>
					@if($candidate->jobPosting)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Job Posting</div>
						<div class="col-md-8">
							<a href="{{ route('jobs.show', $candidate->jobPosting->id) }}" class="text-primary text-decoration-none hover-text-dark transition-all fw-medium">{{ $candidate->jobPosting->title }}</a>
						</div>
					</div>
					@endif
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Applied Date</div>
						<div class="col-md-8 text-dark">{{ $candidate->applied_date->format('M d, Y') }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Status</div>
						<div class="col-md-8">
							@if($candidate->status == 'hired')
								<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
									<i class="ti ti-check me-1 fs-10"></i>{{ ucfirst(str_replace('_', ' ', $candidate->status)) }}
								</span>
							@elseif($candidate->status == 'rejected')
								<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
									<i class="ti ti-x me-1 fs-10"></i>{{ ucfirst($candidate->status) }}
								</span>
							@elseif($candidate->status == 'interviewed')
								<span class="badge bg-info-transparent text-info rounded-pill d-inline-flex align-items-center px-2 py-1">
									<i class="ti ti-info-circle me-1 fs-10"></i>{{ ucfirst($candidate->status) }}
								</span>
							@elseif($candidate->status == 'scheduled')
								<span class="badge bg-warning-transparent text-warning rounded-pill d-inline-flex align-items-center px-2 py-1">
									<i class="ti ti-clock me-1 fs-10"></i>{{ ucfirst($candidate->status) }}
								</span>
							@else
								<span class="badge bg-light-transparent text-dark border rounded-pill d-inline-flex align-items-center px-2 py-1">
									<i class="ti ti-point-filled me-1 fs-10"></i>{{ ucfirst(str_replace('_', ' ', $candidate->status)) }}
								</span>
							@endif
						</div>
					</div>
					@if($candidate->resume_path)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Resume</div>
						<div class="col-md-8">
							<a href="{{ asset($candidate->resume_path) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-sm">
								<i class="ti ti-file-text me-1"></i>View Resume
							</a>
						</div>
					</div>
					@endif
					@if($candidate->cover_letter)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Cover Letter</div>
						<div class="col-md-8 text-dark">{{ $candidate->cover_letter }}</div>
					</div>
					@endif
					@if($candidate->experience_summary)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Experience Summary</div>
						<div class="col-md-8 text-dark">{{ $candidate->experience_summary }}</div>
					</div>
					@endif
					@if($candidate->education)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Education</div>
						<div class="col-md-8 text-dark">{{ $candidate->education }}</div>
					</div>
					@endif
					@if($candidate->skills)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Skills</div>
						<div class="col-md-8 text-dark">{{ $candidate->skills }}</div>
					</div>
					@endif
					@if($candidate->notes)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Notes</div>
						<div class="col-md-8 text-dark">{{ $candidate->notes }}</div>
					</div>
					@endif
					@if($candidate->emirates_id)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Emirates ID</div>
						<div class="col-md-8 text-dark">{{ $candidate->emirates_id }}</div>
					</div>
					@endif
					@if($candidate->passport_number)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Passport Number</div>
						<div class="col-md-8 text-dark">{{ $candidate->passport_number }}</div>
					</div>
					@endif
					@if($candidate->nationality)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Nationality</div>
						<div class="col-md-8 text-dark">{{ $candidate->nationality }}</div>
					</div>
					@endif
					@if($candidate->visa_status)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Visa Status</div>
						<div class="col-md-8">
							@if($candidate->visa_status == 'valid')
								<span class="badge bg-success-transparent text-success rounded-pill px-3">Valid</span>
							@elseif($candidate->visa_status == 'expired')
								<span class="badge bg-danger-transparent text-danger rounded-pill px-3">Expired</span>
							@elseif($candidate->visa_status == 'pending')
								<span class="badge bg-warning-transparent text-warning rounded-pill px-3">Pending</span>
							@else
								<span class="badge bg-info-transparent text-info rounded-pill px-3">Not Required</span>
							@endif
						</div>
					</div>
					@endif
					@if($candidate->current_location_emirate)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Current Location</div>
						<div class="col-md-8 text-dark">{{ $candidate->current_location_emirate }}{{ $candidate->current_location_city ? ', ' . $candidate->current_location_city : '' }}</div>
					</div>
					@endif
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Created At</div>
						<div class="col-md-8 text-muted">{{ $candidate->created_at->format('M d, Y H:i') }}</div>
					</div>
					<div class="row">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Updated At</div>
						<div class="col-md-8 text-muted">{{ $candidate->updated_at->format('M d, Y H:i') }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body text-center p-4">
					<div class="avatar avatar-xxl mb-3 bg-primary-transparent rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
						<i class="ti ti-user fs-36 text-primary"></i>
					</div>
					<h4 class="mb-1 text-dark fw-bold">{{ $candidate->first_name }} {{ $candidate->last_name }}</h4>
					<p class="text-muted mb-4">{{ $candidate->email }}</p>
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('candidates.edit', $candidate->id) }}" class="btn btn-primary rounded-pill shadow-sm py-2">
							<i class="ti ti-edit me-2"></i>Edit Candidate
						</a>
						@if($candidate->jobPosting)
							<a href="{{ route('jobs.show', $candidate->jobPosting->id) }}" class="btn btn-info rounded-pill shadow-sm py-2 text-white">
								<i class="ti ti-briefcase me-2"></i>View Job
							</a>
						@endif
						<form action="{{ route('candidates.destroy', $candidate->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this candidate?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger rounded-pill w-100 py-2">
								<i class="ti ti-trash me-2"></i>Delete Candidate
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

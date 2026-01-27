@extends('layouts.app')

@section('title', 'Referral Details')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Referral Details</h2>
			<p class="text-muted mb-0 fs-13">View referral information and candidate details</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('referrals.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="row">
		<div class="col-md-4 order-md-last">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-body text-center p-4">
					<div class="avatar avatar-xxl mb-3 bg-primary-transparent text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
						<span class="fs-36 fw-bold">{{ strtoupper(substr($referral->referred_first_name, 0, 1) . substr($referral->referred_last_name, 0, 1)) }}</span>
					</div>
					<h4 class="mb-1 text-dark fw-bold">{{ $referral->referred_first_name }} {{ $referral->referred_last_name }}</h4>
					<p class="text-muted mb-4 pt-1">{{ $referral->referred_email }}</p>

					@if($referral->status == 'hired')
						<span class="badge bg-success-transparent text-success rounded-pill px-3 py-2 mb-4">Hired</span>
					@elseif($referral->status == 'rejected')
						<span class="badge bg-danger-transparent text-danger rounded-pill px-3 py-2 mb-4">Rejected</span>
					@elseif($referral->status == 'interviewed')
						<span class="badge bg-info-transparent text-info rounded-pill px-3 py-2 mb-4">Interviewed</span>
					@elseif($referral->status == 'shortlisted')
						<span class="badge bg-warning-transparent text-warning rounded-pill px-3 py-2 mb-4">Shortlisted</span>
					@elseif($referral->status == 'contacted')
						<span class="badge bg-purple-transparent text-purple rounded-pill px-3 py-2 mb-4">Contacted</span>
					@else
						<span class="badge bg-light-transparent text-dark border rounded-pill px-3 py-2 mb-4">{{ ucfirst($referral->status) }}</span>
					@endif

					@if($referral->referrer)
					<div class="mb-4 pb-4 border-bottom border-light">
						<p class="mb-2 fs-12 text-uppercase text-muted fw-bold ls-1">Referred By</p>
						<div class="d-flex align-items-center justify-content-center gap-2">
							@if($referral->referrer->profile_picture)
								<img src="{{ asset('storage/' . $referral->referrer->profile_picture) }}" alt="{{ $referral->referrer->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
							@else
								<div class="avatar avatar-sm bg-light rounded-circle fw-bold d-flex align-items-center justify-content-center border text-dark" style="width: 32px; height: 32px; font-size: 12px;">
									{{ strtoupper(substr($referral->referrer->name, 0, 1)) }}
								</div>
							@endif
							<div class="text-start">
								<a href="{{ route('users.show', $referral->referrer->id) }}" class="text-dark fw-bold text-decoration-none d-block lh-1">{{ $referral->referrer->name }}</a>
								<small class="text-muted">{{ $referral->referrer->email }}</small>
							</div>
						</div>
					</div>
					@endif

					<div class="d-flex flex-column gap-2">
						<a href="{{ route('referrals.edit', $referral->id) }}" class="btn btn-primary rounded-pill shadow-sm py-2">
							<i class="ti ti-edit me-2"></i>Edit Referral
						</a>
						@if($referral->jobPosting)
							<a href="{{ route('jobs.show', $referral->jobPosting->id) }}" class="btn btn-light rounded-pill shadow-sm py-2 border">
								<i class="ti ti-briefcase me-2"></i>View Job
							</a>
						@endif
						<form action="{{ route('referrals.destroy', $referral->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this referral?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger rounded-pill w-100 py-2">
								<i class="ti ti-trash me-2"></i>Delete Referral
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Referral Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Referral Code</div>
						<div class="col-md-8 text-dark fw-medium">{{ $referral->referral_code ?? 'REF-' . str_pad($referral->id, 3, '0', STR_PAD_LEFT) }}</div>
					</div>
					@if($referral->jobPosting)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Job Posting</div>
						<div class="col-md-8">
							<a href="{{ route('jobs.show', $referral->jobPosting->id) }}" class="text-primary fw-medium text-decoration-none">{{ $referral->jobPosting->title }}</a>
						</div>
					</div>
					@endif
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Referral Date</div>
						<div class="col-md-8 text-dark">{{ $referral->referral_date->format('M d, Y') }}</div>
					</div>
					@if($referral->referral_bonus)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Referral Bonus</div>
						<div class="col-md-8">
							<span class="fw-bold text-dark me-2">{{ number_format($referral->referral_bonus, 2) }} AED</span>
							@if($referral->bonus_status)
								<span class="badge bg-light border text-muted px-2 py-0" style="width: fit-content; font-size: 10px;">
									{{ ucfirst($referral->bonus_status) }}
								</span>
							@endif
						</div>
					</div>
					@endif
					@if($referral->bonus_paid_date)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Bonus Paid Date</div>
						<div class="col-md-8 text-dark">{{ $referral->bonus_paid_date->format('M d, Y') }}</div>
					</div>
					@endif
					@if($referral->notes)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Notes</div>
						<div class="col-md-8 text-dark">{{ $referral->notes }}</div>
					</div>
					@endif
				</div>
			</div>

			<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Referred Person Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Name</div>
						<div class="col-md-8 text-dark fw-medium">{{ $referral->referred_first_name }} {{ $referral->referred_last_name }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Email</div>
						<div class="col-md-8 text-dark">{{ $referral->referred_email }}</div>
					</div>
					@if($referral->referred_phone)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Phone</div>
						<div class="col-md-8 text-dark">{{ $referral->referred_phone }}</div>
					</div>
					@endif
					@if($referral->referred_skills)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Skills</div>
						<div class="col-md-8 text-dark">{{ $referral->referred_skills }}</div>
					</div>
					@endif
					@if($referral->referred_experience)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Experience</div>
						<div class="col-md-8 text-dark">{{ $referral->referred_experience }}</div>
					</div>
					@endif
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Created At</div>
						<div class="col-md-8 text-muted">{{ $referral->created_at->format('M d, Y H:i') }}</div>
					</div>
					<div class="row">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Updated At</div>
						<div class="col-md-8 text-muted">{{ $referral->updated_at->format('M d, Y H:i') }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

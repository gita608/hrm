@extends('layouts.app')

@section('title', 'Referral Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Referral Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('referrals.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5>Referral Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-4"><strong>Referral Code:</strong></div>
						<div class="col-md-8">{{ $referral->referral_code ?? 'REF-' . str_pad($referral->id, 3, '0', STR_PAD_LEFT) }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Referrer:</strong></div>
						<div class="col-md-8">
							@if($referral->referrer)
								<a href="{{ route('users.show', $referral->referrer->id) }}">{{ $referral->referrer->name }}</a>
								<span class="text-muted">({{ $referral->referrer->email }})</span>
							@else
								<span class="text-muted">N/A</span>
							@endif
						</div>
					</div>
					@if($referral->jobPosting)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Job Posting:</strong></div>
						<div class="col-md-8">
							<a href="{{ route('jobs.show', $referral->jobPosting->id) }}">{{ $referral->jobPosting->title }}</a>
						</div>
					</div>
					@endif
					<div class="row mb-3">
						<div class="col-md-4"><strong>Referral Date:</strong></div>
						<div class="col-md-8">{{ $referral->referral_date->format('M d, Y') }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Status:</strong></div>
						<div class="col-md-8">
							@if($referral->status == 'hired')
								<span class="badge badge-success">{{ ucfirst($referral->status) }}</span>
							@elseif($referral->status == 'rejected')
								<span class="badge badge-danger">{{ ucfirst($referral->status) }}</span>
							@elseif($referral->status == 'interviewed')
								<span class="badge badge-info">{{ ucfirst($referral->status) }}</span>
							@elseif($referral->status == 'shortlisted')
								<span class="badge badge-warning">{{ ucfirst($referral->status) }}</span>
							@elseif($referral->status == 'contacted')
								<span class="badge badge-pink">{{ ucfirst($referral->status) }}</span>
							@else
								<span class="badge badge-purple">{{ ucfirst($referral->status) }}</span>
							@endif
						</div>
					</div>
					@if($referral->referral_bonus)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Referral Bonus:</strong></div>
						<div class="col-md-8">
							<span class="fw-medium">{{ number_format($referral->referral_bonus, 2) }} AED</span>
							@if($referral->bonus_status)
								<span class="badge badge-soft-{{ $referral->bonus_status == 'paid' ? 'success' : ($referral->bonus_status == 'approved' ? 'info' : 'warning') }} ms-2">
									{{ ucfirst($referral->bonus_status) }}
								</span>
							@endif
						</div>
					</div>
					@endif
					@if($referral->bonus_paid_date)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Bonus Paid Date:</strong></div>
						<div class="col-md-8">{{ $referral->bonus_paid_date->format('M d, Y') }}</div>
					</div>
					@endif
					@if($referral->notes)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Notes:</strong></div>
						<div class="col-md-8">{{ $referral->notes }}</div>
					</div>
					@endif
				</div>
			</div>

			<div class="card mt-3">
				<div class="card-header">
					<h5>Referred Person Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-4"><strong>Name:</strong></div>
						<div class="col-md-8">{{ $referral->referred_first_name }} {{ $referral->referred_last_name }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Email:</strong></div>
						<div class="col-md-8">{{ $referral->referred_email }}</div>
					</div>
					@if($referral->referred_phone)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Phone:</strong></div>
						<div class="col-md-8">{{ $referral->referred_phone }}</div>
					</div>
					@endif
					@if($referral->referred_skills)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Skills:</strong></div>
						<div class="col-md-8">{{ $referral->referred_skills }}</div>
					</div>
					@endif
					@if($referral->referred_experience)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Experience:</strong></div>
						<div class="col-md-8">{{ $referral->referred_experience }}</div>
					</div>
					@endif
					<div class="row mb-3">
						<div class="col-md-4"><strong>Created At:</strong></div>
						<div class="col-md-8">{{ $referral->created_at->format('M d, Y H:i') }}</div>
					</div>
					<div class="row">
						<div class="col-md-4"><strong>Updated At:</strong></div>
						<div class="col-md-8">{{ $referral->updated_at->format('M d, Y H:i') }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body text-center">
					<div class="avatar avatar-xxl mb-3">
						<i class="ti ti-ux-circle fs-48 text-primary"></i>
					</div>
					<h4 class="mb-1">{{ $referral->referred_first_name }} {{ $referral->referred_last_name }}</h4>
					<p class="text-muted mb-2">{{ $referral->referred_email }}</p>
					@if($referral->referrer)
					<div class="mb-3">
						<p class="mb-1"><small class="text-muted">Referred by</small></p>
						<p class="fw-medium">{{ $referral->referrer->name }}</p>
					</div>
					@endif
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('referrals.edit', $referral->id) }}" class="btn btn-primary btn-sm">
							<i class="ti ti-edit me-2"></i>Edit Referral
						</a>
						@if($referral->jobPosting)
							<a href="{{ route('jobs.show', $referral->jobPosting->id) }}" class="btn btn-info btn-sm">
								<i class="ti ti-briefcase me-2"></i>View Job
							</a>
						@endif
						<form action="{{ route('referrals.destroy', $referral->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this referral?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger btn-sm w-100">
								<i class="ti ti-trash me-2"></i>Delete Referral
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

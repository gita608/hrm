@extends('layouts.app')

@section('title', 'Referrals')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Referrals</h2>
			<p class="text-muted mb-0 fs-13">Manage employee referrals and track their status</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('referrals.create') }}" class="btn btn-primary d-flex align-items-center rounded-pill shadow-sm">
				<i class="ti ti-circle-plus me-2"></i>Add Referral
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
		<div class="card-header bg-transparent border-0 d-flex align-items-center justify-content-between pt-3 pb-2 flex-wrap row-gap-3">
			<h5 class="mb-0 fw-bold text-dark">Referrals List</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('referrals.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
					<div>
						<select name="status" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" onchange="this.form.submit()">
							<option value="">All Status</option>
							<option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
							<option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
							<option value="interviewed" {{ request('status') == 'interviewed' ? 'selected' : '' }}>Interviewed</option>
							<option value="shortlisted" {{ request('status') == 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
							<option value="hired" {{ request('status') == 'hired' ? 'selected' : '' }}>Hired</option>
							<option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
							<option value="withdrawn" {{ request('status') == 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
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
					<div>
						<select name="referrer_id" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" onchange="this.form.submit()">
							<option value="">All Referrers</option>
							@foreach($employees as $employee)
								<option value="{{ $employee->id }}" {{ request('referrer_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<select name="bonus_status" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" onchange="this.form.submit()">
							<option value="">All Bonus Status</option>
							<option value="pending" {{ request('bonus_status') == 'pending' ? 'selected' : '' }}>Pending</option>
							<option value="approved" {{ request('bonus_status') == 'approved' ? 'selected' : '' }}>Approved</option>
							<option value="paid" {{ request('bonus_status') == 'paid' ? 'selected' : '' }}>Paid</option>
						</select>
					</div>
					<div>
						@if(request()->hasAny(['status', 'job_posting_id', 'referrer_id', 'bonus_status']))
							<a href="{{ route('referrals.index') }}" class="btn btn-sm btn-light rounded-pill px-3 shadow-none">Clear</a>
						@endif
					</div>
				</form>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="bg-light-50">
						<tr>
							<th class="ps-3 border-0 text-muted fs-12 fw-medium text-uppercase">#</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Referred Person</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Referrer</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Job Position</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Referral Date</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Bonus</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($referrals as $referral)
							<tr class="border-bottom border-light">
								<td class="ps-3 text-muted">{{ $loop->iteration }}</td>
								<td>
									<div class="d-flex align-items-center">
										<div class="avatar avatar-sm bg-primary-transparent text-primary rounded-circle me-2 fw-bold d-flex align-items-center justify-content-center" style="font-size: 0.75rem;">
											{{ strtoupper(substr($referral->referred_first_name, 0, 1) . substr($referral->referred_last_name, 0, 1)) }}
										</div>
										<div>
											<h6 class="mb-0 fw-medium text-dark"><a href="{{ route('referrals.show', $referral->id) }}" class="text-dark text-decoration-none">{{ $referral->referred_first_name }} {{ $referral->referred_last_name }}</a></h6>
											<span class="d-block fs-12 text-muted">{{ $referral->referred_email }}</span>
										</div>
									</div>
								</td>
								<td>
									@if($referral->referrer)
										<div class="d-flex align-items-center">
											@if($referral->referrer->profile_picture)
												<img src="{{ asset('storage/' . $referral->referrer->profile_picture) }}" alt="{{ $referral->referrer->name }}" class="rounded-circle me-2" style="width: 24px; height: 24px; object-fit: cover;">
											@else
												<div class="avatar avatar-xs bg-light rounded-circle me-2 fw-bold d-flex align-items-center justify-content-center border" style="width: 24px; height: 24px; font-size: 10px;">
													{{ strtoupper(substr($referral->referrer->name, 0, 1)) }}
												</div>
											@endif
											<span class="text-dark fs-13">{{ $referral->referrer->name }}</span>
										</div>
									@else
										<span class="text-muted fs-13">N/A</span>
									@endif
								</td>
								<td><span class="badge bg-light text-dark border">{{ $referral->jobPosting->title ?? 'N/A' }}</span></td>
								<td class="text-muted">{{ $referral->referral_date->format('d M, Y') }}</td>
								<td>
									@if($referral->status == 'hired')
										<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-check me-1 fs-10"></i>Hired
										</span>
									@elseif($referral->status == 'rejected')
										<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-x me-1 fs-10"></i>Rejected
										</span>
									@elseif($referral->status == 'interviewed')
										<span class="badge bg-info-transparent text-info rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-microphone me-1 fs-10"></i>Interviewed
										</span>
									@elseif($referral->status == 'shortlisted')
										<span class="badge bg-warning-transparent text-warning rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-star me-1 fs-10"></i>Shortlisted
										</span>
									@elseif($referral->status == 'contacted')
										<span class="badge bg-purple-transparent text-purple rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-phone me-1 fs-10"></i>Contacted
										</span>
									@else
										<span class="badge bg-light-transparent text-dark border rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-circle-filled me-1 fs-10"></i>{{ ucfirst($referral->status) }}
										</span>
									@endif
								</td>
								<td>
									@if($referral->referral_bonus)
										<div class="d-flex flex-column">
											<span class="fw-bold text-dark fs-13">{{ number_format($referral->referral_bonus, 0) }} AED</span>
											@if($referral->bonus_status)
												<span class="badge bg-light border text-muted px-2 py-0 mt-1" style="width: fit-content; font-size: 10px;">
													{{ ucfirst($referral->bonus_status) }}
												</span>
											@endif
										</div>
									@else
										<span class="text-muted">-</span>
									@endif
								</td>
								<td class="pe-3 text-end">
									<div class="d-flex justify-content-end gap-2">
										<a href="{{ route('referrals.show', $referral->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('referrals.edit', $referral->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-info hover-text-white transition-all" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										<form action="{{ route('referrals.destroy', $referral->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this referral?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-danger hover-text-white transition-all" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="8" class="text-center py-5">
									<div class="d-flex flex-column align-items-center">
										<div class="avatar avatar-xxl bg-light-50 rounded-circle mb-3 text-muted">
											<i class="ti ti-users-off fs-30"></i>
										</div>
										<h6 class="text-muted mb-0">No referrals found</h6>
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

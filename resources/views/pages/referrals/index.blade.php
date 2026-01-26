@extends('layouts.app')

@section('title', 'Referrals')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Referrals</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<a href="{{ route('referrals.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Referral</a>
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
			<h5>Referrals List</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('referrals.index') }}" class="d-flex gap-2 flex-wrap">
					<div>
						<select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
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
						<select name="job_posting_id" class="form-select form-select-sm" onchange="this.form.submit()">
							<option value="">All Jobs</option>
							@foreach($jobPostings as $job)
								<option value="{{ $job->id }}" {{ request('job_posting_id') == $job->id ? 'selected' : '' }}>{{ $job->title }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<select name="referrer_id" class="form-select form-select-sm" onchange="this.form.submit()">
							<option value="">All Referrers</option>
							@foreach($employees as $employee)
								<option value="{{ $employee->id }}" {{ request('referrer_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<select name="bonus_status" class="form-select form-select-sm" onchange="this.form.submit()">
							<option value="">All Bonus Status</option>
							<option value="pending" {{ request('bonus_status') == 'pending' ? 'selected' : '' }}>Pending</option>
							<option value="approved" {{ request('bonus_status') == 'approved' ? 'selected' : '' }}>Approved</option>
							<option value="paid" {{ request('bonus_status') == 'paid' ? 'selected' : '' }}>Paid</option>
						</select>
					</div>
					@if(request()->hasAny(['status', 'job_posting_id', 'referrer_id', 'bonus_status']))
						<a href="{{ route('referrals.index') }}" class="btn btn-sm btn-outline-light border">Clear Filters</a>
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
							<th>#</th>
							<th>Ref ID</th>
							<th>Referred Person</th>
							<th>Referrer</th>
							<th>Job Position</th>
							<th>Referral Date</th>
							<th>Status</th>
							<th>Bonus</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@forelse($referrals as $referral)
							<tr>
								<td>
									<div class="form-check form-check-md">
										<input class="form-check-input" type="checkbox" value="{{ $referral->id }}">
									</div>
								</td>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $referral->referral_code ?? 'REF-' . str_pad($referral->id, 3, '0', STR_PAD_LEFT) }}</td>
								<td>
									<div class="d-flex align-items-center file-name-icon">
										<div class="ms-2">
											<h6 class="fw-medium"><a href="{{ route('referrals.show', $referral->id) }}">{{ $referral->referred_first_name }} {{ $referral->referred_last_name }}</a></h6>
											<span class="d-block mt-1">{{ $referral->referred_email }}</span>
										</div>
									</div>
								</td>
								<td>
									@if($referral->referrer)
										<span class="badge badge-soft-primary">{{ $referral->referrer->name }}</span>
									@else
										<span class="text-muted">N/A</span>
									@endif
								</td>
								<td>{{ $referral->jobPosting->title ?? 'N/A' }}</td>
								<td>{{ $referral->referral_date->format('d M Y') }}</td>
								<td>
									@if($referral->status == 'hired')
										<span class="badge badge-success d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Hired
										</span>
									@elseif($referral->status == 'rejected')
										<span class="badge badge-danger d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Rejected
										</span>
									@elseif($referral->status == 'interviewed')
										<span class="badge badge-info d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Interviewed
										</span>
									@elseif($referral->status == 'shortlisted')
										<span class="badge badge-warning d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Shortlisted
										</span>
									@elseif($referral->status == 'contacted')
										<span class="badge badge-pink d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Contacted
										</span>
									@else
										<span class="badge badge-purple d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>{{ ucfirst($referral->status) }}
										</span>
									@endif
								</td>
								<td>
									@if($referral->referral_bonus)
										<div>
											<span class="fw-medium">{{ number_format($referral->referral_bonus, 2) }} AED</span>
											@if($referral->bonus_status)
												<br>
												<small class="badge badge-soft-{{ $referral->bonus_status == 'paid' ? 'success' : ($referral->bonus_status == 'approved' ? 'info' : 'warning') }}">
													{{ ucfirst($referral->bonus_status) }}
												</small>
											@endif
										</div>
									@else
										<span class="text-muted">-</span>
									@endif
								</td>
								<td>
									<div class="action-icon d-inline-flex">
										<a href="{{ route('referrals.show', $referral->id) }}" class="me-2" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('referrals.edit', $referral->id) }}" class="me-2" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										<form action="{{ route('referrals.destroy', $referral->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this referral?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-link p-0 text-danger" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="10" class="text-center">No referrals found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

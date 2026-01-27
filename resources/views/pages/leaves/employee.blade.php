@extends('layouts.app')

@section('title', 'My Leaves')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">My Leaves</h2>
			<p class="text-muted mb-0 fs-13">View and manage your leave requests</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('leaves.create') }}" class="btn btn-primary rounded-pill shadow-sm py-2 px-3">
				<i class="ti ti-plus me-2"></i>Request Leave
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

	@if(session('error'))
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			{{ session('error') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2 d-flex align-items-center justify-content-between flex-wrap row-gap-3">
			<h5 class="mb-0 fw-bold text-dark">Leave Requests</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('leaves.employee') }}" class="d-flex align-items-center gap-2 flex-wrap">
					<div>
						<select name="status" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" onchange="this.form.submit()">
							<option value="">All Status</option>
							<option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
							<option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
							<option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
							<option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
						</select>
					</div>
					@if(request()->has('status'))
						<a href="{{ route('leaves.employee') }}" class="btn btn-sm btn-light rounded-pill px-3">Clear</a>
					@endif
				</form>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="bg-light-50">
						<tr>
							<th class="ps-3 border-0 text-muted fs-12 fw-medium text-uppercase">#</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Leave Type</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">From Date</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">To Date</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Days</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Reason</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($leaves as $leave)
							<tr class="border-bottom border-light">
								<td class="ps-3 text-muted">{{ $loop->iteration }}</td>
								<td class="text-dark fw-medium">{{ $leave->leaveType->name }}</td>
								<td class="text-muted">{{ $leave->from_date->format('d M Y') }}</td>
								<td class="text-muted">{{ $leave->to_date->format('d M Y') }}</td>
								<td class="text-muted">{{ $leave->days }} Days</td>
								<td class="text-muted"><span class="d-inline-block text-truncate" style="max-width: 150px;">{{ Str::limit($leave->reason, 50) }}</span></td>
								<td>
									@if($leave->status == 'approved')
										<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-circle-check-filled me-1 fs-10"></i>{{ ucfirst($leave->status) }}
										</span>
									@elseif($leave->status == 'rejected')
										<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-circle-x-filled me-1 fs-10"></i>{{ ucfirst($leave->status) }}
										</span>
									@elseif($leave->status == 'pending')
										<span class="badge bg-warning-transparent text-warning rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-clock-filled me-1 fs-10"></i>{{ ucfirst($leave->status) }}
										</span>
									@else
										<span class="badge bg-secondary-transparent text-secondary rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>{{ ucfirst($leave->status) }}
										</span>
									@endif
								</td>
								<td class="pe-3 text-end">
									<div class="d-flex justify-content-end gap-2">
										<a href="javascript:void(0);" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all" data-bs-toggle="modal" data-bs-target="#viewLeave{{ $leave->id }}" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										@if($leave->status == 'pending')
											<form action="{{ route('leaves.cancel', $leave->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to cancel this leave request?');">
												@csrf
												@method('PUT')
												<button type="submit" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-danger hover-text-white transition-all" data-bs-toggle="tooltip" title="Cancel"><i class="ti ti-x"></i></button>
											</form>
										@endif
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="8" class="text-center py-5">
									<div class="d-flex flex-column align-items-center">
										<div class="avatar avatar-xxl bg-light-50 rounded-circle mb-3 text-muted">
											<i class="ti ti-calendar-off fs-30"></i>
										</div>
										<h6 class="text-muted mb-0">No leave requests found</h6>
									</div>
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- View Leave Modal -->
	<!-- View Leave Modal -->
	@foreach($leaves as $leave)
	<div class="modal fade" id="viewLeave{{ $leave->id }}" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content border-0 shadow-lg rounded-4">
				<div class="modal-header bg-light-50 border-bottom border-light">
					<h5 class="modal-title fw-bold text-dark">Leave Details</h5>
					<button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
				</div>
				<div class="modal-body p-4">
					<div class="row g-3">
						<div class="col-md-6">
							<div class="p-3 bg-light-50 rounded-3 border border-light h-100">
								<h6 class="text-muted fs-12 text-uppercase fw-medium mb-2">Leave Status</h6>
								<div class="mb-2">
									<h5 class="mb-1 text-dark fw-bold">{{ $leave->leaveType->name }}</h5>
									@if($leave->status == 'approved')
										<span class="badge bg-success-transparent text-success rounded-pill px-2 py-1"><i class="ti ti-circle-check-filled me-1"></i>Approved</span>
									@elseif($leave->status == 'rejected')
										<span class="badge bg-danger-transparent text-danger rounded-pill px-2 py-1"><i class="ti ti-circle-x-filled me-1"></i>Rejected</span>
									@elseif($leave->status == 'pending')
										<span class="badge bg-warning-transparent text-warning rounded-pill px-2 py-1"><i class="ti ti-clock-filled me-1"></i>Pending</span>
									@else
										<span class="badge bg-secondary-transparent text-secondary rounded-pill px-2 py-1"><i class="ti ti-point-filled me-1"></i>{{ ucfirst($leave->status) }}</span>
									@endif
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="p-3 bg-light-50 rounded-3 border border-light h-100">
								<h6 class="text-muted fs-12 text-uppercase fw-medium mb-3">Duration</h6>
								<div class="d-flex align-items-center justify-content-between">
									<div>
										<span class="d-block text-muted fs-12 mb-1">From Date</span>
										<h6 class="fw-bold text-dark mb-0">{{ $leave->from_date->format('d M Y') }}</h6>
									</div>
									<div class="text-center px-2">
										<span class="badge bg-white text-dark border rounded-pill px-3 shadow-sm">{{ $leave->days }} Days</span>
									</div>
									<div class="text-end">
										<span class="d-block text-muted fs-12 mb-1">To Date</span>
										<h6 class="fw-bold text-dark mb-0">{{ $leave->to_date->format('d M Y') }}</h6>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="p-3 bg-light-50 rounded-3 border border-light">
								<h6 class="text-muted fs-12 text-uppercase fw-medium mb-2">Reason</h6>
								<p class="mb-0 text-dark">{{ $leave->reason }}</p>
							</div>
						</div>
						@if($leave->rejection_reason)
						<div class="col-md-12">
							<div class="p-3 bg-danger-transparent rounded-3 border border-danger-subtle">
								<h6 class="text-danger fs-12 text-uppercase fw-medium mb-2">Rejection Reason</h6>
								<p class="mb-0 text-danger">{{ $leave->rejection_reason }}</p>
							</div>
						</div>
						@endif
						@if($leave->admin_notes)
						<div class="col-md-12">
							<div class="p-3 bg-light-50 rounded-3 border border-light">
								<h6 class="text-muted fs-12 text-uppercase fw-medium mb-2">Admin Notes</h6>
								<p class="mb-0 text-dark">{{ $leave->admin_notes }}</p>
							</div>
						</div>
						@endif
						@if($leave->approver)
						<div class="col-md-12">
							<div class="d-flex align-items-center gap-2 text-muted fs-13">
								<i class="ti ti-user-check"></i>
								<span>Approved by <span class="fw-bold text-dark">{{ $leave->approver->name }}</span> on {{ $leave->approved_at->format('d M Y H:i') }}</span>
							</div>
						</div>
						@endif
					</div>
				</div>
				<div class="modal-footer border-top border-light">
					<button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	@endforeach

@endsection

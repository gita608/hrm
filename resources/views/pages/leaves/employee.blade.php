@extends('layouts.app')

@section('title', 'My Leaves')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">My Leaves</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<a href="{{ route('leaves.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Request Leave</a>
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

	@if(session('error'))
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			{{ session('error') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	<div class="card">
		<div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
			<h5>Leave Requests</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('leaves.employee') }}" class="d-flex gap-2 flex-wrap">
					<div>
						<select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
							<option value="">All Status</option>
							<option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
							<option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
							<option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
							<option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
						</select>
					</div>
					@if(request()->has('status'))
						<a href="{{ route('leaves.employee') }}" class="btn btn-sm btn-outline-light border">Clear Filter</a>
					@endif
				</form>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="custom-datatable-filter table-responsive">
				<table class="table datatable">
					<thead class="thead-light">
						<tr>
							<th>#</th>
							<th>Leave Type</th>
							<th>From Date</th>
							<th>To Date</th>
							<th>Days</th>
							<th>Reason</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($leaves as $leave)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $leave->leaveType->name }}</td>
								<td>{{ $leave->from_date->format('d M Y') }}</td>
								<td>{{ $leave->to_date->format('d M Y') }}</td>
								<td>{{ $leave->days }}</td>
								<td>{{ Str::limit($leave->reason, 50) }}</td>
								<td>
									@if($leave->status == 'approved')
										<span class="badge badge-success">{{ ucfirst($leave->status) }}</span>
									@elseif($leave->status == 'rejected')
										<span class="badge badge-danger">{{ ucfirst($leave->status) }}</span>
									@elseif($leave->status == 'pending')
										<span class="badge badge-warning">{{ ucfirst($leave->status) }}</span>
									@else
										<span class="badge badge-secondary">{{ ucfirst($leave->status) }}</span>
									@endif
								</td>
								<td>
									<div class="action-icon d-inline-flex">
										<a href="javascript:void(0);" class="me-2" data-bs-toggle="modal" data-bs-target="#viewLeave{{ $leave->id }}" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										@if($leave->status == 'pending')
											<form action="{{ route('leaves.cancel', $leave->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to cancel this leave request?');">
												@csrf
												@method('PUT')
												<button type="submit" class="btn btn-link p-0 text-danger" data-bs-toggle="tooltip" title="Cancel"><i class="ti ti-x"></i></button>
											</form>
										@endif
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="8" class="text-center">No leave requests found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- View Leave Modal -->
	@foreach($leaves as $leave)
	<div class="modal fade" id="viewLeave{{ $leave->id }}" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Leave Details</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<div class="modal-body">
					<div class="row mb-3">
						<div class="col-md-4"><strong>Leave Type:</strong></div>
						<div class="col-md-8">{{ $leave->leaveType->name }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>From Date:</strong></div>
						<div class="col-md-8">{{ $leave->from_date->format('d M Y') }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>To Date:</strong></div>
						<div class="col-md-8">{{ $leave->to_date->format('d M Y') }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Days:</strong></div>
						<div class="col-md-8">{{ $leave->days }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Reason:</strong></div>
						<div class="col-md-8">{{ $leave->reason }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Status:</strong></div>
						<div class="col-md-8">
							@if($leave->status == 'approved')
								<span class="badge badge-success">{{ ucfirst($leave->status) }}</span>
							@elseif($leave->status == 'rejected')
								<span class="badge badge-danger">{{ ucfirst($leave->status) }}</span>
							@elseif($leave->status == 'pending')
								<span class="badge badge-warning">{{ ucfirst($leave->status) }}</span>
							@else
								<span class="badge badge-secondary">{{ ucfirst($leave->status) }}</span>
							@endif
						</div>
					</div>
					@if($leave->rejection_reason)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Rejection Reason:</strong></div>
						<div class="col-md-8">{{ $leave->rejection_reason }}</div>
					</div>
					@endif
					@if($leave->admin_notes)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Admin Notes:</strong></div>
						<div class="col-md-8">{{ $leave->admin_notes }}</div>
					</div>
					@endif
					@if($leave->approver)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Approved By:</strong></div>
						<div class="col-md-8">{{ $leave->approver->name }} on {{ $leave->approved_at->format('d M Y H:i') }}</div>
					</div>
					@endif
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-light border" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	@endforeach

@endsection

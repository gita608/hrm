@extends('layouts.app')

@section('title', 'Leaves (Admin)')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Leaves (Admin)</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
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
			<h5>Leave Requests</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('leaves.index') }}" class="d-flex gap-2 flex-wrap">
					<div>
						<select name="employee_id" class="form-select form-select-sm" onchange="this.form.submit()">
							<option value="">All Employees</option>
							@foreach($employees as $employee)
								<option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
							<option value="">All Status</option>
							<option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
							<option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
							<option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
							<option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
						</select>
					</div>
					<div>
						<select name="leave_type_id" class="form-select form-select-sm" onchange="this.form.submit()">
							<option value="">All Leave Types</option>
							@foreach($leaveTypes as $type)
								<option value="{{ $type->id }}" {{ request('leave_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
							@endforeach
						</select>
					</div>
					@if(request()->hasAny(['employee_id', 'status', 'leave_type_id', 'date_from', 'date_to']))
						<a href="{{ route('leaves.index') }}" class="btn btn-sm btn-outline-light border">Clear Filters</a>
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
							<th>Employee</th>
							<th>Leave Type</th>
							<th>From Date</th>
							<th>To Date</th>
							<th>Days</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($leaves as $leave)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>
									<div class="d-flex align-items-center">
										<div class="ms-2">
											<h6 class="fw-medium">{{ $leave->employee->name }}</h6>
											<span class="d-block mt-1 text-muted">{{ $leave->employee->email }}</span>
										</div>
									</div>
								</td>
								<td>{{ $leave->leaveType->name }}</td>
								<td>{{ $leave->from_date->format('d M Y') }}</td>
								<td>{{ $leave->to_date->format('d M Y') }}</td>
								<td>{{ $leave->days }}</td>
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
											<a href="javascript:void(0);" class="me-2" data-bs-toggle="modal" data-bs-target="#approveLeave{{ $leave->id }}" data-bs-toggle="tooltip" title="Approve"><i class="ti ti-check text-success"></i></a>
											<a href="javascript:void(0);" class="me-2" data-bs-toggle="modal" data-bs-target="#rejectLeave{{ $leave->id }}" data-bs-toggle="tooltip" title="Reject"><i class="ti ti-x text-danger"></i></a>
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
						<div class="col-md-4"><strong>Employee:</strong></div>
						<div class="col-md-8">{{ $leave->employee->name }}</div>
					</div>
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

	<!-- Approve Leave Modal -->
	<div class="modal fade" id="approveLeave{{ $leave->id }}" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Approve Leave Request</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<form action="{{ route('leaves.approve', $leave->id) }}" method="POST">
					@csrf
					<div class="modal-body">
						<div class="mb-3">
							<label class="form-label">Admin Notes (Optional)</label>
							<textarea class="form-control" name="admin_notes" rows="3" placeholder="Add any notes..."></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-light border" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-success">Approve</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Reject Leave Modal -->
	<div class="modal fade" id="rejectLeave{{ $leave->id }}" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Reject Leave Request</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<form action="{{ route('leaves.reject', $leave->id) }}" method="POST">
					@csrf
					<div class="modal-body">
						<div class="mb-3">
							<label class="form-label">Rejection Reason <span class="text-danger">*</span></label>
							<textarea class="form-control" name="rejection_reason" rows="3" placeholder="Enter rejection reason..." required></textarea>
						</div>
						<div class="mb-3">
							<label class="form-label">Admin Notes (Optional)</label>
							<textarea class="form-control" name="admin_notes" rows="2" placeholder="Add any notes..."></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-light border" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-danger">Reject</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	@endforeach

@endsection

@extends('layouts.app')

@section('title', 'Overtime Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Overtime Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('overtime.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5>Overtime Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Employee</label>
							<p class="mb-0 fw-semibold">{{ $overtime->employee->name ?? 'N/A' }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">Date</label>
							<p class="mb-0 fw-semibold">{{ $overtime->date->format('d M Y') }}</p>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Start Time</label>
							<p class="mb-0 fw-semibold">{{ date('h:i A', strtotime($overtime->start_time)) }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">End Time</label>
							<p class="mb-0 fw-semibold">{{ date('h:i A', strtotime($overtime->end_time)) }}</p>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Total Hours</label>
							<p class="mb-0 fw-semibold">{{ number_format($overtime->hours, 2) }} hrs</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">Status</label>
							<p class="mb-0">
								@if($overtime->status == 'approved')
									<span class="badge badge-success d-inline-flex align-items-center badge-sm">
										<i class="ti ti-point-filled me-1"></i>Approved
									</span>
								@elseif($overtime->status == 'rejected')
									<span class="badge badge-danger d-inline-flex align-items-center badge-sm">
										<i class="ti ti-point-filled me-1"></i>Rejected
									</span>
								@else
									<span class="badge badge-warning d-inline-flex align-items-center badge-sm">
										<i class="ti ti-point-filled me-1"></i>Pending
									</span>
								@endif
							</p>
						</div>
					</div>
					@if($overtime->reason)
						<div class="mb-3">
							<label class="form-label text-muted">Reason</label>
							<p class="mb-0">{{ $overtime->reason }}</p>
						</div>
					@endif
					@if($overtime->notes)
						<div class="mb-3">
							<label class="form-label text-muted">Notes</label>
							<p class="mb-0">{{ $overtime->notes }}</p>
						</div>
					@endif
					@if($overtime->approved_by)
						<div class="row mb-3">
							<div class="col-md-6">
								<label class="form-label text-muted">Approved By</label>
								<p class="mb-0 fw-semibold">{{ $overtime->approver->name ?? 'N/A' }}</p>
							</div>
							<div class="col-md-6">
								<label class="form-label text-muted">Approved At</label>
								<p class="mb-0 fw-semibold">{{ $overtime->approved_at ? $overtime->approved_at->format('d M Y h:i A') : 'N/A' }}</p>
							</div>
						</div>
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-header">
					<h5>Actions</h5>
				</div>
				<div class="card-body">
					<div class="d-grid gap-2">
						<a href="{{ route('overtime.edit', $overtime->id) }}" class="btn btn-primary">
							<i class="ti ti-edit me-2"></i>Edit Overtime
						</a>
						@if($overtime->status == 'pending')
							<form action="{{ route('overtime.approve', $overtime->id) }}" method="POST" class="d-grid">
								@csrf
								<button type="submit" class="btn btn-success">
									<i class="ti ti-check me-2"></i>Approve
								</button>
							</form>
							<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
								<i class="ti ti-x me-2"></i>Reject
							</button>
						@endif
						<form action="{{ route('overtime.destroy', $overtime->id) }}" method="POST" class="d-grid" onsubmit="return confirm('Are you sure you want to delete this overtime request?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger">
								<i class="ti ti-trash me-2"></i>Delete
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Reject Modal -->
	@if($overtime->status == 'pending')
		<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<form action="{{ route('overtime.reject', $overtime->id) }}" method="POST">
						@csrf
						<div class="modal-header">
							<h5 class="modal-title" id="rejectModalLabel">Reject Overtime Request</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<div class="mb-3">
								<label class="form-label">Rejection Notes</label>
								<textarea class="form-control" name="notes" rows="3" placeholder="Enter reason for rejection"></textarea>
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
	@endif

@endsection

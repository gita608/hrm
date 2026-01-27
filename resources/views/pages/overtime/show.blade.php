@extends('layouts.app')

@section('title', 'Overtime Details')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Overtime Details</h2>
			<p class="text-muted mb-0 fs-13">View detailed overtime information</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('overtime.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="row">
		<div class="col-md-8">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Overtime Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row mb-4">
						<div class="col-md-6 border-end border-light">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Employee</label>
							@if($overtime->employee)
							<div class="d-flex align-items-center mt-1">
								<div class="avatar avatar-sm bg-primary-transparent text-primary rounded-circle me-2 fw-bold">
									{{ strtoupper(substr($overtime->employee->name, 0, 1)) }}
								</div>
								<p class="mb-0 fw-bold fs-15 text-dark">{{ $overtime->employee->name }}</p>
							</div>
							@else
								<p class="text-muted">N/A</p>
							@endif
						</div>
						<div class="col-md-6 ps-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Date</label>
							<p class="mb-0 fw-bold fs-15 text-dark mt-1">{{ $overtime->date->format('d M Y') }}</p>
						</div>
					</div>
					<div class="row mb-4">
						<div class="col-md-6">
							<div class="p-3 bg-light-50 rounded-3 border border-light h-100">
								<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-2">Duration</label>
								<div class="d-flex align-items-center justify-content-between">
									<p class="mb-0 fw-bold fs-15 text-dark">{{ date('h:i A', strtotime($overtime->start_time)) }} - {{ date('h:i A', strtotime($overtime->end_time)) }}</p>
									<span class="badge bg-white text-dark border border-light shadow-sm">{{ number_format($overtime->hours, 2) }} hrs</span>
								</div>
							</div>
						</div>
						<div class="col-md-6 mt-3 mt-md-0">
							<div class="p-3 bg-light-50 rounded-3 border border-light h-100">
								<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-2">Status</label>
								<div class="mt-1">
									@if($overtime->status == 'approved')
										<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Approved
										</span>
									@elseif($overtime->status == 'rejected')
										<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Rejected
										</span>
									@else
										<span class="badge bg-warning-transparent text-warning rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Pending
										</span>
									@endif
								</div>
							</div>
						</div>
					</div>
					@if($overtime->reason)
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-2">Reason</label>
							<p class="mb-0 text-dark">{{ $overtime->reason }}</p>
						</div>
					@endif
					@if($overtime->notes)
						<div class="mt-4 pt-3 border-top border-light">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-2">Notes</label>
							<p class="mb-0 text-dark bg-light-50 p-3 rounded-3">{{ $overtime->notes }}</p>
						</div>
					@endif
					@if($overtime->approved_by)
						<div class="mt-4 pt-3 border-top border-light">
							<div class="row">
								<div class="col-md-6">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Approved By</label>
									<p class="mb-0 fw-medium text-dark">{{ $overtime->approver->name ?? 'N/A' }}</p>
								</div>
								<div class="col-md-6">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Approved At</label>
									<p class="mb-0 fw-medium text-dark">{{ $overtime->approved_at ? $overtime->approved_at->format('d M Y h:i A') : 'N/A' }}</p>
								</div>
							</div>
						</div>
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Actions</h5>
				</div>
				<div class="card-body p-4">
					<div class="d-grid gap-3">
						<a href="{{ route('overtime.edit', $overtime->id) }}" class="btn btn-primary rounded-pill py-2 shadow-sm">
							<i class="ti ti-edit me-2"></i>Edit Overtime
						</a>
						@if($overtime->status == 'pending')
							<form action="{{ route('overtime.approve', $overtime->id) }}" method="POST" class="d-grid">
								@csrf
								<button type="submit" class="btn btn-success rounded-pill py-2 shadow-sm text-white">
									<i class="ti ti-check me-2"></i>Approve
								</button>
							</form>
							<button type="button" class="btn btn-outline-danger rounded-pill py-2" data-bs-toggle="modal" data-bs-target="#rejectModal">
								<i class="ti ti-x me-2"></i>Reject
							</button>
						@endif
						<form action="{{ route('overtime.destroy', $overtime->id) }}" method="POST" class="d-grid" onsubmit="return confirm('Are you sure you want to delete this overtime request?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger rounded-pill py-2">
								<i class="ti ti-trash me-2"></i>Delete Request
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
						<div class="modal-footer border-top border-light">
							<button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-danger rounded-pill">Reject</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	@endif

@endsection

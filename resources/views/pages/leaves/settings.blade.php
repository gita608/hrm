@extends('layouts.app')

@section('title', 'Leave Settings')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Leave Settings</h2>
			<p class="text-muted mb-0 fs-13">Configure leave types and policies</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<button type="button" class="btn btn-primary rounded-pill shadow-sm py-2 px-3" data-bs-toggle="modal" data-bs-target="#addLeaveType">
				<i class="ti ti-plus me-2"></i>Add Leave Type
			</button>
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
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
			<h5 class="mb-0 fw-bold text-dark">Leave Types</h5>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="bg-light-50">
						<tr>
							<th class="ps-3 border-0 text-muted fs-12 fw-medium text-uppercase">#</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Name</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Days Per Year</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Paid</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Requires Approval</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($leaveTypes as $type)
							<tr class="border-bottom border-light">
								<td class="ps-3 text-muted">{{ $loop->iteration }}</td>
								<td class="text-dark fw-bold">{{ $type->name }}</td>
								<td class="text-muted">{{ $type->days_per_year }} Days</td>
								<td>
									@if($type->is_paid)
										<span class="badge bg-success-transparent text-success rounded-pill px-2 py-1"><i class="ti ti-check me-1"></i>Yes</span>
									@else
										<span class="badge bg-secondary-transparent text-secondary rounded-pill px-2 py-1"><i class="ti ti-x me-1"></i>No</span>
									@endif
								</td>
								<td>
									@if($type->requires_approval)
										<span class="badge bg-info-transparent text-info rounded-pill px-2 py-1"><i class="ti ti-check me-1"></i>Yes</span>
									@else
										<span class="badge bg-secondary-transparent text-secondary rounded-pill px-2 py-1"><i class="ti ti-x me-1"></i>No</span>
									@endif
								</td>
								<td>
									@if($type->is_active)
										<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Active
										</span>
									@else
										<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Inactive
										</span>
									@endif
								</td>
								<td class="pe-3 text-end">
									<div class="d-flex justify-content-end gap-2">
										<a href="javascript:void(0);" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all" data-bs-toggle="modal" data-bs-target="#editLeaveType{{ $type->id }}" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										<form action="{{ route('leave-types.destroy', $type->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this leave type?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-danger hover-text-white transition-all" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="7" class="text-center py-5">
									<div class="d-flex flex-column align-items-center">
										<div class="avatar avatar-xxl bg-light-50 rounded-circle mb-3 text-muted">
											<i class="ti ti-settings-off fs-30"></i>
										</div>
										<h6 class="text-muted mb-0">No leave types found</h6>
									</div>
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Add Leave Type Modal -->
	<div class="modal fade" id="addLeaveType" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content border-0 shadow-lg rounded-4">
				<div class="modal-header bg-light-50 border-bottom border-light">
					<h5 class="modal-title fw-bold text-dark">Add Leave Type</h5>
					<button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
				</div>
				<form action="{{ route('leave-types.store') }}" method="POST">
					@csrf
					<div class="modal-body p-4">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="name" required placeholder="e.g., Annual Leave">
						</div>
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Days Per Year <span class="text-danger">*</span></label>
							<input type="number" class="form-control rounded-3 border-light shadow-none" name="days_per_year" min="0" required placeholder="e.g., 30">
						</div>
						<div class="mb-3">
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" name="is_paid" value="1" id="isPaid" checked>
								<label class="form-check-label fw-medium text-dark" for="isPaid">Paid Leave</label>
							</div>
						</div>
						<div class="mb-3">
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" name="requires_approval" value="1" id="requiresApproval" checked>
								<label class="form-check-label fw-medium text-dark" for="requiresApproval">Requires Approval</label>
							</div>
						</div>
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Description</label>
							<textarea class="form-control rounded-3 border-light shadow-none" name="description" rows="2" placeholder="Brief description of the leave type"></textarea>
						</div>
						<div class="mb-3">
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" checked>
								<label class="form-check-label fw-medium text-dark" for="isActive">Active</label>
							</div>
						</div>
					</div>
					<div class="modal-footer border-top border-light">
						<button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Create Leave Type</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Edit Leave Type Modal -->
	<!-- Edit Leave Type Modal -->
	@foreach($leaveTypes as $type)
	<div class="modal fade" id="editLeaveType{{ $type->id }}" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content border-0 shadow-lg rounded-4">
				<div class="modal-header bg-light-50 border-bottom border-light">
					<h5 class="modal-title fw-bold text-dark">Edit Leave Type</h5>
					<button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
				</div>
				<form action="{{ route('leave-types.update', $type->id) }}" method="POST">
					@csrf
					@method('PUT')
					<div class="modal-body p-4">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="name" value="{{ $type->name }}" required>
						</div>
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Days Per Year <span class="text-danger">*</span></label>
							<input type="number" class="form-control rounded-3 border-light shadow-none" name="days_per_year" value="{{ $type->days_per_year }}" min="0" required>
						</div>
						<div class="mb-3">
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" name="is_paid" value="1" id="editIsPaid{{ $type->id }}" {{ $type->is_paid ? 'checked' : '' }}>
								<label class="form-check-label fw-medium text-dark" for="editIsPaid{{ $type->id }}">Paid Leave</label>
							</div>
						</div>
						<div class="mb-3">
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" name="requires_approval" value="1" id="editRequiresApproval{{ $type->id }}" {{ $type->requires_approval ? 'checked' : '' }}>
								<label class="form-check-label fw-medium text-dark" for="editRequiresApproval{{ $type->id }}">Requires Approval</label>
							</div>
						</div>
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Description</label>
							<textarea class="form-control rounded-3 border-light shadow-none" name="description" rows="2">{{ $type->description }}</textarea>
						</div>
						<div class="mb-3">
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" name="is_active" value="1" id="editIsActive{{ $type->id }}" {{ $type->is_active ? 'checked' : '' }}>
								<label class="form-check-label fw-medium text-dark" for="editIsActive{{ $type->id }}">Active</label>
							</div>
						</div>
					</div>
					<div class="modal-footer border-top border-light">
						<button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Update Leave Type</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	@endforeach

@endsection

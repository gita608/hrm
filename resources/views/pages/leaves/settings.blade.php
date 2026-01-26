@extends('layouts.app')

@section('title', 'Leave Settings')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Leave Settings</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLeaveType">
					<i class="ti ti-circle-plus me-2"></i>Add Leave Type
				</button>
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
		<div class="card-header">
			<h5>Leave Types</h5>
		</div>
		<div class="card-body p-0">
			<div class="custom-datatable-filter table-responsive">
				<table class="table datatable">
					<thead class="thead-light">
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Days Per Year</th>
							<th>Paid</th>
							<th>Requires Approval</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($leaveTypes as $type)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $type->name }}</td>
								<td>{{ $type->days_per_year }}</td>
								<td>
									@if($type->is_paid)
										<span class="badge badge-success">Yes</span>
									@else
										<span class="badge badge-secondary">No</span>
									@endif
								</td>
								<td>
									@if($type->requires_approval)
										<span class="badge badge-info">Yes</span>
									@else
										<span class="badge badge-secondary">No</span>
									@endif
								</td>
								<td>
									@if($type->is_active)
										<span class="badge badge-success">Active</span>
									@else
										<span class="badge badge-danger">Inactive</span>
									@endif
								</td>
								<td>
									<div class="action-icon d-inline-flex">
										<a href="javascript:void(0);" class="me-2" data-bs-toggle="modal" data-bs-target="#editLeaveType{{ $type->id }}" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										<form action="{{ route('leave-types.destroy', $type->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this leave type?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-link p-0 text-danger" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="7" class="text-center">No leave types found.</td>
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
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Leave Type</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<form action="{{ route('leave-types.store') }}" method="POST">
					@csrf
					<div class="modal-body">
						<div class="mb-3">
							<label class="form-label">Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="name" required>
						</div>
						<div class="mb-3">
							<label class="form-label">Days Per Year <span class="text-danger">*</span></label>
							<input type="number" class="form-control" name="days_per_year" min="0" required>
						</div>
						<div class="mb-3">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="is_paid" value="1" checked>
								<label class="form-check-label">Paid Leave</label>
							</div>
						</div>
						<div class="mb-3">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="requires_approval" value="1" checked>
								<label class="form-check-label">Requires Approval</label>
							</div>
						</div>
						<div class="mb-3">
							<label class="form-label">Description</label>
							<textarea class="form-control" name="description" rows="2"></textarea>
						</div>
						<div class="mb-3">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
								<label class="form-check-label">Active</label>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-light border" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary">Create</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Edit Leave Type Modal -->
	@foreach($leaveTypes as $type)
	<div class="modal fade" id="editLeaveType{{ $type->id }}" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit Leave Type</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<form action="{{ route('leave-types.update', $type->id) }}" method="POST">
					@csrf
					@method('PUT')
					<div class="modal-body">
						<div class="mb-3">
							<label class="form-label">Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="name" value="{{ $type->name }}" required>
						</div>
						<div class="mb-3">
							<label class="form-label">Days Per Year <span class="text-danger">*</span></label>
							<input type="number" class="form-control" name="days_per_year" value="{{ $type->days_per_year }}" min="0" required>
						</div>
						<div class="mb-3">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="is_paid" value="1" {{ $type->is_paid ? 'checked' : '' }}>
								<label class="form-check-label">Paid Leave</label>
							</div>
						</div>
						<div class="mb-3">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="requires_approval" value="1" {{ $type->requires_approval ? 'checked' : '' }}>
								<label class="form-check-label">Requires Approval</label>
							</div>
						</div>
						<div class="mb-3">
							<label class="form-label">Description</label>
							<textarea class="form-control" name="description" rows="2">{{ $type->description }}</textarea>
						</div>
						<div class="mb-3">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $type->is_active ? 'checked' : '' }}>
								<label class="form-check-label">Active</label>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-light border" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary">Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	@endforeach

@endsection

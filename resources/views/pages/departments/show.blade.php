@extends('layouts.app')

@section('title', 'Department Details')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Department Details</h2>
			<p class="text-muted mb-0 fs-13">View detailed department information</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('departments.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="row">
		<div class="col-md-8">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Department Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row mb-4">
						<div class="col-md-6 border-end border-light">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Name</label>
							<p class="mb-0 fw-bold fs-15 text-dark mt-1">{{ $department->name }}</p>
						</div>
						<div class="col-md-6 ps-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Status</label>
							<div class="mt-1">
								@if($department->is_active)
									<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
										<i class="ti ti-point-filled me-1 fs-10"></i>Active
									</span>
								@else
									<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
										<i class="ti ti-point-filled me-1 fs-10"></i>Inactive
									</span>
								@endif
							</div>
						</div>
					</div>
					<div class="row mb-4">
						<div class="col-md-6">
							<div class="p-3 bg-light-50 rounded-3 border border-light h-100">
								<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-2">Department Code</label>
								<p class="mb-0 fw-bold fs-15 text-dark">{{ $department->code ?? 'N/A' }}</p>
							</div>
						</div>
						<div class="col-md-6 mt-3 mt-md-0">
							<div class="p-3 bg-light-50 rounded-3 border border-light h-100">
								<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-2">Manager</label>
								@if($department->manager)
								<div class="d-flex align-items-center">
									<div class="avatar avatar-xs bg-primary-transparent text-primary rounded-circle me-2 fw-bold">
										{{ strtoupper(substr($department->manager->name, 0, 1)) }}
									</div>
									<span class="fw-bold text-dark">{{ $department->manager->name }}</span>
								</div>
								@else
									<span class="text-muted">N/A</span>
								@endif
							</div>
						</div>
					</div>
					<div class="row mb-4">
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Created At</label>
							<p class="mb-0 fw-medium text-dark">{{ $department->created_at->format('M d, Y H:i') }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Last Updated</label>
							<p class="mb-0 fw-medium text-dark">{{ $department->updated_at->format('M d, Y H:i') }}</p>
						</div>
					</div>
					@if($department->description)
						<div class="mt-4 pt-3 border-top border-light">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-2">Description</label>
							<p class="mb-0 text-dark bg-light-50 p-3 rounded-3">{{ $department->description }}</p>
						</div>
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2 d-flex justify-content-between align-items-center">
					<h5 class="mb-0 fw-bold text-dark">Designations</h5>
					<span class="badge bg-primary-transparent text-primary rounded-pill">{{ $department->designations->count() }}</span>
				</div>
				<div class="card-body p-0">
					@if($department->designations->count() > 0)
						<div class="list-group list-group-flush">
							@foreach($department->designations as $designation)
								<div class="list-group-item d-flex justify-content-between align-items-center border-bottom border-light px-4 py-3">
									<span class="fw-medium text-dark">{{ $designation->name }}</span>
									@if($designation->is_active)
										<span class="badge bg-success-transparent text-success rounded-pill px-2 py-1 fs-10">Active</span>
									@else
										<span class="badge bg-danger-transparent text-danger rounded-pill px-2 py-1 fs-10">Inactive</span>
									@endif
								</div>
							@endforeach
						</div>
					@else
						<div class="text-center py-5">
							<div class="avatar avatar-xl bg-light-50 rounded-circle mb-3 text-muted">
								<i class="ti ti-id fs-24"></i>
							</div>
							<p class="text-muted mb-0">No designations assigned</p>
						</div>
					@endif
				</div>
			</div>
			
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Actions</h5>
				</div>
				<div class="card-body p-4">
					<div class="d-grid gap-3">
						<a href="{{ route('departments.edit', $department->id) }}" class="btn btn-primary rounded-pill py-2 shadow-sm">
							<i class="ti ti-edit me-2"></i>Edit Department
						</a>
						<form action="{{ route('departments.destroy', $department->id) }}" method="POST" class="d-grid" onsubmit="return confirm('Are you sure you want to delete this department?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger rounded-pill py-2">
								<i class="ti ti-trash me-2"></i>Delete Department
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

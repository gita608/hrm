@extends('layouts.app')

@section('title', 'Training Type Details')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Training Type Details</h2>
			<p class="text-muted mb-0 fs-13">View complete category information</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('training.types.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="row">
		<div class="col-md-8">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Training Type Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Name</label>
						</div>
						<div class="col-md-8">
							<p class="mb-0 fw-bold text-dark fs-15">{{ $trainingType->name }}</p>
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Code</label>
						</div>
						<div class="col-md-8">
							<span class="text-dark">{{ $trainingType->code ?? 'N/A' }}</span>
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Status</label>
						</div>
						<div class="col-md-8">
							@if($trainingType->is_active)
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
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Description</label>
						</div>
						<div class="col-md-8">
							<p class="mb-0 text-muted">{{ $trainingType->description ?? 'No description provided.' }}</p>
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Total Trainings</label>
						</div>
						<div class="col-md-8">
							<div class="d-flex align-items-center gap-2">
								<span class="avatar avatar-xs bg-primary-transparent text-primary rounded-circle"><i class="ti ti-hash fs-10"></i></span>
								<span class="fw-medium text-dark">{{ $trainingType->trainings_count ?? 0 }}</span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Created At</label>
							<p class="mb-0 text-muted fs-13">{{ $trainingType->created_at->format('d M Y h:i A') }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Updated At</label>
							<p class="mb-0 text-muted fs-13">{{ $trainingType->updated_at->format('d M Y h:i A') }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body text-center p-4">
					<div class="avatar avatar-xxl bg-primary-transparent text-primary rounded-circle mb-3 mx-auto d-flex align-items-center justify-content-center">
						<i class="ti ti-category fs-48"></i>
					</div>
					<h5 class="mb-1 fw-bold text-dark">{{ $trainingType->name }}</h5>
					<p class="text-muted mb-4 fs-13">Training Category</p>
					
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('training.types.edit', $trainingType->id) }}" class="btn btn-primary rounded-pill shadow-sm py-2">
							<i class="ti ti-edit me-2"></i>Edit Training Type
						</a>
						@if($trainingType->trainings_count == 0)
							<form action="{{ route('training.types.destroy', $trainingType->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this training type?');">
								@csrf
								@method('DELETE')
								<button type="submit" class="btn btn-outline-danger rounded-pill shadow-sm py-2 w-100">
									<i class="ti ti-trash me-2"></i>Delete Training Type
								</button>
							</form>
						@else
							<button type="button" class="btn btn-outline-danger rounded-pill shadow-sm py-2 w-100 disabled" disabled title="Cannot delete training type with assigned trainings">
								<i class="ti ti-trash me-2"></i>Delete Training Type
							</button>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

@extends('layouts.app')

@section('title', 'Trainer Details')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Trainer Details</h2>
			<p class="text-muted mb-0 fs-13">View complete trainer profile</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('trainers.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="row">
		<div class="col-md-8">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Trainer Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Name</label>
						</div>
						<div class="col-md-8">
							<p class="mb-0 fw-bold text-dark fs-15">{{ $trainer->name }}</p>
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Email</label>
						</div>
						<div class="col-md-8">
							<span class="text-dark">{{ $trainer->email }}</span>
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Phone</label>
						</div>
						<div class="col-md-8">
							<span class="text-dark">{{ $trainer->phone ?? 'N/A' }}</span>
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Status</label>
						</div>
						<div class="col-md-8">
							@if($trainer->is_active)
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
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Expertise</label>
						</div>
						<div class="col-md-8">
							<span class="text-dark">{{ $trainer->expertise ?? 'N/A' }}</span>
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Bio</label>
						</div>
						<div class="col-md-8">
							<p class="mb-0 text-muted">{{ $trainer->bio ?? 'N/A' }}</p>
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Total Trainings</label>
						</div>
						<div class="col-md-8">
							<div class="d-flex align-items-center gap-2">
								<span class="avatar avatar-xs bg-primary-transparent text-primary rounded-circle"><i class="ti ti-school fs-10"></i></span>
								<span class="fw-medium text-dark">{{ $trainer->trainings_count ?? 0 }}</span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Created At</label>
							<p class="mb-0 text-muted fs-13">{{ $trainer->created_at->format('d M Y h:i A') }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Updated At</label>
							<p class="mb-0 text-muted fs-13">{{ $trainer->updated_at->format('d M Y h:i A') }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body text-center p-4">
					<div class="avatar avatar-xxl bg-primary-transparent text-primary rounded-circle mb-3 mx-auto d-flex align-items-center justify-content-center fw-bold fs-30">
						{{ substr($trainer->name, 0, 1) }}
					</div>
					<h5 class="mb-1 fw-bold text-dark">{{ $trainer->name }}</h5>
					<p class="text-muted mb-4 fs-13">{{ $trainer->email }}</p>
					
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('trainers.edit', $trainer->id) }}" class="btn btn-primary rounded-pill shadow-sm py-2">
							<i class="ti ti-edit me-2"></i>Edit Trainer
						</a>
						<form action="{{ route('trainers.destroy', $trainer->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this trainer?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger rounded-pill shadow-sm py-2 w-100">
								<i class="ti ti-trash me-2"></i>Delete Trainer
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

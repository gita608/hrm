@extends('layouts.app')

@section('title', 'Holiday Details')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Holiday Details</h2>
			<p class="text-muted mb-0 fs-13">View holiday information</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('holidays.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="row">
		<div class="col-md-8">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Holiday Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row mb-4">
						<div class="col-md-6 border-end border-light">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Name</label>
							<p class="mb-0 fw-bold fs-15 text-dark mt-1">{{ $holiday->name }}</p>
						</div>
						<div class="col-md-6 ps-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Date</label>
							<p class="mb-0 fw-bold fs-15 text-dark mt-1">{{ $holiday->date->format('d M Y') }}</p>
						</div>
					</div>
					<div class="row mb-4">
						<div class="col-md-6">
							<div class="p-3 bg-light-50 rounded-3 border border-light h-100">
								<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-2">Type</label>
								<div class="mt-1">
									@if($holiday->type == 'national')
										<span class="badge bg-primary-transparent text-primary rounded-pill px-3 py-2">National Holiday</span>
									@elseif($holiday->type == 'regional')
										<span class="badge bg-info-transparent text-info rounded-pill px-3 py-2">Regional Holiday</span>
									@else
										<span class="badge bg-light text-dark border border-light-subtle rounded-pill px-3 py-2">Other</span>
									@endif
								</div>
							</div>
						</div>
						<div class="col-md-6 mt-3 mt-md-0">
							<div class="p-3 bg-light-50 rounded-3 border border-light h-100">
								<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-2">Status</label>
								<div class="mt-1">
									@if($holiday->is_active)
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
					</div>
					@if($holiday->description)
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-2">Description</label>
							<p class="mb-0 text-dark">{{ $holiday->description }}</p>
						</div>
					@endif
					<div class="row mt-4 pt-3 border-top border-light">
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Created At</label>
							<p class="mb-0 fw-medium text-dark">{{ $holiday->created_at->format('d M Y h:i A') }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Updated At</label>
							<p class="mb-0 fw-medium text-dark">{{ $holiday->updated_at->format('d M Y h:i A') }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden text-center p-4">
				<div class="avatar avatar-xxl bg-primary-transparent text-primary rounded-circle mb-3 mx-auto">
					<i class="ti ti-calendar-event fs-48"></i>
				</div>
				<h4 class="mb-1 text-dark fw-bold">{{ $holiday->name }}</h4>
				<p class="text-muted mb-4">{{ $holiday->date->format('l, d F Y') }}</p>
				
				<div class="d-grid gap-3">
					<a href="{{ route('holidays.edit', $holiday->id) }}" class="btn btn-primary rounded-pill py-2 shadow-sm">
						<i class="ti ti-edit me-2"></i>Edit Holiday
					</a>
					<form action="{{ route('holidays.destroy', $holiday->id) }}" method="POST" class="d-grid" onsubmit="return confirm('Are you sure you want to delete this holiday?');">
						@csrf
						@method('DELETE')
						<button type="submit" class="btn btn-outline-danger rounded-pill py-2">
							<i class="ti ti-trash me-2"></i>Delete Holiday
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection

@extends('layouts.app')

@section('title', 'Asset Details')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Asset Details</h2>
			<p class="text-muted mb-0 fs-13">View complete asset information</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('assets.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="row">
		<div class="col-md-8">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Asset Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Name</label>
						</div>
						<div class="col-md-8">
							<p class="mb-0 fw-bold text-dark fs-15">{{ $asset->name }}</p>
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Asset Code</label>
						</div>
						<div class="col-md-8">
							<span class="text-dark">{{ $asset->asset_code ?? 'N/A' }}</span>
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Category</label>
						</div>
						<div class="col-md-8">
							@if($asset->category)
								<span class="badge bg-light text-dark border rounded-pill">{{ $asset->category->name }}</span>
							@else
								<span class="text-muted">N/A</span>
							@endif
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Serial Number</label>
						</div>
						<div class="col-md-8">
							<span class="text-dark">{{ $asset->serial_number ?? 'N/A' }}</span>
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Status</label>
						</div>
						<div class="col-md-8">
							@if($asset->status == 'available')
								<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
									<i class="ti ti-point-filled me-1 fs-10"></i>Available
								</span>
							@elseif($asset->status == 'assigned')
								<span class="badge bg-info-transparent text-info rounded-pill d-inline-flex align-items-center px-2 py-1">
									<i class="ti ti-point-filled me-1 fs-10"></i>Assigned
								</span>
							@elseif($asset->status == 'maintenance')
								<span class="badge bg-warning-transparent text-warning rounded-pill d-inline-flex align-items-center px-2 py-1">
									<i class="ti ti-point-filled me-1 fs-10"></i>Maintenance
								</span>
							@else
								<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
									<i class="ti ti-point-filled me-1 fs-10"></i>Retired
								</span>
							@endif
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Assigned To</label>
						</div>
						<div class="col-md-8">
							@if($asset->assignedUser)
								<div class="d-flex align-items-center">
									<div class="avatar avatar-xs bg-light-subtle rounded-circle d-flex align-items-center justify-content-center me-2 border border-light shadow-sm text-primary fw-bold">
										{{ substr($asset->assignedUser->name, 0, 1) }}
									</div>
									<span class="fs-13 text-dark fw-medium">{{ $asset->assignedUser->name }}</span>
								</div>
							@else
								<span class="text-muted">Unassigned</span>
							@endif
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Purchase Price</label>
						</div>
						<div class="col-md-8">
							@if($asset->purchase_price)
								<span class="fw-medium text-dark">${{ number_format($asset->purchase_price, 2) }}</span>
							@else
								<span class="text-muted">N/A</span>
							@endif
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Purchase Date</label>
						</div>
						<div class="col-md-8">
							<span class="text-dark">{{ $asset->purchase_date ? $asset->purchase_date->format('M d, Y') : 'N/A' }}</span>
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Warranty Expiry Date</label>
						</div>
						<div class="col-md-8">
							<span class="text-dark">{{ $asset->warranty_expiry_date ? $asset->warranty_expiry_date->format('M d, Y') : 'N/A' }}</span>
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Location</label>
						</div>
						<div class="col-md-8">
							<span class="text-dark">{{ $asset->location ?? 'N/A' }}</span>
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Description</label>
						</div>
						<div class="col-md-8">
							<p class="mb-0 text-muted">{{ $asset->description ?? 'N/A' }}</p>
						</div>
					</div>
					@if($asset->notes)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Notes</label>
						</div>
						<div class="col-md-8">
							<p class="mb-0 text-muted">{{ $asset->notes }}</p>
						</div>
					</div>
					@endif
					<div class="row">
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Created At</label>
							<p class="mb-0 text-muted fs-13">{{ $asset->created_at->format('d M Y h:i A') }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Updated At</label>
							<p class="mb-0 text-muted fs-13">{{ $asset->updated_at->format('d M Y h:i A') }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body text-center p-4">
					<div class="avatar avatar-xxl bg-primary-transparent text-primary rounded-circle mb-3 mx-auto d-flex align-items-center justify-content-center">
						<i class="ti ti-package fs-48"></i>
					</div>
					<h5 class="mb-1 fw-bold text-dark">{{ $asset->name }}</h5>
					<p class="text-muted mb-4 fs-13">{{ $asset->category->name ?? 'No Category' }}</p>
					
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-primary rounded-pill shadow-sm py-2">
							<i class="ti ti-edit me-2"></i>Edit Asset
						</a>
						<form action="{{ route('assets.destroy', $asset->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this asset?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger rounded-pill shadow-sm py-2 w-100">
								<i class="ti ti-trash me-2"></i>Delete Asset
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

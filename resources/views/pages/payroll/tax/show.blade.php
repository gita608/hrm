@extends('layouts.app')

@section('title', 'Tax Bracket Details')

@section('content')

	<!-- Breadcrumb -->
	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Tax Bracket Details</h2>
			<p class="text-muted mb-0 fs-13">View detailed tax configuration</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('payroll.tax.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Breadcrumb -->
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-md-8">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Tax Bracket Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row mb-4">
						<div class="col-md-6 border-end border-light">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Name</label>
							<p class="mb-0 fw-bold fs-15 text-dark mt-1">{{ $tax->name }}</p>
						</div>
						<div class="col-md-6 ps-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Method</label>
							<div class="mt-1">
								<span class="badge bg-info-transparent text-info rounded-pill border border-info-transparent px-3 py-2">{{ ucfirst($tax->calculation_method) }}</span>
							</div>
						</div>
					</div>
					<div class="row mb-4">
						<div class="col-md-6">
							<div class="p-3 bg-light-50 rounded-3 border border-light h-100">
								<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-2">Income Range</label>
								<div class="d-flex align-items-center gap-2">
									<span class="fw-bold fs-15 text-dark">{{ number_format($tax->min_income, 2) }}</span>
									<i class="ti ti-arrow-right text-muted"></i>
									<span class="fw-bold fs-15 text-dark">{{ $tax->max_income ? number_format($tax->max_income, 2) : 'Above' }}</span>
								</div>
							</div>
						</div>
						<div class="col-md-6 mt-3 mt-md-0">
							<div class="p-3 bg-light-50 rounded-3 border border-light h-100">
								<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-2">Tax Rate</label>
								<p class="mb-0 fw-bolder fs-18 text-danger">{{ number_format($tax->tax_rate, 2) }}%</p>
							</div>
						</div>
					</div>
					<div class="row mb-4">
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Status</label>
							<div class="mt-1">
								@if($tax->is_active)
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
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Effective From</label>
							<p class="mb-0 fw-bold fs-15 text-dark mt-1">{{ $tax->effective_from->format('d M Y') }}</p>
						</div>
					</div>
					@if($tax->description)
						<div class="mt-4 pt-3 border-top border-light">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-2">Description</label>
							<p class="mb-0 text-dark bg-light-50 p-3 rounded-3">{{ $tax->description }}</p>
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
						<a href="{{ route('payroll.tax.edit', $tax->id) }}" class="btn btn-primary rounded-pill py-2 shadow-sm">
							<i class="ti ti-edit me-2"></i>Edit Tax Bracket
						</a>
						<form action="{{ route('payroll.tax.destroy', $tax->id) }}" method="POST" class="d-grid" onsubmit="return confirm('Are you sure?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger rounded-pill py-2">
								<i class="ti ti-trash me-2"></i>Delete
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

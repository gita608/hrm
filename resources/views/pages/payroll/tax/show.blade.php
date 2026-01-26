@extends('layouts.app')

@section('title', 'Tax Bracket Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Tax Bracket Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('payroll.tax.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5>Tax Bracket Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Name</label>
							<p class="mb-0 fw-semibold">{{ $tax->name }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">Calculation Method</label>
							<p class="mb-0"><span class="badge badge-info">{{ ucfirst($tax->calculation_method) }}</span></p>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Income Range</label>
							<p class="mb-0 fw-semibold">
								{{ number_format($tax->min_income, 2) }} - 
								{{ $tax->max_income ? number_format($tax->max_income, 2) : 'Above' }}
							</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">Tax Rate</label>
							<p class="mb-0 fw-semibold">{{ number_format($tax->tax_rate, 2) }}%</p>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Status</label>
							<p class="mb-0">
								@if($tax->is_active)
									<span class="badge badge-success">Active</span>
								@else
									<span class="badge badge-danger">Inactive</span>
								@endif
							</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">Effective From</label>
							<p class="mb-0 fw-semibold">{{ $tax->effective_from->format('d M Y') }}</p>
						</div>
					</div>
					@if($tax->description)
						<div class="mb-3">
							<label class="form-label text-muted">Description</label>
							<p class="mb-0">{{ $tax->description }}</p>
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
						<a href="{{ route('payroll.tax.edit', $tax->id) }}" class="btn btn-primary">
							<i class="ti ti-edit me-2"></i>Edit Tax Bracket
						</a>
						<form action="{{ route('payroll.tax.destroy', $tax->id) }}" method="POST" class="d-grid" onsubmit="return confirm('Are you sure?');">
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

@endsection

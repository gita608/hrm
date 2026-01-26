@extends('layouts.app')

@section('title', 'Payroll Item Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Payroll Item Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('payroll.items.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5>Payroll Item Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Name</label>
							<p class="mb-0 fw-semibold">{{ $payrollItem->name }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">Type</label>
							<p class="mb-0"><span class="badge badge-info">{{ ucfirst($payrollItem->type) }}</span></p>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Calculation Type</label>
							<p class="mb-0 fw-semibold">{{ ucfirst(str_replace('_', ' ', $payrollItem->calculation_type)) }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">Amount/Percentage</label>
							<p class="mb-0 fw-semibold">
								@if($payrollItem->calculation_type == 'percentage')
									{{ number_format($payrollItem->percentage, 2) }}%
								@else
									{{ number_format($payrollItem->amount ?? 0, 2) }}
								@endif
							</p>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Taxable</label>
							<p class="mb-0">
								@if($payrollItem->is_taxable)
									<span class="badge badge-warning">Yes</span>
								@else
									<span class="badge badge-secondary">No</span>
								@endif
							</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">Status</label>
							<p class="mb-0">
								@if($payrollItem->is_active)
									<span class="badge badge-success">Active</span>
								@else
									<span class="badge badge-danger">Inactive</span>
								@endif
							</p>
						</div>
					</div>
					@if($payrollItem->description)
						<div class="mb-3">
							<label class="form-label text-muted">Description</label>
							<p class="mb-0">{{ $payrollItem->description }}</p>
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
						<a href="{{ route('payroll.items.edit', $payrollItem->id) }}" class="btn btn-primary">
							<i class="ti ti-edit me-2"></i>Edit Item
						</a>
						<form action="{{ route('payroll.items.destroy', $payrollItem->id) }}" method="POST" class="d-grid" onsubmit="return confirm('Are you sure?');">
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

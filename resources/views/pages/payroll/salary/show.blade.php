@extends('layouts.app')

@section('title', 'Salary Details')

@section('content')

	<!-- Breadcrumb -->
	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Salary Details</h2>
			<p class="text-muted mb-0 fs-13">View detailed salary breakdown</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('payroll.salary.index') }}" class="btn btn-light rounded-pill border shadow-sm">
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
					<h5 class="mb-0 fw-bold text-dark">Salary Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row mb-4">
						<div class="col-md-6 border-end border-light">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Employee</label>
							<div class="d-flex align-items-center mt-1">
								<div class="avatar avatar-sm bg-primary-transparent text-primary rounded-circle me-2 fw-bold">
									{{ strtoupper(substr($salary->employee->name ?? 'U', 0, 1)) }}
								</div>
								<p class="mb-0 fw-bold fs-15 text-dark">{{ $salary->employee->name ?? 'N/A' }}</p>
							</div>
						</div>
						<div class="col-md-6 ps-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Status</label>
							<div class="mt-1">
								@if($salary->status == 'active')
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
								<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-2">Basic Salary</label>
								<p class="mb-0 fw-bold fs-18 text-dark">{{ number_format($salary->basic_salary, 2) }}</p>
							</div>
						</div>
						<div class="col-md-6 mt-3 mt-md-0">
							<div class="p-3 bg-light-50 rounded-3 border border-light h-100">
								<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-2">Gross Salary</label>
								<p class="mb-0 fw-bold fs-18 text-dark">{{ number_format($salary->gross_salary, 2) }}</p>
							</div>
						</div>
					</div>
					<div class="row mb-4">
						<div class="col-md-6">
							<div class="p-3 bg-danger-transparent rounded-3 border border-danger-transparent h-100">
								<label class="form-label text-danger fs-12 text-uppercase fw-medium mb-2">Total Deductions</label>
								<p class="mb-0 fw-bold fs-18 text-danger">{{ number_format($salary->total_deductions, 2) }}</p>
							</div>
						</div>
						<div class="col-md-6 mt-3 mt-md-0">
							<div class="p-3 bg-primary-transparent rounded-3 border border-primary-transparent h-100">
								<label class="form-label text-primary fs-12 text-uppercase fw-bold mb-2">Net Salary</label>
								<p class="mb-0 fw-bolder fs-24 text-primary">{{ number_format($salary->net_salary, 2) }}</p>
							</div>
						</div>
					</div>
					@if($salary->notes)
						<div class="mt-4 pt-3 border-top border-light">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-2">Notes</label>
							<p class="mb-0 text-dark bg-light-50 p-3 rounded-3">{{ $salary->notes }}</p>
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
						<a href="{{ route('payroll.salary.edit', $salary->id) }}" class="btn btn-primary rounded-pill py-2 shadow-sm">
							<i class="ti ti-edit me-2"></i>Edit Salary
						</a>
						<form action="{{ route('payroll.salary.destroy', $salary->id) }}" method="POST" class="d-grid" onsubmit="return confirm('Are you sure you want to delete this salary?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger rounded-pill py-2">
								<i class="ti ti-trash me-2"></i>Delete Salary
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

@extends('layouts.app')

@section('title', 'Salary Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Salary Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('payroll.salary.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5>Salary Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Employee</label>
							<p class="mb-0 fw-semibold">{{ $salary->employee->name ?? 'N/A' }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">Status</label>
							<p class="mb-0">
								@if($salary->status == 'active')
									<span class="badge badge-success">Active</span>
								@else
									<span class="badge badge-danger">Inactive</span>
								@endif
							</p>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Basic Salary</label>
							<p class="mb-0 fw-semibold">{{ number_format($salary->basic_salary, 2) }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">Gross Salary</label>
							<p class="mb-0 fw-semibold">{{ number_format($salary->gross_salary, 2) }}</p>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Total Deductions</label>
							<p class="mb-0 fw-semibold">{{ number_format($salary->total_deductions, 2) }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">Net Salary</label>
							<p class="mb-0 fw-semibold fs-18 text-primary">{{ number_format($salary->net_salary, 2) }}</p>
						</div>
					</div>
					@if($salary->notes)
						<div class="mb-3">
							<label class="form-label text-muted">Notes</label>
							<p class="mb-0">{{ $salary->notes }}</p>
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
						<a href="{{ route('payroll.salary.edit', $salary->id) }}" class="btn btn-primary">
							<i class="ti ti-edit me-2"></i>Edit Salary
						</a>
						<form action="{{ route('payroll.salary.destroy', $salary->id) }}" method="POST" class="d-grid" onsubmit="return confirm('Are you sure?');">
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

@extends('layouts.app')

@section('title', 'Provident Fund Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Provident Fund Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('payroll.provident-fund.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5>Provident Fund Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Employee</label>
							<p class="mb-0 fw-semibold">{{ $providentFund->employee->name ?? 'N/A' }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">Month/Year</label>
							<p class="mb-0 fw-semibold">{{ $providentFund->month }} {{ $providentFund->year }}</p>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Employee Contribution</label>
							<p class="mb-0 fw-semibold">{{ number_format($providentFund->employee_contribution, 2) }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">Employer Contribution</label>
							<p class="mb-0 fw-semibold">{{ number_format($providentFund->employer_contribution, 2) }}</p>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-12">
							<label class="form-label text-muted">Total Contribution</label>
							<p class="mb-0 fw-semibold fs-18 text-primary">{{ number_format($providentFund->total_contribution, 2) }}</p>
						</div>
					</div>
					@if($providentFund->notes)
						<div class="mb-3">
							<label class="form-label text-muted">Notes</label>
							<p class="mb-0">{{ $providentFund->notes }}</p>
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
						<a href="{{ route('payroll.provident-fund.edit', $providentFund->id) }}" class="btn btn-primary">
							<i class="ti ti-edit me-2"></i>Edit Contribution
						</a>
						<form action="{{ route('payroll.provident-fund.destroy', $providentFund->id) }}" method="POST" class="d-grid" onsubmit="return confirm('Are you sure?');">
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

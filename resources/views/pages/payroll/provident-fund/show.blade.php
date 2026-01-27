@extends('layouts.app')

@section('title', 'Provident Fund Details')

@section('content')

	<!-- Breadcrumb -->
	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Provident Fund Details</h2>
			<p class="text-muted mb-0 fs-13">View detailed contribution information</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('payroll.provident-fund.index') }}" class="btn btn-light rounded-pill border shadow-sm">
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
					<h5 class="mb-0 fw-bold text-dark">Contribution Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row mb-4">
						<div class="col-md-6 border-end border-light">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Employee</label>
							<div class="d-flex align-items-center mt-1">
								<div class="avatar avatar-sm bg-primary-transparent text-primary rounded-circle me-2 fw-bold">
									{{ strtoupper(substr($providentFund->employee->name ?? 'U', 0, 1)) }}
								</div>
								<p class="mb-0 fw-bold fs-15 text-dark">{{ $providentFund->employee->name ?? 'N/A' }}</p>
							</div>
						</div>
						<div class="col-md-6 ps-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Period</label>
							<p class="mb-0 fw-bold fs-15 text-dark mt-1">{{ $providentFund->month }} {{ $providentFund->year }}</p>
						</div>
					</div>
					<div class="row mb-4">
						<div class="col-md-6">
							<div class="p-3 bg-light-50 rounded-3 border border-light">
								<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-2">Employee Share</label>
								<p class="mb-0 fw-bold fs-18 text-dark">{{ number_format($providentFund->employee_contribution, 2) }}</p>
							</div>
						</div>
						<div class="col-md-6 mt-3 mt-md-0">
							<div class="p-3 bg-light-50 rounded-3 border border-light">
								<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-2">Employer Share</label>
								<p class="mb-0 fw-bold fs-18 text-dark">{{ number_format($providentFund->employer_contribution, 2) }}</p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="p-4 bg-primary-transparent rounded-4 border border-primary-transparent text-center">
								<label class="form-label text-primary fs-13 text-uppercase fw-bold mb-2">Total Contribution</label>
								<p class="mb-0 fw-bolder display-6 text-primary">{{ number_format($providentFund->total_contribution, 2) }}</p>
							</div>
						</div>
					</div>
					@if($providentFund->notes)
						<div class="mt-4 pt-3 border-top border-light">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-2">Notes</label>
							<p class="mb-0 text-dark bg-light-50 p-3 rounded-3">{{ $providentFund->notes }}</p>
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
						<a href="{{ route('payroll.provident-fund.edit', $providentFund->id) }}" class="btn btn-primary rounded-pill py-2 shadow-sm">
							<i class="ti ti-edit me-2"></i>Edit Contribution
						</a>
						<form action="{{ route('payroll.provident-fund.destroy', $providentFund->id) }}" method="POST" class="d-grid" onsubmit="return confirm('Are you sure you want to delete this contribution?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger rounded-pill py-2">
								<i class="ti ti-trash me-2"></i>Delete Contribution
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

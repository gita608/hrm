@extends('layouts.app')

@section('title', 'Taxes')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Tax Brackets</h2>
			<p class="text-muted mb-0 fs-13">Configure tax rules and deduction percentages</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('payroll.tax.create') }}" class="btn btn-primary d-flex align-items-center rounded-pill shadow-sm">
				<i class="ti ti-plus me-2"></i>Add Tax Bracket
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	@if(session('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			{{ session('success') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-0 d-flex align-items-center justify-content-between pt-3 pb-2">
			<h5 class="mb-0 fw-bold text-dark">Tax Brackets List</h5>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="bg-light-50">
						<tr>
							<th class="ps-3 border-0 text-muted fs-12 fw-medium text-uppercase">#</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Name</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Income Range</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Tax Rate</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Method</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($taxes as $tax)
							<tr class="border-bottom border-light">
								<td class="ps-3 text-muted">{{ $loop->iteration }}</td>
								<td><span class="text-dark fw-medium">{{ $tax->name }}</span></td>
								<td>
									<div class="d-flex align-items-center gap-1">
										<span class="badge bg-light text-muted border border-light-subtle">{{ number_format($tax->min_income, 2) }}</span>
										<i class="ti ti-arrow-right fs-10 text-muted"></i>
										<span class="badge bg-light text-muted border border-light-subtle">{{ $tax->max_income ? number_format($tax->max_income, 2) : 'Above' }}</span>
									</div>
								</td>
								<td><span class="text-danger fw-bold">{{ number_format($tax->tax_rate, 2) }}%</span></td>
								<td><span class="badge bg-info-transparent text-info rounded-pill">{{ ucfirst($tax->calculation_method) }}</span></td>
								<td>
									@if($tax->is_active)
										<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Active
										</span>
									@else
										<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Inactive
										</span>
									@endif
								</td>
								<td class="pe-3 text-end">
									<div class="d-flex justify-content-end gap-2">
										<a href="{{ route('payroll.tax.show', $tax->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all" data-bs-toggle="tooltip" title="View">
											<i class="ti ti-eye"></i>
										</a>
										<a href="{{ route('payroll.tax.edit', $tax->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-info hover-text-white transition-all" data-bs-toggle="tooltip" title="Edit">
											<i class="ti ti-edit"></i>
										</a>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="7" class="text-center py-5">
									<div class="d-flex flex-column align-items-center">
										<div class="avatar avatar-xxl bg-light-50 rounded-circle mb-3 text-muted">
											<i class="ti ti-receipt-tax fs-30"></i>
										</div>
										<h6 class="text-muted mb-0">No tax brackets found</h6>
									</div>
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

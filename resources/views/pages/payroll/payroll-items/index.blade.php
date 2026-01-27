@extends('layouts.app')

@section('title', 'Payroll Items')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Payroll Items</h2>
			<p class="text-muted mb-0 fs-13">Manage additions, deductions and other payroll components</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('payroll.items.create') }}" class="btn btn-primary d-flex align-items-center rounded-pill shadow-sm">
				<i class="ti ti-plus me-2"></i>Add Item
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
			<h5 class="mb-0 fw-bold text-dark">Payroll Items List</h5>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="bg-light-50">
						<tr>
							<th class="ps-3 border-0 text-muted fs-12 fw-medium text-uppercase">#</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Name</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Type</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Calculation</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Amount/Perc</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Taxable</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($payrollItems as $item)
							<tr class="border-bottom border-light">
								<td class="ps-3 text-muted">{{ $loop->iteration }}</td>
								<td>
									<span class="text-dark fw-medium">{{ $item->name }}</span>
								</td>
								<td>
									<span class="badge bg-info-transparent text-info rounded-pill border border-info-transparent">{{ ucfirst($item->type) }}</span>
								</td>
								<td class="text-muted">{{ ucfirst(str_replace('_', ' ', $item->calculation_type)) }}</td>
								<td class="fw-medium text-dark">
									@if($item->calculation_type == 'percentage')
										{{ number_format($item->percentage, 2) }}%
									@else
										{{ number_format($item->amount ?? 0, 2) }}
									@endif
								</td>
								<td>
									@if($item->is_taxable)
										<div class="d-flex align-items-center">
											<i class="ti ti-check text-success me-1"></i>
											<span class="text-success fs-13">Yes</span>
										</div>
									@else
										<div class="d-flex align-items-center">
											<i class="ti ti-x text-muted me-1"></i>
											<span class="text-muted fs-13">No</span>
										</div>
									@endif
								</td>
								<td>
									@if($item->is_active)
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
										<a href="{{ route('payroll.items.show', $item->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all" data-bs-toggle="tooltip" title="View">
											<i class="ti ti-eye"></i>
										</a>
										<a href="{{ route('payroll.items.edit', $item->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-info hover-text-white transition-all" data-bs-toggle="tooltip" title="Edit">
											<i class="ti ti-edit"></i>
										</a>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="8" class="text-center py-5">
									<div class="d-flex flex-column align-items-center">
										<div class="avatar avatar-xxl bg-light-50 rounded-circle mb-3 text-muted">
											<i class="ti ti-files fs-30"></i>
										</div>
										<h6 class="text-muted mb-0">No payroll items found</h6>
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

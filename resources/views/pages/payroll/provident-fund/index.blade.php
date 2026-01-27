@extends('layouts.app')

@section('title', 'Provident Fund')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Provident Fund</h2>
			<p class="text-muted mb-0 fs-13">View and manage provident fund contributions</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('payroll.provident-fund.create') }}" class="btn btn-primary d-flex align-items-center rounded-pill shadow-sm">
				<i class="ti ti-plus me-2"></i>Add Contribution
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
			<h5 class="mb-0 fw-bold text-dark">Contribution List</h5>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="bg-light-50">
						<tr>
							<th class="ps-3 border-0 text-muted fs-12 fw-medium text-uppercase">#</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Employee</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Month/Year</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Employee Share</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Employer Share</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Total</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($providentFunds as $pf)
							<tr class="border-bottom border-light">
								<td class="ps-3 text-muted">{{ $loop->iteration }}</td>
								<td>
									<div class="d-flex align-items-center">
										<div class="avatar avatar-sm bg-success-transparent text-success rounded-circle me-2 fw-bold">
											{{ strtoupper(substr($pf->employee->name ?? 'U', 0, 1)) }}
										</div>
										<span class="text-dark fw-medium">{{ $pf->employee->name ?? 'N/A' }}</span>
									</div>
								</td>
								<td>
									<span class="badge bg-light text-dark border border-light-subtle rounded-pill">{{ $pf->month }} {{ $pf->year }}</span>
								</td>
								<td class="text-muted">{{ number_format($pf->employee_contribution, 2) }}</td>
								<td class="text-muted">{{ number_format($pf->employer_contribution, 2) }}</td>
								<td><strong class="text-primary">{{ number_format($pf->total_contribution, 2) }}</strong></td>
								<td class="pe-3 text-end">
									<div class="d-flex justify-content-end gap-2">
										<a href="{{ route('payroll.provident-fund.show', $pf->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all" data-bs-toggle="tooltip" title="View">
											<i class="ti ti-eye"></i>
										</a>
										<a href="{{ route('payroll.provident-fund.edit', $pf->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-info hover-text-white transition-all" data-bs-toggle="tooltip" title="Edit">
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
											<i class="ti ti-piggy-bank fs-30"></i>
										</div>
										<h6 class="text-muted mb-0">No contributions found</h6>
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

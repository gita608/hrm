@extends('layouts.app')

@section('title', 'Promotions')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Promotions</h2>
			<p class="text-muted mb-0 fs-13">Manage employee promotions and role changes</p>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
			<a href="{{ route('promotions.create') }}" class="btn btn-primary d-flex align-items-center rounded-pill shadow-sm">
				<i class="ti ti-circle-plus me-2 fs-4"></i>Add Promotion
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	@if(session('success'))
		<div class="alert alert-success alert-dismissible fade show border-0 bg-success-transparent text-success rounded-3 mb-4" role="alert">
			<div class="d-flex align-items-center">
				<i class="ti ti-check-circle me-2 fs-5"></i>
				<div>{{ session('success') }}</div>
			</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2 d-flex align-items-center justify-content-between flex-wrap row-gap-3">
			<h5 class="mb-0 fw-bold text-dark">Promotions List</h5>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="bg-light-50 border-bottom border-light">
						<tr>
							<th class="ps-4 py-3 text-muted fs-12 fw-medium text-uppercase">#</th>
							<th class="py-3 text-muted fs-12 fw-medium text-uppercase">Employee</th>
							<th class="py-3 text-muted fs-12 fw-medium text-uppercase">Department</th>
							<th class="py-3 text-muted fs-12 fw-medium text-uppercase">Designation</th>
							<th class="py-3 text-muted fs-12 fw-medium text-uppercase">Promotion Date</th>
							<th class="py-3 text-muted fs-12 fw-medium text-uppercase">Salary Increase</th>
							<th class="pe-4 py-3 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($promotions as $promotion)
							<tr>
								<td class="ps-4">{{ $loop->iteration }}</td>
								<td>
									<div class="d-flex align-items-center">
										<div class="avatar avatar-sm bg-primary-transparent text-primary rounded-circle me-2 d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px;">
											{{ strtoupper(substr($promotion->employee->name ?? 'U', 0, 1)) }}
										</div>
										<span class="text-dark fw-medium">{{ $promotion->employee->name ?? 'N/A' }}</span>
									</div>
								</td>
								<td>
									<div class="d-flex flex-column">
										<span class="text-dark fw-medium fs-13">{{ $promotion->toDepartment->name ?? 'N/A' }}</span>
										<span class="text-muted fs-11">From: {{ $promotion->fromDepartment->name ?? 'N/A' }}</span>
									</div>
								</td>
								<td>
									<div class="d-flex flex-column">
										<span class="text-dark fw-medium fs-13">{{ $promotion->toDesignation->name ?? 'N/A' }}</span>
										<span class="text-muted fs-11">From: {{ $promotion->fromDesignation->name ?? 'N/A' }}</span>
									</div>
								</td>
								<td><span class="text-muted">{{ $promotion->promotion_date->format('M d, Y') }}</span></td>
								<td>
									<span class="text-success fw-medium">+{{ $promotion->salary ? number_format($promotion->salary, 2) : '0' }}</span>
								</td>
								<td class="pe-4 text-end">
									<div class="d-flex justify-content-end gap-1">
										<a href="{{ route('promotions.show', $promotion->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all" data-bs-toggle="tooltip" title="View Details">
											<i class="ti ti-eye"></i>
										</a>
										<a href="{{ route('promotions.edit', $promotion->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-info hover-text-white transition-all" data-bs-toggle="tooltip" title="Edit">
											<i class="ti ti-edit"></i>
										</a>
										<form action="{{ route('promotions.destroy', $promotion->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this promotion?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-danger hover-text-white transition-all" data-bs-toggle="tooltip" title="Delete">
												<i class="ti ti-trash"></i>
											</button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="7" class="text-center py-5">
									<div class="d-flex flex-column align-items-center justify-content-center">
										<div class="avatar avatar-xl bg-light rounded-circle mb-3">
											<i class="ti ti-award fs-1 text-muted"></i>
										</div>
										<h5 class="text-muted mb-1">No Promotions found</h5>
										<p class="text-muted small mb-0">Record employee promotions to see them here.</p>
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

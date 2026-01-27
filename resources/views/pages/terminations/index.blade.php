@extends('layouts.app')

@section('title', 'Terminations')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Terminations</h2>
			<p class="text-muted mb-0 fs-13">Manage employee terminations and exits</p>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
			<a href="{{ route('terminations.create') }}" class="btn btn-primary d-flex align-items-center rounded-pill shadow-sm">
				<i class="ti ti-circle-plus me-2 fs-4"></i>Add Termination
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
			<h5 class="mb-0 fw-bold text-dark">Terminations List</h5>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="bg-light-50 border-bottom border-light">
						<tr>
							<th class="ps-4 py-3 text-muted fs-12 fw-medium text-uppercase">#</th>
							<th class="py-3 text-muted fs-12 fw-medium text-uppercase">Employee</th>
							<th class="py-3 text-muted fs-12 fw-medium text-uppercase">Termination Date</th>
							<th class="py-3 text-muted fs-12 fw-medium text-uppercase">Notice Date</th>
							<th class="py-3 text-muted fs-12 fw-medium text-uppercase">Type</th>
							<th class="pe-4 py-3 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($terminations as $termination)
							<tr>
								<td class="ps-4">{{ $loop->iteration }}</td>
								<td>
									<div class="d-flex align-items-center">
										<div class="avatar avatar-sm bg-danger-transparent text-danger rounded-circle me-2 d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px;">
											{{ strtoupper(substr($termination->employee->name ?? 'U', 0, 1)) }}
										</div>
										<span class="text-dark fw-medium">{{ $termination->employee->name ?? 'N/A' }}</span>
									</div>
								</td>
								<td><span class="text-muted">{{ $termination->termination_date->format('M d, Y') }}</span></td>
								<td><span class="text-muted">{{ $termination->notice_date ? $termination->notice_date->format('M d, Y') : 'N/A' }}</span></td>
								<td>
									@if($termination->type == 'voluntary')
										<span class="badge bg-info-transparent text-info rounded-pill px-2 py-1">Voluntary</span>
									@elseif($termination->type == 'involuntary')
										<span class="badge bg-danger-transparent text-danger rounded-pill px-2 py-1">Involuntary</span>
									@elseif($termination->type == 'retirement')
										<span class="badge bg-success-transparent text-success rounded-pill px-2 py-1">Retirement</span>
									@elseif($termination->type == 'end_of_contract')
										<span class="badge bg-warning-transparent text-warning rounded-pill px-2 py-1">End of Contract</span>
									@else
										<span class="badge bg-secondary-transparent text-secondary rounded-pill px-2 py-1">Other</span>
									@endif
								</td>
								<td class="pe-4 text-end">
									<div class="d-flex justify-content-end gap-1">
										<a href="{{ route('terminations.show', $termination->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all" data-bs-toggle="tooltip" title="View Details">
											<i class="ti ti-eye"></i>
										</a>
										<a href="{{ route('terminations.edit', $termination->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-info hover-text-white transition-all" data-bs-toggle="tooltip" title="Edit">
											<i class="ti ti-edit"></i>
										</a>
										<form action="{{ route('terminations.destroy', $termination->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this termination?');">
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
								<td colspan="6" class="text-center py-5">
									<div class="d-flex flex-column align-items-center justify-content-center">
										<div class="avatar avatar-xl bg-light rounded-circle mb-3">
											<i class="ti ti-user-x fs-1 text-muted"></i>
										</div>
										<h5 class="text-muted mb-1">No Terminations found</h5>
										<p class="text-muted small mb-0">Record employee terminations to see them here.</p>
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

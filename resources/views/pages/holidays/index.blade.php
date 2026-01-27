@extends('layouts.app')

@section('title', 'Holidays')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Holidays</h2>
			<p class="text-muted mb-0 fs-13">Manage company holidays and events</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('holidays.create') }}" class="btn btn-primary rounded-pill shadow-sm py-2">
				<i class="ti ti-plus me-1"></i>Add Holiday
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

	<div class="row mb-4">
		<!-- Total Holidays -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body p-4">
					<div class="d-flex align-items-center justify-content-between">
						<div>
							<p class="text-muted fw-medium mb-1 fs-13">Total Holidays</p>
							<h3 class="mb-0 fw-bold text-dark">{{ $holidays->count() }}</h3>
						</div>
						<div class="avatar avatar-lg bg-primary-transparent text-primary rounded-circle">
							<i class="ti ti-calendar-event fs-24"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Total Holidays -->

		<!-- Upcoming -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body p-4">
					<div class="d-flex align-items-center justify-content-between">
						<div>
							<p class="text-muted fw-medium mb-1 fs-13">Upcoming</p>
							<h3 class="mb-0 fw-bold text-dark">{{ $holidays->where('date', '>=', now())->count() }}</h3>
						</div>
						<div class="avatar avatar-lg bg-info-transparent text-info rounded-circle">
							<i class="ti ti-clock-hour-4 fs-24"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Upcoming -->

		<!-- Active -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body p-4">
					<div class="d-flex align-items-center justify-content-between">
						<div>
							<p class="text-muted fw-medium mb-1 fs-13">Active</p>
							<h3 class="mb-0 fw-bold text-dark">{{ $holidays->where('is_active', true)->count() }}</h3>
						</div>
						<div class="avatar avatar-lg bg-success-transparent text-success rounded-circle">
							<i class="ti ti-check fs-24"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Active -->
	</div>

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-0 d-flex align-items-center justify-content-between pt-3 pb-2 flex-wrap row-gap-3">
			<h5 class="mb-0 fw-bold text-dark">Holidays List</h5>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="bg-light-50">
						<tr>
							<th class="ps-3 border-0 text-muted fs-12 fw-medium text-uppercase" style="width: 50px;">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="select-all">
								</div>
							</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">#</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Title</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Date</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Description</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($holidays as $holiday)
							<tr class="border-bottom border-light">
								<td class="ps-3">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="{{ $holiday->id }}">
									</div>
								</td>
								<td class="text-muted">{{ $loop->iteration }}</td>
								<td>
									<span class="text-dark fw-bold">{{ $holiday->name }}</span>
								</td>
								<td class="text-dark">{{ $holiday->date->format('d M Y') }}</td>
								<td class="text-muted fs-13">{{ Str::limit($holiday->description ?? 'N/A', 50) }}</td>
								<td>
									@if($holiday->is_active)
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
										<a href="{{ route('holidays.show', $holiday->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all" data-bs-toggle="tooltip" title="View">
											<i class="ti ti-eye"></i>
										</a>
										<a href="{{ route('holidays.edit', $holiday->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-info hover-text-white transition-all" data-bs-toggle="tooltip" title="Edit">
											<i class="ti ti-edit"></i>
										</a>
										<form action="{{ route('holidays.destroy', $holiday->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this holiday?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-danger hover-text-white transition-all" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="7" class="text-center py-5">
									<div class="d-flex flex-column align-items-center">
										<div class="avatar avatar-xxl bg-light-50 rounded-circle mb-3 text-muted">
											<i class="ti ti-calendar-off fs-30"></i>
										</div>
										<h6 class="text-muted mb-0">No holidays found</h6>
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

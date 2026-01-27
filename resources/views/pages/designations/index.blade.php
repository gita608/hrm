@extends('layouts.app')

@section('title', 'Designations')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Designations</h2>
			<p class="text-muted mb-0 fs-13">Manage job roles and designations</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('designations.create') }}" class="btn btn-primary d-flex align-items-center rounded-pill shadow-sm">
				<i class="ti ti-plus me-2"></i>Add Designation
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
		<!-- Total Designations -->
		<div class="col-lg-4 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body p-4">
					<div class="d-flex align-items-center justify-content-between">
						<div>
							<p class="text-muted fw-medium mb-1 fs-13">Total Designations</p>
							<h3 class="mb-0 fw-bold text-dark">{{ $designations->count() }}</h3>
						</div>
						<div class="avatar avatar-lg bg-info-transparent text-info rounded-circle">
							<i class="ti ti-briefcase fs-24"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Total Designations -->

		<!-- Active Designations -->
		<div class="col-lg-4 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body p-4">
					<div class="d-flex align-items-center justify-content-between">
						<div>
							<p class="text-muted fw-medium mb-1 fs-13">Active</p>
							<h3 class="mb-0 fw-bold text-dark">{{ $designations->where('is_active', true)->count() }}</h3>
						</div>
						<div class="avatar avatar-lg bg-success-transparent text-success rounded-circle">
							<i class="ti ti-check fs-24"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Active Designations -->

		<!-- Inactive Designations -->
		<div class="col-lg-4 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body p-4">
					<div class="d-flex align-items-center justify-content-between">
						<div>
							<p class="text-muted fw-medium mb-1 fs-13">Inactive</p>
							<h3 class="mb-0 fw-bold text-dark">{{ $designations->where('is_active', false)->count() }}</h3>
						</div>
						<div class="avatar avatar-lg bg-danger-transparent text-danger rounded-circle">
							<i class="ti ti-x fs-24"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Inactive Designations -->
	</div>

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-0 d-flex align-items-center justify-content-between pt-3 pb-2 flex-wrap row-gap-3">
			<h5 class="mb-0 fw-bold text-dark">Designation List</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('designations.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
					<div>
						<select name="status" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none">
							<option value="">All Status</option>
							<option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
							<option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
						</select>
					</div>
					<div>
						<select name="department_id" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none">
							<option value="">All Departments</option>
							@foreach($departments as $dept)
								<option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="d-flex gap-2">
						<button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">Filter</button>
						@if(request()->hasAny(['status', 'department_id']))
							<a href="{{ route('designations.index') }}" class="btn btn-sm btn-light rounded-pill px-3">Clear</a>
						@endif
					</div>
				</form>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="bg-light-50">
						<tr>
							<th class="ps-3 border-0 text-muted fs-12 fw-medium text-uppercase">#</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Name</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Code</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Department</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Description</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($designations as $designation)
							<tr class="border-bottom border-light">
								<td class="ps-3 text-muted">{{ $loop->iteration }}</td>
								<td><strong class="text-dark fw-bold">{{ $designation->name }}</strong></td>
								<td class="text-muted">{{ $designation->code ?? 'N/A' }}</td>
								<td>
									@if($designation->department)
										<div class="d-flex align-items-center">
											<div class="avatar avatar-xs bg-primary-transparent text-primary rounded-circle me-2 fw-bold">
												{{ strtoupper(substr($designation->department->name, 0, 1)) }}
											</div>
											<span class="text-dark">{{ $designation->department->name }}</span>
										</div>
									@else
										<span class="text-muted">N/A</span>
									@endif
								</td>
								<td class="text-muted fs-13">{{ Str::limit($designation->description ?? 'N/A', 40) }}</td>
								<td>
									@if($designation->is_active)
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
										<a href="{{ route('designations.show', $designation->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all" data-bs-toggle="tooltip" title="View">
											<i class="ti ti-eye"></i>
										</a>
										<a href="{{ route('designations.edit', $designation->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-info hover-text-white transition-all" data-bs-toggle="tooltip" title="Edit">
											<i class="ti ti-edit"></i>
										</a>
										<form action="{{ route('designations.destroy', $designation->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this designation?');">
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
											<i class="ti ti-briefcase-off fs-30"></i>
										</div>
										<h6 class="text-muted mb-0">No designations found</h6>
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

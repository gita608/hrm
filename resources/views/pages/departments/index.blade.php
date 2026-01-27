@extends('layouts.app')

@section('title', 'Departments')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Departments</h2>
			<p class="text-muted mb-0 fs-13">Manage organization departments and structure</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('departments.create') }}" class="btn btn-primary d-flex align-items-center rounded-pill shadow-sm">
				<i class="ti ti-plus me-2"></i>Add Department
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
		<!-- Total Departments -->
		<div class="col-lg-4 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body p-4">
					<div class="d-flex align-items-center justify-content-between">
						<div>
							<p class="text-muted fw-medium mb-1 fs-13">Total Departments</p>
							<h3 class="mb-0 fw-bold text-dark">{{ $departments->count() }}</h3>
						</div>
						<div class="avatar avatar-lg bg-primary-transparent text-primary rounded-circle">
							<i class="ti ti-building fs-24"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Total Departments -->

		<!-- Active Departments -->
		<div class="col-lg-4 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body p-4">
					<div class="d-flex align-items-center justify-content-between">
						<div>
							<p class="text-muted fw-medium mb-1 fs-13">Active</p>
							<h3 class="mb-0 fw-bold text-dark">{{ $departments->where('is_active', true)->count() }}</h3>
						</div>
						<div class="avatar avatar-lg bg-success-transparent text-success rounded-circle">
							<i class="ti ti-check fs-24"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Active Departments -->

		<!-- Inactive Departments -->
		<div class="col-lg-4 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body p-4">
					<div class="d-flex align-items-center justify-content-between">
						<div>
							<p class="text-muted fw-medium mb-1 fs-13">Inactive</p>
							<h3 class="mb-0 fw-bold text-dark">{{ $departments->where('is_active', false)->count() }}</h3>
						</div>
						<div class="avatar avatar-lg bg-danger-transparent text-danger rounded-circle">
							<i class="ti ti-x fs-24"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Inactive Departments -->
	</div>

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-0 d-flex align-items-center justify-content-between pt-3 pb-2 flex-wrap row-gap-3">
			<h5 class="mb-0 fw-bold text-dark">Department List</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('departments.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
					<div>
						<select name="status" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none">
							<option value="">All Status</option>
							<option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
							<option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
						</select>
					</div>
					<div>
						<select name="manager_id" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none">
							<option value="">All Managers</option>
							@foreach($managers as $manager)
								<option value="{{ $manager->id }}" {{ request('manager_id') == $manager->id ? 'selected' : '' }}>{{ $manager->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="d-flex gap-2">
						<button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">Filter</button>
						@if(request()->hasAny(['status', 'manager_id']))
							<a href="{{ route('departments.index') }}" class="btn btn-sm btn-light rounded-pill px-3">Clear</a>
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
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Manager</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Description</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($departments as $department)
							<tr class="border-bottom border-light">
								<td class="ps-3 text-muted">{{ $loop->iteration }}</td>
								<td><strong class="text-dark fw-bold">{{ $department->name }}</strong></td>
								<td class="text-muted">{{ $department->code ?? 'N/A' }}</td>
								<td>
									@if($department->manager)
									<div class="d-flex align-items-center">
										<div class="avatar avatar-xs bg-primary-transparent text-primary rounded-circle me-2 fw-bold">
											{{ strtoupper(substr($department->manager->name, 0, 1)) }}
										</div>
										<span class="text-dark">{{ $department->manager->name }}</span>
									</div>
									@else
										<span class="text-muted">N/A</span>
									@endif
								</td>
								<td class="text-muted fs-13">{{ Str::limit($department->description ?? 'N/A', 40) }}</td>
								<td>
									@if($department->is_active)
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
										<a href="{{ route('departments.show', $department->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all" data-bs-toggle="tooltip" title="View">
											<i class="ti ti-eye"></i>
										</a>
										<a href="{{ route('departments.edit', $department->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-info hover-text-white transition-all" data-bs-toggle="tooltip" title="Edit">
											<i class="ti ti-edit"></i>
										</a>
										<form action="{{ route('departments.destroy', $department->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this department?');">
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
											<i class="ti ti-building-off fs-30"></i>
										</div>
										<h6 class="text-muted mb-0">No departments found</h6>
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

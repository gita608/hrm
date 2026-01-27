@extends('layouts.app')

@section('title', 'Roles & Permissions')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Roles & Permissions</h2>
			<p class="text-muted mb-0 fs-13">Manage user roles and access control</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('roles.create') }}" class="btn btn-primary rounded-pill shadow-sm py-2 px-3">
				<i class="ti ti-plus me-2"></i>Add Role
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

	@if(session('error'))
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			{{ session('error') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	<div class="row">
		<!-- Total Roles -->
		<div class="col-lg-4 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden position-relative">
				<div class="card-body d-flex align-items-center justify-content-between p-4">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-xl bg-primary-transparent text-primary rounded-circle shadow-sm"><i class="ti ti-user-star fs-24"></i></span>
						</div>
						<div class="ms-3 overflow-hidden">
							<p class="fs-13 fw-medium mb-1 text-muted text-truncate text-uppercase ls-1">Total Roles</p>
							<h4 class="mb-0 fw-bold text-dark">{{ $roles->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Total Roles -->

		<!-- Active Roles -->
		<div class="col-lg-4 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden position-relative">
				<div class="card-body d-flex align-items-center justify-content-between p-4">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-xl bg-success-transparent text-success rounded-circle shadow-sm"><i class="ti ti-check fs-24"></i></span>
						</div>
						<div class="ms-3 overflow-hidden">
							<p class="fs-13 fw-medium mb-1 text-muted text-truncate text-uppercase ls-1">Active Roles</p>
							<h4 class="mb-0 fw-bold text-dark">{{ $roles->where('is_active', true)->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Active Roles -->

		<!-- Inactive Roles -->
		<div class="col-lg-4 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden position-relative">
				<div class="card-body d-flex align-items-center justify-content-between p-4">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-xl bg-danger-transparent text-danger rounded-circle shadow-sm"><i class="ti ti-x fs-24"></i></span>
						</div>
						<div class="ms-3 overflow-hidden">
							<p class="fs-13 fw-medium mb-1 text-muted text-truncate text-uppercase ls-1">Inactive Roles</p>
							<h4 class="mb-0 fw-bold text-dark">{{ $roles->where('is_active', false)->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Inactive Roles -->
	</div>

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2 d-flex align-items-center justify-content-between flex-wrap gap-3">
			<h5 class="mb-0 fw-bold text-dark">Role List</h5>
			<div class="d-flex align-items-center gap-2 flex-wrap">
				<form method="GET" action="{{ route('roles.index') }}" class="d-flex gap-2 flex-wrap align-items-center">
					<div>
						<select name="status" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" onchange="this.form.submit()">
							<option value="">All Status</option>
							<option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
							<option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
						</select>
					</div>
					@if(request()->has('status'))
						<a href="{{ route('roles.index') }}" class="btn btn-sm btn-light rounded-pill px-3 shadow-none">Clear</a>
					@endif
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
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Slug</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Description</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Users</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($roles as $role)
							<tr class="border-bottom border-light">
								<td class="ps-3 text-muted fs-12">{{ $loop->iteration }}</td>
								<td><strong class="text-dark">{{ $role->name }}</strong></td>
								<td><code class="text-primary bg-light-subtle px-2 py-1 rounded">{{ $role->slug }}</code></td>
								<td class="text-muted fs-13">{{ Str::limit($role->description ?? 'N/A', 50) }}</td>
								<td class="text-dark fs-13">
									<span class="badge bg-light text-dark border rounded-pill">{{ $role->users()->count() }} Users</span>
								</td>
								<td>
									@if($role->is_active)
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
										<a href="{{ route('roles.show', $role->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="View">
											<i class="ti ti-eye"></i>
										</a>
										<a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="Edit">
											<i class="ti ti-edit"></i>
										</a>
										<form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-danger hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="Delete">
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
										<div class="avatar avatar-xxl bg-light-50 rounded-circle mb-3 text-muted">
											<i class="ti ti-user-x fs-30"></i>
										</div>
										<p class="text-muted mb-0">No roles found.</p>
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

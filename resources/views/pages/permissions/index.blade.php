@extends('layouts.app')

@section('title', 'Menu Permissions')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Menu Permissions</h2>
			<p class="text-muted mb-0 fs-13">Assign menu access to different user roles</p>
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
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
			<h5 class="mb-0 fw-bold text-dark">Role Access Control</h5>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="bg-light-50">
						<tr>
							<th class="ps-3 border-0 text-muted fs-12 fw-medium text-uppercase">#</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Role Name</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Description</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase text-center">Assigned Menus</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($roles as $role)
							<tr class="border-bottom border-light">
								<td class="ps-3 text-muted fs-12">{{ $loop->iteration }}</td>
								<td><strong class="text-dark">{{ $role->name }}</strong></td>
								<td class="text-muted fs-13">{{ Str::limit($role->description ?? 'N/A', 100) }}</td>
								<td class="text-center">
									<span class="badge bg-primary-transparent text-primary rounded-pill px-3 shadow-none">
										{{ $role->menuItems()->count() }} Menus
									</span>
								</td>
								<td class="pe-3 text-end">
									<a href="{{ route('permissions.edit', $role->id) }}" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm d-inline-flex align-items-center">
										<i class="ti ti-shield-lock me-2"></i> Manage Permissions
									</a>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="5" class="text-center py-5">
									<div class="d-flex flex-column align-items-center justify-content-center">
										<p class="text-muted mb-0">No active roles found.</p>
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

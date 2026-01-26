@extends('layouts.app')

@section('title', 'Users')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Users</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<a href="{{ route('users.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add User</a>
			</div>
			<div class="head-icons ms-2">
				<a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header">
					<i class="ti ti-chevrons-up"></i>
				</a>
			</div>
		</div>
	</div>
	<!-- /Breadcrumb -->

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
		<!-- Total Users -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-lg bg-primary rounded-circle"><i class="ti ti-users"></i></span>
						</div>
						<div class="ms-2 overflow-hidden">
							<p class="fs-12 fw-medium mb-1 text-truncate">Total Users</p>
							<h4>{{ $users->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Total Users -->

		<!-- Verified Users -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-lg bg-success rounded-circle"><i class="ti ti-check"></i></span>
						</div>
						<div class="ms-2 overflow-hidden">
							<p class="fs-12 fw-medium mb-1 text-truncate">Verified</p>
							<h4>{{ $users->whereNotNull('email_verified_at')->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Verified Users -->

		<!-- Unverified Users -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-lg bg-warning rounded-circle"><i class="ti ti-alert-circle"></i></span>
						</div>
						<div class="ms-2 overflow-hidden">
							<p class="fs-12 fw-medium mb-1 text-truncate">Unverified</p>
							<h4>{{ $users->whereNull('email_verified_at')->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Unverified Users -->
	</div>

	<div class="card">
		<div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
			<h5>User List</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('users.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
					<div>
						<select name="status" class="form-select form-select-sm">
							<option value="">All Status</option>
							<option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
							<option value="unverified" {{ request('status') == 'unverified' ? 'selected' : '' }}>Unverified</option>
						</select>
					</div>
					<div>
						<select name="role_id" class="form-select form-select-sm">
							<option value="">All Roles</option>
							@foreach($roles as $role)
								<option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<button type="submit" class="btn btn-sm btn-primary">Filter</button>
						@if(request()->hasAny(['status', 'role_id']))
							<a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-light border">Clear</a>
						@endif
					</div>
				</form>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="custom-datatable-filter table-responsive">
				<table class="table datatable">
					<thead class="thead-light">
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Email</th>
							<th>Role</th>
							<th>Phone</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($users as $user)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>
									<div class="d-flex align-items-center">
										@if($user->profile_picture)
											<span class="avatar avatar-sm me-2">
												<img src="{{ asset('storage/' . $user->profile_picture) }}" alt="User" class="img-fluid rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
											</span>
										@else
											<span class="avatar avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="font-size: 0.875rem; font-weight: 600;">
												{{ strtoupper(substr($user->name, 0, 1)) }}
											</span>
										@endif
										<strong>{{ $user->name }}</strong>
									</div>
								</td>
								<td>{{ $user->email }}</td>
								<td>
									@if($user->role)
										<span class="badge badge-info">{{ $user->role->name }}</span>
									@else
										<span class="text-muted">N/A</span>
									@endif
								</td>
								<td>{{ $user->phone ?? 'N/A' }}</td>
								<td>
									@if($user->email_verified_at)
										<span class="badge badge-success d-inline-flex align-items-center badge-xs">
											<i class="ti ti-point-filled me-1"></i>Verified
										</span>
									@else
										<span class="badge badge-warning d-inline-flex align-items-center badge-xs">
											<i class="ti ti-point-filled me-1"></i>Unverified
										</span>
									@endif
								</td>
								<td>
									<div class="action-icon d-inline-flex">
										<a href="{{ route('users.show', $user->id) }}" class="me-2" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('users.edit', $user->id) }}" class="me-2" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										@if($user->id !== auth()->id())
											<form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
												@csrf
												@method('DELETE')
												<button type="submit" class="btn btn-link p-0 text-danger" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
											</form>
										@endif
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="7" class="text-center">No users found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

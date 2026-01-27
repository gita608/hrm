@extends('layouts.app')

@section('title', 'User Management')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">User Management</h2>
			<p class="text-muted mb-0 fs-13">Manage and monitor all system user accounts and permissions</p>
		</div>
		<div class="d-flex align-items-center gap-2 flex-wrap mt-md-0 mt-3">
			<a href="{{ route('users.create') }}" class="btn btn-primary d-flex align-items-center rounded-pill px-4 shadow-sm fw-600">
                <i class="ti ti-circle-plus me-2 fs-16"></i>Add New User
            </a>
		</div>
	</div>
	<!-- /Page Header -->

	@if(session('success'))
		<div class="alert alert-success border-0 shadow-sm rounded-4 alert-dismissible fade show mb-4 d-flex align-items-center" role="alert">
			<i class="ti ti-circle-check-filled me-2 fs-20"></i>
            <div>{{ session('success') }}</div>
			<button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

    @if(session('error'))
		<div class="alert alert-danger border-0 shadow-sm rounded-4 alert-dismissible fade show mb-4 d-flex align-items-center" role="alert">
			<i class="ti ti-alert-circle me-2 fs-20"></i>
            <div>{{ session('error') }}</div>
			<button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	<div class="row g-4 mb-4">
		<!-- Total Users -->
		<div class="col-lg-4 col-md-6">
			<div class="card border-0 shadow-sm rounded-4 flex-fill overflow-hidden stat-card">
				<div class="card-body p-4">
					<div class="d-flex align-items-center justify-content-between">
						<div>
							<p class="fs-13 fw-medium text-muted mb-1">Total System Users</p>
							<h2 class="fw-bold mb-0">{{ $users->count() }}</h2>
						</div>
						<div class="stat-icon bg-primary-transparent rounded-4 p-3 d-flex align-items-center justify-content-center">
							<i class="ti ti-users fs-24 text-primary"></i>
						</div>
					</div>
                    <div class="mt-3">
                        <span class="text-success fw-medium fs-12"><i class="ti ti-arrow-up-right me-1"></i>Active account base</span>
                    </div>
				</div>
                <div class="stat-progress bg-primary" style="height: 4px; width: 100%; opacity: 0.1;"></div>
			</div>
		</div>
		<!-- /Total Users -->

		<!-- Verified Users -->
		<div class="col-lg-4 col-md-6">
			<div class="card border-0 shadow-sm rounded-4 flex-fill overflow-hidden stat-card">
				<div class="card-body p-4">
					<div class="d-flex align-items-center justify-content-between">
						<div>
							<p class="fs-13 fw-medium text-muted mb-1">Verified Identities</p>
							<h2 class="fw-bold mb-0 text-success">{{ $users->whereNotNull('email_verified_at')->count() }}</h2>
						</div>
						<div class="stat-icon bg-success-transparent rounded-4 p-3 d-flex align-items-center justify-content-center">
							<i class="ti ti-shield-check fs-24 text-success"></i>
						</div>
					</div>
                    <div class="mt-3">
                        @php
                            $total = $users->count() ?: 1;
                            $verified = $users->whereNotNull('email_verified_at')->count();
                            $percent = round(($verified / $total) * 100);
                        @endphp
                        <span class="text-muted fs-12 fw-medium">{{ $percent }}% of total users verified</span>
                    </div>
				</div>
                <div class="stat-progress bg-success" style="height: 4px; width: {{ $percent }}%; opacity: 0.2;"></div>
			</div>
		</div>
		<!-- /Verified Users -->

		<!-- Unverified Users -->
		<div class="col-lg-4 col-md-6">
			<div class="card border-0 shadow-sm rounded-4 flex-fill overflow-hidden stat-card">
				<div class="card-body p-4">
					<div class="d-flex align-items-center justify-content-between">
						<div>
							<p class="fs-13 fw-medium text-muted mb-1">Pending Verification</p>
							<h2 class="fw-bold mb-0 text-warning">{{ $users->whereNull('email_verified_at')->count() }}</h2>
						</div>
						<div class="stat-icon bg-warning-transparent rounded-4 p-3 d-flex align-items-center justify-content-center">
							<i class="ti ti-help-hexagon fs-24 text-warning"></i>
						</div>
					</div>
                    <div class="mt-3">
                        <span class="text-muted fs-12 fw-medium">Requires administrative action</span>
                    </div>
				</div>
                <div class="stat-progress bg-warning" style="height: 4px; width: 100%; opacity: 0.1;"></div>
			</div>
		</div>
		<!-- /Unverified Users -->
	</div>

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-white py-4 d-flex align-items-center justify-content-between flex-wrap row-gap-3 border-bottom border-light">
			<h5 class="fw-bold mb-0 border-start border-4 border-primary ps-3">Directory Records</h5>
			<div class="d-flex align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('users.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
					<div class="filter-select shadow-sm rounded-pill overflow-hidden border">
						<select name="status" class="form-select border-0 px-3 fs-13" style="min-width: 140px;">
							<option value="">Status Filter</option>
							<option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified Only</option>
							<option value="unverified" {{ request('status') == 'unverified' ? 'selected' : '' }}>Unverified Only</option>
						</select>
					</div>
					<div class="filter-select shadow-sm rounded-pill overflow-hidden border ms-md-2">
						<select name="role_id" class="form-select border-0 px-3 fs-13" style="min-width: 140px;">
							<option value="">All Job Roles</option>
							@foreach($roles as $role)
								<option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="ms-md-2 mt-md-0 mt-2">
						<button type="submit" class="btn btn-primary btn-icon rounded-circle shadow-sm" data-bs-toggle="tooltip" title="Apply Filters">
                            <i class="ti ti-filter"></i>
                        </button>
						@if(request()->hasAny(['status', 'role_id']))
							<a href="{{ route('users.index') }}" class="btn btn-outline-light border rounded-circle ms-1 p-2 shadow-sm" data-bs-toggle="tooltip" title="Reset">
                                <i class="ti ti-refresh text-muted"></i>
                            </a>
						@endif
					</div>
				</form>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table datatable table-hover align-middle mb-0">
					<thead class="bg-light-50">
						<tr>
							<th class="ps-4 py-3 text-uppercase fs-11 fw-bold text-muted">Ref</th>
							<th class="py-3 text-uppercase fs-11 fw-bold text-muted">Personnel Identity</th>
							<th class="py-3 text-uppercase fs-11 fw-bold text-muted">Email Communications</th>
							<th class="py-3 text-uppercase fs-11 fw-bold text-muted text-center">Designation Role</th>
							<th class="py-3 text-uppercase fs-11 fw-bold text-muted">Contact Info</th>
							<th class="py-3 text-uppercase fs-11 fw-bold text-muted text-center">Status</th>
							<th class="py-3 text-uppercase fs-11 fw-bold text-muted text-center pe-4">Manage</th>
						</tr>
					</thead>
					<tbody class="border-top-0">
						@forelse($users as $user)
							<tr>
								<td class="ps-4"><span class="text-muted fs-12 pb-0">#{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</span></td>
								<td>
									<div class="d-flex align-items-center">
										@if($user->profile_picture)
											<div class="avatar avatar-md border border-light p-1 shadow-sm rounded-circle me-3">
												<img src="{{ asset('storage/' . $user->profile_picture) }}" alt="User" class="img-fluid rounded-circle w-100 h-100 object-fit-cover">
											</div>
										@else
											<div class="avatar avatar-md bg-primary-transparent border border-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm fw-600">
												{{ strtoupper(substr($user->name, 0, 1)) }}
											</div>
										@endif
										<div>
											<h6 class="mb-0 fw-bold text-dark fs-14">{{ $user->name }}</h6>
											<p class="fs-12 text-muted mb-0">Registered user</p>
										</div>
									</div>
								</td>
								<td>
                                    <div class="d-flex align-items-center">
                                        <i class="ti ti-mail me-2 text-muted fs-13"></i>
                                        <span class="fs-13 text-dark">{{ $user->email }}</span>
                                    </div>
                                </td>
								<td class="text-center">
									@if($user->role)
										<div class="badge bg-soft-info border border-info-subtle rounded-pill px-3 py-2 text-info fs-11 fw-bold">
                                            <i class="ti ti-briefcase-2 me-1"></i>{{ strtoupper($user->role->name) }}
                                        </div>
									@else
										<span class="text-muted opacity-50 fs-12 italic">No context</span>
									@endif
								</td>
								<td>
                                    <div class="d-flex align-items-center">
                                        <i class="ti ti-phone me-2 text-muted fs-13"></i>
                                        <span class="fs-13">{{ $user->phone ?? 'Not set' }}</span>
                                    </div>
                                </td>
								<td class="text-center">
									@if($user->email_verified_at)
										<span class="badge bg-success-transparent border border-success-subtle text-success rounded-pill px-3 py-2 fs-10 fw-800 text-uppercase tracking-wider">
											<i class="ti ti-shield-check me-1"></i>Verified
										</span>
									@else
										<span class="badge bg-warning-transparent border border-warning-subtle text-warning rounded-pill px-3 py-2 fs-10 fw-800 text-uppercase tracking-wider">
											<i class="ti ti-shield-x me-1"></i>Unverified
										</span>
									@endif
								</td>
								<td class="text-center pe-4">
									<div class="d-flex align-items-center justify-content-center gap-2">
										<a href="{{ route('users.show', $user->id) }}" class="btn btn-light btn-icon btn-sm rounded-pill shadow-sm hover-primary" data-bs-toggle="tooltip" title="Personnel Profile">
                                            <i class="ti ti-user-scan"></i>
                                        </a>
										<a href="{{ route('users.edit', $user->id) }}" class="btn btn-light btn-icon btn-sm rounded-pill shadow-sm hover-success" data-bs-toggle="tooltip" title="Adjust Records">
                                            <i class="ti ti-pencil"></i>
                                        </a>
										@if($user->id !== auth()->id())
											<form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('WARNING: Are you sure you want to permanently remove this personnel record?');">
												@csrf
												@method('DELETE')
												<button type="submit" class="btn btn-light btn-icon btn-sm rounded-pill shadow-sm hover-danger" data-bs-toggle="tooltip" title="Purge Record">
                                                    <i class="ti ti-trash-x"></i>
                                                </button>
											</form>
										@endif
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="7">
                                    <div class="p-5 text-center">
                                        <div class="bg-light-transparent rounded-circle p-4 d-inline-block mb-3">
                                            <i class="ti ti-users-off fs-40 text-muted"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark">No Personnel Found</h5>
                                        <p class="text-muted">The directory is currently empty or matches no filters.</p>
                                    </div>
                                </td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

    <style>
        .fs-10 { font-size: 10px; }
        .fs-11 { font-size: 11px; }
        .fs-13 { font-size: 13.5px; }
        .fw-600 { font-weight: 600; }
        .bg-light-50 { background-color: #f9fafb; }
        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-icon { width: 56px; height: 56px; transition: all 0.3s ease; }
        .stat-card:hover .stat-icon { transform: rotate(-5deg) scale(1.1); }
        
        /* Subtle Badge Effects */
        .bg-success-transparent { background-color: rgba(30, 190, 165, 0.08) !important; }
        .bg-warning-transparent { background-color: rgba(255, 152, 0, 0.08) !important; }
        .bg-primary-transparent { background-color: rgba(242, 101, 34, 0.08) !important; }
        .bg-success-transparent.border-success-subtle { border-color: rgba(30, 190, 165, 0.2) !important; }
        
        .bg-soft-info { background-color: rgba(0, 191, 255, 0.06); }
        
        .btn-icon { width: 34px; height: 34px; padding: 0; display: flex; align-items: center; justify-content: center; }
        .hover-primary:hover { border-color: #f26522 !important; color: #f26522 !important; background: rgba(242, 101, 34, 0.05) !important; }
        .hover-success:hover { border-color: #1ebea5 !important; color: #1ebea5 !important; background: rgba(30, 190, 165, 0.05) !important; }
        .hover-danger:hover { border-color: #ef4444 !important; color: #ef4444 !important; background: rgba(239, 68, 68, 0.05) !important; }
        
        .object-fit-cover { object-fit: cover; }
        .tracking-wider { letter-spacing: 0.5px; }
        
        .filter-select .form-select:focus { box-shadow: none; border-color: #f26522; }
    </style>

@endsection

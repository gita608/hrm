@extends('layouts.app')

@section('title', 'Assets')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Assets</h2>
			<p class="text-muted mb-0 fs-13">Track and manage company assets and equipment</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('assets.create') }}" class="btn btn-primary rounded-pill shadow-sm py-2 px-3">
				<i class="ti ti-plus me-2"></i>Add Asset
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
		<!-- Total Assets -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden position-relative">
				<div class="card-body d-flex align-items-center justify-content-between p-4">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-xl bg-primary-transparent text-primary rounded-circle shadow-sm"><i class="ti ti-package fs-24"></i></span>
						</div>
						<div class="ms-3 overflow-hidden">
							<p class="fs-13 fw-medium mb-1 text-muted text-truncate text-uppercase ls-1">Total Assets</p>
							<h4 class="mb-0 fw-bold text-dark">{{ $assets->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Total Assets -->

		<!-- Available Assets -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden position-relative">
				<div class="card-body d-flex align-items-center justify-content-between p-4">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-xl bg-success-transparent text-success rounded-circle shadow-sm"><i class="ti ti-check fs-24"></i></span>
						</div>
						<div class="ms-3 overflow-hidden">
							<p class="fs-13 fw-medium mb-1 text-muted text-truncate text-uppercase ls-1">Available</p>
							<h4 class="mb-0 fw-bold text-dark">{{ $assets->where('status', 'available')->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Available Assets -->

		<!-- Assigned Assets -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden position-relative">
				<div class="card-body d-flex align-items-center justify-content-between p-4">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-xl bg-info-transparent text-info rounded-circle shadow-sm"><i class="ti ti-user-check fs-24"></i></span>
						</div>
						<div class="ms-3 overflow-hidden">
							<p class="fs-13 fw-medium mb-1 text-muted text-truncate text-uppercase ls-1">Assigned</p>
							<h4 class="mb-0 fw-bold text-dark">{{ $assets->where('status', 'assigned')->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Assigned Assets -->

		<!-- Maintenance Assets -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden position-relative">
				<div class="card-body d-flex align-items-center justify-content-between p-4">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-xl bg-warning-transparent text-warning rounded-circle shadow-sm"><i class="ti ti-tools fs-24"></i></span>
						</div>
						<div class="ms-3 overflow-hidden">
							<p class="fs-13 fw-medium mb-1 text-muted text-truncate text-uppercase ls-1">Maintenance</p>
							<h4 class="mb-0 fw-bold text-dark">{{ $assets->where('status', 'maintenance')->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Maintenance Assets -->
	</div>

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2 d-flex align-items-center justify-content-between flex-wrap gap-3">
			<h5 class="mb-0 fw-bold text-dark">Asset List</h5>
			<div class="d-flex align-items-center gap-2 flex-wrap">
				<form method="GET" action="{{ route('assets.index') }}" class="d-flex gap-2 flex-wrap align-items-center">
					<div>
						<select name="status" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" onchange="this.form.submit()">
							<option value="">All Status</option>
							<option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
							<option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>Assigned</option>
							<option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
							<option value="retired" {{ request('status') == 'retired' ? 'selected' : '' }}>Retired</option>
						</select>
					</div>
					<div>
						<select name="category_id" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" onchange="this.form.submit()">
							<option value="">All Categories</option>
							@foreach($categories as $category)
								<option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<select name="assigned_to" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" onchange="this.form.submit()">
							<option value="">All Users</option>
							@foreach($users as $user)
								<option value="{{ $user->id }}" {{ request('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
							@endforeach
						</select>
					</div>
					@if(request()->hasAny(['status', 'category_id', 'assigned_to']))
						<a href="{{ route('assets.index') }}" class="btn btn-sm btn-light rounded-pill px-3 shadow-none">Clear</a>
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
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Asset Code</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Category</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Serial Number</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Assigned To</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Purchase Price</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($assets as $asset)
							<tr class="border-bottom border-light">
								<td class="ps-3 text-muted fs-12">{{ $loop->iteration }}</td>
								<td><strong class="text-dark">{{ $asset->name }}</strong></td>
								<td class="text-muted fs-13">{{ $asset->asset_code ?? 'N/A' }}</td>
								<td>
									@if($asset->category)
										<span class="badge bg-light text-dark border rounded-pill">{{ $asset->category->name }}</span>
									@else
										<span class="text-muted">N/A</span>
									@endif
								</td>
								<td class="text-muted fs-13">{{ $asset->serial_number ?? 'N/A' }}</td>
								<td>
									@if($asset->assignedUser)
										<div class="d-flex align-items-center">
											<div class="avatar avatar-xs bg-light-subtle rounded-circle d-flex align-items-center justify-content-center me-2 border border-light shadow-sm text-primary fw-bold">
												{{ substr($asset->assignedUser->name, 0, 1) }}
											</div>
											<span class="fs-13 text-dark">{{ $asset->assignedUser->name }}</span>
										</div>
									@else
										<span class="text-muted">Unassigned</span>
									@endif
								</td>
								<td>
									@if($asset->status == 'available')
										<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Available
										</span>
									@elseif($asset->status == 'assigned')
										<span class="badge bg-info-transparent text-info rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Assigned
										</span>
									@elseif($asset->status == 'maintenance')
										<span class="badge bg-warning-transparent text-warning rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Maintenance
										</span>
									@else
										<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Retired
										</span>
									@endif
								</td>
								<td class="text-dark fs-13">
									@if($asset->purchase_price)
										${{ number_format($asset->purchase_price, 2) }}
									@else
										N/A
									@endif
								</td>
								<td class="pe-3 text-end">
									<div class="d-flex justify-content-end gap-2">
										<a href="{{ route('assets.show', $asset->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="View">
											<i class="ti ti-eye"></i>
										</a>
										<a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="Edit">
											<i class="ti ti-edit"></i>
										</a>
										<form action="{{ route('assets.destroy', $asset->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this asset?');">
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
								<td colspan="9" class="text-center py-5">
									<div class="d-flex flex-column align-items-center justify-content-center">
										<div class="avatar avatar-xxl bg-light-50 rounded-circle mb-3 text-muted">
											<i class="ti ti-package-off fs-30"></i>
										</div>
										<p class="text-muted mb-0">No assets found.</p>
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

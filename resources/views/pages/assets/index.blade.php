@extends('layouts.app')

@section('title', 'Assets')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Assets</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<a href="{{ route('assets.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Asset</a>
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
		<!-- Total Assets -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-lg bg-primary rounded-circle"><i class="ti ti-package"></i></span>
						</div>
						<div class="ms-2 overflow-hidden">
							<p class="fs-12 fw-medium mb-1 text-truncate">Total Assets</p>
							<h4>{{ $assets->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Total Assets -->

		<!-- Available Assets -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-lg bg-success rounded-circle"><i class="ti ti-check"></i></span>
						</div>
						<div class="ms-2 overflow-hidden">
							<p class="fs-12 fw-medium mb-1 text-truncate">Available</p>
							<h4>{{ $assets->where('status', 'available')->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Available Assets -->

		<!-- Assigned Assets -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-lg bg-info rounded-circle"><i class="ti ti-user-check"></i></span>
						</div>
						<div class="ms-2 overflow-hidden">
							<p class="fs-12 fw-medium mb-1 text-truncate">Assigned</p>
							<h4>{{ $assets->where('status', 'assigned')->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Assigned Assets -->

		<!-- Maintenance Assets -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-lg bg-warning rounded-circle"><i class="ti ti-tools"></i></span>
						</div>
						<div class="ms-2 overflow-hidden">
							<p class="fs-12 fw-medium mb-1 text-truncate">Maintenance</p>
							<h4>{{ $assets->where('status', 'maintenance')->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Maintenance Assets -->
	</div>

	<div class="card">
		<div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
			<h5>Asset List</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('assets.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
					<div>
						<select name="status" class="form-select form-select-sm">
							<option value="">All Status</option>
							<option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
							<option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>Assigned</option>
							<option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
							<option value="retired" {{ request('status') == 'retired' ? 'selected' : '' }}>Retired</option>
						</select>
					</div>
					<div>
						<select name="category_id" class="form-select form-select-sm">
							<option value="">All Categories</option>
							@foreach($categories as $category)
								<option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<select name="assigned_to" class="form-select form-select-sm">
							<option value="">All Users</option>
							@foreach($users as $user)
								<option value="{{ $user->id }}" {{ request('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<button type="submit" class="btn btn-sm btn-primary">Filter</button>
						@if(request()->hasAny(['status', 'category_id', 'assigned_to']))
							<a href="{{ route('assets.index') }}" class="btn btn-sm btn-outline-light border">Clear</a>
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
							<th>Asset Code</th>
							<th>Category</th>
							<th>Serial Number</th>
							<th>Assigned To</th>
							<th>Status</th>
							<th>Purchase Price</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($assets as $asset)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td><strong>{{ $asset->name }}</strong></td>
								<td>{{ $asset->asset_code ?? 'N/A' }}</td>
								<td>
									@if($asset->category)
										<span class="badge badge-info">{{ $asset->category->name }}</span>
									@else
										<span class="text-muted">N/A</span>
									@endif
								</td>
								<td>{{ $asset->serial_number ?? 'N/A' }}</td>
								<td>
									@if($asset->assignedUser)
										{{ $asset->assignedUser->name }}
									@else
										<span class="text-muted">Unassigned</span>
									@endif
								</td>
								<td>
									@if($asset->status == 'available')
										<span class="badge badge-success d-inline-flex align-items-center badge-xs">
											<i class="ti ti-point-filled me-1"></i>Available
										</span>
									@elseif($asset->status == 'assigned')
										<span class="badge badge-info d-inline-flex align-items-center badge-xs">
											<i class="ti ti-point-filled me-1"></i>Assigned
										</span>
									@elseif($asset->status == 'maintenance')
										<span class="badge badge-warning d-inline-flex align-items-center badge-xs">
											<i class="ti ti-point-filled me-1"></i>Maintenance
										</span>
									@else
										<span class="badge badge-danger d-inline-flex align-items-center badge-xs">
											<i class="ti ti-point-filled me-1"></i>Retired
										</span>
									@endif
								</td>
								<td>
									@if($asset->purchase_price)
										${{ number_format($asset->purchase_price, 2) }}
									@else
										N/A
									@endif
								</td>
								<td>
									<div class="action-icon d-inline-flex">
										<a href="{{ route('assets.show', $asset->id) }}" class="me-2" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('assets.edit', $asset->id) }}" class="me-2" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										<form action="{{ route('assets.destroy', $asset->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this asset?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-link p-0 text-danger" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="9" class="text-center">No assets found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

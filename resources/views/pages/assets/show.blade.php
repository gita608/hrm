@extends('layouts.app')

@section('title', 'Asset Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Asset Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('assets.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5>Asset Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-4"><strong>Name:</strong></div>
						<div class="col-md-8">{{ $asset->name }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Asset Code:</strong></div>
						<div class="col-md-8">{{ $asset->asset_code ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Category:</strong></div>
						<div class="col-md-8">
							@if($asset->category)
								<span class="badge badge-info">{{ $asset->category->name }}</span>
							@else
								<span class="text-muted">N/A</span>
							@endif
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Serial Number:</strong></div>
						<div class="col-md-8">{{ $asset->serial_number ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Status:</strong></div>
						<div class="col-md-8">
							@if($asset->status == 'available')
								<span class="badge badge-success">Available</span>
							@elseif($asset->status == 'assigned')
								<span class="badge badge-info">Assigned</span>
							@elseif($asset->status == 'maintenance')
								<span class="badge badge-warning">Maintenance</span>
							@else
								<span class="badge badge-danger">Retired</span>
							@endif
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Assigned To:</strong></div>
						<div class="col-md-8">
							@if($asset->assignedUser)
								{{ $asset->assignedUser->name }}
							@else
								<span class="text-muted">Unassigned</span>
							@endif
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Purchase Price:</strong></div>
						<div class="col-md-8">
							@if($asset->purchase_price)
								${{ number_format($asset->purchase_price, 2) }}
							@else
								N/A
							@endif
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Purchase Date:</strong></div>
						<div class="col-md-8">{{ $asset->purchase_date ? $asset->purchase_date->format('M d, Y') : 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Warranty Expiry Date:</strong></div>
						<div class="col-md-8">{{ $asset->warranty_expiry_date ? $asset->warranty_expiry_date->format('M d, Y') : 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Location:</strong></div>
						<div class="col-md-8">{{ $asset->location ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Description:</strong></div>
						<div class="col-md-8">{{ $asset->description ?? 'N/A' }}</div>
					</div>
					@if($asset->notes)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Notes:</strong></div>
						<div class="col-md-8">{{ $asset->notes }}</div>
					</div>
					@endif
					<div class="row mb-3">
						<div class="col-md-4"><strong>Created At:</strong></div>
						<div class="col-md-8">{{ $asset->created_at->format('M d, Y H:i') }}</div>
					</div>
					<div class="row">
						<div class="col-md-4"><strong>Updated At:</strong></div>
						<div class="col-md-8">{{ $asset->updated_at->format('M d, Y H:i') }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body text-center">
					<div class="avatar avatar-xxl mb-3">
						<i class="ti ti-package fs-48 text-primary"></i>
					</div>
					<h4 class="mb-1">{{ $asset->name }}</h4>
					<p class="text-muted mb-2">{{ $asset->category->name ?? 'No Category' }}</p>
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-primary btn-sm">
							<i class="ti ti-edit me-2"></i>Edit Asset
						</a>
						<form action="{{ route('assets.destroy', $asset->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this asset?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger btn-sm w-100">
								<i class="ti ti-trash me-2"></i>Delete Asset
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

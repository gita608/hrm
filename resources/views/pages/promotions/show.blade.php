@extends('layouts.app')

@section('title', 'Promotion Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Promotion Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('promotions.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5>Promotion Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-4"><strong>Employee:</strong></div>
						<div class="col-md-8">{{ $promotion->employee->name ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Promotion Date:</strong></div>
						<div class="col-md-8">{{ $promotion->promotion_date->format('M d, Y') }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>From Department:</strong></div>
						<div class="col-md-8">{{ $promotion->fromDepartment->name ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>To Department:</strong></div>
						<div class="col-md-8">{{ $promotion->toDepartment->name ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>From Designation:</strong></div>
						<div class="col-md-8">{{ $promotion->fromDesignation->name ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>To Designation:</strong></div>
						<div class="col-md-8">{{ $promotion->toDesignation->name ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Salary:</strong></div>
						<div class="col-md-8">{{ $promotion->salary ? number_format($promotion->salary, 2) : 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Status:</strong></div>
						<div class="col-md-8">
							@if($promotion->is_active)
								<span class="badge badge-success">Active</span>
							@else
								<span class="badge badge-danger">Inactive</span>
							@endif
						</div>
					</div>
					@if($promotion->notes)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Notes:</strong></div>
						<div class="col-md-8">{{ $promotion->notes }}</div>
					</div>
					@endif
					<div class="row mb-3">
						<div class="col-md-4"><strong>Created At:</strong></div>
						<div class="col-md-8">{{ $promotion->created_at->format('M d, Y H:i') }}</div>
					</div>
					<div class="row">
						<div class="col-md-4"><strong>Updated At:</strong></div>
						<div class="col-md-8">{{ $promotion->updated_at->format('M d, Y H:i') }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body text-center">
					<div class="avatar avatar-xxl mb-3">
						<i class="ti ti-speakerphone fs-48 text-primary"></i>
					</div>
					<h4 class="mb-1">{{ $promotion->employee->name ?? 'N/A' }}</h4>
					<p class="text-muted mb-2">{{ $promotion->promotion_date->format('M d, Y') }}</p>
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('promotions.edit', $promotion->id) }}" class="btn btn-primary btn-sm">
							<i class="ti ti-edit me-2"></i>Edit Promotion
						</a>
						<form action="{{ route('promotions.destroy', $promotion->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this promotion?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger btn-sm w-100">
								<i class="ti ti-trash me-2"></i>Delete Promotion
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

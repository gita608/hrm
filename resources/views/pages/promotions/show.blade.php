@extends('layouts.app')

@section('title', 'Promotion Details')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Promotion Details</h2>
			<p class="text-muted mb-0 fs-13">View detailed promotion records</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('promotions.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="row">
		<div class="col-md-4 order-md-last">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-body text-center p-4">
					<div class="avatar avatar-xxl mb-3 bg-primary-transparent text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
						<i class="ti ti-speakerphone fs-36"></i>
					</div>
					<h4 class="mb-1 text-dark fw-bold">{{ $promotion->employee->name ?? 'N/A' }}</h4>
					<p class="text-muted mb-4 pt-1">Promoted on {{ $promotion->promotion_date->format('M d, Y') }}</p>

					@if($promotion->is_active)
						<div class="mb-4">
							<span class="badge bg-success-transparent text-success rounded-pill px-3 py-2 fs-12">Active Record</span>
						</div>
					@else
						<div class="mb-4">
							<span class="badge bg-danger-transparent text-danger rounded-pill px-3 py-2 fs-12">Inactive</span>
						</div>
					@endif

					<div class="d-flex flex-column gap-2">
						<a href="{{ route('promotions.edit', $promotion->id) }}" class="btn btn-primary rounded-pill shadow-sm py-2">
							<i class="ti ti-edit me-2"></i>Edit Promotion
						</a>
						<form action="{{ route('promotions.destroy', $promotion->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this promotion?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger rounded-pill w-100 py-2">
								<i class="ti ti-trash me-2"></i>Delete Promotion
							</button>
						</form>
					</div>
				</div>
			</div>
			
			@if($promotion->salary)
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Compensation</h5>
				</div>
				<div class="card-body p-4">
					<div class="d-flex align-items-center justify-content-between">
						<span class="text-muted fs-13 text-uppercase fw-medium">Salary Increase</span>
						<span class="text-success fw-bold fs-18">+{{ number_format($promotion->salary, 2) }}</span>
					</div>
				</div>
			</div>
			@endif
		</div>
		<div class="col-md-8">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Promotion Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Employee</div>
						<div class="col-md-8 text-dark fw-bold">{{ $promotion->employee->name ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Promotion Date</div>
						<div class="col-md-8 text-dark">{{ $promotion->promotion_date->format('M d, Y') }}</div>
					</div>
					
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Department Change</div>
						<div class="col-md-8">
							<div class="d-flex flex-column">
								<div class="d-flex align-items-center text-dark fw-medium mb-1">
									<i class="ti ti-arrow-right text-primary me-2"></i>
									{{ $promotion->toDepartment->name ?? 'N/A' }}
								</div>
								<div class="text-muted fs-13 ms-4">
									From: {{ $promotion->fromDepartment->name ?? 'N/A' }}
								</div>
							</div>
						</div>
					</div>
					
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Designation Change</div>
						<div class="col-md-8">
							<div class="d-flex flex-column">
								<div class="d-flex align-items-center text-dark fw-medium mb-1">
									<i class="ti ti-arrow-right text-primary me-2"></i>
									{{ $promotion->toDesignation->name ?? 'N/A' }}
								</div>
								<div class="text-muted fs-13 ms-4">
									From: {{ $promotion->fromDesignation->name ?? 'N/A' }}
								</div>
							</div>
						</div>
					</div>

					@if($promotion->notes)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Notes</div>
						<div class="col-md-8 text-dark bg-light-50 p-3 rounded-3 border-start border-3 border-primary">{{ $promotion->notes }}</div>
					</div>
					@endif
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Created At</div>
						<div class="col-md-8 text-muted">{{ $promotion->created_at->format('M d, Y H:i') }}</div>
					</div>
					<div class="row">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Updated At</div>
						<div class="col-md-8 text-muted">{{ $promotion->updated_at->format('M d, Y H:i') }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

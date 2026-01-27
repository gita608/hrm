@extends('layouts.app')

@section('title', 'Termination Details')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Termination Details</h2>
			<p class="text-muted mb-0 fs-13">View detailed termination records</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('terminations.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="row">
		<div class="col-md-4 order-md-last">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-body text-center p-4">
					<div class="avatar avatar-xxl mb-3 bg-danger-transparent text-danger rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
						<i class="ti ti-circle-x fs-36"></i>
					</div>
					<h4 class="mb-1 text-dark fw-bold">{{ $termination->employee->name ?? 'N/A' }}</h4>
					<p class="text-muted mb-4 pt-1">Terminated effective {{ $termination->termination_date->format('M d, Y') }}</p>

					<div class="d-flex flex-column gap-2">
						<a href="{{ route('terminations.edit', $termination->id) }}" class="btn btn-primary rounded-pill shadow-sm py-2">
							<i class="ti ti-edit me-2"></i>Edit Termination
						</a>
						<form action="{{ route('terminations.destroy', $termination->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this termination?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger rounded-pill w-100 py-2">
								<i class="ti ti-trash me-2"></i>Delete Termination
							</button>
						</form>
					</div>
				</div>
			</div>
			
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">UAE-Specific Info</h5>
				</div>
				<div class="card-body p-4">
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-5 text-muted fs-13 text-uppercase fw-medium">Visa Cancellation</div>
						<div class="col-md-7 text-end text-dark">{{ $termination->visa_cancellation_date ? $termination->visa_cancellation_date->format('M d, Y') : 'N/A' }}</div>
					</div>
					<div class="row">
						<div class="col-md-5 text-muted fs-13 text-uppercase fw-medium">Labor Card Cancel</div>
						<div class="col-md-7 text-end text-dark">{{ $termination->labor_card_cancellation_date ? $termination->labor_card_cancellation_date->format('M d, Y') : 'N/A' }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Termination Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Employee</div>
						<div class="col-md-8 text-dark fw-bold">{{ $termination->employee->name ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Termination Date</div>
						<div class="col-md-8 text-dark">{{ $termination->termination_date->format('M d, Y') }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Notice Date</div>
						<div class="col-md-8 text-dark">{{ $termination->notice_date ? $termination->notice_date->format('M d, Y') : 'N/A' }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Type</div>
						<div class="col-md-8">
							@if($termination->type == 'voluntary')
								<span class="badge bg-info-transparent text-info rounded-pill px-3 py-2 fs-12">Voluntary</span>
							@elseif($termination->type == 'involuntary')
								<span class="badge bg-danger-transparent text-danger rounded-pill px-3 py-2 fs-12">Involuntary</span>
							@elseif($termination->type == 'retirement')
								<span class="badge bg-success-transparent text-success rounded-pill px-3 py-2 fs-12">Retirement</span>
							@elseif($termination->type == 'end_of_contract')
								<span class="badge bg-warning-transparent text-warning rounded-pill px-3 py-2 fs-12">End of Contract</span>
							@else
								<span class="badge bg-secondary-transparent text-secondary rounded-pill px-3 py-2 fs-12">Other</span>
							@endif
						</div>
					</div>
					@if($termination->reason)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Reason</div>
						<div class="col-md-8 text-dark bg-light-50 p-3 rounded-3 border-start border-3 border-primary">{{ $termination->reason }}</div>
					</div>
					@endif
					@if($termination->notes)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Notes</div>
						<div class="col-md-8 text-dark">{{ $termination->notes }}</div>
					</div>
					@endif
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Created At</div>
						<div class="col-md-8 text-muted">{{ $termination->created_at->format('M d, Y H:i') }}</div>
					</div>
					<div class="row">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Updated At</div>
						<div class="col-md-8 text-muted">{{ $termination->updated_at->format('M d, Y H:i') }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

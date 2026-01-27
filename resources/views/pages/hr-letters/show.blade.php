@extends('layouts.app')

@section('title', 'View HR Letter')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">HR Letter Details</h2>
			<p class="text-muted mb-0 fs-13">View letter information and content</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('hr-letters.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="row">
		<div class="col-md-4">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-body text-center p-4">
					<div class="avatar avatar-xxl mb-3 bg-primary-transparent rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
						<i class="ti ti-file-certificate fs-36 text-primary"></i>
					</div>
					<h4 class="mb-1 text-dark fw-bold">{{ $letter->title }}</h4>
					<p class="text-muted mb-4 pt-1">{{ $letter->letter_number ?? 'No Letter Number' }}</p>

					@if($letter->status == 'issued')
						<span class="badge bg-success-transparent text-success rounded-pill px-3 py-2 mb-4">Issued</span>
					@elseif($letter->status == 'draft')
						<span class="badge bg-warning-transparent text-warning rounded-pill px-3 py-2 mb-4">Draft</span>
					@elseif($letter->status == 'cancelled')
						<span class="badge bg-danger-transparent text-danger rounded-pill px-3 py-2 mb-4">Cancelled</span>
					@else
						<span class="badge bg-info-transparent text-info rounded-pill px-3 py-2 mb-4">{{ ucfirst($letter->status) }}</span>
					@endif

					<div class="d-flex flex-column gap-2 mt-2">
						@if($letter->file_path)
							<a href="{{ asset('storage/' . $letter->file_path) }}" target="_blank" class="btn btn-primary rounded-pill shadow-sm py-2">
								<i class="ti ti-download me-2"></i>Download Letter
							</a>
						@endif
						<a href="{{ route('hr-letters.edit', $letter->id) }}" class="btn btn-light rounded-pill shadow-sm py-2 border">
							<i class="ti ti-edit me-2"></i>Edit Letter
						</a>
						<form action="{{ route('hr-letters.destroy', $letter->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this letter?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger rounded-pill w-100 py-2">
								<i class="ti ti-trash me-2"></i>Delete
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Letter Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Employee</div>
						<div class="col-md-8 text-dark fw-medium">{{ $letter->employee ? $letter->employee->name : 'N/A' }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Letter Type</div>
						<div class="col-md-8 text-dark">{{ ucfirst(str_replace('_', ' ', $letter->letter_type ?? 'N/A')) }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Issue Date</div>
						<div class="col-md-8 text-dark">{{ $letter->issue_date ? $letter->issue_date->format('d M, Y') : 'N/A' }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Issued By</div>
						<div class="col-md-8 text-dark">{{ $letter->issuer ? $letter->issuer->name : 'N/A' }}</div>
					</div>
					@if($letter->content)
						<div class="row mb-3 pb-3 border-bottom border-light">
							<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Content</div>
							<div class="col-md-8 text-dark text-break" style="white-space: pre-line;">{{ $letter->content }}</div>
						</div>
					@endif
					@if($letter->notes)
						<div class="row mb-3 pb-3 border-bottom border-light">
							<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Notes</div>
							<div class="col-md-8 text-dark">{{ $letter->notes }}</div>
						</div>
					@endif
					<div class="row">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Created At</div>
						<div class="col-md-8 text-muted">{{ $letter->created_at->format('M d, Y H:i') }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

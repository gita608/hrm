@extends('layouts.app')

@section('title', 'View Document')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Document Details</h2>
			<p class="text-muted mb-0 fs-13">View document information and status</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('documents.index') }}" class="btn btn-light rounded-pill border shadow-sm">
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
						<i class="ti ti-file-text fs-36 text-primary"></i>
					</div>
					<h4 class="mb-1 text-dark fw-bold">{{ $document->title }}</h4>
					<p class="text-muted mb-4 pt-1">{{ $document->document_number ?? 'No Doc Number' }}</p>

					@if($document->status == 'active')
						<span class="badge bg-success-transparent text-success rounded-pill px-3 py-2 mb-4">Active</span>
					@elseif($document->status == 'expired')
						<span class="badge bg-warning-transparent text-warning rounded-pill px-3 py-2 mb-4">Expired</span>
					@else
						<span class="badge bg-secondary-transparent text-secondary rounded-pill px-3 py-2 mb-4">Archived</span>
					@endif

					<div class="d-flex flex-column gap-2 mt-2">
						@if($document->file_path)
							<a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="btn btn-primary rounded-pill shadow-sm py-2">
								<i class="ti ti-download me-2"></i>Download Document
							</a>
						@endif
						<a href="{{ route('documents.edit', $document->id) }}" class="btn btn-light rounded-pill shadow-sm py-2 border">
							<i class="ti ti-edit me-2"></i>Edit Details
						</a>
						<form action="{{ route('documents.destroy', $document->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this document?');">
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
					<h5 class="mb-0 fw-bold text-dark">Document Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Employee</div>
						<div class="col-md-8 text-dark fw-medium">{{ $document->employee ? $document->employee->name : 'N/A' }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Category</div>
						<div class="col-md-8 text-dark">{{ $document->category ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Issue Date</div>
						<div class="col-md-8 text-dark">{{ $document->issue_date ? $document->issue_date->format('d M, Y') : 'N/A' }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Expiry Date</div>
						<div class="col-md-8 text-dark">{{ $document->expiry_date ? $document->expiry_date->format('d M, Y') : 'N/A' }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Uploaded By</div>
						<div class="col-md-8 text-dark">{{ $document->uploader ? $document->uploader->name : 'N/A' }}</div>
					</div>
					@if($document->description)
						<div class="row mb-3 pb-3 border-bottom border-light">
							<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Description</div>
							<div class="col-md-8 text-dark">{{ $document->description }}</div>
						</div>
					@endif
					@if($document->notes)
						<div class="row mb-3 pb-3 border-bottom border-light">
							<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Notes</div>
							<div class="col-md-8 text-dark">{{ $document->notes }}</div>
						</div>
					@endif
					<div class="row">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Created At</div>
						<div class="col-md-8 text-muted">{{ $document->created_at->format('M d, Y H:i') }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

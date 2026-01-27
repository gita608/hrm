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
						<i class="ti ti-file-certificate fs-36 text-primary"></i>
					</div>
					<h4 class="mb-1 text-dark fw-bold">{{ $document->title }}</h4>
					<p class="text-muted mb-4 pt-1 fs-12 text-uppercase ls-1">{{ $document->document_number ?? 'No Reference Number' }}</p>

					<div class="mb-4">
						@if($document->status == 'active')
							<span class="badge bg-success-transparent text-success rounded-pill px-3 py-2">
								<i class="ti ti-point-filled me-1"></i>Active
							</span>
						@elseif($document->status == 'expired')
							<span class="badge bg-danger-transparent text-danger rounded-pill px-3 py-2">
								<i class="ti ti-point-filled me-1"></i>Expired
							</span>
						@else
							<span class="badge bg-secondary-transparent text-secondary rounded-pill px-3 py-2">
								<i class="ti ti-point-filled me-1"></i>Archived
							</span>
						@endif
					</div>

					<div class="d-flex flex-column gap-2">
						@if($document->file_path)
							<a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="btn btn-primary rounded-pill shadow-sm py-2">
								<i class="ti ti-eye me-2"></i>View Document
							</a>
							<a href="{{ asset('storage/' . $document->file_path) }}" download class="btn btn-outline-primary rounded-pill shadow-none py-2 border-primary-subtle">
								<i class="ti ti-download me-2"></i>Download File
							</a>
						@endif
						<hr class="my-3 opacity-50">
						<a href="{{ route('documents.edit', $document->id) }}" class="btn btn-light rounded-pill shadow-sm py-2 border">
							<i class="ti ti-edit me-2"></i>Edit Details
						</a>
						<form action="{{ route('documents.destroy', $document->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this document?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-link text-danger text-decoration-none w-100 py-2 fs-13">
								<i class="ti ti-trash me-2"></i>Permanently Delete No
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Document Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row mb-3 pb-3 border-bottom border-light align-items-center">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium ls-1">Owner</div>
						<div class="col-md-8">
							<div class="d-flex align-items-center">
								@if($document->employee && $document->employee->profile_picture)
									<img src="{{ asset('storage/' . $document->employee->profile_picture) }}" class="avatar avatar-sm rounded-circle me-2" alt="img">
								@endif
								<span class="text-dark fw-bold">{{ $document->employee ? $document->employee->name : 'N/A' }}</span>
							</div>
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium ls-1">Reference No.</div>
						<div class="col-md-8 text-dark fw-medium">{{ $document->document_number ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium ls-1">Issue Date</div>
						<div class="col-md-8 text-dark"><i class="ti ti-calendar-event me-2 text-muted"></i>{{ $document->issue_date ? $document->issue_date->format('d M, Y') : 'N/A' }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium ls-1">Expiry Date</div>
						<div class="col-md-8 text-dark">
							@if($document->expiry_date)
								<i class="ti ti-calendar-x me-2 text-{{ $document->expiry_date->isPast() ? 'danger' : 'muted' }}"></i>
								<span class="text-{{ $document->expiry_date->isPast() ? 'danger fw-bold' : 'dark' }}">
									{{ $document->expiry_date->format('d M, Y') }}
									@if($document->expiry_date->isPast()) (Expired) @endif
								</span>
							@else
								<span class="text-muted">No Expiry</span>
							@endif
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium ls-1">Uploaded By</div>
						<div class="col-md-8 text-dark">{{ $document->uploader ? $document->uploader->name : 'System' }}</div>
					</div>
					@if($document->description)
						<div class="row mb-3 pb-3 border-bottom border-light">
							<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium ls-1">Description</div>
							<div class="col-md-8 text-dark">{{ $document->description }}</div>
						</div>
					@endif
					@if($document->notes)
						<div class="row mb-3 pb-3 border-bottom border-light">
							<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium ls-1">Internal Notes</div>
							<div class="col-md-8 p-3 bg-light rounded-3 text-muted fs-13 border-start border-primary border-4">{{ $document->notes }}</div>
						</div>
					@endif
					<div class="row mt-4">
						<div class="col-md-4 text-muted fs-12 text-uppercase fw-medium ls-1 opacity-50">Log Details</div>
						<div class="col-md-8 text-muted fs-11">
							Created on {{ $document->created_at->format('M d, Y \a\t H:i') }}<br>
							Last updated on {{ $document->updated_at->format('M d, Y \a\t H:i') }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

@extends('layouts.app')

@section('title', 'View Document')

@section('content')

	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Document Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('documents.edit', $document->id) }}" class="btn btn-primary me-2"><i class="ti ti-edit me-2"></i>Edit</a>
			<a href="{{ route('documents.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>

	<div class="card">
		<div class="card-header">
			<h5>Document Information</h5>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Title</label>
					<p>{{ $document->title }}</p>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Document Number</label>
					<p>{{ $document->document_number ?? 'N/A' }}</p>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Category</label>
					<p>{{ $document->category ?? 'N/A' }}</p>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Employee</label>
					<p>{{ $document->employee ? $document->employee->name : 'N/A' }}</p>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Issue Date</label>
					<p>{{ $document->issue_date ? $document->issue_date->format('d M, Y') : 'N/A' }}</p>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Expiry Date</label>
					<p>{{ $document->expiry_date ? $document->expiry_date->format('d M, Y') : 'N/A' }}</p>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Status</label>
					<p>
						@if($document->status == 'active')
							<span class="badge badge-success">Active</span>
						@elseif($document->status == 'expired')
							<span class="badge badge-warning">Expired</span>
						@else
							<span class="badge badge-secondary">Archived</span>
						@endif
					</p>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Uploaded By</label>
					<p>{{ $document->uploader ? $document->uploader->name : 'N/A' }}</p>
				</div>
				<div class="col-md-12 mb-3">
					<label class="form-label fw-bold">Description</label>
					<p>{{ $document->description ?? 'N/A' }}</p>
				</div>
				<div class="col-md-12 mb-3">
					<label class="form-label fw-bold">Notes</label>
					<p>{{ $document->notes ?? 'N/A' }}</p>
				</div>
				@if($document->file_path)
					<div class="col-md-12 mb-3">
						<label class="form-label fw-bold">File</label>
						<div>
							<a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="btn btn-primary">
								<i class="ti ti-download me-2"></i>Download File
							</a>
							<span class="ms-2 text-muted">{{ $document->file_name }}</span>
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>

@endsection

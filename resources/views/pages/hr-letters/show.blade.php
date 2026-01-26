@extends('layouts.app')

@section('title', 'View HR Letter')

@section('content')

	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">HR Letter Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('hr-letters.edit', $letter->id) }}" class="btn btn-primary me-2"><i class="ti ti-edit me-2"></i>Edit</a>
			<a href="{{ route('hr-letters.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>

	<div class="card">
		<div class="card-header">
			<h5>HR Letter Information</h5>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Title</label>
					<p>{{ $letter->title }}</p>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">HR Letter Number</label>
					<p>{{ $letter->document_number ?? 'N/A' }}</p>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Category</label>
					<p>{{ $letter->category ?? 'N/A' }}</p>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Employee</label>
					<p>{{ $letter->employee ? $letter->employee->name : 'N/A' }}</p>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Issue Date</label>
					<p>{{ $letter->issue_date ? $letter->issue_date->format('d M, Y') : 'N/A' }}</p>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Expiry Date</label>
					<p>{{ $letter->expiry_date ? $letter->expiry_date->format('d M, Y') : 'N/A' }}</p>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Status</label>
					<p>
						@if($letter->status == 'active')
							<span class="badge badge-success">Active</span>
						@elseif($letter->status == 'expired')
							<span class="badge badge-warning">Expired</span>
						@else
							<span class="badge badge-secondary">Archived</span>
						@endif
					</p>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Uploaded By</label>
					<p>{{ $letter->uploader ? $letter->uploader->name : 'N/A' }}</p>
				</div>
				<div class="col-md-12 mb-3">
					<label class="form-label fw-bold">Description</label>
					<p>{{ $letter->description ?? 'N/A' }}</p>
				</div>
				<div class="col-md-12 mb-3">
					<label class="form-label fw-bold">Notes</label>
					<p>{{ $letter->notes ?? 'N/A' }}</p>
				</div>
				@if($letter->file_path)
					<div class="col-md-12 mb-3">
						<label class="form-label fw-bold">File</label>
						<div>
							<a href="{{ asset('storage/' . $letter->file_path) }}" target="_blank" class="btn btn-primary">
								<i class="ti ti-download me-2"></i>Download File
							</a>
							<span class="ms-2 text-muted">{{ $letter->file_name }}</span>
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>

@endsection

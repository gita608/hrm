@extends('layouts.app')

@section('title', 'View Certificate')

@section('content')

	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Certificate Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('certificates.edit', $certificate->id) }}" class="btn btn-primary me-2"><i class="ti ti-edit me-2"></i>Edit</a>
			<a href="{{ route('certificates.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>

	<div class="card">
		<div class="card-header">
			<h5>Certificate Information</h5>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Title</label>
					<p>{{ $certificate->title }}</p>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Certificate Number</label>
					<p>{{ $certificate->certificate_number ?? 'N/A' }}</p>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Certificate Type</label>
					<p>{{ ucfirst($certificate->certificate_type ?? 'N/A') }}</p>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Employee</label>
					<p>{{ $certificate->employee ? $certificate->employee->name : 'N/A' }}</p>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Issuing Authority</label>
					<p>{{ $certificate->issuing_authority ?? 'N/A' }}</p>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Issue Date</label>
					<p>{{ $certificate->issue_date ? $certificate->issue_date->format('d M, Y') : 'N/A' }}</p>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Expiry Date</label>
					<p>{{ $certificate->expiry_date ? $certificate->expiry_date->format('d M, Y') : 'N/A' }}</p>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Status</label>
					<p>
						@if($certificate->status == 'active')
							<span class="badge badge-success">Active</span>
						@elseif($certificate->status == 'expired')
							<span class="badge badge-warning">Expired</span>
						@elseif($certificate->status == 'revoked')
							<span class="badge badge-danger">Revoked</span>
						@else
							<span class="badge badge-secondary">{{ ucfirst($certificate->status) }}</span>
						@endif
					</p>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Uploaded By</label>
					<p>{{ $certificate->uploader ? $certificate->uploader->name : 'N/A' }}</p>
				</div>
				<div class="col-md-12 mb-3">
					<label class="form-label fw-bold">Description</label>
					<p>{{ $certificate->description ?? 'N/A' }}</p>
				</div>
				<div class="col-md-12 mb-3">
					<label class="form-label fw-bold">Notes</label>
					<p>{{ $certificate->notes ?? 'N/A' }}</p>
				</div>
				@if($certificate->file_path)
					<div class="col-md-12 mb-3">
						<label class="form-label fw-bold">File</label>
						<div>
							<a href="{{ asset('storage/' . $certificate->file_path) }}" target="_blank" class="btn btn-primary">
								<i class="ti ti-download me-2"></i>Download File
							</a>
							<span class="ms-2 text-muted">{{ $certificate->file_name }}</span>
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>

@endsection

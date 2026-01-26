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
					<label class="form-label fw-bold">Letter Number</label>
					<p>{{ $letter->letter_number ?? 'N/A' }}</p>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Letter Type</label>
					<p>{{ ucfirst(str_replace('_', ' ', $letter->letter_type ?? 'N/A')) }}</p>
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
					<label class="form-label fw-bold">Status</label>
					<p>
						@if($letter->status == 'draft')
							<span class="badge badge-secondary">Draft</span>
						@elseif($letter->status == 'issued')
							<span class="badge badge-success">Issued</span>
						@elseif($letter->status == 'cancelled')
							<span class="badge badge-danger">Cancelled</span>
						@else
							<span class="badge badge-info">{{ ucfirst($letter->status) }}</span>
						@endif
					</p>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold">Issued By</label>
					<p>{{ $letter->issuer ? $letter->issuer->name : 'N/A' }}</p>
				</div>
				<div class="col-md-12 mb-3">
					<label class="form-label fw-bold">Content</label>
					<p>{{ $letter->content ?? 'N/A' }}</p>
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

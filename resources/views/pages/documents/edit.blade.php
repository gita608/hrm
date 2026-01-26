@extends('layouts.app')

@section('title', 'Edit Document')

@section('content')

	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Edit Document</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('documents.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>

	<div class="card">
		<div class="card-header">
			<h5>Document Information</h5>
		</div>
		<div class="card-body">
			<form action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Title <span class="text-danger">*</span></label>
							<input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $document->title) }}" required>
							@error('title')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Document Number</label>
							<input type="text" class="form-control @error('document_number') is-invalid @enderror" name="document_number" value="{{ old('document_number', $document->document_number) }}">
							@error('document_number')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Employee</label>
							<select class="form-select @error('employee_id') is-invalid @enderror" name="employee_id">
								<option value="">Select Employee</option>
								@foreach($employees as $employee)
									<option value="{{ $employee->id }}" {{ old('employee_id', $document->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
								@endforeach
							</select>
							@error('employee_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Issue Date</label>
							<input type="date" class="form-control @error('issue_date') is-invalid @enderror" name="issue_date" value="{{ old('issue_date', $document->issue_date?->format('Y-m-d')) }}">
							@error('issue_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Expiry Date</label>
							<input type="date" class="form-control @error('expiry_date') is-invalid @enderror" name="expiry_date" value="{{ old('expiry_date', $document->expiry_date?->format('Y-m-d')) }}">
							@error('expiry_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Status <span class="text-danger">*</span></label>
							<select class="form-select @error('status') is-invalid @enderror" name="status" required>
								<option value="active" {{ old('status', $document->status) == 'active' ? 'selected' : '' }}>Active</option>
								<option value="expired" {{ old('status', $document->status) == 'expired' ? 'selected' : '' }}>Expired</option>
								<option value="archived" {{ old('status', $document->status) == 'archived' ? 'selected' : '' }}>Archived</option>
							</select>
							@error('status')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">File</label>
							<input type="file" class="form-control @error('file') is-invalid @enderror" name="file">
							<small class="text-muted">Leave empty to keep current file. Max file size: 10MB</small>
							@if($document->file_path)
								<div class="mt-2">
									<a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
										<i class="ti ti-download me-1"></i>Download Current File
									</a>
								</div>
							@endif
							@error('file')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Description</label>
							<textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description', $document->description) }}</textarea>
							@error('description')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Notes</label>
							<textarea class="form-control @error('notes') is-invalid @enderror" name="notes" rows="2">{{ old('notes', $document->notes) }}</textarea>
							@error('notes')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2">
					<a href="{{ route('documents.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Update Document</button>
				</div>
			</form>
		</div>
	</div>

@endsection

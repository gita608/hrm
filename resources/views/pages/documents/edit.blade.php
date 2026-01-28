@extends('layouts.app')

@section('title', 'Edit Employee Document')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Edit Employee Document</h2>
			<p class="text-muted mb-0 fs-13">Update document details and status</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('documents.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to Documents
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
			<h5 class="mb-0 fw-bold text-dark">Document Information</h5>
		</div>
		<div class="card-body p-4">
			<form action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-info d-flex align-items-start border-0 bg-primary-transparent text-primary rounded-3 shadow-none mb-4" role="alert">
							<i class="ti ti-info-circle me-3 fs-3"></i>
							<div>
								<h6 class="mb-1 fw-bold">Note</h6>
								<p class="mb-0 fs-13 opacity-75">Changing employee will re-link this file to the selected employee.</p>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium ls-1">Title <span class="text-danger">*</span></label>
							<input type="text" class="form-control rounded-3 border-light shadow-none py-2 @error('title') is-invalid @enderror" name="title" value="{{ old('title', $document->title) }}" required>
							@error('title')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium ls-1">Document Number</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none py-2 @error('document_number') is-invalid @enderror" name="document_number" value="{{ old('document_number', $document->document_number) }}">
							@error('document_number')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium ls-1">Employee <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none py-2 @error('employee_id') is-invalid @enderror" name="employee_id" required>
								<option value="">Select Employee</option>
								@foreach($employees as $employee)
									<option value="{{ $employee->id }}" {{ old('employee_id', $document->employee_id) == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->name }} {{ $employee->employee_id ? '(' . $employee->employee_id . ')' : '' }}
                                    </option>
								@endforeach
							</select>
							@error('employee_id')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium ls-1">Issue Date</label>
							<input type="date" class="form-control rounded-3 border-light shadow-none py-2 @error('issue_date') is-invalid @enderror" name="issue_date" value="{{ old('issue_date', $document->issue_date?->format('Y-m-d')) }}">
							@error('issue_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium ls-1">Expiry Date</label>
							<input type="date" class="form-control rounded-3 border-light shadow-none py-2 @error('expiry_date') is-invalid @enderror" name="expiry_date" value="{{ old('expiry_date', $document->expiry_date?->format('Y-m-d')) }}">
							@error('expiry_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium ls-1">Status <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none py-2 @error('status') is-invalid @enderror" name="status" required>
								<option value="active" {{ old('status', $document->status) == 'active' ? 'selected' : '' }}>Active</option>
								<option value="expired" {{ old('status', $document->status) == 'expired' ? 'selected' : '' }}>Expired</option>
								<option value="archived" {{ old('status', $document->status) == 'archived' ? 'selected' : '' }}>Archived</option>
							</select>
							@error('status')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium ls-1">Replace File</label>
							<div class="input-group">
								<input type="file" class="form-control rounded-3 border-light shadow-none py-2 @error('file') is-invalid @enderror" name="file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
							</div>
							<small class="text-muted fs-11 mt-1 d-block">Leave empty to keep current file. Accepted forms: PDF, Images, DOC (Max 10MB)</small>
							@if($document->file_path)
								<div class="mt-3 p-3 bg-light rounded-3 d-inline-flex align-items-center">
									<i class="ti ti-file-description fs-24 text-primary me-2"></i>
									<div>
										<p class="mb-0 fs-13 fw-bold text-dark">Current Document</p>
										<a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="text-primary fs-12 text-decoration-none">
											<i class="ti ti-download me-1"></i>Download/View File
										</a>
									</div>
								</div>
							@endif
							@error('file')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium ls-1">Description</label>
							<textarea class="form-control rounded-3 border-light shadow-none @error('description') is-invalid @enderror" name="description" rows="3" placeholder="Briefly describe the document...">{{ old('description', $document->description) }}</textarea>
							@error('description')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium ls-1">Internal Notes</label>
							<textarea class="form-control rounded-3 border-light shadow-none @error('notes') is-invalid @enderror" name="notes" rows="2" placeholder="Any additional internal notes...">{{ old('notes', $document->notes) }}</textarea>
							@error('notes')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2 mt-4">
					<a href="{{ route('documents.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
					<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm"><i class="ti ti-device-floppy me-1"></i>Update Document</button>
				</div>
			</form>
		</div>
	</div>

@endsection

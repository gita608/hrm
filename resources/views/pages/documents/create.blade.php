@extends('layouts.app')

@section('title', 'Upload Employee Document')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Upload Employee Document</h2>
			<p class="text-muted mb-0 fs-13">Upload and manage employee documentation</p>
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
			<form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-info d-flex align-items-start border-0 bg-primary-transparent text-primary rounded-3 shadow-none mb-4" role="alert">
							<i class="ti ti-info-circle me-3 fs-3"></i>
							<div>
								<h6 class="mb-1 fw-bold">Important Information</h6>
								<p class="mb-0 fs-13 opacity-75">Select the employee first, then fill document details. Accepted max file size 10MB. Allowed formats: PDF, JPG, PNG, DOC, DOCX.</p>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium ls-1">Employee <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none py-2 @error('employee_id') is-invalid @enderror" name="employee_id" required>
								<option value="">Select Employee</option>
								@foreach($employees as $employee)
									<option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
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
							<label class="form-label text-muted fs-12 text-uppercase fw-medium ls-1">Title <span class="text-danger">*</span></label>
							<input type="text" class="form-control rounded-3 border-light shadow-none py-2 @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" placeholder="e.g. Passport, Emirates ID, Visa" required>
							@error('title')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium ls-1">Document Number</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none py-2 @error('document_number') is-invalid @enderror" name="document_number" value="{{ old('document_number') }}" placeholder="e.g., EMP-XXXX or Gov Ref">
							@error('document_number')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium ls-1">Issue Date</label>
							<input type="date" class="form-control rounded-3 border-light shadow-none py-2 @error('issue_date') is-invalid @enderror" name="issue_date" value="{{ old('issue_date') }}">
							@error('issue_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium ls-1">Expiry Date</label>
							<input type="date" class="form-control rounded-3 border-light shadow-none py-2 @error('expiry_date') is-invalid @enderror" name="expiry_date" value="{{ old('expiry_date') }}">
							@error('expiry_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium ls-1">Status <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none py-2 @error('status') is-invalid @enderror" name="status" required>
								<option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
								<option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Expired</option>
								<option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
							</select>
							@error('status')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium ls-1">File Upload <span class="text-danger">*</span></label>
							<div class="input-group">
								<input type="file" class="form-control rounded-3 border-light shadow-none py-2 @error('file') is-invalid @enderror" name="file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required>
							</div>
							<small class="text-muted fs-11 mt-1 d-block">Accepted forms: PDF, Images, DOC (Max 10MB)</small>
							@error('file')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium ls-1">Description</label>
							<textarea class="form-control rounded-3 border-light shadow-none @error('description') is-invalid @enderror" name="description" rows="3" placeholder="Briefly describe the document...">{{ old('description') }}</textarea>
							@error('description')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium ls-1">Internal Notes</label>
							<textarea class="form-control rounded-3 border-light shadow-none @error('notes') is-invalid @enderror" name="notes" rows="2" placeholder="Any additional internal notes...">{{ old('notes') }}</textarea>
							@error('notes')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2 mt-4">
					<a href="{{ route('documents.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
					<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm"><i class="ti ti-upload me-1"></i>Save Document</button>
				</div>
			</form>
		</div>
	</div>

@endsection

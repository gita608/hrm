@extends('layouts.app')

@section('title', 'Add Certificate')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Add Certificate</h2>
			<p class="text-muted mb-0 fs-13">Register a new certificate for an employee</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('certificates.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
			<h5 class="mb-0 fw-bold text-dark">Certificate Information</h5>
		</div>
		<div class="card-body p-4">
			<form action="{{ route('certificates.store') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Title <span class="text-danger">*</span></label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="title" value="{{ old('title') }}" placeholder="e.g., Bachelor of Science" required>
							@error('title')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Certificate Number <span class="text-danger">*</span></label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="certificate_number" value="{{ old('certificate_number') }}" placeholder="e.g., CERT-2026-001" required>
							@error('certificate_number')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Employee <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none" name="employee_id" required>
								<option value="">Select Employee</option>
								@foreach($employees as $employee)
									<option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
								@endforeach
							</select>
							@error('employee_id')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Certificate Type <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none" name="certificate_type" required>
								<option value="">Select Type</option>
								<option value="education" {{ old('certificate_type') == 'education' ? 'selected' : '' }}>Education</option>
								<option value="training" {{ old('certificate_type') == 'training' ? 'selected' : '' }}>Training</option>
								<option value="achievement" {{ old('certificate_type') == 'achievement' ? 'selected' : '' }}>Achievement</option>
								<option value="professional" {{ old('certificate_type') == 'professional' ? 'selected' : '' }}>Professional</option>
								<option value="other" {{ old('certificate_type') == 'other' ? 'selected' : '' }}>Other</option>
							</select>
							@error('certificate_type')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Issuing Authority</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="issuing_authority" value="{{ old('issuing_authority') }}" placeholder="e.g., University Name, Training Institute">
							@error('issuing_authority')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Issue Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control rounded-3 border-light shadow-none" name="issue_date" value="{{ old('issue_date') }}" required>
							@error('issue_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Expiry Date</label>
							<input type="date" class="form-control rounded-3 border-light shadow-none" name="expiry_date" value="{{ old('expiry_date') }}">
							<small class="text-muted fs-11">Leave empty if certificate doesn't expire</small>
							@error('expiry_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Status <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none" name="status" required>
								<option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
								<option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Expired</option>
								<option value="revoked" {{ old('status') == 'revoked' ? 'selected' : '' }}>Revoked</option>
							</select>
							@error('status')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Certificate File</label>
							<input type="file" class="form-control rounded-3 border-light shadow-none" name="file" accept=".pdf,.jpg,.jpeg,.png">
							<small class="text-muted fs-11">Upload certificate copy (PDF or Image, Max: 10MB)</small>
							@error('file')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Description</label>
							<textarea class="form-control rounded-3 border-light shadow-none" name="description" rows="2">{{ old('description') }}</textarea>
							@error('description')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Notes</label>
							<textarea class="form-control rounded-3 border-light shadow-none" name="notes" rows="2">{{ old('notes') }}</textarea>
							@error('notes')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2 mt-4">
					<a href="{{ route('certificates.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
					<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Save Certificate</button>
				</div>
			</form>
		</div>
	</div>

@endsection

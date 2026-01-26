@extends('layouts.app')

@section('title', 'Edit Certificate')

@section('content')

	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Edit Certificate</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('certificates.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>

	<div class="card">
		<div class="card-header">
			<h5>Certificate Information</h5>
		</div>
		<div class="card-body">
			<form action="{{ route('certificates.update', $certificate->id) }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Title <span class="text-danger">*</span></label>
							<input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $certificate->title) }}" placeholder="e.g., Bachelor of Science" required>
							@error('title')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Certificate Number <span class="text-danger">*</span></label>
							<input type="text" class="form-control @error('certificate_number') is-invalid @enderror" name="certificate_number" value="{{ old('certificate_number', $certificate->certificate_number) }}" placeholder="e.g., CERT-2026-001" required>
							@error('certificate_number')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Employee <span class="text-danger">*</span></label>
							<select class="form-select @error('employee_id') is-invalid @enderror" name="employee_id" required>
								<option value="">Select Employee</option>
								@foreach($employees as $employee)
									<option value="{{ $employee->id }}" {{ old('employee_id', $certificate->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
								@endforeach
							</select>
							@error('employee_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Certificate Type <span class="text-danger">*</span></label>
							<select class="form-select @error('certificate_type') is-invalid @enderror" name="certificate_type" required>
								<option value="">Select Type</option>
								<option value="education" {{ old('certificate_type', $certificate->certificate_type) == 'education' ? 'selected' : '' }}>Education</option>
								<option value="training" {{ old('certificate_type', $certificate->certificate_type) == 'training' ? 'selected' : '' }}>Training</option>
								<option value="achievement" {{ old('certificate_type', $certificate->certificate_type) == 'achievement' ? 'selected' : '' }}>Achievement</option>
								<option value="professional" {{ old('certificate_type', $certificate->certificate_type) == 'professional' ? 'selected' : '' }}>Professional</option>
								<option value="other" {{ old('certificate_type', $certificate->certificate_type) == 'other' ? 'selected' : '' }}>Other</option>
							</select>
							@error('certificate_type')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Issuing Authority</label>
							<input type="text" class="form-control @error('issuing_authority') is-invalid @enderror" name="issuing_authority" value="{{ old('issuing_authority', $certificate->issuing_authority) }}" placeholder="e.g., University Name, Training Institute">
							@error('issuing_authority')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Issue Date</label>
							<input type="date" class="form-control @error('issue_date') is-invalid @enderror" name="issue_date" value="{{ old('issue_date', $certificate->issue_date?->format('Y-m-d')) }}">
							@error('issue_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Expiry Date</label>
							<input type="date" class="form-control @error('expiry_date') is-invalid @enderror" name="expiry_date" value="{{ old('expiry_date', $certificate->expiry_date?->format('Y-m-d')) }}">
							@error('expiry_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Status <span class="text-danger">*</span></label>
							<select class="form-select @error('status') is-invalid @enderror" name="status" required>
								<option value="active" {{ old('status', $certificate->status) == 'active' ? 'selected' : '' }}>Active</option>
								<option value="expired" {{ old('status', $certificate->status) == 'expired' ? 'selected' : '' }}>Expired</option>
								<option value="archived" {{ old('status', $certificate->status) == 'archived' ? 'selected' : '' }}>Archived</option>
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
							@if($certificate->file_path)
								<div class="mt-2">
									<a href="{{ asset('storage/' . $certificate->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
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
							<textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description', $certificate->description) }}</textarea>
							@error('description')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Notes</label>
							<textarea class="form-control @error('notes') is-invalid @enderror" name="notes" rows="2">{{ old('notes', $certificate->notes) }}</textarea>
							@error('notes')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2">
					<a href="{{ route('certificates.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Update Certificate</button>
				</div>
			</form>
		</div>
	</div>

@endsection

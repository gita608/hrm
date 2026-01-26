@extends('layouts.app')

@section('title', 'Edit HR Letter')

@section('content')

	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Edit HR Letter</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('hr-letters.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>

	<div class="card">
		<div class="card-header">
			<h5>HR Letter Information</h5>
		</div>
		<div class="card-body">
			<div class="alert alert-info d-flex align-items-start mb-4" role="alert">
				<i class="ti ti-info-circle me-2"></i>
				<div>
					<strong>Employee-Centric HR Letter Management:</strong> Select the employee first, then choose the appropriate letter type (Offer, Appointment, Experience, etc.). All letters are linked to employee records for easy tracking.
				</div>
			</div>
			<form action="{{ route('hr-letters.update', $letter->id) }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Employee <span class="text-danger">*</span></label>
							<select class="form-select @error('employee_id') is-invalid @enderror" name="employee_id" required>
								<option value="">Select Employee</option>
								@foreach($employees as $employee)
									<option value="{{ $employee->id }}" {{ old('employee_id', $letter->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
								@endforeach
							</select>
							@error('employee_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Letter Type <span class="text-danger">*</span></label>
							<select class="form-select @error('letter_type') is-invalid @enderror" name="letter_type" required>
								<option value="">Select Letter Type</option>
								<option value="offer" {{ old('letter_type', $letter->letter_type) == 'offer' ? 'selected' : '' }}>Offer Letter</option>
								<option value="appointment" {{ old('letter_type', $letter->letter_type) == 'appointment' ? 'selected' : '' }}>Appointment Letter</option>
								<option value="experience" {{ old('letter_type', $letter->letter_type) == 'experience' ? 'selected' : '' }}>Experience Certificate</option>
								<option value="relieving" {{ old('letter_type', $letter->letter_type) == 'relieving' ? 'selected' : '' }}>Relieving Letter</option>
								<option value="warning" {{ old('letter_type', $letter->letter_type) == 'warning' ? 'selected' : '' }}>Warning Letter</option>
								<option value="appreciation" {{ old('letter_type', $letter->letter_type) == 'appreciation' ? 'selected' : '' }}>Appreciation Letter</option>
								<option value="promotion" {{ old('letter_type', $letter->letter_type) == 'promotion' ? 'selected' : '' }}>Promotion Letter</option>
								<option value="transfer" {{ old('letter_type', $letter->letter_type) == 'transfer' ? 'selected' : '' }}>Transfer Letter</option>
								<option value="other" {{ old('letter_type', $letter->letter_type) == 'other' ? 'selected' : '' }}>Other</option>
							</select>
							@error('letter_type')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Letter Number <span class="text-danger">*</span></label>
							<input type="text" class="form-control @error('letter_number') is-invalid @enderror" name="letter_number" value="{{ old('letter_number', $letter->letter_number) }}" placeholder="e.g., HR/2026/001" required>
							@error('letter_number')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Title <span class="text-danger">*</span></label>
							<input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $letter->title) }}" placeholder="e.g., Offer Letter - Software Engineer" required>
							@error('title')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Issue Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control @error('issue_date') is-invalid @enderror" name="issue_date" value="{{ old('issue_date', $letter->issue_date?->format('Y-m-d')) }}" required>
							@error('issue_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Status <span class="text-danger">*</span></label>
							<select class="form-select @error('status') is-invalid @enderror" name="status" required>
								<option value="draft" {{ old('status', $letter->status) == 'draft' ? 'selected' : '' }}>Draft</option>
								<option value="issued" {{ old('status', $letter->status) == 'issued' ? 'selected' : '' }}>Issued</option>
								<option value="cancelled" {{ old('status', $letter->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
							</select>
							@error('status')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Letter Content <span class="text-danger">*</span></label>
							<textarea class="form-control @error('content') is-invalid @enderror" name="content" rows="6" placeholder="Enter the full letter content here..." required>{{ old('content', $letter->content) }}</textarea>
							<small class="text-muted">Write the complete letter content including salutation, body, and closing.</small>
							@error('content')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Attach File (Optional)</label>
							<input type="file" class="form-control @error('file') is-invalid @enderror" name="file" accept=".pdf,.doc,.docx">
							<small class="text-muted">Leave empty to keep current file. Accepted: PDF, DOC, DOCX. Max size: 10MB</small>
							@if($letter->file_path)
								<div class="mt-2">
									<a href="{{ asset('storage/' . $letter->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
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
							<label class="form-label">Notes (Internal Use)</label>
							<textarea class="form-control @error('notes') is-invalid @enderror" name="notes" rows="2" placeholder="Add any internal notes or remarks...">{{ old('notes', $letter->notes) }}</textarea>
							@error('notes')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2">
					<a href="{{ route('hr-letters.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Update HR Letter</button>
				</div>
			</form>
		</div>
	</div>

@endsection

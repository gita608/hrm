@extends('layouts.app')

@section('title', 'Add Candidate')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Add Candidate</h2>
			<p class="text-muted mb-0 fs-13">Create a new candidate profile</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('candidates.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
			<h5 class="mb-0 fw-bold text-dark">Candidate Information</h5>
		</div>
		<div class="card-body p-4">
			<form action="{{ route('candidates.store') }}" method="POST">
				@csrf
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Candidate Code</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="candidate_code" value="{{ old('candidate_code') }}" placeholder="Auto-generated or Enter Code">
							@error('candidate_code')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Job Posting</label>
							<select class="form-select rounded-3 border-light shadow-none" name="job_posting_id">
								<option value="">Select Job</option>
								@foreach($jobPostings as $job)
									<option value="{{ $job->id }}" {{ old('job_posting_id', $jobPostingId ?? null) == $job->id ? 'selected' : '' }}>{{ $job->title }}</option>
								@endforeach
							</select>
							@error('job_posting_id')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">First Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="first_name" value="{{ old('first_name') }}" required>
							@error('first_name')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Last Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="last_name" value="{{ old('last_name') }}" required>
							@error('last_name')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Email <span class="text-danger">*</span></label>
							<input type="email" class="form-control rounded-3 border-light shadow-none" name="email" value="{{ old('email') }}" required>
							@error('email')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Phone</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="phone" value="{{ old('phone') }}">
							@error('phone')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Applied Role</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="applied_role" value="{{ old('applied_role') }}" placeholder="e.g., Software Developer">
							@error('applied_role')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Applied Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control rounded-3 border-light shadow-none" name="applied_date" value="{{ old('applied_date', date('Y-m-d')) }}" required>
							@error('applied_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Status <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none" name="status" required>
								<option value="app_received" {{ old('status', 'app_received') == 'app_received' ? 'selected' : '' }}>App Received</option>
								<option value="screening" {{ old('status') == 'screening' ? 'selected' : '' }}>Screening</option>
								<option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
								<option value="interviewed" {{ old('status') == 'interviewed' ? 'selected' : '' }}>Interviewed</option>
								<option value="shortlisted" {{ old('status') == 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
								<option value="hired" {{ old('status') == 'hired' ? 'selected' : '' }}>Hired</option>
								<option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
								<option value="withdrawn" {{ old('status') == 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
							</select>
							@error('status')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Resume Path</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="resume_path" value="{{ old('resume_path') }}" placeholder="Path to resume file">
							@error('resume_path')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Cover Letter</label>
							<textarea class="form-control rounded-3 border-light shadow-none" name="cover_letter" rows="3">{{ old('cover_letter') }}</textarea>
							@error('cover_letter')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Experience Summary</label>
							<textarea class="form-control rounded-3 border-light shadow-none" name="experience_summary" rows="3">{{ old('experience_summary') }}</textarea>
							@error('experience_summary')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Education</label>
							<textarea class="form-control rounded-3 border-light shadow-none" name="education" rows="2">{{ old('education') }}</textarea>
							@error('education')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Skills</label>
							<textarea class="form-control rounded-3 border-light shadow-none" name="skills" rows="2" placeholder="Comma-separated skills">{{ old('skills') }}</textarea>
							@error('skills')
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

				<!-- UAE-Specific Information Section -->
				<hr class="my-4 border-light">
				<h5 class="mb-3 fw-bold text-dark">UAE-Specific Information</h5>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Emirates ID</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="emirates_id" value="{{ old('emirates_id') }}" placeholder="e.g., 784-1234-1234567-1">
							@error('emirates_id')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Passport Number</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="passport_number" value="{{ old('passport_number') }}">
							@error('passport_number')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Nationality</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="nationality" value="{{ old('nationality') }}">
							@error('nationality')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Visa Status</label>
							<select class="form-select rounded-3 border-light shadow-none" name="visa_status">
								<option value="">Select Visa Status</option>
								<option value="valid" {{ old('visa_status') == 'valid' ? 'selected' : '' }}>Valid</option>
								<option value="expired" {{ old('visa_status') == 'expired' ? 'selected' : '' }}>Expired</option>
								<option value="not_required" {{ old('visa_status') == 'not_required' ? 'selected' : '' }}>Not Required</option>
								<option value="pending" {{ old('visa_status') == 'pending' ? 'selected' : '' }}>Pending</option>
							</select>
							@error('visa_status')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Current Location - Emirate</label>
							<select class="form-select rounded-3 border-light shadow-none" name="current_location_emirate">
								<option value="">Select Emirate</option>
								<option value="Abu Dhabi" {{ old('current_location_emirate') == 'Abu Dhabi' ? 'selected' : '' }}>Abu Dhabi</option>
								<option value="Dubai" {{ old('current_location_emirate') == 'Dubai' ? 'selected' : '' }}>Dubai</option>
								<option value="Sharjah" {{ old('current_location_emirate') == 'Sharjah' ? 'selected' : '' }}>Sharjah</option>
								<option value="Ajman" {{ old('current_location_emirate') == 'Ajman' ? 'selected' : '' }}>Ajman</option>
								<option value="Umm Al Quwain" {{ old('current_location_emirate') == 'Umm Al Quwain' ? 'selected' : '' }}>Umm Al Quwain</option>
								<option value="Ras Al Khaimah" {{ old('current_location_emirate') == 'Ras Al Khaimah' ? 'selected' : '' }}>Ras Al Khaimah</option>
								<option value="Fujairah" {{ old('current_location_emirate') == 'Fujairah' ? 'selected' : '' }}>Fujairah</option>
								<option value="Outside UAE" {{ old('current_location_emirate') == 'Outside UAE' ? 'selected' : '' }}>Outside UAE</option>
							</select>
							@error('current_location_emirate')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Current Location - City</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="current_location_city" value="{{ old('current_location_city') }}">
							@error('current_location_city')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2 mt-4">
					<a href="{{ route('candidates.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
					<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Save Candidate</button>
				</div>
			</form>
		</div>
	</div>

@endsection

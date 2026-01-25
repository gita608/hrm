@extends('layouts.app')

@section('title', 'Edit Candidate')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Edit Candidate</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('candidates.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="card">
		<div class="card-header">
			<h5>Candidate Information</h5>
		</div>
		<div class="card-body">
			<form action="{{ route('candidates.update', $candidate->id) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Candidate Code</label>
							<input type="text" class="form-control @error('candidate_code') is-invalid @enderror" name="candidate_code" value="{{ old('candidate_code', $candidate->candidate_code) }}">
							@error('candidate_code')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Job Posting</label>
							<select class="form-select @error('job_posting_id') is-invalid @enderror" name="job_posting_id">
								<option value="">Select Job</option>
								@foreach($jobPostings as $job)
									<option value="{{ $job->id }}" {{ old('job_posting_id', $candidate->job_posting_id) == $job->id ? 'selected' : '' }}>{{ $job->title }}</option>
								@endforeach
							</select>
							@error('job_posting_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">First Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', $candidate->first_name) }}" required>
							@error('first_name')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Last Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', $candidate->last_name) }}" required>
							@error('last_name')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Email <span class="text-danger">*</span></label>
							<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $candidate->email) }}" required>
							@error('email')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Phone</label>
							<input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $candidate->phone) }}">
							@error('phone')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Applied Role</label>
							<input type="text" class="form-control @error('applied_role') is-invalid @enderror" name="applied_role" value="{{ old('applied_role', $candidate->applied_role) }}" placeholder="e.g., Software Developer">
							@error('applied_role')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Applied Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control @error('applied_date') is-invalid @enderror" name="applied_date" value="{{ old('applied_date', $candidate->applied_date->format('Y-m-d')) }}" required>
							@error('applied_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Status <span class="text-danger">*</span></label>
							<select class="form-select @error('status') is-invalid @enderror" name="status" required>
								<option value="app_received" {{ old('status', $candidate->status) == 'app_received' ? 'selected' : '' }}>App Received</option>
								<option value="screening" {{ old('status', $candidate->status) == 'screening' ? 'selected' : '' }}>Screening</option>
								<option value="scheduled" {{ old('status', $candidate->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
								<option value="interviewed" {{ old('status', $candidate->status) == 'interviewed' ? 'selected' : '' }}>Interviewed</option>
								<option value="shortlisted" {{ old('status', $candidate->status) == 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
								<option value="hired" {{ old('status', $candidate->status) == 'hired' ? 'selected' : '' }}>Hired</option>
								<option value="rejected" {{ old('status', $candidate->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
								<option value="withdrawn" {{ old('status', $candidate->status) == 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
							</select>
							@error('status')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Resume Path</label>
							<input type="text" class="form-control @error('resume_path') is-invalid @enderror" name="resume_path" value="{{ old('resume_path', $candidate->resume_path) }}" placeholder="Path to resume file">
							@error('resume_path')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Cover Letter</label>
							<textarea class="form-control @error('cover_letter') is-invalid @enderror" name="cover_letter" rows="3">{{ old('cover_letter', $candidate->cover_letter) }}</textarea>
							@error('cover_letter')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Experience Summary</label>
							<textarea class="form-control @error('experience_summary') is-invalid @enderror" name="experience_summary" rows="3">{{ old('experience_summary', $candidate->experience_summary) }}</textarea>
							@error('experience_summary')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Education</label>
							<textarea class="form-control @error('education') is-invalid @enderror" name="education" rows="2">{{ old('education', $candidate->education) }}</textarea>
							@error('education')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Skills</label>
							<textarea class="form-control @error('skills') is-invalid @enderror" name="skills" rows="2" placeholder="Comma-separated skills">{{ old('skills', $candidate->skills) }}</textarea>
							@error('skills')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Notes</label>
							<textarea class="form-control @error('notes') is-invalid @enderror" name="notes" rows="2">{{ old('notes', $candidate->notes) }}</textarea>
							@error('notes')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>

				<!-- UAE-Specific Information Section -->
				<hr class="my-4">
				<h5 class="mb-3">UAE-Specific Information</h5>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Emirates ID</label>
							<input type="text" class="form-control @error('emirates_id') is-invalid @enderror" name="emirates_id" value="{{ old('emirates_id', $candidate->emirates_id) }}" placeholder="e.g., 784-1234-1234567-1">
							@error('emirates_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Passport Number</label>
							<input type="text" class="form-control @error('passport_number') is-invalid @enderror" name="passport_number" value="{{ old('passport_number', $candidate->passport_number) }}">
							@error('passport_number')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Nationality</label>
							<input type="text" class="form-control @error('nationality') is-invalid @enderror" name="nationality" value="{{ old('nationality', $candidate->nationality) }}">
							@error('nationality')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Visa Status</label>
							<select class="form-select @error('visa_status') is-invalid @enderror" name="visa_status">
								<option value="">Select Visa Status</option>
								<option value="valid" {{ old('visa_status', $candidate->visa_status) == 'valid' ? 'selected' : '' }}>Valid</option>
								<option value="expired" {{ old('visa_status', $candidate->visa_status) == 'expired' ? 'selected' : '' }}>Expired</option>
								<option value="not_required" {{ old('visa_status', $candidate->visa_status) == 'not_required' ? 'selected' : '' }}>Not Required</option>
								<option value="pending" {{ old('visa_status', $candidate->visa_status) == 'pending' ? 'selected' : '' }}>Pending</option>
							</select>
							@error('visa_status')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Current Location - Emirate</label>
							<select class="form-select @error('current_location_emirate') is-invalid @enderror" name="current_location_emirate">
								<option value="">Select Emirate</option>
								<option value="Abu Dhabi" {{ old('current_location_emirate', $candidate->current_location_emirate) == 'Abu Dhabi' ? 'selected' : '' }}>Abu Dhabi</option>
								<option value="Dubai" {{ old('current_location_emirate', $candidate->current_location_emirate) == 'Dubai' ? 'selected' : '' }}>Dubai</option>
								<option value="Sharjah" {{ old('current_location_emirate', $candidate->current_location_emirate) == 'Sharjah' ? 'selected' : '' }}>Sharjah</option>
								<option value="Ajman" {{ old('current_location_emirate', $candidate->current_location_emirate) == 'Ajman' ? 'selected' : '' }}>Ajman</option>
								<option value="Umm Al Quwain" {{ old('current_location_emirate', $candidate->current_location_emirate) == 'Umm Al Quwain' ? 'selected' : '' }}>Umm Al Quwain</option>
								<option value="Ras Al Khaimah" {{ old('current_location_emirate', $candidate->current_location_emirate) == 'Ras Al Khaimah' ? 'selected' : '' }}>Ras Al Khaimah</option>
								<option value="Fujairah" {{ old('current_location_emirate', $candidate->current_location_emirate) == 'Fujairah' ? 'selected' : '' }}>Fujairah</option>
								<option value="Outside UAE" {{ old('current_location_emirate', $candidate->current_location_emirate) == 'Outside UAE' ? 'selected' : '' }}>Outside UAE</option>
							</select>
							@error('current_location_emirate')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Current Location - City</label>
							<input type="text" class="form-control @error('current_location_city') is-invalid @enderror" name="current_location_city" value="{{ old('current_location_city', $candidate->current_location_city) }}">
							@error('current_location_city')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2">
					<a href="{{ route('candidates.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Update Candidate</button>
				</div>
			</form>
		</div>
	</div>

@endsection

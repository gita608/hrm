@extends('layouts.app')

@section('title', 'Edit Job')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Edit Job</h2>
			<p class="text-muted mb-0 fs-13">Modify job posting details</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('jobs.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
			<h5 class="mb-0 fw-bold text-dark">Job Information</h5>
		</div>
		<div class="card-body p-4">
			<form action="{{ route('jobs.update', $jobPosting->id) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Job Code</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="job_code" value="{{ old('job_code', $jobPosting->job_code) }}" placeholder="Auto-generated or Enter Code">
							@error('job_code')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Title <span class="text-danger">*</span></label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="title" value="{{ old('title', $jobPosting->title) }}" required placeholder="e.g. Senior Software Engineer">
							@error('title')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Department</label>
							<select class="form-select rounded-3 border-light shadow-none" name="department_id">
								<option value="">Select Department</option>
								@foreach($departments as $department)
									<option value="{{ $department->id }}" {{ old('department_id', $jobPosting->department_id) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
								@endforeach
							</select>
							@error('department_id')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Designation</label>
							<select class="form-select rounded-3 border-light shadow-none" name="designation_id">
								<option value="">Select Designation</option>
								@foreach($designations as $designation)
									<option value="{{ $designation->id }}" {{ old('designation_id', $jobPosting->designation_id) == $designation->id ? 'selected' : '' }}>{{ $designation->name }}</option>
								@endforeach
							</select>
							@error('designation_id')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">No. of Positions <span class="text-danger">*</span></label>
							<input type="number" class="form-control rounded-3 border-light shadow-none" name="no_of_positions" value="{{ old('no_of_positions', $jobPosting->no_of_positions) }}" min="1" required>
							@error('no_of_positions')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Job Type <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none" name="job_type" required>
								<option value="full_time" {{ old('job_type', $jobPosting->job_type) == 'full_time' ? 'selected' : '' }}>Full Time</option>
								<option value="part_time" {{ old('job_type', $jobPosting->job_type) == 'part_time' ? 'selected' : '' }}>Part Time</option>
								<option value="contract" {{ old('job_type', $jobPosting->job_type) == 'contract' ? 'selected' : '' }}>Contract</option>
								<option value="internship" {{ old('job_type', $jobPosting->job_type) == 'internship' ? 'selected' : '' }}>Internship</option>
								<option value="temporary" {{ old('job_type', $jobPosting->job_type) == 'temporary' ? 'selected' : '' }}>Temporary</option>
							</select>
							@error('job_type')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Start Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control rounded-3 border-light shadow-none" name="start_date" value="{{ old('start_date', $jobPosting->start_date->format('Y-m-d')) }}" required>
							@error('start_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">End Date</label>
							<input type="date" class="form-control rounded-3 border-light shadow-none" name="end_date" value="{{ old('end_date', $jobPosting->end_date ? $jobPosting->end_date->format('Y-m-d') : '') }}">
							@error('end_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Experience Level</label>
							<select class="form-select rounded-3 border-light shadow-none" name="experience_level">
								<option value="">Select Level</option>
								<option value="entry" {{ old('experience_level', $jobPosting->experience_level) == 'entry' ? 'selected' : '' }}>Entry</option>
								<option value="mid" {{ old('experience_level', $jobPosting->experience_level) == 'mid' ? 'selected' : '' }}>Mid</option>
								<option value="senior" {{ old('experience_level', $jobPosting->experience_level) == 'senior' ? 'selected' : '' }}>Senior</option>
								<option value="executive" {{ old('experience_level', $jobPosting->experience_level) == 'executive' ? 'selected' : '' }}>Executive</option>
							</select>
							@error('experience_level')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Location</label>
							<div class="input-group">
								<span class="input-group-text bg-light-50 border-light border-end-0 rounded-start-3 text-muted"><i class="ti ti-map-pin"></i></span>
								<input type="text" class="form-control rounded-end-3 border-light shadow-none border-start-0 ps-0" name="location" value="{{ old('location', $jobPosting->location) }}" placeholder="e.g. Dubai, UAE">
							</div>
							@error('location')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">UAE Emirate</label>
							<select class="form-select rounded-3 border-light shadow-none" name="uae_emirate">
								<option value="">Select Emirate</option>
								<option value="Abu Dhabi" {{ old('uae_emirate', $jobPosting->uae_emirate) == 'Abu Dhabi' ? 'selected' : '' }}>Abu Dhabi</option>
								<option value="Dubai" {{ old('uae_emirate', $jobPosting->uae_emirate) == 'Dubai' ? 'selected' : '' }}>Dubai</option>
								<option value="Sharjah" {{ old('uae_emirate', $jobPosting->uae_emirate) == 'Sharjah' ? 'selected' : '' }}>Sharjah</option>
								<option value="Ajman" {{ old('uae_emirate', $jobPosting->uae_emirate) == 'Ajman' ? 'selected' : '' }}>Ajman</option>
								<option value="Umm Al Quwain" {{ old('uae_emirate', $jobPosting->uae_emirate) == 'Umm Al Quwain' ? 'selected' : '' }}>Umm Al Quwain</option>
								<option value="Ras Al Khaimah" {{ old('uae_emirate', $jobPosting->uae_emirate) == 'Ras Al Khaimah' ? 'selected' : '' }}>Ras Al Khaimah</option>
								<option value="Fujairah" {{ old('uae_emirate', $jobPosting->uae_emirate) == 'Fujairah' ? 'selected' : '' }}>Fujairah</option>
							</select>
							@error('uae_emirate')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">UAE City</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="uae_city" value="{{ old('uae_city', $jobPosting->uae_city) }}">
							@error('uae_city')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Visa Sponsorship</label>
							<div class="form-check form-switch mt-2">
								<input class="form-check-input" type="checkbox" name="visa_sponsorship" value="1" id="visa_sponsorship" {{ old('visa_sponsorship', $jobPosting->visa_sponsorship) ? 'checked' : '' }}>
								<label class="form-check-label text-dark fw-medium" for="visa_sponsorship">Yes, visa sponsorship provided</label>
							</div>
							@error('visa_sponsorship')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Work Permit Required</label>
							<div class="form-check form-switch mt-2">
								<input class="form-check-input" type="checkbox" name="work_permit_required" value="1" id="work_permit_required" {{ old('work_permit_required', $jobPosting->work_permit_required) ? 'checked' : '' }}>
								<label class="form-check-label text-dark fw-medium" for="work_permit_required">Work permit required</label>
							</div>
							@error('work_permit_required')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Salary From</label>
							<input type="number" class="form-control rounded-3 border-light shadow-none" name="salary_from" value="{{ old('salary_from', $jobPosting->salary_from) }}" step="0.01" min="0">
							@error('salary_from')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Salary To</label>
							<input type="number" class="form-control rounded-3 border-light shadow-none" name="salary_to" value="{{ old('salary_to', $jobPosting->salary_to) }}" step="0.01" min="0">
							@error('salary_to')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Status <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none" name="status" required>
								<option value="draft" {{ old('status', $jobPosting->status) == 'draft' ? 'selected' : '' }}>Draft</option>
								<option value="open" {{ old('status', $jobPosting->status) == 'open' ? 'selected' : '' }}>Open</option>
								<option value="closed" {{ old('status', $jobPosting->status) == 'closed' ? 'selected' : '' }}>Closed</option>
								<option value="cancelled" {{ old('status', $jobPosting->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
							</select>
							@error('status')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Description</label>
							<textarea class="form-control rounded-3 border-light shadow-none" name="description" rows="3">{{ old('description', $jobPosting->description) }}</textarea>
							@error('description')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Requirements</label>
							<textarea class="form-control rounded-3 border-light shadow-none" name="requirements" rows="3">{{ old('requirements', $jobPosting->requirements) }}</textarea>
							@error('requirements')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Benefits</label>
							<textarea class="form-control rounded-3 border-light shadow-none" name="benefits" rows="3">{{ old('benefits', $jobPosting->benefits) }}</textarea>
							@error('benefits')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2 mt-4">
					<a href="{{ route('jobs.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
					<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Update Job</button>
				</div>
			</form>
		</div>
	</div>

@endsection

@extends('layouts.app')

@section('title', 'Edit Job')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Edit Job</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('jobs.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="card">
		<div class="card-header">
			<h5>Job Information</h5>
		</div>
		<div class="card-body">
			<form action="{{ route('jobs.update', $jobPosting->id) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Job Code</label>
							<input type="text" class="form-control @error('job_code') is-invalid @enderror" name="job_code" value="{{ old('job_code', $jobPosting->job_code) }}">
							@error('job_code')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Title <span class="text-danger">*</span></label>
							<input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $jobPosting->title) }}" required>
							@error('title')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Department</label>
							<select class="form-select @error('department_id') is-invalid @enderror" name="department_id">
								<option value="">Select Department</option>
								@foreach($departments as $department)
									<option value="{{ $department->id }}" {{ old('department_id', $jobPosting->department_id) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
								@endforeach
							</select>
							@error('department_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Designation</label>
							<select class="form-select @error('designation_id') is-invalid @enderror" name="designation_id">
								<option value="">Select Designation</option>
								@foreach($designations as $designation)
									<option value="{{ $designation->id }}" {{ old('designation_id', $jobPosting->designation_id) == $designation->id ? 'selected' : '' }}>{{ $designation->name }}</option>
								@endforeach
							</select>
							@error('designation_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">No. of Positions <span class="text-danger">*</span></label>
							<input type="number" class="form-control @error('no_of_positions') is-invalid @enderror" name="no_of_positions" value="{{ old('no_of_positions', $jobPosting->no_of_positions) }}" min="1" required>
							@error('no_of_positions')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Job Type <span class="text-danger">*</span></label>
							<select class="form-select @error('job_type') is-invalid @enderror" name="job_type" required>
								<option value="full_time" {{ old('job_type', $jobPosting->job_type) == 'full_time' ? 'selected' : '' }}>Full Time</option>
								<option value="part_time" {{ old('job_type', $jobPosting->job_type) == 'part_time' ? 'selected' : '' }}>Part Time</option>
								<option value="contract" {{ old('job_type', $jobPosting->job_type) == 'contract' ? 'selected' : '' }}>Contract</option>
								<option value="internship" {{ old('job_type', $jobPosting->job_type) == 'internship' ? 'selected' : '' }}>Internship</option>
								<option value="temporary" {{ old('job_type', $jobPosting->job_type) == 'temporary' ? 'selected' : '' }}>Temporary</option>
							</select>
							@error('job_type')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Start Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date', $jobPosting->start_date->format('Y-m-d')) }}" required>
							@error('start_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">End Date</label>
							<input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date', $jobPosting->end_date ? $jobPosting->end_date->format('Y-m-d') : '') }}">
							@error('end_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Experience Level</label>
							<select class="form-select @error('experience_level') is-invalid @enderror" name="experience_level">
								<option value="">Select Level</option>
								<option value="entry" {{ old('experience_level', $jobPosting->experience_level) == 'entry' ? 'selected' : '' }}>Entry</option>
								<option value="mid" {{ old('experience_level', $jobPosting->experience_level) == 'mid' ? 'selected' : '' }}>Mid</option>
								<option value="senior" {{ old('experience_level', $jobPosting->experience_level) == 'senior' ? 'selected' : '' }}>Senior</option>
								<option value="executive" {{ old('experience_level', $jobPosting->experience_level) == 'executive' ? 'selected' : '' }}>Executive</option>
							</select>
							@error('experience_level')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Location</label>
							<input type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ old('location', $jobPosting->location) }}">
							@error('location')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Salary From</label>
							<input type="number" class="form-control @error('salary_from') is-invalid @enderror" name="salary_from" value="{{ old('salary_from', $jobPosting->salary_from) }}" step="0.01" min="0">
							@error('salary_from')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Salary To</label>
							<input type="number" class="form-control @error('salary_to') is-invalid @enderror" name="salary_to" value="{{ old('salary_to', $jobPosting->salary_to) }}" step="0.01" min="0">
							@error('salary_to')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Status <span class="text-danger">*</span></label>
							<select class="form-select @error('status') is-invalid @enderror" name="status" required>
								<option value="draft" {{ old('status', $jobPosting->status) == 'draft' ? 'selected' : '' }}>Draft</option>
								<option value="open" {{ old('status', $jobPosting->status) == 'open' ? 'selected' : '' }}>Open</option>
								<option value="closed" {{ old('status', $jobPosting->status) == 'closed' ? 'selected' : '' }}>Closed</option>
								<option value="cancelled" {{ old('status', $jobPosting->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
							</select>
							@error('status')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Description</label>
							<textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description', $jobPosting->description) }}</textarea>
							@error('description')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Requirements</label>
							<textarea class="form-control @error('requirements') is-invalid @enderror" name="requirements" rows="3">{{ old('requirements', $jobPosting->requirements) }}</textarea>
							@error('requirements')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Benefits</label>
							<textarea class="form-control @error('benefits') is-invalid @enderror" name="benefits" rows="3">{{ old('benefits', $jobPosting->benefits) }}</textarea>
							@error('benefits')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2">
					<a href="{{ route('jobs.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Update Job</button>
				</div>
			</form>
		</div>
	</div>

@endsection

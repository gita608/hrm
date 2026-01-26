@extends('layouts.app')

@section('title', 'Add Referral')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Add Referral</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('referrals.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="card">
		<div class="card-header">
			<h5>Referral Information</h5>
		</div>
		<div class="card-body">
			<form action="{{ route('referrals.store') }}" method="POST">
				@csrf
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Referral Code</label>
							<input type="text" class="form-control @error('referral_code') is-invalid @enderror" name="referral_code" value="{{ old('referral_code') }}" placeholder="Auto-generated if left blank">
							@error('referral_code')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Referrer (Employee) <span class="text-danger">*</span></label>
							<select class="form-select @error('referrer_id') is-invalid @enderror" name="referrer_id" required>
								<option value="">Select Employee</option>
								@foreach($employees as $employee)
									<option value="{{ $employee->id }}" {{ old('referrer_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }} ({{ $employee->email }})</option>
								@endforeach
							</select>
							@error('referrer_id')
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
									<option value="{{ $job->id }}" {{ old('job_posting_id', $jobPostingId ?? null) == $job->id ? 'selected' : '' }}>{{ $job->title }}</option>
								@endforeach
							</select>
							@error('job_posting_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Referral Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control @error('referral_date') is-invalid @enderror" name="referral_date" value="{{ old('referral_date', date('Y-m-d')) }}" required>
							@error('referral_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Status <span class="text-danger">*</span></label>
							<select class="form-select @error('status') is-invalid @enderror" name="status" required>
								<option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
								<option value="contacted" {{ old('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
								<option value="interviewed" {{ old('status') == 'interviewed' ? 'selected' : '' }}>Interviewed</option>
								<option value="shortlisted" {{ old('status') == 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
								<option value="hired" {{ old('status') == 'hired' ? 'selected' : '' }}>Hired</option>
								<option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
								<option value="withdrawn" {{ old('status') == 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
							</select>
							@error('status')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>

				<hr class="my-4">
				<h5 class="mb-3">Referred Person Information</h5>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">First Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control @error('referred_first_name') is-invalid @enderror" name="referred_first_name" value="{{ old('referred_first_name') }}" required>
							@error('referred_first_name')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Last Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control @error('referred_last_name') is-invalid @enderror" name="referred_last_name" value="{{ old('referred_last_name') }}" required>
							@error('referred_last_name')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Email <span class="text-danger">*</span></label>
							<input type="email" class="form-control @error('referred_email') is-invalid @enderror" name="referred_email" value="{{ old('referred_email') }}" required>
							@error('referred_email')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Phone</label>
							<input type="text" class="form-control @error('referred_phone') is-invalid @enderror" name="referred_phone" value="{{ old('referred_phone') }}">
							@error('referred_phone')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Skills</label>
							<textarea class="form-control @error('referred_skills') is-invalid @enderror" name="referred_skills" rows="2" placeholder="Comma-separated skills or detailed description">{{ old('referred_skills') }}</textarea>
							@error('referred_skills')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Experience</label>
							<textarea class="form-control @error('referred_experience') is-invalid @enderror" name="referred_experience" rows="3" placeholder="Brief experience summary">{{ old('referred_experience') }}</textarea>
							@error('referred_experience')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>

				<hr class="my-4">
				<h5 class="mb-3">Referral Bonus Information</h5>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Referral Bonus Amount (AED)</label>
							<input type="number" step="0.01" min="0" class="form-control @error('referral_bonus') is-invalid @enderror" name="referral_bonus" value="{{ old('referral_bonus') }}" placeholder="0.00">
							@error('referral_bonus')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Bonus Status</label>
							<select class="form-select @error('bonus_status') is-invalid @enderror" name="bonus_status">
								<option value="">Select Status</option>
								<option value="pending" {{ old('bonus_status') == 'pending' ? 'selected' : '' }}>Pending</option>
								<option value="approved" {{ old('bonus_status') == 'approved' ? 'selected' : '' }}>Approved</option>
								<option value="paid" {{ old('bonus_status') == 'paid' ? 'selected' : '' }}>Paid</option>
							</select>
							@error('bonus_status')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Bonus Paid Date</label>
							<input type="date" class="form-control @error('bonus_paid_date') is-invalid @enderror" name="bonus_paid_date" value="{{ old('bonus_paid_date') }}">
							@error('bonus_paid_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Notes</label>
							<textarea class="form-control @error('notes') is-invalid @enderror" name="notes" rows="3" placeholder="Additional notes about the referral">{{ old('notes') }}</textarea>
							@error('notes')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>

				<div class="card-footer d-flex justify-content-end gap-2">
					<a href="{{ route('referrals.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Create Referral</button>
				</div>
			</form>
		</div>
	</div>

@endsection

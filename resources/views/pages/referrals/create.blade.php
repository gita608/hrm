@extends('layouts.app')

@section('title', 'Add Referral')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Add Referral</h2>
			<p class="text-muted mb-0 fs-13">Create a new employee referral</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('referrals.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
			<h5 class="mb-0 fw-bold text-dark">Referral Information</h5>
		</div>
		<div class="card-body p-4">
			<form action="{{ route('referrals.store') }}" method="POST">
				@csrf
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Referral Code</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="referral_code" value="{{ old('referral_code') }}" placeholder="Auto-generated if left blank">
							@error('referral_code')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Referrer (Employee) <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none" name="referrer_id" required>
								<option value="">Select Employee</option>
								@foreach($employees as $employee)
									<option value="{{ $employee->id }}" {{ old('referrer_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }} ({{ $employee->email }})</option>
								@endforeach
							</select>
							@error('referrer_id')
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
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Referral Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control rounded-3 border-light shadow-none" name="referral_date" value="{{ old('referral_date', date('Y-m-d')) }}" required>
							@error('referral_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Status <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none" name="status" required>
								<option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
								<option value="contacted" {{ old('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
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
				</div>

				<hr class="my-4 border-light">
				<h5 class="mb-3 fw-bold text-dark">Referred Person Information</h5>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">First Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="referred_first_name" value="{{ old('referred_first_name') }}" required>
							@error('referred_first_name')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Last Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="referred_last_name" value="{{ old('referred_last_name') }}" required>
							@error('referred_last_name')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Email <span class="text-danger">*</span></label>
							<input type="email" class="form-control rounded-3 border-light shadow-none" name="referred_email" value="{{ old('referred_email') }}" required>
							@error('referred_email')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Phone</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="referred_phone" value="{{ old('referred_phone') }}">
							@error('referred_phone')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Skills</label>
							<textarea class="form-control rounded-3 border-light shadow-none" name="referred_skills" rows="2" placeholder="Comma-separated skills or detailed description">{{ old('referred_skills') }}</textarea>
							@error('referred_skills')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Experience</label>
							<textarea class="form-control rounded-3 border-light shadow-none" name="referred_experience" rows="3" placeholder="Brief experience summary">{{ old('referred_experience') }}</textarea>
							@error('referred_experience')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>

				<hr class="my-4 border-light">
				<h5 class="mb-3 fw-bold text-dark">Referral Bonus Information</h5>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Referral Bonus Amount (AED)</label>
							<input type="number" step="0.01" min="0" class="form-control rounded-3 border-light shadow-none" name="referral_bonus" value="{{ old('referral_bonus') }}" placeholder="0.00">
							@error('referral_bonus')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Bonus Status</label>
							<select class="form-select rounded-3 border-light shadow-none" name="bonus_status">
								<option value="">Select Status</option>
								<option value="pending" {{ old('bonus_status') == 'pending' ? 'selected' : '' }}>Pending</option>
								<option value="approved" {{ old('bonus_status') == 'approved' ? 'selected' : '' }}>Approved</option>
								<option value="paid" {{ old('bonus_status') == 'paid' ? 'selected' : '' }}>Paid</option>
							</select>
							@error('bonus_status')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Bonus Paid Date</label>
							<input type="date" class="form-control rounded-3 border-light shadow-none" name="bonus_paid_date" value="{{ old('bonus_paid_date') }}">
							@error('bonus_paid_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Notes</label>
							<textarea class="form-control rounded-3 border-light shadow-none" name="notes" rows="3" placeholder="Additional notes about the referral">{{ old('notes') }}</textarea>
							@error('notes')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>

				<div class="d-flex justify-content-end gap-2 mt-4">
					<a href="{{ route('referrals.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
					<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Create Referral</button>
				</div>
			</form>
		</div>
	</div>

@endsection

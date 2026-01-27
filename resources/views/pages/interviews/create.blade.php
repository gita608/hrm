@extends('layouts.app')

@section('title', 'Schedule Interview')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Schedule Interview</h2>
			<p class="text-muted mb-0 fs-13">Create a new interview schedule</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('interviews.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
			<h5 class="mb-0 fw-bold text-dark">Interview Information</h5>
		</div>
		<div class="card-body p-4">
			<form action="{{ route('interviews.store') }}" method="POST">
				@csrf
				<h6 class="fw-bold text-dark mb-3">Candidate Details</h6>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Candidate (User)</label>
							<select class="form-select rounded-3 border-light shadow-none @error('candidate_id') is-invalid @enderror" name="candidate_id" id="candidate_id">
								<option value="">Select Candidate</option>
								@foreach($candidates as $candidate)
									<option value="{{ $candidate->id }}" {{ old('candidate_id') == $candidate->id ? 'selected' : '' }}>{{ $candidate->name }} ({{ $candidate->email }})</option>
								@endforeach
							</select>
							<small class="text-muted fs-11">Or fill in candidate details below if not a user</small>
							@error('candidate_id')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Job Title</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none @error('job_title') is-invalid @enderror" name="job_title" value="{{ old('job_title') }}" placeholder="e.g., Software Developer">
							@error('job_title')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-4">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Candidate Name</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none @error('candidate_name') is-invalid @enderror" name="candidate_name" value="{{ old('candidate_name') }}" id="candidate_name">
							@error('candidate_name')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-4">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Candidate Email</label>
							<input type="email" class="form-control rounded-3 border-light shadow-none @error('candidate_email') is-invalid @enderror" name="candidate_email" value="{{ old('candidate_email') }}" id="candidate_email">
							@error('candidate_email')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-4">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Candidate Phone</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none @error('candidate_phone') is-invalid @enderror" name="candidate_phone" value="{{ old('candidate_phone') }}" id="candidate_phone">
							@error('candidate_phone')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>

				<hr class="my-4 border-light">
				<h6 class="fw-bold text-dark mb-3">Interview Details</h6>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Interviewer <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none @error('interviewer_id') is-invalid @enderror" name="interviewer_id" required>
								<option value="">Select Interviewer</option>
								@foreach($interviewers as $interviewer)
									<option value="{{ $interviewer->id }}" {{ old('interviewer_id') == $interviewer->id ? 'selected' : '' }}>{{ $interviewer->name }}</option>
								@endforeach
							</select>
							@error('interviewer_id')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Status <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none @error('status') is-invalid @enderror" name="status" required>
								<option value="scheduled" {{ old('status', 'scheduled') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
								<option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
								<option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
								<option value="rescheduled" {{ old('status') == 'rescheduled' ? 'selected' : '' }}>Rescheduled</option>
							</select>
							@error('status')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Interview Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control rounded-3 border-light shadow-none @error('interview_date') is-invalid @enderror" name="interview_date" value="{{ old('interview_date') }}" required>
							@error('interview_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Interview Time <span class="text-danger">*</span></label>
							<input type="time" class="form-control rounded-3 border-light shadow-none @error('interview_time') is-invalid @enderror" name="interview_time" value="{{ old('interview_time') }}" required>
							@error('interview_time')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Location / Meeting Link</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none @error('location') is-invalid @enderror" name="location" value="{{ old('location') }}" placeholder="Physical location or video call link">
							@error('location')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Description</label>
							<textarea class="form-control rounded-3 border-light shadow-none @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description') }}</textarea>
							@error('description')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Notes</label>
							<textarea class="form-control rounded-3 border-light shadow-none @error('notes') is-invalid @enderror" name="notes" rows="2">{{ old('notes') }}</textarea>
							@error('notes')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2 mt-4">
					<a href="{{ route('interviews.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
					<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Schedule Interview</button>
				</div>
			</form>
		</div>
	</div>

	<script>
		document.getElementById('candidate_id').addEventListener('change', function() {
			if (this.value) {
				// Disable manual candidate fields if user is selected
				document.getElementById('candidate_name').disabled = true;
				document.getElementById('candidate_email').disabled = true;
				document.getElementById('candidate_phone').disabled = true;
			} else {
				document.getElementById('candidate_name').disabled = false;
				document.getElementById('candidate_email').disabled = false;
				document.getElementById('candidate_phone').disabled = false;
			}
		});
	</script>

@endsection

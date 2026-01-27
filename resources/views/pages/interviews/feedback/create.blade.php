@extends('layouts.app')

@section('title', 'Add Interview Feedback')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Add Interview Feedback</h2>
			<p class="text-muted mb-0 fs-13">Record feedback for an interview</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('interviews.feedback.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
			<h5 class="mb-0 fw-bold text-dark">Feedback Information</h5>
		</div>
		<div class="card-body p-4">
			<form action="{{ route('interviews.feedback.store') }}" method="POST">
				@csrf
				<h6 class="fw-bold text-dark mb-3">Interview Details</h6>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Interview <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none @error('interview_id') is-invalid @enderror" name="interview_id" required>
								<option value="">Select Interview</option>
								@foreach($interviews as $interview)
									<option value="{{ $interview->id }}" {{ old('interview_id', $interviewId ?? null) == $interview->id ? 'selected' : '' }}>
										{{ $interview->candidate->name ?? $interview->candidate_name ?? 'N/A' }} - {{ $interview->interview_date->format('M d, Y') }} ({{ $interview->job_title ?? 'N/A' }})
									</option>
								@endforeach
							</select>
							@error('interview_id')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
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
				</div>

				<hr class="my-4 border-light">
				<h6 class="fw-bold text-dark mb-3">Evaluation</h6>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Rating (1-5)</label>
							<select class="form-select rounded-3 border-light shadow-none @error('rating') is-invalid @enderror" name="rating">
								<option value="">Select Rating</option>
								@for($i = 1; $i <= 5; $i++)
									<option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
								@endfor
							</select>
							@error('rating')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Recommendation</label>
							<select class="form-select rounded-3 border-light shadow-none @error('recommendation') is-invalid @enderror" name="recommendation">
								<option value="">Select Recommendation</option>
								<option value="strong_hire" {{ old('recommendation') == 'strong_hire' ? 'selected' : '' }}>Strong Hire</option>
								<option value="hire" {{ old('recommendation') == 'hire' ? 'selected' : '' }}>Hire</option>
								<option value="maybe" {{ old('recommendation') == 'maybe' ? 'selected' : '' }}>Maybe</option>
								<option value="reject" {{ old('recommendation') == 'reject' ? 'selected' : '' }}>Reject</option>
							</select>
							@error('recommendation')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Feedback</label>
							<textarea class="form-control rounded-3 border-light shadow-none @error('feedback') is-invalid @enderror" name="feedback" rows="4">{{ old('feedback') }}</textarea>
							@error('feedback')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Strengths</label>
							<textarea class="form-control rounded-3 border-light shadow-none @error('strengths') is-invalid @enderror" name="strengths" rows="3">{{ old('strengths') }}</textarea>
							@error('strengths')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Weaknesses</label>
							<textarea class="form-control rounded-3 border-light shadow-none @error('weaknesses') is-invalid @enderror" name="weaknesses" rows="3">{{ old('weaknesses') }}</textarea>
							@error('weaknesses')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Additional Notes</label>
							<textarea class="form-control rounded-3 border-light shadow-none @error('additional_notes') is-invalid @enderror" name="additional_notes" rows="3">{{ old('additional_notes') }}</textarea>
							@error('additional_notes')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2 mt-4">
					<a href="{{ route('interviews.feedback.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
					<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Submit Feedback</button>
				</div>
			</form>
		</div>
	</div>

@endsection

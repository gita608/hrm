@extends('layouts.app')

@section('title', 'Edit Interview Feedback')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Edit Interview Feedback</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('interviews.feedback.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="card">
		<div class="card-header">
			<h5>Feedback Information</h5>
		</div>
		<div class="card-body">
			<form action="{{ route('interviews.feedback.update', $feedback->id) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Interview <span class="text-danger">*</span></label>
							<select class="form-select @error('interview_id') is-invalid @enderror" name="interview_id" required>
								<option value="">Select Interview</option>
								@foreach($interviews as $interview)
									<option value="{{ $interview->id }}" {{ old('interview_id', $feedback->interview_id) == $interview->id ? 'selected' : '' }}>
										{{ $interview->candidate->name ?? $interview->candidate_name ?? 'N/A' }} - {{ $interview->interview_date->format('M d, Y') }} ({{ $interview->job_title ?? 'N/A' }})
									</option>
								@endforeach
							</select>
							@error('interview_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Interviewer <span class="text-danger">*</span></label>
							<select class="form-select @error('interviewer_id') is-invalid @enderror" name="interviewer_id" required>
								<option value="">Select Interviewer</option>
								@foreach($interviewers as $interviewer)
									<option value="{{ $interviewer->id }}" {{ old('interviewer_id', $feedback->interviewer_id) == $interviewer->id ? 'selected' : '' }}>{{ $interviewer->name }}</option>
								@endforeach
							</select>
							@error('interviewer_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Rating (1-5)</label>
							<select class="form-select @error('rating') is-invalid @enderror" name="rating">
								<option value="">Select Rating</option>
								@for($i = 1; $i <= 5; $i++)
									<option value="{{ $i }}" {{ old('rating', $feedback->rating) == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
								@endfor
							</select>
							@error('rating')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Recommendation</label>
							<select class="form-select @error('recommendation') is-invalid @enderror" name="recommendation">
								<option value="">Select Recommendation</option>
								<option value="strong_hire" {{ old('recommendation', $feedback->recommendation) == 'strong_hire' ? 'selected' : '' }}>Strong Hire</option>
								<option value="hire" {{ old('recommendation', $feedback->recommendation) == 'hire' ? 'selected' : '' }}>Hire</option>
								<option value="maybe" {{ old('recommendation', $feedback->recommendation) == 'maybe' ? 'selected' : '' }}>Maybe</option>
								<option value="reject" {{ old('recommendation', $feedback->recommendation) == 'reject' ? 'selected' : '' }}>Reject</option>
							</select>
							@error('recommendation')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Feedback</label>
							<textarea class="form-control @error('feedback') is-invalid @enderror" name="feedback" rows="4">{{ old('feedback', $feedback->feedback) }}</textarea>
							@error('feedback')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Strengths</label>
							<textarea class="form-control @error('strengths') is-invalid @enderror" name="strengths" rows="3">{{ old('strengths', $feedback->strengths) }}</textarea>
							@error('strengths')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Weaknesses</label>
							<textarea class="form-control @error('weaknesses') is-invalid @enderror" name="weaknesses" rows="3">{{ old('weaknesses', $feedback->weaknesses) }}</textarea>
							@error('weaknesses')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Additional Notes</label>
							<textarea class="form-control @error('additional_notes') is-invalid @enderror" name="additional_notes" rows="3">{{ old('additional_notes', $feedback->additional_notes) }}</textarea>
							@error('additional_notes')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2">
					<a href="{{ route('interviews.feedback.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Update Feedback</button>
				</div>
			</form>
		</div>
	</div>

@endsection

@extends('layouts.app')

@section('title', 'Edit Interview')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Edit Interview</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('interviews.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="card">
		<div class="card-header">
			<h5>Interview Information</h5>
		</div>
		<div class="card-body">
			<form action="{{ route('interviews.update', $interview->id) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Candidate (User)</label>
							<select class="form-select @error('candidate_id') is-invalid @enderror" name="candidate_id" id="candidate_id">
								<option value="">Select Candidate</option>
								@foreach($candidates as $candidate)
									<option value="{{ $candidate->id }}" {{ old('candidate_id', $interview->candidate_id) == $candidate->id ? 'selected' : '' }}>{{ $candidate->name }} ({{ $candidate->email }})</option>
								@endforeach
							</select>
							<small class="text-muted">Or fill in candidate details below if not a user</small>
							@error('candidate_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Job Title</label>
							<input type="text" class="form-control @error('job_title') is-invalid @enderror" name="job_title" value="{{ old('job_title', $interview->job_title) }}" placeholder="e.g., Software Developer">
							@error('job_title')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-4">
						<div class="mb-3">
							<label class="form-label">Candidate Name</label>
							<input type="text" class="form-control @error('candidate_name') is-invalid @enderror" name="candidate_name" value="{{ old('candidate_name', $interview->candidate_name) }}" id="candidate_name">
							@error('candidate_name')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-4">
						<div class="mb-3">
							<label class="form-label">Candidate Email</label>
							<input type="email" class="form-control @error('candidate_email') is-invalid @enderror" name="candidate_email" value="{{ old('candidate_email', $interview->candidate_email) }}" id="candidate_email">
							@error('candidate_email')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-4">
						<div class="mb-3">
							<label class="form-label">Candidate Phone</label>
							<input type="text" class="form-control @error('candidate_phone') is-invalid @enderror" name="candidate_phone" value="{{ old('candidate_phone', $interview->candidate_phone) }}" id="candidate_phone">
							@error('candidate_phone')
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
									<option value="{{ $interviewer->id }}" {{ old('interviewer_id', $interview->interviewer_id) == $interviewer->id ? 'selected' : '' }}>{{ $interviewer->name }}</option>
								@endforeach
							</select>
							@error('interviewer_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Status <span class="text-danger">*</span></label>
							<select class="form-select @error('status') is-invalid @enderror" name="status" required>
								<option value="scheduled" {{ old('status', $interview->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
								<option value="completed" {{ old('status', $interview->status) == 'completed' ? 'selected' : '' }}>Completed</option>
								<option value="cancelled" {{ old('status', $interview->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
								<option value="rescheduled" {{ old('status', $interview->status) == 'rescheduled' ? 'selected' : '' }}>Rescheduled</option>
							</select>
							@error('status')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Interview Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control @error('interview_date') is-invalid @enderror" name="interview_date" value="{{ old('interview_date', $interview->interview_date->format('Y-m-d')) }}" required>
							@error('interview_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Interview Time <span class="text-danger">*</span></label>
							<input type="time" class="form-control @error('interview_time') is-invalid @enderror" name="interview_time" value="{{ old('interview_time', \Carbon\Carbon::parse($interview->interview_time)->format('H:i')) }}" required>
							@error('interview_time')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Location / Meeting Link</label>
							<input type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ old('location', $interview->location) }}" placeholder="Physical location or video call link">
							@error('location')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Description</label>
							<textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description', $interview->description) }}</textarea>
							@error('description')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Notes</label>
							<textarea class="form-control @error('notes') is-invalid @enderror" name="notes" rows="2">{{ old('notes', $interview->notes) }}</textarea>
							@error('notes')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2">
					<a href="{{ route('interviews.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Update Interview</button>
				</div>
			</form>
		</div>
	</div>

	<script>
		document.getElementById('candidate_id').addEventListener('change', function() {
			if (this.value) {
				document.getElementById('candidate_name').disabled = true;
				document.getElementById('candidate_email').disabled = true;
				document.getElementById('candidate_phone').disabled = true;
			} else {
				document.getElementById('candidate_name').disabled = false;
				document.getElementById('candidate_email').disabled = false;
				document.getElementById('candidate_phone').disabled = false;
			}
		});
		// Initialize on page load
		if (document.getElementById('candidate_id').value) {
			document.getElementById('candidate_name').disabled = true;
			document.getElementById('candidate_email').disabled = true;
			document.getElementById('candidate_phone').disabled = true;
		}
	</script>

@endsection

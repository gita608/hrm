@extends('layouts.app')

@section('title', 'Feedback Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Feedback Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('interviews.feedback.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5>Interview Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-4"><strong>Candidate:</strong></div>
						<div class="col-md-8">
							@if($feedback->interview->candidate)
								{{ $feedback->interview->candidate->name }}<br>
								<small class="text-muted">{{ $feedback->interview->candidate->email }}</small>
							@else
								{{ $feedback->interview->candidate_name ?? 'N/A' }}<br>
								@if($feedback->interview->candidate_email)
									<small class="text-muted">{{ $feedback->interview->candidate_email }}</small>
								@endif
							@endif
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Job Title:</strong></div>
						<div class="col-md-8">{{ $feedback->interview->job_title ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Interview Date:</strong></div>
						<div class="col-md-8">{{ $feedback->interview->interview_date->format('M d, Y') }} at {{ \Carbon\Carbon::parse($feedback->interview->interview_time)->format('h:i A') }}</div>
					</div>
				</div>
			</div>

			<div class="card mt-3">
				<div class="card-header">
					<h5>Feedback Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-4"><strong>Interviewer:</strong></div>
						<div class="col-md-8">{{ $feedback->interviewer->name ?? 'N/A' }}</div>
					</div>
					@if($feedback->rating)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Rating:</strong></div>
						<div class="col-md-8">
							@for($i = 1; $i <= 5; $i++)
								<i class="ti ti-star{{ $i <= $feedback->rating ? '-filled' : '' }} text-warning"></i>
							@endfor
							<span class="ms-2">({{ $feedback->rating }}/5)</span>
						</div>
					</div>
					@endif
					@if($feedback->recommendation)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Recommendation:</strong></div>
						<div class="col-md-8">
							@if($feedback->recommendation == 'hire' || $feedback->recommendation == 'strong_hire')
								<span class="badge badge-success">{{ ucfirst(str_replace('_', ' ', $feedback->recommendation)) }}</span>
							@elseif($feedback->recommendation == 'reject')
								<span class="badge badge-danger">Reject</span>
							@else
								<span class="badge badge-warning">Maybe</span>
							@endif
						</div>
					</div>
					@endif
					@if($feedback->feedback)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Feedback:</strong></div>
						<div class="col-md-8">{{ $feedback->feedback }}</div>
					</div>
					@endif
					@if($feedback->strengths)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Strengths:</strong></div>
						<div class="col-md-8">{{ $feedback->strengths }}</div>
					</div>
					@endif
					@if($feedback->weaknesses)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Weaknesses:</strong></div>
						<div class="col-md-8">{{ $feedback->weaknesses }}</div>
					</div>
					@endif
					@if($feedback->additional_notes)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Additional Notes:</strong></div>
						<div class="col-md-8">{{ $feedback->additional_notes }}</div>
					</div>
					@endif
					<div class="row mb-3">
						<div class="col-md-4"><strong>Created At:</strong></div>
						<div class="col-md-8">{{ $feedback->created_at->format('M d, Y H:i') }}</div>
					</div>
					<div class="row">
						<div class="col-md-4"><strong>Updated At:</strong></div>
						<div class="col-md-8">{{ $feedback->updated_at->format('M d, Y H:i') }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body text-center">
					<div class="avatar avatar-xxl mb-3">
						<i class="ti ti-message-circle fs-48 text-primary"></i>
					</div>
					<h4 class="mb-1">{{ $feedback->interviewer->name ?? 'N/A' }}</h4>
					<p class="text-muted mb-2">Interview Feedback</p>
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('interviews.feedback.edit', $feedback->id) }}" class="btn btn-primary btn-sm">
							<i class="ti ti-edit me-2"></i>Edit Feedback
						</a>
						<a href="{{ route('interviews.show', $feedback->interview_id) }}" class="btn btn-info btn-sm">
							<i class="ti ti-eye me-2"></i>View Interview
						</a>
						<form action="{{ route('interviews.feedback.destroy', $feedback->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this feedback?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger btn-sm w-100">
								<i class="ti ti-trash me-2"></i>Delete Feedback
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

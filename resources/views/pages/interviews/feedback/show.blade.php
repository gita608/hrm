@extends('layouts.app')

@section('title', 'Feedback Details')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Feedback Details</h2>
			<p class="text-muted mb-0 fs-13">View interview feedback and evaluation</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('interviews.feedback.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="row">
		<div class="col-md-4 order-md-last">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-body text-center p-4">
					<div class="avatar avatar-xxl mb-3 bg-primary-transparent text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
						<i class="ti ti-message-circle fs-36"></i>
					</div>
					<h4 class="mb-1 text-dark fw-bold">{{ $feedback->interviewer->name ?? 'N/A' }}</h4>
					<p class="text-muted mb-4 pt-1">Interviewer</p>

					@if($feedback->recommendation)
						<div class="mb-4">
						@if($feedback->recommendation == 'hire' || $feedback->recommendation == 'strong_hire')
							<span class="badge bg-success-transparent text-success rounded-pill px-3 py-2 fs-12">{{ ucfirst(str_replace('_', ' ', $feedback->recommendation)) }}</span>
						@elseif($feedback->recommendation == 'reject')
							<span class="badge bg-danger-transparent text-danger rounded-pill px-3 py-2 fs-12">Reject</span>
						@else
							<span class="badge bg-warning-transparent text-warning rounded-pill px-3 py-2 fs-12">Maybe</span>
						@endif
						</div>
					@endif

					<div class="d-flex flex-column gap-2">
						<a href="{{ route('interviews.feedback.edit', $feedback->id) }}" class="btn btn-primary rounded-pill shadow-sm py-2">
							<i class="ti ti-edit me-2"></i>Edit Feedback
						</a>
						<a href="{{ route('interviews.show', $feedback->interview_id) }}" class="btn btn-info rounded-pill shadow-sm py-2 text-white">
							<i class="ti ti-eye me-2"></i>View Interview
						</a>
						<form action="{{ route('interviews.feedback.destroy', $feedback->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this feedback?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger rounded-pill w-100 py-2">
								<i class="ti ti-trash me-2"></i>Delete Feedback
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Interview Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Candidate</div>
						<div class="col-md-8">
							@if($feedback->interview->candidate)
								<span class="text-dark fw-medium">{{ $feedback->interview->candidate->name }}</span><br>
								<small class="text-muted">{{ $feedback->interview->candidate->email }}</small>
							@else
								<span class="text-dark fw-medium">{{ $feedback->interview->candidate_name ?? 'N/A' }}</span><br>
								@if($feedback->interview->candidate_email)
									<small class="text-muted">{{ $feedback->interview->candidate_email }}</small>
								@endif
							@endif
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Job Title</div>
						<div class="col-md-8 text-dark">{{ $feedback->interview->job_title ?? 'N/A' }}</div>
					</div>
					<div class="row">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Interview Date</div>
						<div class="col-md-8 text-dark">{{ $feedback->interview->interview_date->format('M d, Y') }} <span class="text-muted mx-1">at</span> {{ \Carbon\Carbon::parse($feedback->interview->interview_time)->format('h:i A') }}</div>
					</div>
				</div>
			</div>

			<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Feedback Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Interviewer</div>
						<div class="col-md-8 text-dark fw-bold">{{ $feedback->interviewer->name ?? 'N/A' }}</div>
					</div>
					@if($feedback->rating)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Rating</div>
						<div class="col-md-8 d-flex align-items-center">
							<div class="me-2">
								@for($i = 1; $i <= 5; $i++)
									<i class="ti ti-star{{ $i <= $feedback->rating ? '-filled' : '' }} text-warning"></i>
								@endfor
							</div>
							<span class="fw-bold text-dark">({{ $feedback->rating }}/5)</span>
						</div>
					</div>
					@endif
					@if($feedback->feedback)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Feedback</div>
						<div class="col-md-8 text-dark bg-light-50 p-3 rounded-3 border-start border-3 border-primary">{{ $feedback->feedback }}</div>
					</div>
					@endif
					@if($feedback->strengths)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Strengths</div>
						<div class="col-md-8">
							<div class="p-3 bg-success-subtle rounded-3">
								<span class="text-dark">{{ $feedback->strengths }}</span>
							</div>
						</div>
					</div>
					@endif
					@if($feedback->weaknesses)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Weaknesses</div>
						<div class="col-md-8">
							<div class="p-3 bg-danger-subtle rounded-3">
								<span class="text-dark">{{ $feedback->weaknesses }}</span>
							</div>
						</div>
					</div>
					@endif
					@if($feedback->additional_notes)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Additional Notes</div>
						<div class="col-md-8 text-dark">{{ $feedback->additional_notes }}</div>
					</div>
					@endif
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Created At</div>
						<div class="col-md-8 text-muted">{{ $feedback->created_at->format('M d, Y H:i') }}</div>
					</div>
					<div class="row">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Updated At</div>
						<div class="col-md-8 text-muted">{{ $feedback->updated_at->format('M d, Y H:i') }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

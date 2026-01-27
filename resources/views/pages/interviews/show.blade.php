@extends('layouts.app')

@section('title', 'Interview Details')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Interview Details</h2>
			<p class="text-muted mb-0 fs-13">View interview schedule and candidate information</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('interviews.index') }}" class="btn btn-light rounded-pill border shadow-sm">
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
						<i class="ti ti-calendar-check fs-36"></i>
					</div>
					<h4 class="mb-1 text-dark fw-bold">
						@if($interview->candidate)
							{{ $interview->candidate->name }}
						@else
							{{ $interview->candidate_name ?? 'N/A' }}
						@endif
					</h4>
					<p class="text-muted mb-4 pt-1">{{ $interview->job_title ?? 'N/A' }}</p>

					@if($interview->status == 'scheduled')
						<span class="badge bg-info-transparent text-info rounded-pill px-3 py-2 mb-4">Scheduled</span>
					@elseif($interview->status == 'completed')
						<span class="badge bg-success-transparent text-success rounded-pill px-3 py-2 mb-4">Completed</span>
					@elseif($interview->status == 'cancelled')
						<span class="badge bg-danger-transparent text-danger rounded-pill px-3 py-2 mb-4">Cancelled</span>
					@else
						<span class="badge bg-warning-transparent text-warning rounded-pill px-3 py-2 mb-4">Rescheduled</span>
					@endif

					@if($interview->interviewer)
					<div class="mb-4 pb-4 border-bottom border-light">
						<p class="mb-2 fs-12 text-uppercase text-muted fw-bold ls-1">Interviewer</p>
						<div class="d-flex align-items-center justify-content-center gap-2">
							<div class="avatar avatar-sm bg-light rounded-circle fw-bold d-flex align-items-center justify-content-center border text-dark" style="width: 32px; height: 32px; font-size: 12px;">
								{{ strtoupper(substr($interview->interviewer->name, 0, 1)) }}
							</div>
							<div class="text-start">
								<span class="text-dark fw-bold d-block lh-1">{{ $interview->interviewer->name }}</span>
								<small class="text-muted">{{ $interview->interviewer->email }}</small>
							</div>
						</div>
					</div>
					@endif

					<div class="d-flex flex-column gap-2">
						<a href="{{ route('interviews.edit', $interview->id) }}" class="btn btn-primary rounded-pill shadow-sm py-2">
							<i class="ti ti-edit me-2"></i>Edit Interview
						</a>
						<a href="{{ route('interviews.feedback.create', ['interview_id' => $interview->id]) }}" class="btn btn-success rounded-pill shadow-sm py-2">
							<i class="ti ti-message-circle me-2"></i>Add Feedback
						</a>
						<form action="{{ route('interviews.destroy', $interview->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this interview?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger rounded-pill w-100 py-2">
								<i class="ti ti-trash me-2"></i>Delete Interview
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
							@if($interview->candidate)
								<span class="text-dark fw-medium">{{ $interview->candidate->name }}</span><br>
								<small class="text-muted">{{ $interview->candidate->email }}</small>
							@else
								<span class="text-dark fw-medium">{{ $interview->candidate_name ?? 'N/A' }}</span><br>
								@if($interview->candidate_email)
									<small class="text-muted">{{ $interview->candidate_email }}</small>
								@endif
							@endif
						</div>
					</div>
					@if($interview->candidate_phone)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Phone</div>
						<div class="col-md-8 text-dark">{{ $interview->candidate_phone }}</div>
					</div>
					@endif
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Job Title</div>
						<div class="col-md-8 text-dark">{{ $interview->job_title ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Date & Time</div>
						<div class="col-md-8 text-dark">
							{{ $interview->interview_date->format('M d, Y') }} <span class="text-muted mx-1">at</span> {{ \Carbon\Carbon::parse($interview->interview_time)->format('h:i A') }}
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Location</div>
						<div class="col-md-8 text-dark d-flex align-items-center">
							<i class="ti ti-map-pin me-2 text-muted"></i>
							{{ $interview->location ?? 'Online' }}
						</div>
					</div>
					@if($interview->description)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Description</div>
						<div class="col-md-8 text-dark">{{ $interview->description }}</div>
					</div>
					@endif
					@if($interview->notes)
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Notes</div>
						<div class="col-md-8 text-dark">{{ $interview->notes }}</div>
					</div>
					@endif
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Created At</div>
						<div class="col-md-8 text-muted">{{ $interview->created_at->format('M d, Y H:i') }}</div>
					</div>
					<div class="row">
						<div class="col-md-4 text-muted fs-13 text-uppercase fw-medium">Updated At</div>
						<div class="col-md-8 text-muted">{{ $interview->updated_at->format('M d, Y H:i') }}</div>
					</div>
				</div>
			</div>

			@if($interview->feedbacks->count() > 0)
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Interview Feedback</h5>
				</div>
				<div class="card-body p-4">
					@foreach($interview->feedbacks as $feedback)
						<div class="border-bottom border-light pb-4 mb-4 last:mb-0 last:pb-0 last:border-0">
							<div class="d-flex justify-content-between align-items-start mb-3">
								<div class="d-flex align-items-center">
									<div class="avatar avatar-sm bg-light rounded-circle fw-bold d-flex align-items-center justify-content-center border text-dark me-2">
										{{ strtoupper(substr($feedback->interviewer->name ?? 'A', 0, 1)) }}
									</div>
									<div>
										<h6 class="mb-0 fw-bold text-dark">{{ $feedback->interviewer->name ?? 'N/A' }}</h6>
										<small class="text-muted">{{ $feedback->created_at->format('M d, Y H:i') }}</small>
									</div>
								</div>
								@if($feedback->rating)
									<div class="bg-light px-2 py-1 rounded-pill border">
										@for($i = 1; $i <= 5; $i++)
											<i class="ti ti-star{{ $i <= $feedback->rating ? '-filled' : '' }} text-warning" style="font-size: 14px;"></i>
										@endfor
									</div>
								@endif
							</div>
							@if($feedback->recommendation)
								<div class="mb-3">
									<span class="text-muted fs-12 text-uppercase fw-medium me-2">Recommendation:</span>
									@if($feedback->recommendation == 'hire' || $feedback->recommendation == 'strong_hire')
										<span class="badge bg-success-transparent text-success rounded-pill px-2">{{ ucfirst(str_replace('_', ' ', $feedback->recommendation)) }}</span>
									@elseif($feedback->recommendation == 'reject')
										<span class="badge bg-danger-transparent text-danger rounded-pill px-2">Reject</span>
									@else
										<span class="badge bg-warning-transparent text-warning rounded-pill px-2">Maybe</span>
									@endif
								</div>
							@endif
							@if($feedback->feedback)
								<p class="mb-3 text-dark bg-light-50 p-3 rounded-3 border-start border-3 border-primary">{{ $feedback->feedback }}</p>
							@endif
							<div class="row g-3">
								@if($feedback->strengths)
									<div class="col-md-6">
										<div class="p-3 bg-success-subtle rounded-3 h-100">
											<strong class="text-success d-block mb-1"><i class="ti ti-thumb-up me-1"></i>Strengths</strong>
											<span class="text-dark">{{ $feedback->strengths }}</span>
										</div>
									</div>
								@endif
								@if($feedback->weaknesses)
									<div class="col-md-6">
										<div class="p-3 bg-danger-subtle rounded-3 h-100">
											<strong class="text-danger d-block mb-1"><i class="ti ti-thumb-down me-1"></i>Weaknesses</strong>
											<span class="text-dark">{{ $feedback->weaknesses }}</span>
										</div>
									</div>
								@endif
							</div>
						</div>
					@endforeach
				</div>
			</div>
			@endif
		</div>
	</div>

@endsection

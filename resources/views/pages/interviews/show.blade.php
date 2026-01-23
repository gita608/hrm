@extends('layouts.app')

@section('title', 'Interview Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Interview Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('interviews.index') }}" class="btn btn-outline-light border">Back to List</a>
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
							@if($interview->candidate)
								{{ $interview->candidate->name }}<br>
								<small class="text-muted">{{ $interview->candidate->email }}</small>
							@else
								{{ $interview->candidate_name ?? 'N/A' }}<br>
								@if($interview->candidate_email)
									<small class="text-muted">{{ $interview->candidate_email }}</small>
								@endif
							@endif
						</div>
					</div>
					@if($interview->candidate_phone)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Phone:</strong></div>
						<div class="col-md-8">{{ $interview->candidate_phone }}</div>
					</div>
					@endif
					<div class="row mb-3">
						<div class="col-md-4"><strong>Job Title:</strong></div>
						<div class="col-md-8">{{ $interview->job_title ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Interviewer:</strong></div>
						<div class="col-md-8">
							@if($interview->interviewer)
								{{ $interview->interviewer->name }}
							@else
								N/A
							@endif
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Date & Time:</strong></div>
						<div class="col-md-8">
							{{ $interview->interview_date->format('M d, Y') }} at {{ \Carbon\Carbon::parse($interview->interview_time)->format('h:i A') }}
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Location:</strong></div>
						<div class="col-md-8">{{ $interview->location ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Status:</strong></div>
						<div class="col-md-8">
							@if($interview->status == 'scheduled')
								<span class="badge badge-info">Scheduled</span>
							@elseif($interview->status == 'completed')
								<span class="badge badge-success">Completed</span>
							@elseif($interview->status == 'cancelled')
								<span class="badge badge-danger">Cancelled</span>
							@else
								<span class="badge badge-warning">Rescheduled</span>
							@endif
						</div>
					</div>
					@if($interview->description)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Description:</strong></div>
						<div class="col-md-8">{{ $interview->description }}</div>
					</div>
					@endif
					@if($interview->notes)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Notes:</strong></div>
						<div class="col-md-8">{{ $interview->notes }}</div>
					</div>
					@endif
					<div class="row mb-3">
						<div class="col-md-4"><strong>Created At:</strong></div>
						<div class="col-md-8">{{ $interview->created_at->format('M d, Y H:i') }}</div>
					</div>
					<div class="row">
						<div class="col-md-4"><strong>Updated At:</strong></div>
						<div class="col-md-8">{{ $interview->updated_at->format('M d, Y H:i') }}</div>
					</div>
				</div>
			</div>

			@if($interview->feedbacks->count() > 0)
			<div class="card mt-3">
				<div class="card-header">
					<h5>Interview Feedback</h5>
				</div>
				<div class="card-body">
					@foreach($interview->feedbacks as $feedback)
						<div class="border-bottom pb-3 mb-3">
							<div class="d-flex justify-content-between align-items-start mb-2">
								<div>
									<h6 class="mb-1">{{ $feedback->interviewer->name ?? 'N/A' }}</h6>
									<small class="text-muted">{{ $feedback->created_at->format('M d, Y H:i') }}</small>
								</div>
								@if($feedback->rating)
									<div>
										@for($i = 1; $i <= 5; $i++)
											<i class="ti ti-star{{ $i <= $feedback->rating ? '-filled' : '' }} text-warning"></i>
										@endfor
									</div>
								@endif
							</div>
							@if($feedback->recommendation)
								<div class="mb-2">
									<strong>Recommendation:</strong>
									@if($feedback->recommendation == 'hire' || $feedback->recommendation == 'strong_hire')
										<span class="badge badge-success">{{ ucfirst(str_replace('_', ' ', $feedback->recommendation)) }}</span>
									@elseif($feedback->recommendation == 'reject')
										<span class="badge badge-danger">Reject</span>
									@else
										<span class="badge badge-warning">Maybe</span>
									@endif
								</div>
							@endif
							@if($feedback->feedback)
								<p class="mb-2">{{ $feedback->feedback }}</p>
							@endif
							@if($feedback->strengths)
								<div class="mb-2">
									<strong>Strengths:</strong> {{ $feedback->strengths }}
								</div>
							@endif
							@if($feedback->weaknesses)
								<div class="mb-2">
									<strong>Weaknesses:</strong> {{ $feedback->weaknesses }}
								</div>
							@endif
						</div>
					@endforeach
				</div>
			</div>
			@endif
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body text-center">
					<div class="avatar avatar-xxl mb-3">
						<i class="ti ti-calendar-check fs-48 text-primary"></i>
					</div>
					<h4 class="mb-1">
						@if($interview->candidate)
							{{ $interview->candidate->name }}
						@else
							{{ $interview->candidate_name ?? 'N/A' }}
						@endif
					</h4>
					<p class="text-muted mb-2">{{ $interview->job_title ?? 'N/A' }}</p>
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('interviews.edit', $interview->id) }}" class="btn btn-primary btn-sm">
							<i class="ti ti-edit me-2"></i>Edit Interview
						</a>
						<a href="{{ route('interviews.feedback.create', ['interview_id' => $interview->id]) }}" class="btn btn-success btn-sm">
							<i class="ti ti-message-circle me-2"></i>Add Feedback
						</a>
						<form action="{{ route('interviews.destroy', $interview->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this interview?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger btn-sm w-100">
								<i class="ti ti-trash me-2"></i>Delete Interview
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

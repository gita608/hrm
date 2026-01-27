@extends('layouts.app')

@section('title', 'Interview Feedback')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Interview Feedback</h2>
			<p class="text-muted mb-0 fs-13">View and manage interview evaluations</p>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
			<a href="{{ route('interviews.feedback.create') }}" class="btn btn-primary d-flex align-items-center rounded-pill shadow-sm">
				<i class="ti ti-circle-plus me-2 fs-4"></i>Add Feedback
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	@if(session('success'))
		<div class="alert alert-success alert-dismissible fade show border-0 bg-success-transparent text-success rounded-3 mb-4" role="alert">
			<div class="d-flex align-items-center">
				<i class="ti ti-check-circle me-2 fs-5"></i>
				<div>{{ session('success') }}</div>
			</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2 d-flex align-items-center justify-content-between flex-wrap row-gap-3">
			<h5 class="mb-0 fw-bold text-dark">Feedback List</h5>
			<div class="d-flex align-items-center gap-2 flex-wrap">
				<form method="GET" action="{{ route('interviews.feedback.index') }}" class="d-flex gap-2 flex-wrap">
					<select name="interview_id" class="form-select form-select-sm rounded-pill border-light" onchange="this.form.submit()" style="width: 180px;">
						<option value="">All Interviews</option>
						@foreach($interviews as $interview)
							<option value="{{ $interview->id }}" {{ request('interview_id') == $interview->id ? 'selected' : '' }}>
								{{ $interview->candidate->name ?? $interview->candidate_name ?? 'N/A' }} - {{ $interview->interview_date->format('M d') }}
							</option>
						@endforeach
					</select>
					<select name="interviewer_id" class="form-select form-select-sm rounded-pill border-light" onchange="this.form.submit()" style="width: 150px;">
						<option value="">All Interviewers</option>
						@foreach($interviewers as $interviewer)
							<option value="{{ $interviewer->id }}" {{ request('interviewer_id') == $interviewer->id ? 'selected' : '' }}>{{ $interviewer->name }}</option>
						@endforeach
					</select>
					<select name="recommendation" class="form-select form-select-sm rounded-pill border-light" onchange="this.form.submit()" style="width: 160px;">
						<option value="">All Recommendations</option>
						<option value="hire" {{ request('recommendation') == 'hire' ? 'selected' : '' }}>Hire</option>
						<option value="strong_hire" {{ request('recommendation') == 'strong_hire' ? 'selected' : '' }}>Strong Hire</option>
						<option value="maybe" {{ request('recommendation') == 'maybe' ? 'selected' : '' }}>Maybe</option>
						<option value="reject" {{ request('recommendation') == 'reject' ? 'selected' : '' }}>Reject</option>
					</select>
					@if(request()->hasAny(['interview_id', 'interviewer_id', 'recommendation']))
						<a href="{{ route('interviews.feedback.index') }}" class="btn btn-sm btn-light rounded-pill border" data-bs-toggle="tooltip" title="Clear Filters">
							<i class="ti ti-x"></i>
						</a>
					@endif
				</form>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="bg-light-50 border-bottom border-light">
						<tr>
							<th class="ps-4 py-3 text-muted fs-12 fw-medium text-uppercase">#</th>
							<th class="py-3 text-muted fs-12 fw-medium text-uppercase">Candidate</th>
							<th class="py-3 text-muted fs-12 fw-medium text-uppercase">Interview Date</th>
							<th class="py-3 text-muted fs-12 fw-medium text-uppercase">Interviewer</th>
							<th class="py-3 text-muted fs-12 fw-medium text-uppercase">Rating</th>
							<th class="py-3 text-muted fs-12 fw-medium text-uppercase">Recommendation</th>
							<th class="py-3 text-muted fs-12 fw-medium text-uppercase">Feedback</th>
							<th class="pe-4 py-3 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($feedbacks as $feedback)
							<tr>
								<td class="ps-4">{{ $loop->iteration }}</td>
								<td>
									@if($feedback->interview->candidate)
										<div class="d-flex flex-column">
											<span class="fw-bold text-dark">{{ $feedback->interview->candidate->name }}</span>
											<span class="text-muted small">{{ $feedback->interview->job_title ?? 'N/A' }}</span>
										</div>
									@else
										<div class="d-flex flex-column">
											<span class="fw-bold text-dark">{{ $feedback->interview->candidate_name ?? 'N/A' }}</span>
											<span class="text-muted small">{{ $feedback->interview->job_title ?? 'N/A' }}</span>
										</div>
									@endif
								</td>
								<td><span class="text-muted">{{ $feedback->interview->interview_date->format('M d, Y') }}</span></td>
								<td>
									<div class="d-flex align-items-center">
										<div class="avatar avatar-xs bg-primary-transparent text-primary rounded-circle me-2 d-flex align-items-center justify-content-center fw-bold" style="width: 24px; height: 24px; font-size: 10px;">
											{{ strtoupper(substr($feedback->interviewer->name ?? 'A', 0, 1)) }}
										</div>
										<span class="text-dark">{{ $feedback->interviewer->name ?? 'N/A' }}</span>
									</div>
								</td>
								<td>
									@if($feedback->rating)
										<div class="d-flex align-items-center">
											<i class="ti ti-star-filled text-warning me-1"></i>
											<span class="fw-bold">{{ $feedback->rating }}</span><span class="text-muted text-xs">/5</span>
										</div>
									@else
										<span class="text-muted">N/A</span>
									@endif
								</td>
								<td>
									@if($feedback->recommendation)
										@if($feedback->recommendation == 'hire' || $feedback->recommendation == 'strong_hire')
											<span class="badge bg-success-transparent text-success rounded-pill px-2 py-1">{{ ucfirst(str_replace('_', ' ', $feedback->recommendation)) }}</span>
										@elseif($feedback->recommendation == 'reject')
											<span class="badge bg-danger-transparent text-danger rounded-pill px-2 py-1">Reject</span>
										@else
											<span class="badge bg-warning-transparent text-warning rounded-pill px-2 py-1">Maybe</span>
										@endif
									@else
										<span class="text-muted">N/A</span>
									@endif
								</td>
								<td><span class="text-muted text-truncate d-block" style="max-width: 200px;">{{ Str::limit($feedback->feedback ?? 'N/A', 50) }}</span></td>
								<td class="pe-4 text-end">
									<div class="d-flex justify-content-end gap-1">
										<a href="{{ route('interviews.feedback.show', $feedback->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all" data-bs-toggle="tooltip" title="View Details">
											<i class="ti ti-eye"></i>
										</a>
										<a href="{{ route('interviews.feedback.edit', $feedback->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-info hover-text-white transition-all" data-bs-toggle="tooltip" title="Edit">
											<i class="ti ti-edit"></i>
										</a>
										<form action="{{ route('interviews.feedback.destroy', $feedback->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this feedback?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-danger hover-text-white transition-all" data-bs-toggle="tooltip" title="Delete">
												<i class="ti ti-trash"></i>
											</button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="8" class="text-center py-5">
									<div class="d-flex flex-column align-items-center justify-content-center">
										<div class="avatar avatar-xl bg-light rounded-circle mb-3">
											<i class="ti ti-message-off fs-1 text-muted"></i>
										</div>
										<h5 class="text-muted mb-1">No Feedback found</h5>
										<p class="text-muted small mb-0">Add feedback for interviews to see them here.</p>
									</div>
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

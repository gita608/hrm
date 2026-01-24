@extends('layouts.app')

@section('title', 'Interview Feedback')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Interview Feedback</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<a href="{{ route('interviews.feedback.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Feedback</a>
			</div>
			<div class="head-icons ms-2">
				<a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header">
					<i class="ti ti-chevrons-up"></i>
				</a>
			</div>
		</div>
	</div>
	<!-- /Page Header -->

	@if(session('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			{{ session('success') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	<div class="card">
		<div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
			<h5>Feedback List</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('interviews.feedback.index') }}" class="d-flex gap-2 flex-wrap">
					<div>
						<select name="interview_id" class="form-select form-select-sm" onchange="this.form.submit()">
							<option value="">All Interviews</option>
							@foreach($interviews as $interview)
								<option value="{{ $interview->id }}" {{ request('interview_id') == $interview->id ? 'selected' : '' }}>
									{{ $interview->candidate->name ?? $interview->candidate_name ?? 'N/A' }} - {{ $interview->interview_date->format('M d, Y') }}
								</option>
							@endforeach
						</select>
					</div>
					<div>
						<select name="interviewer_id" class="form-select form-select-sm" onchange="this.form.submit()">
							<option value="">All Interviewers</option>
							@foreach($interviewers as $interviewer)
								<option value="{{ $interviewer->id }}" {{ request('interviewer_id') == $interviewer->id ? 'selected' : '' }}>{{ $interviewer->name }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<select name="recommendation" class="form-select form-select-sm" onchange="this.form.submit()">
							<option value="">All Recommendations</option>
							<option value="hire" {{ request('recommendation') == 'hire' ? 'selected' : '' }}>Hire</option>
							<option value="strong_hire" {{ request('recommendation') == 'strong_hire' ? 'selected' : '' }}>Strong Hire</option>
							<option value="maybe" {{ request('recommendation') == 'maybe' ? 'selected' : '' }}>Maybe</option>
							<option value="reject" {{ request('recommendation') == 'reject' ? 'selected' : '' }}>Reject</option>
						</select>
					</div>
					@if(request()->hasAny(['interview_id', 'interviewer_id', 'recommendation']))
						<a href="{{ route('interviews.feedback.index') }}" class="btn btn-sm btn-outline-light border">Clear Filters</a>
					@endif
				</form>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="custom-datatable-filter table-responsive">
				<table class="table datatable">
					<thead class="thead-light">
						<tr>
							<th class="no-sort">
								<div class="form-check form-check-md">
									<input class="form-check-input" type="checkbox" id="select-all">
								</div>
							</th>
							<th>#</th>
							<th>Candidate</th>
							<th>Interview Date</th>
							<th>Interviewer</th>
							<th>Rating</th>
							<th>Recommendation</th>
							<th>Feedback</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@forelse($feedbacks as $feedback)
							<tr>
								<td>
									<div class="form-check form-check-md">
										<input class="form-check-input" type="checkbox" value="{{ $feedback->id }}">
									</div>
								</td>
								<td>{{ $loop->iteration }}</td>
								<td>
									@if($feedback->interview->candidate)
										<h6 class="fw-medium"><a href="#">{{ $feedback->interview->candidate->name }}</a></h6>
										<span class="text-muted">{{ $feedback->interview->job_title ?? 'N/A' }}</span>
									@else
										<h6 class="fw-medium"><a href="#">{{ $feedback->interview->candidate_name ?? 'N/A' }}</a></h6>
										<span class="text-muted">{{ $feedback->interview->job_title ?? 'N/A' }}</span>
									@endif
								</td>
								<td>{{ $feedback->interview->interview_date->format('d M Y') }}</td>
								<td>{{ $feedback->interviewer->name ?? 'N/A' }}</td>
								<td>
									@if($feedback->rating)
										@for($i = 1; $i <= 5; $i++)
											<i class="ti ti-star{{ $i <= $feedback->rating ? '-filled' : '' }} text-warning"></i>
										@endfor
										<small class="text-muted">({{ $feedback->rating }}/5)</small>
									@else
										N/A
									@endif
								</td>
								<td>
									@if($feedback->recommendation)
										@if($feedback->recommendation == 'hire' || $feedback->recommendation == 'strong_hire')
											<span class="badge badge-success">{{ ucfirst(str_replace('_', ' ', $feedback->recommendation)) }}</span>
										@elseif($feedback->recommendation == 'reject')
											<span class="badge badge-danger">Reject</span>
										@else
											<span class="badge badge-warning">Maybe</span>
										@endif
									@else
										N/A
									@endif
								</td>
								<td>{{ Str::limit($feedback->feedback ?? 'N/A', 50) }}</td>
								<td>
									<div class="action-icon d-inline-flex">
										<a href="{{ route('interviews.feedback.show', $feedback->id) }}" class="me-2" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('interviews.feedback.edit', $feedback->id) }}" class="me-2" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										<form action="{{ route('interviews.feedback.destroy', $feedback->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this feedback?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-link p-0 text-danger" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="9" class="text-center">No feedback found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

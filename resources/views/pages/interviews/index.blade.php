@extends('layouts.app')

@section('title', 'Interview Schedule')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Interview Schedule</h2>
			<p class="text-muted mb-0 fs-13">Manage and track interview schedules</p>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
			<a href="{{ route('interviews.create') }}" class="btn btn-primary d-flex align-items-center rounded-pill shadow-sm">
				<i class="ti ti-circle-plus me-2 fs-4"></i>Schedule Interview
			</a>
		</div>
	</div>
	<!-- /Page Header -->
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
			<h5 class="mb-0 fw-bold text-dark">Interviews List</h5>
			<div class="d-flex align-items-center gap-2 flex-wrap">
				<form method="GET" action="{{ route('interviews.index') }}" class="d-flex gap-2 flex-wrap">
					<select name="status" class="form-select form-select-sm rounded-pill border-light" onchange="this.form.submit()" style="width: 140px;">
						<option value="">All Status</option>
						<option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
						<option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
						<option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
						<option value="rescheduled" {{ request('status') == 'rescheduled' ? 'selected' : '' }}>Rescheduled</option>
					</select>
					<select name="interviewer_id" class="form-select form-select-sm rounded-pill border-light" onchange="this.form.submit()" style="width: 160px;">
						<option value="">All Interviewers</option>
						@foreach($interviewers as $interviewer)
							<option value="{{ $interviewer->id }}" {{ request('interviewer_id') == $interviewer->id ? 'selected' : '' }}>{{ $interviewer->name }}</option>
						@endforeach
					</select>
					@if(request()->hasAny(['status', 'interviewer_id', 'date_from', 'date_to']))
						<a href="{{ route('interviews.index') }}" class="btn btn-sm btn-light rounded-pill border" data-bs-toggle="tooltip" title="Clear Filters">
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
							<th class="py-3 text-muted fs-12 fw-medium text-uppercase">Job Title</th>
							<th class="py-3 text-muted fs-12 fw-medium text-uppercase">Interviewer</th>
							<th class="py-3 text-muted fs-12 fw-medium text-uppercase">Date & Time</th>
							<th class="py-3 text-muted fs-12 fw-medium text-uppercase">Location</th>
							<th class="py-3 text-muted fs-12 fw-medium text-uppercase">Status</th>
							<th class="pe-4 py-3 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($interviews as $interview)
							<tr>
								<td class="ps-4">{{ $loop->iteration }}</td>
								<td>
									@if($interview->candidate)
										<div class="d-flex flex-column">
											<span class="fw-bold text-dark">{{ $interview->candidate->name }}</span>
											<span class="text-muted small">{{ $interview->candidate->email }}</span>
										</div>
									@else
										<div class="d-flex flex-column">
											<span class="fw-bold text-dark">{{ $interview->candidate_name ?? 'N/A' }}</span>
											<span class="text-muted small">{{ $interview->candidate_email ?? '' }}</span>
										</div>
									@endif
								</td>
								<td><span class="badge bg-light text-dark border">{{ $interview->job_title ?? 'N/A' }}</span></td>
								<td>
									@if($interview->interviewer)
										<div class="d-flex align-items-center">
											<div class="avatar avatar-xs bg-primary-transparent text-primary rounded-circle me-2 d-flex align-items-center justify-content-center fw-bold" style="width: 24px; height: 24px; font-size: 10px;">
												{{ strtoupper(substr($interview->interviewer->name, 0, 1)) }}
											</div>
											<span class="text-dark">{{ $interview->interviewer->name }}</span>
										</div>
									@else
										<span class="text-muted">N/A</span>
									@endif
								</td>
								<td>
									<div class="d-flex flex-column">
										<span class="fw-medium text-dark">{{ $interview->interview_date->format('M d, Y') }}</span>
										<small class="text-muted">{{ \Carbon\Carbon::parse($interview->interview_time)->format('h:i A') }}</small>
									</div>
								</td>
								<td><span class="text-muted small"><i class="ti ti-map-pin me-1"></i>{{ Str::limit($interview->location ?? 'Online', 20) }}</span></td>
								<td>
									@if($interview->status == 'scheduled')
										<span class="badge bg-info-transparent text-info rounded-pill px-2 py-1"><i class="ti ti-calendar-time me-1"></i>Scheduled</span>
									@elseif($interview->status == 'completed')
										<span class="badge bg-success-transparent text-success rounded-pill px-2 py-1"><i class="ti ti-check me-1"></i>Completed</span>
									@elseif($interview->status == 'cancelled')
										<span class="badge bg-danger-transparent text-danger rounded-pill px-2 py-1"><i class="ti ti-x me-1"></i>Cancelled</span>
									@else
										<span class="badge bg-warning-transparent text-warning rounded-pill px-2 py-1"><i class="ti ti-clock-edit me-1"></i>Rescheduled</span>
									@endif
								</td>
								<td class="pe-4 text-end">
									<div class="d-flex justify-content-end gap-1">
										<a href="{{ route('interviews.show', $interview->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all" data-bs-toggle="tooltip" title="View Details">
											<i class="ti ti-eye"></i>
										</a>
										<a href="{{ route('interviews.edit', $interview->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-info hover-text-white transition-all" data-bs-toggle="tooltip" title="Edit">
											<i class="ti ti-edit"></i>
										</a>
										<form action="{{ route('interviews.destroy', $interview->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this interview?');">
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
											<i class="ti ti-calendar-off fs-1 text-muted"></i>
										</div>
										<h5 class="text-muted mb-1">No Interviews found</h5>
										<p class="text-muted small mb-0">Schedule a new interview to get started.</p>
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

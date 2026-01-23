@extends('layouts.app')

@section('title', 'Interview Schedule')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Interview Schedule</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<a href="{{ route('interviews.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Schedule Interview</a>
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
			<h5>Interviews List</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('interviews.index') }}" class="d-flex gap-2 flex-wrap">
					<div>
						<select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
							<option value="">All Status</option>
							<option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
							<option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
							<option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
							<option value="rescheduled" {{ request('status') == 'rescheduled' ? 'selected' : '' }}>Rescheduled</option>
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
					@if(request()->hasAny(['status', 'interviewer_id', 'date_from', 'date_to']))
						<a href="{{ route('interviews.index') }}" class="btn btn-sm btn-outline-light border">Clear Filters</a>
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
							<th>Candidate</th>
							<th>Job Title</th>
							<th>Interviewer</th>
							<th>Date & Time</th>
							<th>Location</th>
							<th>Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@forelse($interviews as $interview)
							<tr>
								<td>
									<div class="form-check form-check-md">
										<input class="form-check-input" type="checkbox" value="{{ $interview->id }}">
									</div>
								</td>
								<td>
									@if($interview->candidate)
										<h6 class="fw-medium"><a href="#">{{ $interview->candidate->name }}</a></h6>
										<span class="text-muted">{{ $interview->candidate->email }}</span>
									@else
										<h6 class="fw-medium"><a href="#">{{ $interview->candidate_name ?? 'N/A' }}</a></h6>
										<span class="text-muted">{{ $interview->candidate_email ?? '' }}</span>
									@endif
								</td>
								<td>{{ $interview->job_title ?? 'N/A' }}</td>
								<td>
									@if($interview->interviewer)
										{{ $interview->interviewer->name }}
									@else
										N/A
									@endif
								</td>
								<td>
									{{ $interview->interview_date->format('d M Y') }}<br>
									<small class="text-muted">{{ \Carbon\Carbon::parse($interview->interview_time)->format('h:i A') }}</small>
								</td>
								<td>{{ Str::limit($interview->location ?? 'N/A', 30) }}</td>
								<td>
									@if($interview->status == 'scheduled')
										<span class="badge badge-info d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Scheduled
										</span>
									@elseif($interview->status == 'completed')
										<span class="badge badge-success d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Completed
										</span>
									@elseif($interview->status == 'cancelled')
										<span class="badge badge-danger d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Cancelled
										</span>
									@else
										<span class="badge badge-warning d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Rescheduled
										</span>
									@endif
								</td>
								<td>
									<div class="action-icon d-inline-flex">
										<a href="{{ route('interviews.show', $interview->id) }}" class="me-2" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('interviews.edit', $interview->id) }}" class="me-2" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										<form action="{{ route('interviews.destroy', $interview->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this interview?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-link p-0 text-danger" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="8" class="text-center">No interviews found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

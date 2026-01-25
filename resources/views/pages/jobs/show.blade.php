@extends('layouts.app')

@section('title', 'Job Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Job Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('jobs.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5>Job Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-4"><strong>Job Code:</strong></div>
						<div class="col-md-8">{{ $jobPosting->job_code ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Title:</strong></div>
						<div class="col-md-8">{{ $jobPosting->title }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Department:</strong></div>
						<div class="col-md-8">{{ $jobPosting->department->name ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Designation:</strong></div>
						<div class="col-md-8">{{ $jobPosting->designation->name ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>No. of Positions:</strong></div>
						<div class="col-md-8">{{ $jobPosting->no_of_positions }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Job Type:</strong></div>
						<div class="col-md-8">{{ ucfirst(str_replace('_', ' ', $jobPosting->job_type)) }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Experience Level:</strong></div>
						<div class="col-md-8">{{ $jobPosting->experience_level ? ucfirst($jobPosting->experience_level) : 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Start Date:</strong></div>
						<div class="col-md-8">{{ $jobPosting->start_date->format('M d, Y') }}</div>
					</div>
					@if($jobPosting->end_date)
					<div class="row mb-3">
						<div class="col-md-4"><strong>End Date:</strong></div>
						<div class="col-md-8">{{ $jobPosting->end_date->format('M d, Y') }}</div>
					</div>
					@endif
					<div class="row mb-3">
						<div class="col-md-4"><strong>Location:</strong></div>
						<div class="col-md-8">{{ $jobPosting->location ?? 'N/A' }}</div>
					</div>
					@if($jobPosting->uae_emirate)
					<div class="row mb-3">
						<div class="col-md-4"><strong>UAE Location:</strong></div>
						<div class="col-md-8">{{ $jobPosting->uae_emirate }}{{ $jobPosting->uae_city ? ', ' . $jobPosting->uae_city : '' }}</div>
					</div>
					@endif
					<div class="row mb-3">
						<div class="col-md-4"><strong>Visa Sponsorship:</strong></div>
						<div class="col-md-8">
							@if($jobPosting->visa_sponsorship)
								<span class="badge badge-success">Yes</span>
							@else
								<span class="badge badge-secondary">No</span>
							@endif
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Work Permit Required:</strong></div>
						<div class="col-md-8">
							@if($jobPosting->work_permit_required)
								<span class="badge badge-warning">Yes</span>
							@else
								<span class="badge badge-secondary">No</span>
							@endif
						</div>
					</div>
					@if($jobPosting->salary_from || $jobPosting->salary_to)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Salary Range:</strong></div>
						<div class="col-md-8">
							@if($jobPosting->salary_from && $jobPosting->salary_to)
								${{ number_format($jobPosting->salary_from, 2) }} - ${{ number_format($jobPosting->salary_to, 2) }}
							@elseif($jobPosting->salary_from)
								From ${{ number_format($jobPosting->salary_from, 2) }}
							@elseif($jobPosting->salary_to)
								Up to ${{ number_format($jobPosting->salary_to, 2) }}
							@endif
						</div>
					</div>
					@endif
					<div class="row mb-3">
						<div class="col-md-4"><strong>Status:</strong></div>
						<div class="col-md-8">
							@if($jobPosting->status == 'open')
								<span class="badge badge-success">Open</span>
							@elseif($jobPosting->status == 'closed')
								<span class="badge badge-danger">Closed</span>
							@elseif($jobPosting->status == 'cancelled')
								<span class="badge badge-warning">Cancelled</span>
							@else
								<span class="badge badge-info">Draft</span>
							@endif
						</div>
					</div>
					@if($jobPosting->description)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Description:</strong></div>
						<div class="col-md-8">{{ $jobPosting->description }}</div>
					</div>
					@endif
					@if($jobPosting->requirements)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Requirements:</strong></div>
						<div class="col-md-8">{{ $jobPosting->requirements }}</div>
					</div>
					@endif
					@if($jobPosting->benefits)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Benefits:</strong></div>
						<div class="col-md-8">{{ $jobPosting->benefits }}</div>
					</div>
					@endif
					<div class="row mb-3">
						<div class="col-md-4"><strong>Created At:</strong></div>
						<div class="col-md-8">{{ $jobPosting->created_at->format('M d, Y H:i') }}</div>
					</div>
					<div class="row">
						<div class="col-md-4"><strong>Updated At:</strong></div>
						<div class="col-md-8">{{ $jobPosting->updated_at->format('M d, Y H:i') }}</div>
					</div>
				</div>
			</div>

			@if($jobPosting->candidates->count() > 0)
			<div class="card mt-3">
				<div class="card-header">
					<h5>Candidates ({{ $jobPosting->candidates->count() }})</h5>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>Name</th>
									<th>Email</th>
									<th>Applied Date</th>
									<th>Status</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach($jobPosting->candidates as $candidate)
									<tr>
										<td>{{ $candidate->first_name }} {{ $candidate->last_name }}</td>
										<td>{{ $candidate->email }}</td>
										<td>{{ $candidate->applied_date->format('M d, Y') }}</td>
										<td>
											@if($candidate->status == 'hired')
												<span class="badge badge-success">{{ ucfirst(str_replace('_', ' ', $candidate->status)) }}</span>
											@elseif($candidate->status == 'rejected')
												<span class="badge badge-danger">{{ ucfirst($candidate->status) }}</span>
											@else
												<span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $candidate->status)) }}</span>
											@endif
										</td>
										<td>
											<a href="{{ route('candidates.show', $candidate->id) }}" class="btn btn-sm btn-outline-primary">View</a>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			@endif
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body text-center">
					<div class="avatar avatar-xxl mb-3">
						<i class="ti ti-briefcase fs-48 text-primary"></i>
					</div>
					<h4 class="mb-1">{{ $jobPosting->title }}</h4>
					<p class="text-muted mb-2">{{ $jobPosting->department->name ?? 'N/A' }}</p>
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('jobs.edit', $jobPosting->id) }}" class="btn btn-primary btn-sm">
							<i class="ti ti-edit me-2"></i>Edit Job
						</a>
						<a href="{{ route('candidates.create', ['job_posting_id' => $jobPosting->id]) }}" class="btn btn-success btn-sm">
							<i class="ti ti-user-plus me-2"></i>Add Candidate
						</a>
						<form action="{{ route('jobs.destroy', $jobPosting->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger btn-sm w-100">
								<i class="ti ti-trash me-2"></i>Delete Job
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

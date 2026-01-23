@extends('layouts.app')

@section('title', 'Candidate Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Candidate Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('candidates.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5>Candidate Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-4"><strong>Candidate Code:</strong></div>
						<div class="col-md-8">{{ $candidate->candidate_code ?? 'Cand-' . str_pad($candidate->id, 3, '0', STR_PAD_LEFT) }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Name:</strong></div>
						<div class="col-md-8">{{ $candidate->first_name }} {{ $candidate->last_name }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Email:</strong></div>
						<div class="col-md-8">{{ $candidate->email }}</div>
					</div>
					@if($candidate->phone)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Phone:</strong></div>
						<div class="col-md-8">{{ $candidate->phone }}</div>
					</div>
					@endif
					<div class="row mb-3">
						<div class="col-md-4"><strong>Applied Role:</strong></div>
						<div class="col-md-8">{{ $candidate->applied_role ?? ($candidate->jobPosting->title ?? 'N/A') }}</div>
					</div>
					@if($candidate->jobPosting)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Job Posting:</strong></div>
						<div class="col-md-8">
							<a href="{{ route('jobs.show', $candidate->jobPosting->id) }}">{{ $candidate->jobPosting->title }}</a>
						</div>
					</div>
					@endif
					<div class="row mb-3">
						<div class="col-md-4"><strong>Applied Date:</strong></div>
						<div class="col-md-8">{{ $candidate->applied_date->format('M d, Y') }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Status:</strong></div>
						<div class="col-md-8">
							@if($candidate->status == 'hired')
								<span class="badge badge-success">{{ ucfirst(str_replace('_', ' ', $candidate->status)) }}</span>
							@elseif($candidate->status == 'rejected')
								<span class="badge badge-danger">{{ ucfirst($candidate->status) }}</span>
							@elseif($candidate->status == 'interviewed')
								<span class="badge badge-info">{{ ucfirst($candidate->status) }}</span>
							@elseif($candidate->status == 'scheduled')
								<span class="badge badge-pink">{{ ucfirst($candidate->status) }}</span>
							@else
								<span class="badge badge-purple">{{ ucfirst(str_replace('_', ' ', $candidate->status)) }}</span>
							@endif
						</div>
					</div>
					@if($candidate->resume_path)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Resume:</strong></div>
						<div class="col-md-8">
							<a href="{{ asset($candidate->resume_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
								<i class="ti ti-file-text me-1"></i>View Resume
							</a>
						</div>
					</div>
					@endif
					@if($candidate->cover_letter)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Cover Letter:</strong></div>
						<div class="col-md-8">{{ $candidate->cover_letter }}</div>
					</div>
					@endif
					@if($candidate->experience_summary)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Experience Summary:</strong></div>
						<div class="col-md-8">{{ $candidate->experience_summary }}</div>
					</div>
					@endif
					@if($candidate->education)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Education:</strong></div>
						<div class="col-md-8">{{ $candidate->education }}</div>
					</div>
					@endif
					@if($candidate->skills)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Skills:</strong></div>
						<div class="col-md-8">{{ $candidate->skills }}</div>
					</div>
					@endif
					@if($candidate->notes)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Notes:</strong></div>
						<div class="col-md-8">{{ $candidate->notes }}</div>
					</div>
					@endif
					<div class="row mb-3">
						<div class="col-md-4"><strong>Created At:</strong></div>
						<div class="col-md-8">{{ $candidate->created_at->format('M d, Y H:i') }}</div>
					</div>
					<div class="row">
						<div class="col-md-4"><strong>Updated At:</strong></div>
						<div class="col-md-8">{{ $candidate->updated_at->format('M d, Y H:i') }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body text-center">
					<div class="avatar avatar-xxl mb-3">
						<i class="ti ti-user-shield fs-48 text-primary"></i>
					</div>
					<h4 class="mb-1">{{ $candidate->first_name }} {{ $candidate->last_name }}</h4>
					<p class="text-muted mb-2">{{ $candidate->email }}</p>
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('candidates.edit', $candidate->id) }}" class="btn btn-primary btn-sm">
							<i class="ti ti-edit me-2"></i>Edit Candidate
						</a>
						@if($candidate->jobPosting)
							<a href="{{ route('jobs.show', $candidate->jobPosting->id) }}" class="btn btn-info btn-sm">
								<i class="ti ti-briefcase me-2"></i>View Job
							</a>
						@endif
						<form action="{{ route('candidates.destroy', $candidate->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this candidate?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger btn-sm w-100">
								<i class="ti ti-trash me-2"></i>Delete Candidate
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

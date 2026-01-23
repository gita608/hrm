@extends('layouts.app')

@section('title', 'Training Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Training Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('training.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5>Training Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-4"><strong>Title:</strong></div>
						<div class="col-md-8">{{ $training->title }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Training Type:</strong></div>
						<div class="col-md-8">
							@if($training->trainingType)
								<span class="badge badge-info">{{ $training->trainingType->name }}</span>
							@else
								<span class="text-muted">N/A</span>
							@endif
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Trainer:</strong></div>
						<div class="col-md-8">
							@if($training->trainer)
								{{ $training->trainer->name }}
							@else
								<span class="text-muted">N/A</span>
							@endif
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Start Date:</strong></div>
						<div class="col-md-8">{{ $training->start_date->format('M d, Y') }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>End Date:</strong></div>
						<div class="col-md-8">{{ $training->end_date->format('M d, Y') }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Status:</strong></div>
						<div class="col-md-8">
							@if($training->status == 'scheduled')
								<span class="badge badge-info">Scheduled</span>
							@elseif($training->status == 'ongoing')
								<span class="badge badge-warning">Ongoing</span>
							@elseif($training->status == 'completed')
								<span class="badge badge-success">Completed</span>
							@else
								<span class="badge badge-danger">Cancelled</span>
							@endif
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Location:</strong></div>
						<div class="col-md-8">{{ $training->location ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Max Participants:</strong></div>
						<div class="col-md-8">{{ $training->max_participants ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Description:</strong></div>
						<div class="col-md-8">{{ $training->description ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Created At:</strong></div>
						<div class="col-md-8">{{ $training->created_at->format('M d, Y H:i') }}</div>
					</div>
					<div class="row">
						<div class="col-md-4"><strong>Updated At:</strong></div>
						<div class="col-md-8">{{ $training->updated_at->format('M d, Y H:i') }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body text-center">
					<div class="avatar avatar-xxl mb-3">
						<i class="ti ti-edit fs-48 text-primary"></i>
					</div>
					<h4 class="mb-1">{{ $training->title }}</h4>
					<p class="text-muted mb-2">{{ $training->trainingType->name ?? 'No Type' }}</p>
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('training.edit', $training->id) }}" class="btn btn-primary btn-sm">
							<i class="ti ti-edit me-2"></i>Edit Training
						</a>
						<form action="{{ route('training.destroy', $training->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this training?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger btn-sm w-100">
								<i class="ti ti-trash me-2"></i>Delete Training
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

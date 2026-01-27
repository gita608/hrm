@extends('layouts.app')

@section('title', 'Training Details')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Training Details</h2>
			<p class="text-muted mb-0 fs-13">View complete training session information</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('training.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="row">
		<div class="col-md-8">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Training Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Title</label>
						</div>
						<div class="col-md-8">
							<p class="mb-0 fw-bold text-dark fs-15">{{ $training->title }}</p>
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Training Type</label>
						</div>
						<div class="col-md-8">
							@if($training->trainingType)
								<span class="badge bg-light text-dark border">{{ $training->trainingType->name }}</span>
							@else
								<span class="text-muted">N/A</span>
							@endif
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Trainer</label>
						</div>
						<div class="col-md-8">
							@if($training->trainer)
								<div class="d-flex align-items-center">
									<div class="avatar avatar-sm bg-primary-transparent text-primary rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold">
										{{ substr($training->trainer->name, 0, 1) }}
									</div>
									<span class="fw-medium text-dark">{{ $training->trainer->name }}</span>
								</div>
							@else
								<span class="text-muted">N/A</span>
							@endif
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Duration</label>
						</div>
						<div class="col-md-8">
							<div class="d-flex align-items-center gap-3">
								<div>
									<span class="d-block text-muted fs-11">Start Date</span>
									<span class="fw-medium text-dark">{{ $training->start_date->format('d M Y') }}</span>
								</div>
								<i class="ti ti-arrow-right text-muted"></i>
								<div>
									<span class="d-block text-muted fs-11">End Date</span>
									<span class="fw-medium text-dark">{{ $training->end_date->format('d M Y') }}</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Status</label>
						</div>
						<div class="col-md-8">
							@if($training->status == 'scheduled')
								<span class="badge bg-info-transparent text-info rounded-pill d-inline-flex align-items-center px-2 py-1">
									<i class="ti ti-calendar me-1 fs-10"></i>Scheduled
								</span>
							@elseif($training->status == 'ongoing')
								<span class="badge bg-warning-transparent text-warning rounded-pill d-inline-flex align-items-center px-2 py-1">
									<i class="ti ti-loader me-1 fs-10"></i>Ongoing
								</span>
							@elseif($training->status == 'completed')
								<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
									<i class="ti ti-check me-1 fs-10"></i>Completed
								</span>
							@else
								<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
									<i class="ti ti-x me-1 fs-10"></i>Cancelled
								</span>
							@endif
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Location</label>
						</div>
						<div class="col-md-8">
							<span class="text-dark">{{ $training->location ?? 'N/A' }}</span>
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Max Participants</label>
						</div>
						<div class="col-md-8">
							<span class="text-dark">{{ $training->max_participants ?? 'N/A' }}</span>
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Description</label>
						</div>
						<div class="col-md-8">
							<p class="mb-0 text-muted">{{ $training->description ?? 'No description provided.' }}</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Created At</label>
							<p class="mb-0 text-muted fs-13">{{ $training->created_at->format('d M Y h:i A') }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Updated At</label>
							<p class="mb-0 text-muted fs-13">{{ $training->updated_at->format('d M Y h:i A') }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body text-center p-4">
					<div class="avatar avatar-xxl bg-primary-transparent text-primary rounded-circle mb-3 mx-auto d-flex align-items-center justify-content-center">
						<i class="ti ti-school fs-48"></i>
					</div>
					<h5 class="mb-1 fw-bold text-dark">{{ $training->title }}</h5>
					<p class="text-muted mb-4">{{ $training->trainingType->name ?? 'No Type' }}</p>
					
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('training.edit', $training->id) }}" class="btn btn-primary rounded-pill shadow-sm py-2">
							<i class="ti ti-edit me-2"></i>Edit Training
						</a>
						<form action="{{ route('training.destroy', $training->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this training?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger rounded-pill shadow-sm py-2 w-100">
								<i class="ti ti-trash me-2"></i>Delete Training
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

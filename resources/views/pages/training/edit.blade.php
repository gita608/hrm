@extends('layouts.app')

@section('title', 'Edit Training')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Edit Training</h2>
			<p class="text-muted mb-0 fs-13">Modify training session details</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('training.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
			<h5 class="mb-0 fw-bold text-dark">Training Information</h5>
		</div>
		<div class="card-body p-4">
			<form action="{{ route('training.update', $training->id) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Title <span class="text-danger">*</span></label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="title" value="{{ old('title', $training->title) }}" required>
							@error('title')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Training Type</label>
							<select class="form-select rounded-3 border-light shadow-none" name="training_type_id">
								<option value="">Select Type</option>
								@foreach($trainingTypes as $type)
									<option value="{{ $type->id }}" {{ old('training_type_id', $training->training_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
								@endforeach
							</select>
							@error('training_type_id')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Trainer</label>
							<select class="form-select rounded-3 border-light shadow-none" name="trainer_id">
								<option value="">Select Trainer</option>
								@foreach($trainers as $trainer)
									<option value="{{ $trainer->id }}" {{ old('trainer_id', $training->trainer_id) == $trainer->id ? 'selected' : '' }}>{{ $trainer->name }}</option>
								@endforeach
							</select>
							@error('trainer_id')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Status <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none" name="status" required>
								<option value="scheduled" {{ old('status', $training->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
								<option value="ongoing" {{ old('status', $training->status) == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
								<option value="completed" {{ old('status', $training->status) == 'completed' ? 'selected' : '' }}>Completed</option>
								<option value="cancelled" {{ old('status', $training->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
							</select>
							@error('status')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Start Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control rounded-3 border-light shadow-none" name="start_date" value="{{ old('start_date', $training->start_date->format('Y-m-d')) }}" required>
							@error('start_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">End Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control rounded-3 border-light shadow-none" name="end_date" value="{{ old('end_date', $training->end_date->format('Y-m-d')) }}" required>
							@error('end_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Location</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="location" value="{{ old('location', $training->location) }}">
							@error('location')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Max Participants</label>
							<input type="number" class="form-control rounded-3 border-light shadow-none" name="max_participants" value="{{ old('max_participants', $training->max_participants) }}" min="1">
							@error('max_participants')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Description</label>
							<textarea class="form-control rounded-3 border-light shadow-none" name="description" rows="3">{{ old('description', $training->description) }}</textarea>
							@error('description')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<div class="form-check form-switch ps-3">
								<input class="form-check-input" type="checkbox" name="uae_labor_law_compliance" value="1" id="uae_labor_law_compliance" {{ old('uae_labor_law_compliance', $training->uae_labor_law_compliance) ? 'checked' : '' }}>
								<label class="form-check-label fw-medium text-dark ms-2" for="uae_labor_law_compliance">
									UAE Labor Law Compliance Training
								</label>
							</div>
							<div class="ms-5 mt-1">
								<small class="text-muted fs-12">Check this if this training covers UAE labor law compliance requirements</small>
							</div>
							@error('uae_labor_law_compliance')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2 mt-4">
					<a href="{{ route('training.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
					<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Update Training</button>
				</div>
			</form>
		</div>
	</div>

@endsection

@extends('layouts.app')

@section('title', 'Edit Training')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Edit Training</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('training.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="card">
		<div class="card-header">
			<h5>Training Information</h5>
		</div>
		<div class="card-body">
			<form action="{{ route('training.update', $training->id) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Title <span class="text-danger">*</span></label>
							<input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $training->title) }}" required>
							@error('title')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Training Type</label>
							<select class="form-select @error('training_type_id') is-invalid @enderror" name="training_type_id">
								<option value="">Select Type</option>
								@foreach($trainingTypes as $type)
									<option value="{{ $type->id }}" {{ old('training_type_id', $training->training_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
								@endforeach
							</select>
							@error('training_type_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Trainer</label>
							<select class="form-select @error('trainer_id') is-invalid @enderror" name="trainer_id">
								<option value="">Select Trainer</option>
								@foreach($trainers as $trainer)
									<option value="{{ $trainer->id }}" {{ old('trainer_id', $training->trainer_id) == $trainer->id ? 'selected' : '' }}>{{ $trainer->name }}</option>
								@endforeach
							</select>
							@error('trainer_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Status <span class="text-danger">*</span></label>
							<select class="form-select @error('status') is-invalid @enderror" name="status" required>
								<option value="scheduled" {{ old('status', $training->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
								<option value="ongoing" {{ old('status', $training->status) == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
								<option value="completed" {{ old('status', $training->status) == 'completed' ? 'selected' : '' }}>Completed</option>
								<option value="cancelled" {{ old('status', $training->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
							</select>
							@error('status')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Start Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date', $training->start_date->format('Y-m-d')) }}" required>
							@error('start_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">End Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date', $training->end_date->format('Y-m-d')) }}" required>
							@error('end_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Location</label>
							<input type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ old('location', $training->location) }}">
							@error('location')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Max Participants</label>
							<input type="number" class="form-control @error('max_participants') is-invalid @enderror" name="max_participants" value="{{ old('max_participants', $training->max_participants) }}" min="1">
							@error('max_participants')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Description</label>
							<textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description', $training->description) }}</textarea>
							@error('description')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" name="uae_labor_law_compliance" value="1" id="uae_labor_law_compliance" {{ old('uae_labor_law_compliance', $training->uae_labor_law_compliance) ? 'checked' : '' }}>
								<label class="form-check-label" for="uae_labor_law_compliance">
									<strong>UAE Labor Law Compliance Training</strong>
								</label>
							</div>
							<small class="text-muted">Check this if this training covers UAE labor law compliance requirements</small>
							@error('uae_labor_law_compliance')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2">
					<a href="{{ route('training.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Update Training</button>
				</div>
			</form>
		</div>
	</div>

@endsection

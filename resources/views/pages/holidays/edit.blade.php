@extends('layouts.app')

@section('title', 'Edit Holiday')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Edit Holiday</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('holidays.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="card">
		<div class="card-header">
			<h5>Holiday Information</h5>
		</div>
		<div class="card-body">
			<form action="{{ route('holidays.update', $holiday->id) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $holiday->name) }}" required>
							@error('name')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date', $holiday->date->format('Y-m-d')) }}" required>
							@error('date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Type <span class="text-danger">*</span></label>
							<select class="form-select @error('type') is-invalid @enderror" name="type" required>
								<option value="">Select Type</option>
								<option value="national" {{ old('type', $holiday->type) == 'national' ? 'selected' : '' }}>National</option>
								<option value="regional" {{ old('type', $holiday->type) == 'regional' ? 'selected' : '' }}>Regional</option>
							</select>
							@error('type')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Status</label>
							<select class="form-select @error('is_active') is-invalid @enderror" name="is_active">
								<option value="1" {{ old('is_active', $holiday->is_active) == '1' ? 'selected' : '' }}>Active</option>
								<option value="0" {{ old('is_active', $holiday->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
							</select>
							@error('is_active')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Description</label>
							<textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description', $holiday->description) }}</textarea>
							@error('description')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2">
					<a href="{{ route('holidays.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Update Holiday</button>
				</div>
			</form>
		</div>
	</div>

@endsection

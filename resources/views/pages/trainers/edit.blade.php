@extends('layouts.app')

@section('title', 'Edit Trainer')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Edit Trainer</h2>
			<p class="text-muted mb-0 fs-13">Modify trainer profile information</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('trainers.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
			<h5 class="mb-0 fw-bold text-dark">Trainer Information</h5>
		</div>
		<div class="card-body p-4">
			<form action="{{ route('trainers.update', $trainer->id) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="name" value="{{ old('name', $trainer->name) }}" required>
							@error('name')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Email <span class="text-danger">*</span></label>
							<input type="email" class="form-control rounded-3 border-light shadow-none" name="email" value="{{ old('email', $trainer->email) }}" required>
							@error('email')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Phone</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="phone" value="{{ old('phone', $trainer->phone) }}">
							@error('phone')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Status</label>
							<select class="form-select rounded-3 border-light shadow-none" name="is_active">
								<option value="1" {{ old('is_active', $trainer->is_active) == '1' ? 'selected' : '' }}>Active</option>
								<option value="0" {{ old('is_active', $trainer->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
							</select>
							@error('is_active')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Expertise</label>
							<textarea class="form-control rounded-3 border-light shadow-none" name="expertise" rows="2">{{ old('expertise', $trainer->expertise) }}</textarea>
							@error('expertise')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Bio</label>
							<textarea class="form-control rounded-3 border-light shadow-none" name="bio" rows="3">{{ old('bio', $trainer->bio) }}</textarea>
							@error('bio')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2 mt-4">
					<a href="{{ route('trainers.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
					<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Update Trainer</button>
				</div>
			</form>
		</div>
	</div>

@endsection

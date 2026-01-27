@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Edit Role</h2>
			<p class="text-muted mb-0 fs-13">Update role information</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('roles.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
			<h5 class="mb-0 fw-bold text-dark">Role Information</h5>
		</div>
		<div class="card-body p-4">
			<form action="{{ route('roles.update', $role->id) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control rounded-3 border-light shadow-none @error('name') is-invalid @enderror" name="name" value="{{ old('name', $role->name) }}" required>
							@error('name')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Slug <span class="text-danger">*</span></label>
							<input type="text" class="form-control rounded-3 border-light shadow-none @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug', $role->slug) }}" required>
							<small class="text-muted fs-11">Lowercase, use hyphens for spaces (e.g., hr-manager)</small>
							@error('slug')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Status</label>
							<select class="form-select rounded-3 border-light shadow-none @error('is_active') is-invalid @enderror" name="is_active">
								<option value="1" {{ old('is_active', $role->is_active) == '1' ? 'selected' : '' }}>Active</option>
								<option value="0" {{ old('is_active', $role->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
							</select>
							@error('is_active')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Description</label>
							<textarea class="form-control rounded-3 border-light shadow-none @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description', $role->description) }}</textarea>
							@error('description')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2 mt-4">
					<a href="{{ route('roles.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
					<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Update Role</button>
				</div>
			</form>
		</div>
	</div>

@endsection

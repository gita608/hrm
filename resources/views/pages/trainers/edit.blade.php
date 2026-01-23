@extends('layouts.app')

@section('title', 'Edit Trainer')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Edit Trainer</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('trainers.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="card">
		<div class="card-header">
			<h5>Trainer Information</h5>
		</div>
		<div class="card-body">
			<form action="{{ route('trainers.update', $trainer->id) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $trainer->name) }}" required>
							@error('name')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Email <span class="text-danger">*</span></label>
							<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $trainer->email) }}" required>
							@error('email')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Phone</label>
							<input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $trainer->phone) }}">
							@error('phone')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Status</label>
							<select class="form-select @error('is_active') is-invalid @enderror" name="is_active">
								<option value="1" {{ old('is_active', $trainer->is_active) == '1' ? 'selected' : '' }}>Active</option>
								<option value="0" {{ old('is_active', $trainer->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
							</select>
							@error('is_active')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Expertise</label>
							<textarea class="form-control @error('expertise') is-invalid @enderror" name="expertise" rows="2">{{ old('expertise', $trainer->expertise) }}</textarea>
							@error('expertise')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Bio</label>
							<textarea class="form-control @error('bio') is-invalid @enderror" name="bio" rows="3">{{ old('bio', $trainer->bio) }}</textarea>
							@error('bio')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2">
					<a href="{{ route('trainers.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Update Trainer</button>
				</div>
			</form>
		</div>
	</div>

@endsection

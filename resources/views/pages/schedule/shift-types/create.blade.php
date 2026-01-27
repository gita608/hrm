@extends('layouts.app')

@section('title', 'Create Shift Type')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Create Shift Type</h2>
			<p class="text-muted mb-0 fs-13">Define new work shift timings and details</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('shift-types.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
			<h5 class="mb-0 fw-bold text-dark">Shift Definition</h5>
		</div>
		<div class="card-body p-4">
			<form action="{{ route('shift-types.store') }}" method="POST">
				@csrf
				<div class="row">
					<div class="col-md-6">
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium ls-1">Shift Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control rounded-3 border-light shadow-none py-2 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="e.g. Morning Shift, Night Shift" required>
							@error('name')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium ls-1">Active Status</label>
							<select class="form-select rounded-3 border-light shadow-none py-2 @error('is_active') is-invalid @enderror" name="is_active">
								<option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Enabled</option>
								<option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Disabled</option>
							</select>
							@error('is_active')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium ls-1">Start Time <span class="text-danger">*</span></label>
							<div class="input-group">
								<span class="input-group-text bg-light border-light-subtle rounded-start-3"><i class="ti ti-clock-play text-muted"></i></span>
								<input type="time" class="form-control rounded-end-3 border-light shadow-none py-2 @error('start_time') is-invalid @enderror" name="start_time" value="{{ old('start_time') }}" required>
							</div>
							@error('start_time')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium ls-1">End Time <span class="text-danger">*</span></label>
							<div class="input-group">
								<span class="input-group-text bg-light border-light-subtle rounded-start-3"><i class="ti ti-clock-stop text-muted"></i></span>
								<input type="time" class="form-control rounded-end-3 border-light shadow-none py-2 @error('end_time') is-invalid @enderror" name="end_time" value="{{ old('end_time') }}" required>
							</div>
							@error('end_time')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium ls-1">Detailed Description</label>
							<textarea class="form-control rounded-3 border-light shadow-none @error('description') is-invalid @enderror" name="description" rows="3" placeholder="Explain the purpose or requirements of this shift...">{{ old('description') }}</textarea>
							@error('description')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<hr class="my-4 opacity-25">
				<div class="d-flex justify-content-end gap-2">
					<a href="{{ route('shift-types.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
					<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm"><i class="ti ti-device-floppy me-1"></i>Create Shift Type</button>
				</div>
			</form>
		</div>
	</div>

@endsection

@extends('layouts.app')

@section('title', 'Settings')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Settings</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('dashboard') }}" class="btn btn-outline-light border">Back to Dashboard</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-xl-8 col-lg-10 mx-auto">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0">Application Settings</h5>
				</div>
				<div class="card-body">
					@if(session('success'))
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							{{ session('success') }}
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					@endif

					<form action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
						@csrf

						<!-- App Name -->
						<div class="mb-4">
							<label class="form-label">Application Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control @error('app_name') is-invalid @enderror" 
								   name="app_name" value="{{ old('app_name', $appName) }}" required>
							@error('app_name')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
							<small class="text-muted">This name will be displayed throughout the application</small>
						</div>

						<!-- App Logo -->
						<div class="mb-4">
							<label class="form-label">Application Logo</label>
							<div class="d-flex align-items-center gap-4">
								@if($appLogo)
									<div class="mb-3">
										<img src="{{ asset('storage/' . $appLogo) }}" alt="App Logo" 
											 class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
									</div>
								@endif
								<div class="flex-grow-1">
									<input type="file" class="form-control @error('app_logo') is-invalid @enderror" 
										   name="app_logo" accept="image/*">
									@error('app_logo')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
									<small class="text-muted">Recommended size: 200x200px. Max file size: 2MB. Background will be automatically removed and converted to PNG.</small>
								</div>
							</div>
						</div>

						<!-- Submit Button -->
						<div class="d-flex justify-content-end gap-2">
							<a href="{{ route('dashboard') }}" class="btn btn-outline-light border">Cancel</a>
							<button type="submit" class="btn btn-primary">Save Settings</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection

@extends('layouts.app')

@section('title', 'Settings')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">System Settings</h2>
			<p class="text-muted mb-0 fs-13">Configure your application preferences and branding</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('dashboard') }}" class="btn btn-light rounded-pill border shadow-sm px-3">
				<i class="ti ti-smart-home me-2"></i>Dashboard
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="row justify-content-center">
		<div class="col-xl-9 col-lg-11">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-header bg-white py-3 border-bottom border-light d-flex align-items-center">
					<div class="bg-primary-transparent rounded-3 p-2 me-3">
						<i class="ti ti-settings-automation fs-20 text-primary"></i>
					</div>
					<h5 class="mb-0 fw-bold text-dark">Global Configuration</h5>
				</div>
				<div class="card-body p-4 p-md-5">
					@if(session('success'))
						<div class="alert alert-success border-0 shadow-sm rounded-4 alert-dismissible fade show mb-4 d-flex align-items-center" role="alert">
							<i class="ti ti-circle-check-filled me-2 fs-20"></i>
							<div>{{ session('success') }}</div>
							<button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					@endif

					<form action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
						@csrf

						<div class="row g-4">
							<!-- App Name -->
							<div class="col-12">
								<div class="form-group mb-0">
									<label class="form-label text-dark fw-bold fs-14 mb-2">
										Application Branding Name <span class="text-danger">*</span>
									</label>
									<div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
										<span class="input-group-text bg-white border-end-0 px-3">
											<i class="ti ti-brand-abstract text-muted"></i>
										</span>
										<input type="text" class="form-control border-start-0 ps-0 @error('app_name') is-invalid @enderror" 
											   name="app_name" value="{{ old('app_name', $appName) }}" 
											   placeholder="e.g. SmartHR Solutions" required>
									</div>
									@error('app_name')
										<div class="text-danger fs-12 mt-1 px-1"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
									@enderror
									<p class="text-muted fs-12 mt-2 mb-0 ms-1">
										<i class="ti ti-info-circle me-1"></i>This identity is used in emails, reports, and browser tabs.
									</p>
								</div>
							</div>

							<!-- App Logo Section -->
							<div class="col-12 mt-5">
								<div class="row g-4">
									<!-- Primary Logo -->
									<div class="col-md-6">
										<div class="p-4 bg-light rounded-4 border border-dashed border-light-subtle h-100">
											<label class="form-label text-dark fw-bold fs-14 mb-3">Main Banner Logo</label>
											<div class="d-flex align-items-center g-4">
												<div class="me-4">
													<div class="position-relative">
														<div class="avatar-preview shadow-sm rounded-4 border border-4 border-white overflow-hidden bg-white d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
															@if($appLogo)
																<img id="logo-preview" src="{{ asset('storage/' . $appLogo) }}" alt="Logo" class="img-fluid w-100 h-100 object-fit-contain p-2">
															@else
																<div id="logo-placeholder" class="text-center p-3">
																	<i class="ti ti-photo fs-30 text-muted opacity-50"></i>
																	<p class="mb-0" style="font-size: 8px; color: #999; font-weight: 700;">NO LOGO</p>
																</div>
																<img id="logo-preview" src="#" alt="Logo Preview" class="img-fluid w-100 h-100 object-fit-contain p-2 d-none">
															@endif
														</div>
													</div>
												</div>
												<div class="flex-grow-1">
													<input type="file" class="form-control form-control-sm @error('app_logo') is-invalid @enderror" 
														   name="app_logo" accept="image/*" onchange="previewImage(this, 'logo-preview', 'logo-placeholder')">
													<p class="text-muted fs-11 mt-2 mb-0">Full logo used for sidebar headers and emails.</p>
												</div>
											</div>
										</div>
									</div>

									<!-- Small Logo (Icon) -->
									<div class="col-md-6">
										<div class="p-4 bg-light rounded-4 border border-dashed border-light-subtle h-100">
											<label class="form-label text-dark fw-bold fs-14 mb-3">Small Icon Logo (Mini Sidebar)</label>
											<div class="d-flex align-items-center g-4">
												<div class="me-4">
													<div class="position-relative">
														<div class="avatar-preview shadow-sm rounded-4 border border-4 border-white overflow-hidden bg-white d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
															@if($appLogoSmall)
																<img id="small-logo-preview" src="{{ asset('storage/' . $appLogoSmall) }}" alt="Small Logo" class="img-fluid w-100 h-100 object-fit-contain p-2">
															@else
																<div id="small-logo-placeholder" class="text-center p-3">
																	<i class="ti ti-brand-abstract fs-30 text-muted opacity-50"></i>
																	<p class="mb-0" style="font-size: 8px; color: #999; font-weight: 700;">NO ICON</p>
																</div>
																<img id="small-logo-preview" src="#" alt="Small Logo Preview" class="img-fluid w-100 h-100 object-fit-contain p-2 d-none">
															@endif
														</div>
													</div>
												</div>
												<div class="flex-grow-1">
													<input type="file" class="form-control form-control-sm @error('app_logo_small') is-invalid @enderror" 
														   name="app_logo_small" accept="image/*" onchange="previewImage(this, 'small-logo-preview', 'small-logo-placeholder')">
													<p class="text-muted fs-11 mt-2 mb-0">Compact icon used when the sidebar is minimized.</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- Actions -->
						<div class="d-flex justify-content-end gap-3 mt-5 pt-4 border-top border-light">
							<a href="{{ route('dashboard') }}" class="btn btn-light rounded-pill px-4 py-2 border">
								Dismiss Changes
							</a>
							<button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm">
								<i class="ti ti-device-floppy me-2"></i>Update System Configuration
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
		function previewImage(input, previewId, placeholderId) {
			const preview = document.getElementById(previewId);
			const placeholder = document.getElementById(placeholderId);
			
			if (input.files && input.files[0]) {
				const reader = new FileReader();
				reader.onload = function(e) {
					preview.src = e.target.result;
					preview.classList.remove('d-none');
					if (placeholder) placeholder.classList.add('d-none');
				}
				reader.readAsDataURL(input.files[0]);
			}
		}
	</script>

	<style>
		.input-group-text {
			color: #adb5bd;
		}
		.form-control:focus + .input-group-text {
			border-color: var(--bs-primary);
		}
		.bg-light-50 {
			background-color: #f8f9fa;
		}
		.border-dashed {
			border-style: dashed !important;
		}
	</style>

@endsection

@extends('layouts.app')

@section('title', 'My Account')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Account Preference</h2>
			<p class="text-muted mb-0 fs-13">Manage your account security, notifications and preferences</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('dashboard') }}" class="btn btn-light rounded-pill border shadow-sm px-3">
				<i class="ti ti-arrow-left me-2"></i>Dashboard
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	@if(session('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			{{ session('success') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	@if(session('error'))
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			{{ session('error') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	<div class="row g-4">
		<!-- Account Overview -->
		<div class="col-xl-4 col-lg-5">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-body p-4 text-center">
					<div class="position-relative d-inline-block mb-3">
						<div class="avatar avatar-xxxl rounded-circle border border-4 border-light-50 shadow-sm overflow-hidden bg-light" style="width: 120px; height: 120px;">
							<img src="{{ asset('assets/img/profiles/avatar-12.jpg') }}" alt="Account" class="img-fluid w-100 h-100 object-fit-cover">
						</div>
						<span class="position-absolute bottom-0 end-0 bg-success border border-white border-3 rounded-circle" style="width: 25px; height: 25px;"></span>
					</div>
					<h4 class="mb-1 fw-bold text-dark">{{ Auth::user()->name }}</h4>
					<p class="text-primary fw-bold mb-3 fs-13 text-uppercase ls-1">{{ Auth::user()->role->name ?? 'System User' }}</p>
					
					<div class="list-group list-group-flush text-start border-top border-light-subtle pt-3">
						<div class="list-group-item bg-transparent px-0 py-3 border-0 d-flex justify-content-between align-items-center">
							<span class="text-muted fs-13"><i class="ti ti-activity me-2"></i>Account Status</span>
							<span class="badge bg-success-subtle text-success rounded-pill px-3 py-1">Active</span>
						</div>
						<div class="list-group-item bg-transparent px-0 py-3 border-0 d-flex justify-content-between align-items-center">
							<span class="text-muted fs-13"><i class="ti ti-mail me-2"></i>Primary Email</span>
							<span class="text-dark fw-bold fs-13">{{ Str::limit(Auth::user()->email, 20) }}</span>
						</div>
						<div class="list-group-item bg-transparent px-0 py-3 border-0 d-flex justify-content-between align-items-center">
							<span class="text-muted fs-13"><i class="ti ti-calendar-event me-2"></i>Member Since</span>
							<span class="text-dark fw-bold fs-13">{{ Auth::user()->created_at->format('M Y') }}</span>
						</div>
					</div>

					<div class="d-grid gap-2 mt-4">
						<a href="{{ route('profile.index') }}" class="btn btn-primary rounded-pill py-2 shadow-sm">
							<i class="ti ti-user-edit me-2"></i>Update Profile
						</a>
						<a href="{{ url('/settings') }}" class="btn btn-outline-dark rounded-pill py-2">
							<i class="ti ti-settings-cog me-2"></i>General Settings
						</a>
					</div>
				</div>
			</div>

			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-dark text-white">
				<div class="card-header bg-transparent py-3 border-bottom border-white-10">
					<h5 class="mb-0 fw-bold fs-15 text-white"><i class="ti ti-shield-check me-2 text-warning"></i>Security Checkup</h5>
				</div>
				<div class="card-body p-4">
					<div class="mb-4">
						<label class="form-label text-white-50 fs-11 text-uppercase fw-bold mb-1 lh-1">Verification Status</label>
						<p class="mb-0">
							@if(Auth::user()->email_verified_at)
								<span class="badge bg-success border border-success rounded-pill px-3 py-1 text-white">Identity Verified <i class="ti ti-discount-check-filled ms-1"></i></span>
							@else
								<span class="badge bg-warning text-dark border border-warning rounded-pill px-3 py-1">Action Required</span>
							@endif
						</p>
					</div>
					<div class="mb-0">
						<label class="form-label text-white-50 fs-11 text-uppercase fw-bold mb-1">Last Security Login</label>
						<div class="d-flex align-items-center">
							<i class="ti ti-device-laptop me-2 text-info"></i>
							<p class="mb-0 text-white fw-medium fs-13">{{ Auth::user()->updated_at->format('M d, Y H:i') }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Account Overview -->

		<div class="col-xl-8 col-lg-7">
			<!-- Account Information -->
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-white py-3 border-bottom border-light d-flex justify-content-between align-items-center">
					<h5 class="mb-0 fw-bold text-dark"><i class="ti ti-id me-2 text-primary"></i>Identity Foundations</h5>
					<a href="{{ route('profile.index') }}" class="btn btn-sm btn-light border rounded-pill px-3 shadow-none">Manage Data</a>
				</div>
				<div class="card-body p-4">
					<div class="row g-4">
						<div class="col-md-6">
							<div class="p-3 bg-light rounded-4 border border-light-subtle">
								<label class="form-label text-muted fs-11 text-uppercase fw-bold mb-2">Display Identity</label>
								<div class="d-flex align-items-center text-dark">
									<i class="ti ti-user-circle fs-18 me-2 text-primary opacity-50"></i>
									<h6 class="mb-0 fw-bold fs-15">{{ Auth::user()->name }}</h6>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="p-3 bg-light rounded-4 border border-light-subtle">
								<label class="form-label text-muted fs-11 text-uppercase fw-bold mb-2">Communication Hub</label>
								<div class="d-flex align-items-center text-dark">
									<i class="ti ti-mail-bolt fs-18 me-2 text-primary opacity-50"></i>
									<h6 class="mb-0 fw-bold fs-15">{{ Auth::user()->email }}</h6>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="p-3 bg-light rounded-4 border border-light-subtle">
								<label class="form-label text-muted fs-11 text-uppercase fw-bold mb-2">Tele-Verification</label>
								<div class="d-flex align-items-center text-dark">
									<i class="ti ti-phone-check fs-18 me-2 text-primary opacity-50"></i>
									<h6 class="mb-0 fw-bold fs-15">{{ Auth::user()->phone ?? 'Contact Pending' }}</h6>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="p-3 bg-light rounded-4 border border-light-subtle">
								<label class="form-label text-muted fs-11 text-uppercase fw-bold mb-2">Internal Role</label>
								<div class="d-flex align-items-center text-dark">
									<i class="ti ti-hierarchy-2 fs-18 me-2 text-primary opacity-50"></i>
									<h6 class="mb-0 fw-bold fs-15">{{ Auth::user()->role->name ?? 'N/A' }}</h6>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /Account Information -->

			<!-- Security Settings -->
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-white py-3 border-bottom border-light">
					<h5 class="mb-0 fw-bold text-dark"><i class="ti ti-shield-lock me-2 text-warning"></i>Security Matrix</h5>
				</div>
				<div class="card-body p-4">
					<div class="d-flex justify-content-between align-items-center mb-4">
						<div class="d-flex align-items-start">
							<div class="bg-warning-subtle p-2 rounded-3 me-3 text-warning">
								<i class="ti ti-key fs-20"></i>
							</div>
							<div>
								<h6 class="mb-1 fw-bold text-dark">Credential Access</h6>
								<p class="text-muted mb-0 fs-13">Manage your authentication password.</p>
								<small class="text-muted">Last changed: {{ Auth::user()->updated_at->format('M d, Y') }}</small>
							</div>
						</div>
						<a href="{{ route('profile.index') }}" class="btn btn-outline-dark rounded-pill px-4 btn-sm">
							<i class="ti ti-rotate me-1"></i>Reset
						</a>
					</div>
					<hr class="border-light-subtle my-4">
					<div class="d-flex justify-content-between align-items-center mb-4">
						<div class="d-flex align-items-start opacity-75">
							<div class="bg-success-subtle p-2 rounded-3 me-3 text-success">
								<i class="ti ti-fingerprint fs-20"></i>
							</div>
							<div>
								<h6 class="mb-1 fw-bold text-dark">Multi-Factor Auth (MFA)</h6>
								<p class="text-muted mb-0 fs-13 lh-base">Shield your workspace with a second biometric layer.</p>
							</div>
						</div>
						<div class="form-check form-switch shadow-none">
							<input class="form-check-input shadow-none" type="checkbox" id="twoFactorAuth" disabled>
						</div>
					</div>
					<hr class="border-light-subtle my-4">
					<div class="d-flex justify-content-between align-items-center mb-0">
						<div class="d-flex align-items-start">
							<div class="bg-info-subtle p-2 rounded-3 me-3 text-info">
								<i class="ti ti-devices fs-20"></i>
							</div>
							<div>
								<h6 class="mb-1 fw-bold text-dark">Hardware Audit</h6>
								<p class="text-muted mb-0 fs-13 lh-base">Monitor and terminate active hardware sessions.</p>
							</div>
						</div>
						<a href="{{ url('/settings/security') }}" class="btn btn-light border rounded-pill px-4 btn-sm shadow-none">
							<i class="ti ti-history me-1"></i>Review
						</a>
					</div>
				</div>
			</div>
			<!-- /Security Settings -->

			<!-- Account Preferences -->
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-white py-3 border-bottom border-light">
					<h5 class="mb-0 fw-bold text-dark"><i class="ti ti-adjustments-alt me-2 text-info"></i>Workspace Matrix</h5>
				</div>
				<div class="card-body p-4">
					<div class="d-flex justify-content-between align-items-center mb-4 text-dark">
						<div class="d-flex align-items-center">
							<div class="bg-blue-subtle p-2 rounded-3 me-3 text-primary"><i class="ti ti-notification fs-20"></i></div>
							<div>
								<h6 class="mb-0 fw-bold">System Alerts</h6>
								<p class="text-muted mb-0 fs-12">Broadcast updates and mentioned flags.</p>
							</div>
						</div>
						<div class="form-check form-switch shadow-none">
							<input class="form-check-input shadow-none" type="checkbox" id="emailNotifications" checked>
						</div>
					</div>
					<hr class="border-light-subtle my-4">
					<div class="d-flex justify-content-between align-items-center mb-0">
						<div class="d-flex align-items-center">
							<div class="bg-purple-subtle p-2 rounded-3 me-3 text-purple"><i class="ti ti-world fs-20"></i></div>
							<div>
								<h6 class="mb-0 fw-bold">Localized Experience</h6>
								<p class="text-muted mb-0 fs-12">Interface language and date formatting.</p>
							</div>
						</div>
						<select class="form-select form-select-sm border-light-subtle rounded-3 shadow-none w-auto">
							<option selected>English (Default)</option>
							<option>Arabic (العربية)</option>
							<option>French</option>
						</select>
					</div>
				</div>
			</div>
			<!-- /Account Preferences -->

			<!-- Sensitive Zone -->
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden border-start border-danger border-4">
				<div class="card-body p-4">
					<div class="d-flex align-items-center mb-4">
						<div class="bg-danger-subtle p-2 rounded-3 me-3 text-danger"><i class="ti ti-alert-circle fs-24"></i></div>
						<div>
							<h5 class="mb-0 fw-bold text-danger">Data Governance</h5>
							<p class="text-muted mb-0 fs-13 lh-sm">High-risk actions related to profile lifecycle management.</p>
						</div>
					</div>
					
					<div class="row g-3">
						<div class="col-md-6">
							<div class="p-3 border border-light-subtle rounded-4 h-100 d-flex flex-column justify-content-between">
								<div>
									<h6 class="fw-bold text-dark mb-2 fs-14">Suspend Access</h6>
									<p class="text-muted fs-11 mb-3">Temporarily offline your data hub. Fully reversible.</p>
								</div>
								<button type="button" class="btn btn-outline-warning rounded-pill btn-sm w-100 py-2 border-2 fw-bold" data-bs-toggle="modal" data-bs-target="#deactivateModal">
									<i class="ti ti-user-pause me-2"></i>Go Dark
								</button>
							</div>
						</div>
						<div class="col-md-6">
							<div class="p-3 border border-danger-subtle bg-danger-transparent rounded-4 h-100 d-flex flex-column justify-content-between">
								<div>
									<h6 class="fw-bold text-danger mb-2 fs-14">Permanent Purge</h6>
									<p class="text-muted fs-11 mb-3">Irreversible deletion of all workspace identities.</p>
								</div>
								<button type="button" class="btn btn-danger rounded-pill btn-sm w-100 py-2 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#deleteModal">
									<i class="ti ti-trash-x me-2"></i>Purge Data
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /Sensitive Zone -->
		</div>
		</div>
	</div>

	<!-- Deactivate Account Modal -->
	<div class="modal fade" id="deactivateModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Deactivate Account</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to deactivate your account? You can reactivate it anytime by logging in again.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<form action="{{ route('account.deactivate') }}" method="POST" class="d-inline">
						@csrf
						@method('PUT')
						<button type="submit" class="btn btn-warning">Deactivate Account</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- /Deactivate Account Modal -->

	<!-- Delete Account Modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-danger">Delete Account</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p class="text-danger"><strong>Warning:</strong> This action cannot be undone. All your data will be permanently deleted.</p>
					<p>Are you absolutely sure you want to delete your account?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<form action="{{ route('account.delete') }}" method="POST" class="d-inline">
						@csrf
						@method('DELETE')
						<button type="submit" class="btn btn-danger">Delete Account</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- /Delete Account Modal -->

@endsection

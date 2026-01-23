@extends('layouts.app')

@section('title', 'My Account')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">My Account</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('dashboard') }}" class="btn btn-outline-light border">Back to Dashboard</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

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

	<div class="row">
		<!-- Account Overview -->
		<div class="col-xl-3 col-lg-4 col-md-12 mb-3">
			<div class="card">
				<div class="card-body text-center">
					<div class="avatar avatar-xxl mb-3">
						<img src="{{ asset('assets/img/profiles/avatar-12.jpg') }}" alt="Account" class="img-fluid rounded-circle">
					</div>
					<h4 class="mb-1">{{ Auth::user()->name }}</h4>
					<p class="text-muted mb-2">{{ Auth::user()->role->name ?? 'N/A' }}</p>
					<p class="text-muted mb-3">{{ Auth::user()->email }}</p>
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('profile.index') }}" class="btn btn-primary btn-sm">
							<i class="ti ti-user-circle me-2"></i>View Profile
						</a>
						<a href="{{ url('/settings') }}" class="btn btn-outline-light border btn-sm">
							<i class="ti ti-settings me-2"></i>Settings
						</a>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header">
					<h5>Account Status</h5>
				</div>
				<div class="card-body">
					<div class="mb-3">
						<label class="form-label text-muted mb-1">Status</label>
						<p class="mb-0">
							<span class="badge badge-success">Active</span>
						</p>
					</div>
					<div class="mb-3">
						<label class="form-label text-muted mb-1">Member Since</label>
						<p class="mb-0">{{ Auth::user()->created_at->format('M d, Y') }}</p>
					</div>
					<div class="mb-3">
						<label class="form-label text-muted mb-1">Last Login</label>
						<p class="mb-0">{{ Auth::user()->updated_at->format('M d, Y H:i') }}</p>
					</div>
					<div class="mb-0">
						<label class="form-label text-muted mb-1">Email Verified</label>
						<p class="mb-0">
							@if(Auth::user()->email_verified_at)
								<span class="badge badge-success">Verified</span>
							@else
								<span class="badge badge-warning">Not Verified</span>
							@endif
						</p>
					</div>
				</div>
			</div>
		</div>
		<!-- /Account Overview -->

		<div class="col-xl-9 col-lg-8 col-md-12">
			<!-- Account Information -->
			<div class="card mb-3">
				<div class="card-header">
					<h5>Account Information</h5>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6 mb-3">
							<label class="form-label text-muted mb-1">Full Name</label>
							<p class="mb-0 fw-medium">{{ Auth::user()->name }}</p>
						</div>
						<div class="col-md-6 mb-3">
							<label class="form-label text-muted mb-1">Email Address</label>
							<p class="mb-0 fw-medium">{{ Auth::user()->email }}</p>
						</div>
						<div class="col-md-6 mb-3">
							<label class="form-label text-muted mb-1">Phone Number</label>
							<p class="mb-0 fw-medium">{{ Auth::user()->phone ?? 'N/A' }}</p>
						</div>
						<div class="col-md-6 mb-3">
							<label class="form-label text-muted mb-1">Role</label>
							<p class="mb-0 fw-medium">{{ Auth::user()->role->name ?? 'N/A' }}</p>
						</div>
						<div class="col-md-12 mb-0">
							<label class="form-label text-muted mb-1">Address</label>
							<p class="mb-0 fw-medium">{{ Auth::user()->address ?? 'N/A' }}</p>
						</div>
					</div>
					<div class="mt-3">
						<a href="{{ route('profile.index') }}" class="btn btn-primary btn-sm">
							<i class="ti ti-edit me-2"></i>Edit Account Information
						</a>
					</div>
				</div>
			</div>
			<!-- /Account Information -->

			<!-- Security Settings -->
			<div class="card mb-3">
				<div class="card-header">
					<h5>Security Settings</h5>
				</div>
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center mb-3">
						<div>
							<h6 class="mb-1">Password</h6>
							<p class="text-muted mb-0">Last changed: {{ Auth::user()->updated_at->format('M d, Y') }}</p>
						</div>
						<a href="{{ route('profile.index') }}" class="btn btn-outline-primary btn-sm">
							<i class="ti ti-key me-2"></i>Change Password
						</a>
					</div>
					<hr>
					<div class="d-flex justify-content-between align-items-center mb-3">
						<div>
							<h6 class="mb-1">Two-Factor Authentication</h6>
							<p class="text-muted mb-0">Add an extra layer of security to your account</p>
						</div>
						<div class="form-check form-switch">
							<input class="form-check-input" type="checkbox" id="twoFactorAuth" disabled>
							<label class="form-check-label" for="twoFactorAuth">Disabled</label>
						</div>
					</div>
					<hr>
					<div class="d-flex justify-content-between align-items-center mb-0">
						<div>
							<h6 class="mb-1">Login Sessions</h6>
							<p class="text-muted mb-0">Manage your active login sessions</p>
						</div>
						<a href="{{ url('/settings/security') }}" class="btn btn-outline-primary btn-sm">
							<i class="ti ti-device-desktop me-2"></i>Manage Sessions
						</a>
					</div>
				</div>
			</div>
			<!-- /Security Settings -->

			<!-- Account Preferences -->
			<div class="card mb-3">
				<div class="card-header">
					<h5>Account Preferences</h5>
				</div>
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center mb-3">
						<div>
							<h6 class="mb-1">Email Notifications</h6>
							<p class="text-muted mb-0">Receive email notifications for important updates</p>
						</div>
						<div class="form-check form-switch">
							<input class="form-check-input" type="checkbox" id="emailNotifications" checked>
							<label class="form-check-label" for="emailNotifications">Enabled</label>
						</div>
					</div>
					<hr>
					<div class="d-flex justify-content-between align-items-center mb-3">
						<div>
							<h6 class="mb-1">SMS Notifications</h6>
							<p class="text-muted mb-0">Receive SMS notifications for important updates</p>
						</div>
						<div class="form-check form-switch">
							<input class="form-check-input" type="checkbox" id="smsNotifications">
							<label class="form-check-label" for="smsNotifications">Disabled</label>
						</div>
					</div>
					<hr>
					<div class="d-flex justify-content-between align-items-center mb-0">
						<div>
							<h6 class="mb-1">Language</h6>
							<p class="text-muted mb-0">Choose your preferred language</p>
						</div>
						<select class="form-select form-select-sm" style="width: auto;">
							<option selected>English</option>
							<option>Spanish</option>
							<option>French</option>
							<option>German</option>
						</select>
					</div>
				</div>
			</div>
			<!-- /Account Preferences -->

			<!-- Danger Zone -->
			<div class="card border-danger">
				<div class="card-header bg-danger text-white">
					<h5 class="mb-0 text-white">Danger Zone</h5>
				</div>
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center mb-3">
						<div>
							<h6 class="mb-1">Deactivate Account</h6>
							<p class="text-muted mb-0">Temporarily disable your account. You can reactivate it anytime.</p>
						</div>
						<button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#deactivateModal">
							<i class="ti ti-user-off me-2"></i>Deactivate Account
						</button>
					</div>
					<hr>
					<div class="d-flex justify-content-between align-items-center mb-0">
						<div>
							<h6 class="mb-1">Delete Account</h6>
							<p class="text-muted mb-0">Permanently delete your account and all associated data. This action cannot be undone.</p>
						</div>
						<button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
							<i class="ti ti-trash me-2"></i>Delete Account
						</button>
					</div>
				</div>
			</div>
			<!-- /Danger Zone -->
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

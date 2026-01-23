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
		<!-- General Settings -->
		<div class="col-xl-3 col-lg-4 col-md-6 mb-3">
			<div class="card">
				<div class="card-body text-center">
					<div class="avatar avatar-lg bg-primary rounded-circle mx-auto mb-3">
						<i class="ti ti-user-circle fs-24"></i>
					</div>
					<h5 class="mb-2">General Settings</h5>
					<p class="text-muted mb-3">Manage your profile, security, notifications, and connected apps</p>
					<a href="{{ url('/settings/profile') }}" class="btn btn-primary btn-sm">Manage</a>
				</div>
			</div>
		</div>
		<!-- /General Settings -->

		<!-- Website Settings -->
		<div class="col-xl-3 col-lg-4 col-md-6 mb-3">
			<div class="card">
				<div class="card-body text-center">
					<div class="avatar avatar-lg bg-success rounded-circle mx-auto mb-3">
						<i class="ti ti-world fs-24"></i>
					</div>
					<h5 class="mb-2">Website Settings</h5>
					<p class="text-muted mb-3">Configure business, SEO, localization, and appearance settings</p>
					<a href="{{ url('/settings/business') }}" class="btn btn-success btn-sm">Manage</a>
				</div>
			</div>
		</div>
		<!-- /Website Settings -->

		<!-- App Settings -->
		<div class="col-xl-3 col-lg-4 col-md-6 mb-3">
			<div class="card">
				<div class="card-body text-center">
					<div class="avatar avatar-lg bg-info rounded-circle mx-auto mb-3">
						<i class="ti ti-apps fs-24"></i>
					</div>
					<h5 class="mb-2">App Settings</h5>
					<p class="text-muted mb-3">Configure salary, approval, invoice, leave types, and custom fields</p>
					<a href="{{ url('/settings/salary') }}" class="btn btn-info btn-sm">Manage</a>
				</div>
			</div>
		</div>
		<!-- /App Settings -->

		<!-- System Settings -->
		<div class="col-xl-3 col-lg-4 col-md-6 mb-3">
			<div class="card">
				<div class="card-body text-center">
					<div class="avatar avatar-lg bg-warning rounded-circle mx-auto mb-3">
						<i class="ti ti-settings fs-24"></i>
					</div>
					<h5 class="mb-2">System Settings</h5>
					<p class="text-muted mb-3">Manage email, SMS, OTP, GDPR, and maintenance mode</p>
					<a href="{{ url('/settings/email') }}" class="btn btn-warning btn-sm">Manage</a>
				</div>
			</div>
		</div>
		<!-- /System Settings -->

		<!-- Financial Settings -->
		<div class="col-xl-3 col-lg-4 col-md-6 mb-3">
			<div class="card">
				<div class="card-body text-center">
					<div class="avatar avatar-lg bg-danger rounded-circle mx-auto mb-3">
						<i class="ti ti-currency-dollar fs-24"></i>
					</div>
					<h5 class="mb-2">Financial Settings</h5>
					<p class="text-muted mb-3">Configure payment gateways, tax rates, and currencies</p>
					<a href="{{ url('/settings/payment-gateways') }}" class="btn btn-danger btn-sm">Manage</a>
				</div>
			</div>
		</div>
		<!-- /Financial Settings -->

		<!-- Other Settings -->
		<div class="col-xl-3 col-lg-4 col-md-6 mb-3">
			<div class="card">
				<div class="card-body text-center">
					<div class="avatar avatar-lg bg-secondary rounded-circle mx-auto mb-3">
						<i class="ti ti-adjustments fs-24"></i>
					</div>
					<h5 class="mb-2">Other Settings</h5>
					<p class="text-muted mb-3">Custom CSS/JS, cronjob, storage, backup, and cache management</p>
					<a href="{{ url('/settings/custom-css') }}" class="btn btn-secondary btn-sm">Manage</a>
				</div>
			</div>
		</div>
		<!-- /Other Settings -->
	</div>

	<!-- Quick Settings Links -->
	<div class="row mt-4">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h5>Quick Settings Links</h5>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6 col-lg-4 mb-3">
							<h6 class="mb-2"><i class="ti ti-user-circle me-2"></i>General Settings</h6>
							<ul class="list-unstyled ms-4">
								<li><a href="{{ url('/settings/profile') }}" class="text-muted">Profile</a></li>
								<li><a href="{{ url('/settings/security') }}" class="text-muted">Security</a></li>
								<li><a href="{{ url('/settings/notifications') }}" class="text-muted">Notifications</a></li>
								<li><a href="{{ url('/settings/apps') }}" class="text-muted">Connected Apps</a></li>
							</ul>
						</div>
						<div class="col-md-6 col-lg-4 mb-3">
							<h6 class="mb-2"><i class="ti ti-world me-2"></i>Website Settings</h6>
							<ul class="list-unstyled ms-4">
								<li><a href="{{ url('/settings/business') }}" class="text-muted">Business Settings</a></li>
								<li><a href="{{ url('/settings/seo') }}" class="text-muted">SEO Settings</a></li>
								<li><a href="{{ url('/settings/localization') }}" class="text-muted">Localization</a></li>
								<li><a href="{{ url('/settings/appearance') }}" class="text-muted">Appearance</a></li>
							</ul>
						</div>
						<div class="col-md-6 col-lg-4 mb-3">
							<h6 class="mb-2"><i class="ti ti-apps me-2"></i>App Settings</h6>
							<ul class="list-unstyled ms-4">
								<li><a href="{{ url('/settings/salary') }}" class="text-muted">Salary Settings</a></li>
								<li><a href="{{ url('/settings/approval') }}" class="text-muted">Approval Settings</a></li>
								<li><a href="{{ url('/settings/leave-type') }}" class="text-muted">Leave Type</a></li>
								<li><a href="{{ url('/policies') }}" class="text-muted">Policies</a></li>
							</ul>
						</div>
						<div class="col-md-6 col-lg-4 mb-3">
							<h6 class="mb-2"><i class="ti ti-settings me-2"></i>System Settings</h6>
							<ul class="list-unstyled ms-4">
								<li><a href="{{ url('/settings/email') }}" class="text-muted">Email Settings</a></li>
								<li><a href="{{ url('/settings/sms') }}" class="text-muted">SMS Settings</a></li>
								<li><a href="{{ url('/settings/otp') }}" class="text-muted">OTP</a></li>
								<li><a href="{{ url('/settings/maintenance') }}" class="text-muted">Maintenance Mode</a></li>
							</ul>
						</div>
						<div class="col-md-6 col-lg-4 mb-3">
							<h6 class="mb-2"><i class="ti ti-currency-dollar me-2"></i>Financial Settings</h6>
							<ul class="list-unstyled ms-4">
								<li><a href="{{ url('/settings/payment-gateways') }}" class="text-muted">Payment Gateways</a></li>
								<li><a href="{{ url('/settings/tax-rates') }}" class="text-muted">Tax Rate</a></li>
								<li><a href="{{ url('/settings/currencies') }}" class="text-muted">Currencies</a></li>
							</ul>
						</div>
						<div class="col-md-6 col-lg-4 mb-3">
							<h6 class="mb-2"><i class="ti ti-adjustments me-2"></i>Other Settings</h6>
							<ul class="list-unstyled ms-4">
								<li><a href="{{ url('/settings/custom-css') }}" class="text-muted">Custom CSS</a></li>
								<li><a href="{{ url('/settings/backup') }}" class="text-muted">Backup</a></li>
								<li><a href="{{ url('/settings/clear-cache') }}" class="text-muted">Clear Cache</a></li>
								<li><a href="{{ url('/settings/storage') }}" class="text-muted">Storage</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /Quick Settings Links -->

@endsection

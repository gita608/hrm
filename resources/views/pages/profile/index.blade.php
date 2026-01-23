@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">My Profile</h2>
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

	<div class="row">
		<div class="col-xl-3 col-lg-4 col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="text-center">
						<div class="avatar avatar-xxl mb-3">
							<img src="{{ asset('assets/img/profiles/avatar-12.jpg') }}" alt="Profile" class="img-fluid rounded-circle">
						</div>
						<h4 class="mb-1">{{ $user->name }}</h4>
						<p class="text-muted mb-2">{{ $user->role->name ?? 'N/A' }}</p>
						<p class="text-muted mb-3">{{ $user->email }}</p>
					</div>
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('profile.index') }}" class="btn btn-primary">
							<i class="ti ti-user-circle me-2"></i>My Profile
						</a>
						<a href="{{ url('/settings') }}" class="btn btn-outline-light border">
							<i class="ti ti-settings me-2"></i>Settings
						</a>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header">
					<h5>Personal Information</h5>
				</div>
				<div class="card-body">
					<div class="mb-3">
						<label class="form-label text-muted mb-1">Phone</label>
						<p class="mb-0">{{ $user->phone ?? 'N/A' }}</p>
					</div>
					<div class="mb-3">
						<label class="form-label text-muted mb-1">Address</label>
						<p class="mb-0">{{ $user->address ?? 'N/A' }}</p>
					</div>
					<div class="mb-3">
						<label class="form-label text-muted mb-1">Member Since</label>
						<p class="mb-0">{{ $user->created_at->format('M d, Y') }}</p>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-9 col-lg-8 col-md-12">
			<div class="card">
				<div class="card-header">
					<h5>Profile Information</h5>
				</div>
				<div class="card-body">
					<form action="{{ route('profile.update') }}" method="POST">
						@csrf
						@method('PUT')
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Full Name <span class="text-danger">*</span></label>
									<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required>
									@error('name')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Email <span class="text-danger">*</span></label>
									<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required>
									@error('email')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Phone</label>
									<input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $user->phone ?? '') }}">
									@error('phone')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Role</label>
									<input type="text" class="form-control" value="{{ $user->role->name ?? 'N/A' }}" disabled>
								</div>
							</div>
							<div class="col-md-12">
								<div class="mb-3">
									<label class="form-label">Address</label>
									<textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="3">{{ old('address', $user->address ?? '') }}</textarea>
									@error('address')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
						<div class="d-flex justify-content-end gap-2">
							<button type="submit" class="btn btn-primary">Update Profile</button>
						</div>
					</form>
				</div>
			</div>

			<div class="card">
				<div class="card-header">
					<h5>Change Password</h5>
				</div>
				<div class="card-body">
					<form action="{{ route('profile.password.update') }}" method="POST">
						@csrf
						@method('PUT')
						<div class="row">
							<div class="col-md-12">
								<div class="mb-3">
									<label class="form-label">Current Password <span class="text-danger">*</span></label>
									<div class="pass-group">
										<input type="password" class="pass-input form-control @error('current_password') is-invalid @enderror" name="current_password" required>
										<span class="ti toggle-password ti-eye-off"></span>
									</div>
									@error('current_password')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">New Password <span class="text-danger">*</span></label>
									<div class="pass-group">
										<input type="password" class="pass-input form-control @error('password') is-invalid @enderror" name="password" required>
										<span class="ti toggle-password ti-eye-off"></span>
									</div>
									@error('password')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Confirm Password <span class="text-danger">*</span></label>
									<div class="pass-group">
										<input type="password" class="pass-input form-control" name="password_confirmation" required>
										<span class="ti toggle-password ti-eye-off"></span>
									</div>
								</div>
							</div>
						</div>
						<div class="d-flex justify-content-end gap-2">
							<button type="submit" class="btn btn-primary">Change Password</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection

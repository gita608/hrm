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
							@if($user->profile_picture)
								<img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile" class="img-fluid rounded-circle">
							@else
								<div class="avatar-initial bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px; font-size: 2.5rem;">
									{{ strtoupper(substr($user->name, 0, 1)) }}
								</div>
							@endif
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
					@if($user->emirates_id)
					<div class="mb-3">
						<label class="form-label text-muted mb-1">Emirates ID</label>
						<p class="mb-0">{{ $user->emirates_id }}</p>
					</div>
					@endif
					@if($user->nationality)
					<div class="mb-3">
						<label class="form-label text-muted mb-1">Nationality</label>
						<p class="mb-0">{{ $user->nationality }}</p>
					</div>
					@endif
					@if($user->uae_emirate)
					<div class="mb-3">
						<label class="form-label text-muted mb-1">UAE Location</label>
						<p class="mb-0">{{ $user->uae_emirate }}{{ $user->uae_city ? ', ' . $user->uae_city : '' }}{{ $user->uae_area ? ', ' . $user->uae_area : '' }}</p>
					</div>
					@endif
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
					<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						<div class="row">
							<div class="col-md-12">
								<div class="mb-4">
									<label class="form-label">Profile Picture</label>
									<div class="d-flex align-items-center flex-wrap row-gap-3 bg-light w-100 rounded p-3">
										<div class="d-flex align-items-center justify-content-center avatar avatar-xxl rounded-circle border border-dashed me-2 flex-shrink-0 text-dark frames" id="profile-preview-container">
											@if($user->profile_picture)
												<img id="profile-preview" src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Preview" class="img-fluid rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
												<i class="ti ti-photo text-gray-2 fs-16 d-none" id="profile-preview-icon"></i>
											@else
												<i class="ti ti-photo text-gray-2 fs-16" id="profile-preview-icon"></i>
												<img id="profile-preview" src="" alt="Profile Preview" class="img-fluid rounded-circle d-none" style="width: 100%; height: 100%; object-fit: cover;">
											@endif
										</div>
										<div class="profile-upload">
											<div class="mb-2">
												<h6 class="mb-1">Upload Profile Image</h6>
												<p class="fs-12">Image should be below 4 MB (JPG, PNG, GIF)</p>
											</div>
											<div class="profile-uploader d-flex align-items-center">
												<label for="profile_picture" class="btn btn-sm btn-primary me-2 mb-0" style="cursor: pointer;">
													Upload
													<input type="file" id="profile_picture" name="profile_picture" class="d-none" accept="image/*" onchange="previewProfilePicture(this)">
												</label>
												<button type="button" class="btn btn-light btn-sm" onclick="clearProfilePicture()">Clear</button>
											</div>
											@error('profile_picture')
												<div class="text-danger fs-12 mt-1">{{ $message }}</div>
											@enderror
										</div>
									</div>
								</div>
							</div>
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

						<!-- UAE-Specific Information Section -->
						<hr class="my-4">
						<h5 class="mb-3">UAE-Specific Information</h5>
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Emirates ID</label>
									<input type="text" class="form-control @error('emirates_id') is-invalid @enderror" name="emirates_id" value="{{ old('emirates_id', $user->emirates_id) }}" placeholder="e.g., 784-1234-1234567-1">
									@error('emirates_id')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Nationality</label>
									<input type="text" class="form-control @error('nationality') is-invalid @enderror" name="nationality" value="{{ old('nationality', $user->nationality) }}">
									@error('nationality')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Passport Number</label>
									<input type="text" class="form-control @error('passport_number') is-invalid @enderror" name="passport_number" value="{{ old('passport_number', $user->passport_number) }}">
									@error('passport_number')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Passport Expiry Date</label>
									<input type="date" class="form-control @error('passport_expiry_date') is-invalid @enderror" name="passport_expiry_date" value="{{ old('passport_expiry_date', $user->passport_expiry_date?->format('Y-m-d')) }}">
									@error('passport_expiry_date')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Visa Type</label>
									<select class="form-select @error('visa_type') is-invalid @enderror" name="visa_type">
										<option value="">Select Visa Type</option>
										<option value="employment" {{ old('visa_type', $user->visa_type) == 'employment' ? 'selected' : '' }}>Employment</option>
										<option value="dependent" {{ old('visa_type', $user->visa_type) == 'dependent' ? 'selected' : '' }}>Dependent</option>
										<option value="investor" {{ old('visa_type', $user->visa_type) == 'investor' ? 'selected' : '' }}>Investor</option>
										<option value="student" {{ old('visa_type', $user->visa_type) == 'student' ? 'selected' : '' }}>Student</option>
										<option value="tourist" {{ old('visa_type', $user->visa_type) == 'tourist' ? 'selected' : '' }}>Tourist</option>
										<option value="other" {{ old('visa_type', $user->visa_type) == 'other' ? 'selected' : '' }}>Other</option>
									</select>
									@error('visa_type')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Visa Number</label>
									<input type="text" class="form-control @error('visa_number') is-invalid @enderror" name="visa_number" value="{{ old('visa_number', $user->visa_number) }}">
									@error('visa_number')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Visa Expiry Date</label>
									<input type="date" class="form-control @error('visa_expiry_date') is-invalid @enderror" name="visa_expiry_date" value="{{ old('visa_expiry_date', $user->visa_expiry_date?->format('Y-m-d')) }}">
									@error('visa_expiry_date')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Labor Card Number</label>
									<input type="text" class="form-control @error('labor_card_number') is-invalid @enderror" name="labor_card_number" value="{{ old('labor_card_number', $user->labor_card_number) }}">
									@error('labor_card_number')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Labor Card Expiry Date</label>
									<input type="date" class="form-control @error('labor_card_expiry_date') is-invalid @enderror" name="labor_card_expiry_date" value="{{ old('labor_card_expiry_date', $user->labor_card_expiry_date?->format('Y-m-d')) }}">
									@error('labor_card_expiry_date')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">UAE Emirate</label>
									<select class="form-select @error('uae_emirate') is-invalid @enderror" name="uae_emirate">
										<option value="">Select Emirate</option>
										<option value="Abu Dhabi" {{ old('uae_emirate', $user->uae_emirate) == 'Abu Dhabi' ? 'selected' : '' }}>Abu Dhabi</option>
										<option value="Dubai" {{ old('uae_emirate', $user->uae_emirate) == 'Dubai' ? 'selected' : '' }}>Dubai</option>
										<option value="Sharjah" {{ old('uae_emirate', $user->uae_emirate) == 'Sharjah' ? 'selected' : '' }}>Sharjah</option>
										<option value="Ajman" {{ old('uae_emirate', $user->uae_emirate) == 'Ajman' ? 'selected' : '' }}>Ajman</option>
										<option value="Umm Al Quwain" {{ old('uae_emirate', $user->uae_emirate) == 'Umm Al Quwain' ? 'selected' : '' }}>Umm Al Quwain</option>
										<option value="Ras Al Khaimah" {{ old('uae_emirate', $user->uae_emirate) == 'Ras Al Khaimah' ? 'selected' : '' }}>Ras Al Khaimah</option>
										<option value="Fujairah" {{ old('uae_emirate', $user->uae_emirate) == 'Fujairah' ? 'selected' : '' }}>Fujairah</option>
									</select>
									@error('uae_emirate')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">UAE City</label>
									<input type="text" class="form-control @error('uae_city') is-invalid @enderror" name="uae_city" value="{{ old('uae_city', $user->uae_city) }}">
									@error('uae_city')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">UAE Area</label>
									<input type="text" class="form-control @error('uae_area') is-invalid @enderror" name="uae_area" value="{{ old('uae_area', $user->uae_area) }}">
									@error('uae_area')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Bank Name</label>
									<input type="text" class="form-control @error('bank_name') is-invalid @enderror" name="bank_name" value="{{ old('bank_name', $user->bank_name) }}" placeholder="e.g., Emirates NBD, ADCB">
									@error('bank_name')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">IBAN</label>
									<input type="text" class="form-control @error('iban') is-invalid @enderror" name="iban" value="{{ old('iban', $user->iban) }}" placeholder="AE123456789012345678901">
									@error('iban')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Emergency Contact Name</label>
									<input type="text" class="form-control @error('emergency_contact_name') is-invalid @enderror" name="emergency_contact_name" value="{{ old('emergency_contact_name', $user->emergency_contact_name) }}">
									@error('emergency_contact_name')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Emergency Contact Phone</label>
									<input type="text" class="form-control @error('emergency_contact_phone') is-invalid @enderror" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $user->emergency_contact_phone) }}">
									@error('emergency_contact_phone')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
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

	<script>
		function previewProfilePicture(input) {
			if (input.files && input.files[0]) {
				const reader = new FileReader();
				reader.onload = function(e) {
					document.getElementById('profile-preview').src = e.target.result;
					document.getElementById('profile-preview').classList.remove('d-none');
					document.getElementById('profile-preview-icon').classList.add('d-none');
				}
				reader.readAsDataURL(input.files[0]);
			}
		}

		function clearProfilePicture() {
			document.getElementById('profile_picture').value = '';
			@if($user->profile_picture)
				document.getElementById('profile-preview').src = '{{ asset('storage/' . $user->profile_picture) }}';
				document.getElementById('profile-preview').classList.remove('d-none');
				document.getElementById('profile-preview-icon').classList.add('d-none');
			@else
				document.getElementById('profile-preview').src = '';
				document.getElementById('profile-preview').classList.add('d-none');
				document.getElementById('profile-preview-icon').classList.remove('d-none');
			@endif
		}
	</script>

@endsection

@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">My Profile</h2>
			<p class="text-muted mb-0 fs-13">Manage your personal information and settings</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('dashboard') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to Dashboard
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

	<div class="row">
		<div class="col-xl-3 col-lg-4 col-md-12">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-body p-4">
					<div class="text-center">
						<div class="avatar avatar-xxl mb-3 mx-auto">
							@if($user->profile_picture)
								<img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile" class="img-fluid rounded-circle border border-2 border-primary p-1" style="width: 100px; height: 100px; object-fit: cover;">
							@else
								<div class="avatar-initial bg-primary-transparent text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 100px; height: 100px; font-size: 2.5rem;">
									{{ strtoupper(substr($user->name, 0, 1)) }}
								</div>
							@endif
						</div>
						<h5 class="mb-1 fw-bold text-dark">{{ $user->name }}</h5>
						<p class="text-muted mb-2 fs-13">{{ $user->role->name ?? 'N/A' }}</p>
						<div class="d-flex align-items-center justify-content-center mb-3">
							<span class="badge bg-light text-dark rounded-pill border px-3 py-1">{{ $user->email }}</span>
						</div>
					</div>
					<div class="d-flex flex-column gap-2 mt-3">
						<a href="{{ route('profile.index') }}" class="btn btn-primary rounded-pill shadow-sm">
							<i class="ti ti-user-circle me-2"></i>My Profile
						</a>
						<a href="{{ url('/settings') }}" class="btn btn-light rounded-pill border shadow-sm">
							<i class="ti ti-settings me-2"></i>Settings
						</a>
					</div>
				</div>
			</div>

			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Personal Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="mb-4">
						<label class="form-label text-muted mb-1 fs-12 text-uppercase fw-medium">Phone</label>
						<p class="mb-0 text-dark fw-medium">{{ $user->phone ?? 'N/A' }}</p>
					</div>
					<div class="mb-4">
						<label class="form-label text-muted mb-1 fs-12 text-uppercase fw-medium">Address</label>
						<p class="mb-0 text-dark fw-medium">{{ $user->address ?? 'N/A' }}</p>
					</div>
					@if($user->emirates_id)
					<div class="mb-4">
						<label class="form-label text-muted mb-1 fs-12 text-uppercase fw-medium">Emirates ID</label>
						<p class="mb-0 text-dark fw-medium">{{ $user->emirates_id }}</p>
					</div>
					@endif
					@if($user->nationality)
					<div class="mb-4">
						<label class="form-label text-muted mb-1 fs-12 text-uppercase fw-medium">Nationality</label>
						<p class="mb-0 text-dark fw-medium">{{ $user->nationality }}</p>
					</div>
					@endif
					@if($user->uae_emirate)
					<div class="mb-4">
						<label class="form-label text-muted mb-1 fs-12 text-uppercase fw-medium">UAE Location</label>
						<p class="mb-0 text-dark fw-medium">{{ $user->uae_emirate }}{{ $user->uae_city ? ', ' . $user->uae_city : '' }}{{ $user->uae_area ? ', ' . $user->uae_area : '' }}</p>
					</div>
					@endif
					<div>
						<label class="form-label text-muted mb-1 fs-12 text-uppercase fw-medium">Member Since</label>
						<p class="mb-0 text-dark fw-medium">{{ $user->created_at->format('M d, Y') }}</p>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-9 col-lg-8 col-md-12">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Profile Information</h5>
				</div>
				<div class="card-body p-4">
					<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						<div class="row">
							<div class="col-md-12">
								<div class="mb-4">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Profile Picture</label>
									<div class="d-flex align-items-center flex-wrap row-gap-3 bg-light-50 border border-dashed rounded-3 p-4">
										<div class="d-flex align-items-center justify-content-center avatar avatar-xxl rounded-circle border border-2 border-white shadow-sm me-3 flex-shrink-0 text-dark bg-white overflow-hidden" id="profile-preview-container" style="width: 80px; height: 80px;">
											@if($user->profile_picture)
												<img id="profile-preview" src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Preview" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
												<i class="ti ti-photo text-muted fs-24 d-none" id="profile-preview-icon"></i>
											@else
												<i class="ti ti-photo text-muted fs-24" id="profile-preview-icon"></i>
												<img id="profile-preview" src="" alt="Profile Preview" class="img-fluid d-none" style="width: 100%; height: 100%; object-fit: cover;">
											@endif
										</div>
										<div class="profile-upload flex-grow-1">
											<div class="mb-2">
												<h6 class="mb-1 fw-bold text-dark">Upload Profile Image</h6>
												<p class="fs-12 text-muted mb-0">Image should be below 4 MB (JPG, PNG, GIF)</p>
											</div>
											<div class="profile-uploader d-flex align-items-center gap-2">
												<label for="profile_picture" class="btn btn-sm btn-primary rounded-pill px-3 mb-0" style="cursor: pointer;">
													Upload
													<input type="file" id="profile_picture" name="profile_picture" class="d-none" accept="image/*" onchange="previewProfilePicture(this)">
												</label>
												<button type="button" class="btn btn-light btn-sm rounded-pill px-3 border" onclick="clearProfilePicture()">Clear</button>
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
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Full Name <span class="text-danger">*</span></label>
									<input type="text" class="form-control rounded-3 border-light shadow-none @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required>
									@error('name')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Email <span class="text-danger">*</span></label>
									<input type="email" class="form-control rounded-3 border-light shadow-none @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required>
									@error('email')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Phone</label>
									<input type="text" class="form-control rounded-3 border-light shadow-none @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $user->phone ?? '') }}">
									@error('phone')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Role</label>
									<input type="text" class="form-control rounded-3 border-light shadow-none bg-light" value="{{ $user->role->name ?? 'N/A' }}" disabled>
								</div>
							</div>
							<div class="col-md-12">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Address</label>
									<textarea class="form-control rounded-3 border-light shadow-none @error('address') is-invalid @enderror" name="address" rows="3">{{ old('address', $user->address ?? '') }}</textarea>
									@error('address')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>

						<!-- UAE-Specific Information Section -->
						<hr class="my-4 border-light">
						<h5 class="mb-3 fw-bold text-dark">UAE-Specific Information</h5>
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Emirates ID</label>
									<input type="text" class="form-control rounded-3 border-light shadow-none @error('emirates_id') is-invalid @enderror" name="emirates_id" value="{{ old('emirates_id', $user->emirates_id) }}" placeholder="e.g., 784-1234-1234567-1">
									@error('emirates_id')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Nationality</label>
									<input type="text" class="form-control rounded-3 border-light shadow-none @error('nationality') is-invalid @enderror" name="nationality" value="{{ old('nationality', $user->nationality) }}">
									@error('nationality')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Passport Number</label>
									<input type="text" class="form-control rounded-3 border-light shadow-none @error('passport_number') is-invalid @enderror" name="passport_number" value="{{ old('passport_number', $user->passport_number) }}">
									@error('passport_number')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Passport Expiry Date</label>
									<input type="date" class="form-control rounded-3 border-light shadow-none @error('passport_expiry_date') is-invalid @enderror" name="passport_expiry_date" value="{{ old('passport_expiry_date', $user->passport_expiry_date?->format('Y-m-d')) }}">
									@error('passport_expiry_date')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Visa Type</label>
									<select class="form-select rounded-3 border-light shadow-none @error('visa_type') is-invalid @enderror" name="visa_type">
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
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Visa Number</label>
									<input type="text" class="form-control rounded-3 border-light shadow-none @error('visa_number') is-invalid @enderror" name="visa_number" value="{{ old('visa_number', $user->visa_number) }}">
									@error('visa_number')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Visa Expiry Date</label>
									<input type="date" class="form-control rounded-3 border-light shadow-none @error('visa_expiry_date') is-invalid @enderror" name="visa_expiry_date" value="{{ old('visa_expiry_date', $user->visa_expiry_date?->format('Y-m-d')) }}">
									@error('visa_expiry_date')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Labor Card Number</label>
									<input type="text" class="form-control rounded-3 border-light shadow-none @error('labor_card_number') is-invalid @enderror" name="labor_card_number" value="{{ old('labor_card_number', $user->labor_card_number) }}">
									@error('labor_card_number')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Labor Card Expiry Date</label>
									<input type="date" class="form-control rounded-3 border-light shadow-none @error('labor_card_expiry_date') is-invalid @enderror" name="labor_card_expiry_date" value="{{ old('labor_card_expiry_date', $user->labor_card_expiry_date?->format('Y-m-d')) }}">
									@error('labor_card_expiry_date')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">UAE Emirate</label>
									<select class="form-select rounded-3 border-light shadow-none @error('uae_emirate') is-invalid @enderror" name="uae_emirate">
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
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">UAE City</label>
									<input type="text" class="form-control rounded-3 border-light shadow-none @error('uae_city') is-invalid @enderror" name="uae_city" value="{{ old('uae_city', $user->uae_city) }}">
									@error('uae_city')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">UAE Area</label>
									<input type="text" class="form-control rounded-3 border-light shadow-none @error('uae_area') is-invalid @enderror" name="uae_area" value="{{ old('uae_area', $user->uae_area) }}">
									@error('uae_area')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Bank Name</label>
									<input type="text" class="form-control rounded-3 border-light shadow-none @error('bank_name') is-invalid @enderror" name="bank_name" value="{{ old('bank_name', $user->bank_name) }}" placeholder="e.g., Emirates NBD, ADCB">
									@error('bank_name')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">IBAN</label>
									<input type="text" class="form-control rounded-3 border-light shadow-none @error('iban') is-invalid @enderror" name="iban" value="{{ old('iban', $user->iban) }}" placeholder="AE123456789012345678901">
									@error('iban')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Emergency Contact Name</label>
									<input type="text" class="form-control rounded-3 border-light shadow-none @error('emergency_contact_name') is-invalid @enderror" name="emergency_contact_name" value="{{ old('emergency_contact_name', $user->emergency_contact_name) }}">
									@error('emergency_contact_name')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Emergency Contact Phone</label>
									<input type="text" class="form-control rounded-3 border-light shadow-none @error('emergency_contact_phone') is-invalid @enderror" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $user->emergency_contact_phone) }}">
									@error('emergency_contact_phone')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-12 d-flex justify-content-end mt-4">
								<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Save Changes</button>
							</div>
					</form>
				</div>
			</div>

			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Change Password</h5>
				</div>
				<div class="card-body p-4">
					<form action="{{ route('profile.password.update') }}" method="POST">
						@csrf
						@method('PUT')
						<div class="row">
							<div class="col-md-12">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Current Password <span class="text-danger">*</span></label>
									<div class="pass-group position-relative">
										<input type="password" class="pass-input form-control rounded-3 border-light shadow-none @error('current_password') is-invalid @enderror" name="current_password" required>
										<span class="ti toggle-password ti-eye-off position-absolute end-0 top-50 translate-middle-y me-3 cursor-pointer"></span>
									</div>
									@error('current_password')
										<div class="invalid-feedback d-block">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">New Password <span class="text-danger">*</span></label>
									<div class="pass-group position-relative">
										<input type="password" class="pass-input form-control rounded-3 border-light shadow-none @error('password') is-invalid @enderror" name="password" required>
										<span class="ti toggle-password ti-eye-off position-absolute end-0 top-50 translate-middle-y me-3 cursor-pointer"></span>
									</div>
									@error('password')
										<div class="invalid-feedback d-block">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Confirm Password <span class="text-danger">*</span></label>
									<div class="pass-group position-relative">
										<input type="password" class="pass-input form-control rounded-3 border-light shadow-none" name="password_confirmation" required>
										<span class="ti toggle-password ti-eye-off position-absolute end-0 top-50 translate-middle-y me-3 cursor-pointer"></span>
									</div>
								</div>
							</div>
						</div>
						<div class="d-flex justify-content-end gap-2 mt-4">
							<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Change Password</button>
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

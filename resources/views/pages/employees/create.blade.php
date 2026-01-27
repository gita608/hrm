@extends('layouts.app')

@section('title', 'Create Employee')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Create Employee</h2>
			<p class="text-muted mb-0 fs-13">Add a new employee to the system</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('employees.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
			<h5 class="mb-0 fw-bold text-dark">Employee Information</h5>
		</div>
		<div class="card-body p-4">
			<form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="row">
					<div class="col-md-12">
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Profile Picture</label>
							<div class="d-flex align-items-center flex-wrap row-gap-3 bg-light-50 border border-light w-100 rounded-4 p-4">
								<div class="d-flex align-items-center justify-content-center avatar avatar-xxl rounded-circle border border-2 border-white shadow-sm me-3 flex-shrink-0 text-dark bg-white overflow-hidden" id="profile-preview-container" style="width: 100px; height: 100px;">
									<i class="ti ti-photo text-muted fs-30" id="profile-preview-icon"></i>
									<img id="profile-preview" src="" alt="Profile Preview" class="img-fluid rounded-circle d-none" style="width: 100%; height: 100%; object-fit: cover;">
								</div>
								<div class="profile-upload">
									<div class="mb-2">
										<h6 class="mb-1 fw-bold text-dark">Upload Profile Image</h6>
										<p class="fs-12 text-muted mb-0">Image should be below 4 MB (JPG, PNG, GIF)</p>
									</div>
									<div class="profile-uploader d-flex align-items-center gap-2">
										<label for="profile_picture" class="btn btn-sm btn-primary rounded-pill px-3 mb-0" style="cursor: pointer;">
											<i class="ti ti-upload me-1"></i> Upload
											<input type="file" id="profile_picture" name="profile_picture" class="d-none" accept="image/*" onchange="previewProfilePicture(this)">
										</label>
										<button type="button" class="btn btn-light btn-sm rounded-pill px-3 border" onclick="clearProfilePicture()">Remove</button>
									</div>
									@error('profile_picture')
										<div class="text-danger fs-12 mt-1 d-block">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Full Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="name" value="{{ old('name') }}" placeholder="Enter full name" required>
							@error('name')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Email <span class="text-danger">*</span></label>
							<input type="email" class="form-control rounded-3 border-light shadow-none" name="email" value="{{ old('email') }}" placeholder="Enter email address" required>
							@error('email')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Password <span class="text-danger">*</span></label>
							<div class="pass-group position-relative">
								<input type="password" class="pass-input form-control rounded-3 border-light shadow-none" name="password" placeholder="Enter password" required>
								<span class="ti toggle-password ti-eye-off position-absolute end-0 top-50 translate-middle-y me-3 cursor-pointer text-muted"></span>
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
								<input type="password" class="pass-input form-control rounded-3 border-light shadow-none" name="password_confirmation" placeholder="Confirm password" required>
								<span class="ti toggle-password ti-eye-off position-absolute end-0 top-50 translate-middle-y me-3 cursor-pointer text-muted"></span>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Role <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none" name="role_id" required>
								<option value="">Select Role</option>
								@foreach($roles as $role)
									<option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
								@endforeach
							</select>
							@error('role_id')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Phone</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="phone" value="{{ old('phone') }}" placeholder="Enter phone number">
							@error('phone')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Address</label>
							<textarea class="form-control rounded-3 border-light shadow-none" name="address" rows="3" placeholder="Enter address">{{ old('address') }}</textarea>
							@error('address')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>

				<!-- UAE-Specific Information Section -->
				<div class="mt-4 mb-3">
					<h5 class="fw-bold text-dark border-bottom border-light pb-2 mb-4">UAE-Specific Information</h5>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Emirates ID</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="emirates_id" value="{{ old('emirates_id') }}" placeholder="e.g., 784-1234-1234567-1">
							@error('emirates_id')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Nationality</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="nationality" value="{{ old('nationality') }}" placeholder="Enter nationality">
							@error('nationality')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Passport Number</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="passport_number" value="{{ old('passport_number') }}" placeholder="Enter passport number">
							@error('passport_number')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Passport Expiry Date</label>
							<input type="date" class="form-control rounded-3 border-light shadow-none" name="passport_expiry_date" value="{{ old('passport_expiry_date') }}">
							@error('passport_expiry_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Visa Type</label>
							<select class="form-select rounded-3 border-light shadow-none" name="visa_type">
								<option value="">Select Visa Type</option>
								<option value="employment" {{ old('visa_type') == 'employment' ? 'selected' : '' }}>Employment</option>
								<option value="dependent" {{ old('visa_type') == 'dependent' ? 'selected' : '' }}>Dependent</option>
								<option value="investor" {{ old('visa_type') == 'investor' ? 'selected' : '' }}>Investor</option>
								<option value="student" {{ old('visa_type') == 'student' ? 'selected' : '' }}>Student</option>
								<option value="tourist" {{ old('visa_type') == 'tourist' ? 'selected' : '' }}>Tourist</option>
								<option value="other" {{ old('visa_type') == 'other' ? 'selected' : '' }}>Other</option>
							</select>
							@error('visa_type')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Visa Number</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="visa_number" value="{{ old('visa_number') }}" placeholder="Enter visa number">
							@error('visa_number')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Visa Expiry Date</label>
							<input type="date" class="form-control rounded-3 border-light shadow-none" name="visa_expiry_date" value="{{ old('visa_expiry_date') }}">
							@error('visa_expiry_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Labor Card Number</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="labor_card_number" value="{{ old('labor_card_number') }}" placeholder="Enter labor card number">
							@error('labor_card_number')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Labor Card Expiry Date</label>
							<input type="date" class="form-control rounded-3 border-light shadow-none" name="labor_card_expiry_date" value="{{ old('labor_card_expiry_date') }}">
							@error('labor_card_expiry_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">UAE Emirate</label>
							<select class="form-select rounded-3 border-light shadow-none" name="uae_emirate">
								<option value="">Select Emirate</option>
								<option value="Abu Dhabi" {{ old('uae_emirate') == 'Abu Dhabi' ? 'selected' : '' }}>Abu Dhabi</option>
								<option value="Dubai" {{ old('uae_emirate') == 'Dubai' ? 'selected' : '' }}>Dubai</option>
								<option value="Sharjah" {{ old('uae_emirate') == 'Sharjah' ? 'selected' : '' }}>Sharjah</option>
								<option value="Ajman" {{ old('uae_emirate') == 'Ajman' ? 'selected' : '' }}>Ajman</option>
								<option value="Umm Al Quwain" {{ old('uae_emirate') == 'Umm Al Quwain' ? 'selected' : '' }}>Umm Al Quwain</option>
								<option value="Ras Al Khaimah" {{ old('uae_emirate') == 'Ras Al Khaimah' ? 'selected' : '' }}>Ras Al Khaimah</option>
								<option value="Fujairah" {{ old('uae_emirate') == 'Fujairah' ? 'selected' : '' }}>Fujairah</option>
							</select>
							@error('uae_emirate')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">UAE City</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="uae_city" value="{{ old('uae_city') }}" placeholder="Enter city">
							@error('uae_city')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">UAE Area</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="uae_area" value="{{ old('uae_area') }}" placeholder="Enter area">
							@error('uae_area')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Bank Name</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="bank_name" value="{{ old('bank_name') }}" placeholder="e.g., Emirates NBD, ADCB">
							@error('bank_name')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">IBAN</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="iban" value="{{ old('iban') }}" placeholder="AE123456789012345678901">
							@error('iban')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Emergency Contact Name</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}" placeholder="Enter emergency contact name">
							@error('emergency_contact_name')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Emergency Contact Phone</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none" name="emergency_contact_phone" value="{{ old('emergency_contact_phone') }}" placeholder="Enter emergency contact phone">
							@error('emergency_contact_phone')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>

				<div class="d-flex justify-content-end gap-2 mt-4">
					<a href="{{ route('employees.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
					<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Create Employee</button>
				</div>
			</form>
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
			document.getElementById('profile-preview').src = '';
			document.getElementById('profile-preview').classList.add('d-none');
			document.getElementById('profile-preview-icon').classList.remove('d-none');
		}
	</script>

@endsection

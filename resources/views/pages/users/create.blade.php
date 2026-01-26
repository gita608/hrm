@extends('layouts.app')

@section('title', 'Create User')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Create User</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('users.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="card">
		<div class="card-header">
			<h5>User Information</h5>
		</div>
		<div class="card-body">
			<form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="row">
					<div class="col-md-12">
						<div class="mb-4">
							<label class="form-label">Profile Picture</label>
							<div class="d-flex align-items-center flex-wrap row-gap-3 bg-light w-100 rounded p-3">
								<div class="d-flex align-items-center justify-content-center avatar avatar-xxl rounded-circle border border-dashed me-2 flex-shrink-0 text-dark frames" id="profile-preview-container">
									<i class="ti ti-photo text-gray-2 fs-16" id="profile-preview-icon"></i>
									<img id="profile-preview" src="" alt="Profile Preview" class="img-fluid rounded-circle d-none" style="width: 100%; height: 100%; object-fit: cover;">
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
							<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
							@error('name')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Email <span class="text-danger">*</span></label>
							<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
							@error('email')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Password <span class="text-danger">*</span></label>
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
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Role <span class="text-danger">*</span></label>
							<select class="form-select @error('role_id') is-invalid @enderror" name="role_id" required>
								<option value="">Select Role</option>
								@foreach($roles as $role)
									<option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
								@endforeach
							</select>
							@error('role_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Phone</label>
							<input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}">
							@error('phone')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Address</label>
							<textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="3">{{ old('address') }}</textarea>
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
							<input type="text" class="form-control @error('emirates_id') is-invalid @enderror" name="emirates_id" value="{{ old('emirates_id') }}" placeholder="e.g., 784-1234-1234567-1">
							@error('emirates_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Nationality</label>
							<input type="text" class="form-control @error('nationality') is-invalid @enderror" name="nationality" value="{{ old('nationality') }}">
							@error('nationality')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Passport Number</label>
							<input type="text" class="form-control @error('passport_number') is-invalid @enderror" name="passport_number" value="{{ old('passport_number') }}">
							@error('passport_number')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Passport Expiry Date</label>
							<input type="date" class="form-control @error('passport_expiry_date') is-invalid @enderror" name="passport_expiry_date" value="{{ old('passport_expiry_date') }}">
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
								<option value="employment" {{ old('visa_type') == 'employment' ? 'selected' : '' }}>Employment</option>
								<option value="dependent" {{ old('visa_type') == 'dependent' ? 'selected' : '' }}>Dependent</option>
								<option value="investor" {{ old('visa_type') == 'investor' ? 'selected' : '' }}>Investor</option>
								<option value="student" {{ old('visa_type') == 'student' ? 'selected' : '' }}>Student</option>
								<option value="tourist" {{ old('visa_type') == 'tourist' ? 'selected' : '' }}>Tourist</option>
								<option value="other" {{ old('visa_type') == 'other' ? 'selected' : '' }}>Other</option>
							</select>
							@error('visa_type')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Visa Number</label>
							<input type="text" class="form-control @error('visa_number') is-invalid @enderror" name="visa_number" value="{{ old('visa_number') }}">
							@error('visa_number')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Visa Expiry Date</label>
							<input type="date" class="form-control @error('visa_expiry_date') is-invalid @enderror" name="visa_expiry_date" value="{{ old('visa_expiry_date') }}">
							@error('visa_expiry_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Labor Card Number</label>
							<input type="text" class="form-control @error('labor_card_number') is-invalid @enderror" name="labor_card_number" value="{{ old('labor_card_number') }}">
							@error('labor_card_number')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Labor Card Expiry Date</label>
							<input type="date" class="form-control @error('labor_card_expiry_date') is-invalid @enderror" name="labor_card_expiry_date" value="{{ old('labor_card_expiry_date') }}">
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
								<option value="Abu Dhabi" {{ old('uae_emirate') == 'Abu Dhabi' ? 'selected' : '' }}>Abu Dhabi</option>
								<option value="Dubai" {{ old('uae_emirate') == 'Dubai' ? 'selected' : '' }}>Dubai</option>
								<option value="Sharjah" {{ old('uae_emirate') == 'Sharjah' ? 'selected' : '' }}>Sharjah</option>
								<option value="Ajman" {{ old('uae_emirate') == 'Ajman' ? 'selected' : '' }}>Ajman</option>
								<option value="Umm Al Quwain" {{ old('uae_emirate') == 'Umm Al Quwain' ? 'selected' : '' }}>Umm Al Quwain</option>
								<option value="Ras Al Khaimah" {{ old('uae_emirate') == 'Ras Al Khaimah' ? 'selected' : '' }}>Ras Al Khaimah</option>
								<option value="Fujairah" {{ old('uae_emirate') == 'Fujairah' ? 'selected' : '' }}>Fujairah</option>
							</select>
							@error('uae_emirate')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">UAE City</label>
							<input type="text" class="form-control @error('uae_city') is-invalid @enderror" name="uae_city" value="{{ old('uae_city') }}">
							@error('uae_city')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">UAE Area</label>
							<input type="text" class="form-control @error('uae_area') is-invalid @enderror" name="uae_area" value="{{ old('uae_area') }}">
							@error('uae_area')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Bank Name</label>
							<input type="text" class="form-control @error('bank_name') is-invalid @enderror" name="bank_name" value="{{ old('bank_name') }}" placeholder="e.g., Emirates NBD, ADCB">
							@error('bank_name')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">IBAN</label>
							<input type="text" class="form-control @error('iban') is-invalid @enderror" name="iban" value="{{ old('iban') }}" placeholder="AE123456789012345678901">
							@error('iban')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Emergency Contact Name</label>
							<input type="text" class="form-control @error('emergency_contact_name') is-invalid @enderror" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}">
							@error('emergency_contact_name')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Emergency Contact Phone</label>
							<input type="text" class="form-control @error('emergency_contact_phone') is-invalid @enderror" name="emergency_contact_phone" value="{{ old('emergency_contact_phone') }}">
							@error('emergency_contact_phone')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>

				<div class="card-footer d-flex justify-content-end gap-2">
					<a href="{{ route('users.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Create User</button>
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

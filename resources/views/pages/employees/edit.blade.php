@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Edit Employee</h2>
			<p class="text-muted mb-0 fs-13">Update employee information</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('employees.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
		<div class="card-header bg-primary text-white py-3">
			<h5 class="mb-0 fw-bold">Step 1: Identity & Credentials</h5>
		</div>
		<div class="card-body p-4">
			<form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<div class="row g-4">
					<div class="col-md-12">
						<div class="mb-2">
							<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1 mb-3">Profile Authentication Image</label>
							<div class="d-flex align-items-center bg-light rounded-4 p-4 border border-dashed border-primary-subtle">
								<div class="position-relative me-4">
									<div class="avatar avatar-xxxl bg-white rounded-circle border border-4 border-white shadow-sm d-flex align-items-center justify-content-center overflow-hidden" style="width: 120px; height: 120px;">
										@if($employee->profile_picture)
											<img id="profile-preview" src="{{ asset('storage/' . $employee->profile_picture) }}" alt="Preview" class="img-fluid w-100 h-100 object-fit-cover">
											<i class="ti ti-user-circle text-muted fs-60 d-none" id="profile-preview-icon"></i>
										@else
											<i class="ti ti-user-circle text-muted fs-60" id="profile-preview-icon"></i>
											<img id="profile-preview" src="" alt="Preview" class="img-fluid d-none w-100 h-100 object-fit-cover">
										@endif
									</div>
									<label for="profile_picture" class="btn btn-primary btn-icon btn-sm rounded-circle position-absolute bottom-0 end-0 border-4 border-white shadow-sm" style="cursor: pointer;">
										<i class="ti ti-camera fs-16"></i>
										<input type="file" id="profile_picture" name="profile_picture" class="d-none" accept="image/*" onchange="previewProfilePicture(this)">
									</label>
								</div>
								<div>
									<h6 class="mb-1 fw-bold text-dark">Staff Identity Picture</h6>
									<p class="fs-12 text-muted mb-3">Recommended size: 500x500px. Max 4MB.</p>
									<button type="button" class="btn btn-sm btn-outline-danger border-0 fw-bold px-0 shadow-none" onclick="clearProfilePicture()">
										<i class="ti ti-trash me-1"></i>Remove Image
									</button>
								</div>
							</div>
							@error('profile_picture')
								<div class="invalid-feedback d-block mt-2">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-1">
							<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1">Full Legal Name <span class="text-danger">*</span></label>
							<div class="input-group">
								<span class="input-group-text bg-light border-light-subtle rounded-start-3"><i class="ti ti-user text-muted"></i></span>
								<input type="text" class="form-control rounded-end-3 border-light shadow-none py-2 @error('name') is-invalid @enderror" name="name" value="{{ old('name', $employee->name) }}" placeholder="Enter full name" required>
							</div>
							@error('name')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-1">
							<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1">Professional Email <span class="text-danger">*</span></label>
							<div class="input-group">
								<span class="input-group-text bg-light border-light-subtle rounded-start-3"><i class="ti ti-mail text-muted"></i></span>
								<input type="email" class="form-control rounded-end-3 border-light shadow-none py-2 @error('email') is-invalid @enderror" name="email" value="{{ old('email', $employee->email) }}" placeholder="email@company.com" required>
							</div>
							@error('email')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-1">
							<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1">Update Password</label>
							<div class="input-group">
								<span class="input-group-text bg-light border-light-subtle rounded-start-3"><i class="ti ti-lock text-muted"></i></span>
								<input type="password" class="form-control border-light shadow-none py-2 @error('password') is-invalid @enderror" name="password" placeholder="Leave blank to keep current">
								<span class="input-group-text bg-light border-light-subtle rounded-end-3 cursor-pointer toggle-password"><i class="ti ti-eye-off text-muted"></i></span>
							</div>
							@error('password')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-1">
							<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1">Confirm New Password</label>
							<div class="input-group">
								<span class="input-group-text bg-light border-light-subtle rounded-start-3"><i class="ti ti-lock-check text-muted"></i></span>
								<input type="password" class="form-control border-light shadow-none py-2" name="password_confirmation" placeholder="Repeat new password">
								<span class="input-group-text bg-light border-light-subtle rounded-end-3 cursor-pointer toggle-password"><i class="ti ti-eye-off text-muted"></i></span>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-1">
							<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1">System Role / Permission <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none py-2 @error('role_id') is-invalid @enderror" name="role_id" required>
								<option value="">Choose access level</option>
								@foreach($roles as $role)
									<option value="{{ $role->id }}" {{ old('role_id', $employee->role_id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
								@endforeach
							</select>
							@error('role_id')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-1">
							<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1">Primary Contact No.</label>
							<div class="input-group">
								<span class="input-group-text bg-light border-light-subtle rounded-start-3"><i class="ti ti-phone text-muted"></i></span>
								<input type="text" class="form-control rounded-end-3 border-light shadow-none py-2 @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $employee->phone) }}" placeholder="+971 -- --- ----">
							</div>
							@error('phone')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-0">
							<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1">Residential Address</label>
							<textarea class="form-control rounded-4 border-light shadow-none @error('address') is-invalid @enderror" name="address" rows="3" placeholder="Enter full permanent address details...">{{ old('address', $employee->address) }}</textarea>
							@error('address')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
			<div class="card-header bg-dark text-white py-3">
				<h5 class="mb-0 fw-bold">Step 2: UAE Residence & Statutory Data</h5>
			</div>
			<div class="card-body p-4 bg-light-50">
				<div class="row g-4">
					<div class="col-md-6">
						<div class="mb-1">
							<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1">Emirates ID (EID)</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none py-2 @error('emirates_id') is-invalid @enderror" name="emirates_id" value="{{ old('emirates_id', $employee->emirates_id) }}" placeholder="784-1234-1234567-1">
							@error('emirates_id')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-1">
							<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1">Nationality</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none py-2 @error('nationality') is-invalid @enderror" name="nationality" value="{{ old('nationality', $employee->nationality) }}" placeholder="Country of passport">
							@error('nationality')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-4">
						<div class="mb-1">
							<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1">Passport No.</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none py-2 @error('passport_number') is-invalid @enderror" name="passport_number" value="{{ old('passport_number', $employee->passport_number) }}">
						</div>
					</div>
					<div class="col-md-4">
						<div class="mb-1">
							<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1">Passport Expiry</label>
							<input type="date" class="form-control rounded-3 border-light shadow-none py-2" name="passport_expiry_date" value="{{ old('passport_expiry_date', $employee->passport_expiry_date?->format('Y-m-d')) }}">
						</div>
					</div>
					<div class="col-md-4">
						<div class="mb-1">
							<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1">Visa Type</label>
							<select class="form-select rounded-3 border-light shadow-none py-2" name="visa_type">
								<option value="">Select Type</option>
								<option value="employment" {{ old('visa_type', $employee->visa_type) == 'employment' ? 'selected' : '' }}>Employment</option>
								<option value="dependent" {{ old('visa_type', $employee->visa_type) == 'dependent' ? 'selected' : '' }}>Dependent</option>
								<option value="investor" {{ old('visa_type', $employee->visa_type) == 'investor' ? 'selected' : '' }}>Investor</option>
								<option value="golden" {{ old('visa_type', $employee->visa_type) == 'golden' ? 'selected' : '' }}>Golden Visa</option>
								<option value="other" {{ old('visa_type', $employee->visa_type) == 'other' ? 'selected' : '' }}>Other</option>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="mb-1">
							<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1">Visa Number</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none py-2" name="visa_number" value="{{ old('visa_number', $employee->visa_number) }}">
						</div>
					</div>
					<div class="col-md-4">
						<div class="mb-1">
							<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1">Visa Expiry</label>
							<input type="date" class="form-control rounded-3 border-light shadow-none py-2" name="visa_expiry_date" value="{{ old('visa_expiry_date', $employee->visa_expiry_date?->format('Y-m-d')) }}">
						</div>
					</div>
					<div class="col-md-4">
						<div class="mb-1">
							<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1">Emirate of Residence</label>
							<select class="form-select rounded-3 border-light shadow-none py-2" name="uae_emirate">
								<option value="">Select Emirate</option>
								<option value="Dubai" {{ old('uae_emirate', $employee->uae_emirate) == 'Dubai' ? 'selected' : '' }}>Dubai</option>
								<option value="Abu Dhabi" {{ old('uae_emirate', $employee->uae_emirate) == 'Abu Dhabi' ? 'selected' : '' }}>Abu Dhabi</option>
								<option value="Sharjah" {{ old('uae_emirate', $employee->uae_emirate) == 'Sharjah' ? 'selected' : '' }}>Sharjah</option>
								<option value="Ajman" {{ old('uae_emirate', $employee->uae_emirate) == 'Ajman' ? 'selected' : '' }}>Ajman</option>
								<option value="Ras Al Khaimah" {{ old('uae_emirate', $employee->uae_emirate) == 'Ras Al Khaimah' ? 'selected' : '' }}>Ras Al Khaimah</option>
								<option value="Fujairah" {{ old('uae_emirate', $employee->uae_emirate) == 'Fujairah' ? 'selected' : '' }}>Fujairah</option>
								<option value="Umm Al Quwain" {{ old('uae_emirate', $employee->uae_emirate) == 'Umm Al Quwain' ? 'selected' : '' }}>Umm Al Quwain</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
			<div class="card-header bg-dark text-white py-3">
				<h5 class="mb-0 fw-bold">Step 3: Financial & Emergency Contacts</h5>
			</div>
			<div class="card-body p-4">
				<div class="row g-4">
					<div class="col-md-6">
						<div class="p-3 rounded-4 bg-light border border-light-subtle h-100">
							<h6 class="mb-3 fw-bold text-dark fs-14"><i class="ti ti-building-bank me-2 text-primary"></i>Banking Details</h6>
							<div class="mb-3">
								<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1">Bank Name</label>
								<input type="text" class="form-control rounded-3 border-light shadow-none py-2" name="bank_name" value="{{ old('bank_name', $employee->bank_name) }}" placeholder="e.g. Emirates NBD">
							</div>
							<div class="mb-0">
								<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1">IBAN Number</label>
								<input type="text" class="form-control rounded-3 border-light shadow-none py-2" name="iban" value="{{ old('iban', $employee->iban) }}" placeholder="AE-- ---- ---- ---- ----">
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="p-3 rounded-4 bg-light border border-light-subtle h-100">
							<h6 class="mb-3 fw-bold text-dark fs-14"><i class="ti ti-urgent me-2 text-danger"></i>Emergency Contact</h6>
							<div class="mb-3">
								<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1">Contact Name</label>
								<input type="text" class="form-control rounded-3 border-light shadow-none py-2" name="emergency_contact_name" value="{{ old('emergency_contact_name', $employee->emergency_contact_name) }}">
							</div>
							<div class="mb-0">
								<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1">Emergency Phone</label>
								<input type="text" class="form-control rounded-3 border-light shadow-none py-2" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $employee->emergency_contact_phone) }}">
							</div>
						</div>
					</div>
				</div>
				<hr class="my-5 opacity-10">
				<div class="d-flex justify-content-end gap-3">
					<a href="{{ route('employees.index') }}" class="btn btn-light rounded-pill px-5 py-2 fw-bold text-muted border">Discard Changes</a>
					<button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-lg"><i class="ti ti-device-floppy me-1"></i>Securely Update Employee Record</button>
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
			@if($employee->profile_picture)
				document.getElementById('profile-preview').src = '{{ asset('storage/' . $employee->profile_picture) }}';
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

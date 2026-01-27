@extends('layouts.app')

@section('title', 'Registration Center')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Personnel Registration</h2>
			<p class="text-muted mb-0 fs-13">Initialize a new identity within the system directory</p>
		</div>
		<div class="d-flex align-items-center gap-2 flex-wrap mt-md-0 mt-3">
			<a href="{{ route('users.index') }}" class="btn btn-light rounded-pill px-4 shadow-sm border border-light-subtle fw-600 fs-13">
                <i class="ti ti-arrow-left me-2"></i>Back to Directory
            </a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="row justify-content-center">
		<div class="col-xl-10">
			<form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
				@csrf
				
                <!-- Basic Identity Card -->
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-white py-3 border-bottom border-light d-flex align-items-center">
                        <div class="bg-primary-transparent rounded-3 p-2 me-3">
                            <i class="ti ti-user-plus fs-18 text-primary"></i>
                        </div>
                        <h5 class="mb-0 fw-bold text-dark">Basic Identity Information</h5>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="row g-4">
                            <!-- Profile Picture Preview -->
                            <div class="col-12 mb-3">
                                <label class="form-label text-dark fw-bold fs-13 mb-3">Personnel Portrait</label>
                                <div class="d-flex align-items-center gap-4 p-4 rounded-4 border border-dashed border-light-subtle bg-light-50">
                                    <div class="position-relative">
                                        <div class="avatar-preview-container shadow-sm rounded-circle border border-4 border-white overflow-hidden bg-white d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                            <i class="ti ti-photo-circle fs-32 text-muted opacity-50" id="profile-preview-icon"></i>
                                            <img id="profile-preview" src="" alt="Profile Preview" class="img-fluid rounded-circle d-none w-100 h-100 object-fit-cover">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-bold fs-14 text-dark">Upload Representative Image</h6>
                                        <p class="text-muted fs-11 mb-3">Recommended: Square format, max 4MB (JPG, PNG)</p>
                                        <div class="d-flex gap-2">
                                            <label for="profile_picture" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold">
                                                <i class="ti ti-upload me-1"></i>Choose File
                                                <input type="file" id="profile_picture" name="profile_picture" class="d-none" accept="image/*" onchange="previewProfilePicture(this)">
                                            </label>
                                            <button type="button" class="btn btn-outline-light btn-sm rounded-pill px-3 border" onclick="clearProfilePicture()">
                                                <i class="ti ti-trash me-1"></i>Reset
                                            </button>
                                        </div>
                                        @error('profile_picture')
                                            <div class="text-danger fs-11 mt-2 fw-medium"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group sp-form-group">
                                    <label class="form-label text-muted fs-12 fw-bold text-uppercase">Full Professional Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-3 py-2 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="e.g. Alexander Pierce" required>
                                    @error('name')
                                        <div class="invalid-feedback fs-11">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group sp-form-group">
                                    <label class="form-label text-muted fs-12 fw-bold text-uppercase">Primary Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control rounded-3 py-2 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="email@company.com" required>
                                    @error('email')
                                        <div class="invalid-feedback fs-11">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group sp-form-group">
                                    <label class="form-label text-muted fs-12 fw-bold text-uppercase">Initial Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control rounded-start-3 py-2 border-end-0 @error('password') is-invalid @enderror" name="password" required>
                                        <span class="input-group-text bg-white border-start-0 rounded-end-3" style="cursor: pointer;">
                                            <i class="ti ti-eye-off text-muted"></i>
                                        </span>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block fs-11">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group sp-form-group">
                                    <label class="form-label text-muted fs-12 fw-bold text-uppercase">Designation Role <span class="text-danger">*</span></label>
                                    <select class="form-select rounded-3 py-2 @error('role_id') is-invalid @enderror" name="role_id" required>
                                        <option value="">Select Company Role</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <div class="invalid-feedback fs-11">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group sp-form-group">
                                    <label class="form-label text-muted fs-12 fw-bold text-uppercase">Personal Contact</label>
                                    <input type="text" class="form-control rounded-3 py-2 @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="+971 12 345 6789">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group sp-form-group">
                                    <label class="form-label text-muted fs-12 fw-bold text-uppercase">Postal Address</label>
                                    <textarea class="form-control rounded-3 @error('address') is-invalid @enderror" name="address" rows="3" placeholder="Apartment, Street, Area...">{{ old('address') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- UAE Regional Details -->
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-white py-3 border-bottom border-light d-flex align-items-center">
                        <div class="bg-success-transparent rounded-3 p-2 me-3">
                            <i class="ti ti-map-pin fs-18 text-success"></i>
                        </div>
                        <h5 class="mb-0 fw-bold text-dark">UAE Regional Documentation</h5>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="row g-4">
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group sp-form-group">
                                    <label class="form-label text-muted fs-11 fw-bold text-uppercase">Emirates Identity</label>
                                    <input type="text" class="form-control @error('emirates_id') is-invalid @enderror" name="emirates_id" value="{{ old('emirates_id') }}" placeholder="784-XXXX-XXXXXXX-X">
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="form-group sp-form-group">
                                    <label class="form-label text-muted fs-11 fw-bold text-uppercase">Resident Nationality</label>
                                    <input type="text" class="form-control @error('nationality') is-invalid @enderror" name="nationality" value="{{ old('nationality') }}">
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="form-group sp-form-group">
                                    <label class="form-label text-muted fs-11 fw-bold text-uppercase">Passport Identifier</label>
                                    <input type="text" class="form-control @error('passport_number') is-invalid @enderror" name="passport_number" value="{{ old('passport_number') }}">
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="form-group sp-form-group">
                                    <label class="form-label text-muted fs-11 fw-bold text-uppercase">Visa Classification</label>
                                    <select class="form-select @error('visa_type') is-invalid @enderror" name="visa_type">
                                        <option value="">Select Class</option>
                                        <option value="employment" {{ old('visa_type') == 'employment' ? 'selected' : '' }}>Employment</option>
                                        <option value="dependent" {{ old('visa_type') == 'dependent' ? 'selected' : '' }}>Dependent</option>
                                        <option value="investor" {{ old('visa_type') == 'investor' ? 'selected' : '' }}>Investor</option>
                                        <option value="student" {{ old('visa_type') == 'student' ? 'selected' : '' }}>Student</option>
                                        <option value="tourist" {{ old('visa_type') == 'tourist' ? 'selected' : '' }}>Tourist</option>
                                        <option value="other" {{ old('visa_type') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="form-group sp-form-group">
                                    <label class="form-label text-muted fs-11 fw-bold text-uppercase">Residency Region</label>
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
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="form-group sp-form-group">
                                    <label class="form-label text-muted fs-11 fw-bold text-uppercase">Specific City</label>
                                    <input type="text" class="form-control @error('uae_city') is-invalid @enderror" name="uae_city" value="{{ old('uae_city') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Financial Section -->
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                    <div class="card-header bg-white py-3 border-bottom border-light d-flex align-items-center">
                        <div class="bg-warning-transparent rounded-3 p-2 me-3">
                            <i class="ti ti-building-bank fs-18 text-warning"></i>
                        </div>
                        <h5 class="mb-0 fw-bold text-dark">Financial & Emergency Context</h5>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="row g-4">
                            <div class="col-md-12 col-lg-6">
                                <div class="row g-4">
                                    <div class="col-12">
                                        <div class="form-group sp-form-group">
                                            <label class="form-label text-muted fs-11 fw-bold text-uppercase">Primary Bank Name</label>
                                            <input type="text" class="form-control" name="bank_name" value="{{ old('bank_name') }}" placeholder="e.g. Emirates NBD">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group sp-form-group">
                                            <label class="form-label text-muted fs-11 fw-bold text-uppercase">IBAN Identification</label>
                                            <input type="text" class="form-control" name="iban" value="{{ old('iban') }}" placeholder="AE...">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-6">
                                <div class="row g-4">
                                    <div class="col-12">
                                        <div class="form-group sp-form-group">
                                            <label class="form-label text-muted fs-11 fw-bold text-uppercase">Emergency Contact Name</label>
                                            <input type="text" class="form-control" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group sp-form-group">
                                            <label class="form-label text-muted fs-11 fw-bold text-uppercase">Emergency Protocol Phone</label>
                                            <input type="text" class="form-control" name="emergency_contact_phone" value="{{ old('emergency_contact_phone') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light-50 py-4 px-4 d-flex justify-content-end gap-3 border-0">
                        <a href="{{ route('users.index') }}" class="btn btn-light rounded-pill px-4 py-2 border fw-bold text-muted fs-13">Dismiss Changes</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm fs-13">
                            <i class="ti ti-device-floppy me-2"></i>Finalize Registration
                        </button>
                    </div>
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

        // Toggle password visibility
        document.querySelectorAll('.ti-eye-off').forEach(icon => {
            icon.addEventListener('click', function() {
                const input = this.closest('.input-group').querySelector('input');
                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.replace('ti-eye-off', 'ti-eye');
                } else {
                    input.type = 'password';
                    this.classList.replace('ti-eye', 'ti-eye-off');
                }
            });
        });
	</script>

    <style>
        .fs-11 { font-size: 11px; }
        .fs-12 { font-size: 12px; }
        .fs-13 { font-size: 13.5px; }
        .fw-600 { font-weight: 600; }
        .bg-light-50 { background-color: #f9fafb; }
        .bg-primary-transparent { background-color: rgba(242, 101, 34, 0.08); }
        .bg-success-transparent { background-color: rgba(30, 190, 165, 0.08); }
        .bg-warning-transparent { background-color: rgba(255, 152, 0, 0.08); }
        .bg-light-transparent { background-color: rgba(0, 0, 0, 0.03); }
        
        .sp-form-group .form-control, .sp-form-group .form-select {
            border-color: #e5e7eb;
            transition: all 0.2s ease;
        }
        .sp-form-group .form-control:focus, .sp-form-group .form-select:focus {
            border-color: #f26522;
            box-shadow: 0 0 0 4px rgba(242, 101, 34, 0.1);
            background-color: white;
        }
        .object-fit-cover { object-fit: cover; }
        .border-dashed { border-style: dashed !important; }
        .tracking-wider { letter-spacing: 0.8px; }
    </style>

@endsection

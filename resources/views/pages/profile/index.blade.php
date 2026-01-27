@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

<style>
    .profile-hero {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        margin-bottom: 30px;
        border: 1px solid #f0f0f0;
    }

    .profile-avatar-wrapper {
        position: relative;
        width: 120px;
        height: 120px;
    }

    .profile-avatar-wrapper img, .profile-avatar-wrapper .avatar-initial {
        width: 120px;
        height: 120px;
        border-radius: 30px;
        object-fit: cover;
        border: 5px solid #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .profile-initial {
        width: 120px;
        height: 120px;
        border-radius: 30px;
        border: 5px solid #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        background: linear-gradient(135deg, #f26522 0%, #ff8c52 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 700;
    }

    .nav-tabs-custom {
        border-bottom: 2px solid #f0f0f0;
        gap: 30px;
    }

    .nav-tabs-custom .nav-link {
        border: none;
        padding: 15px 0;
        font-weight: 600;
        color: #6b7280;
        position: relative;
        background: transparent;
    }

    .nav-tabs-custom .nav-link.active {
        color: #f26522;
    }

    .nav-tabs-custom .nav-link.active::after {
        content: "";
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 2px;
        background: #f26522;
        border-radius: 2px;
    }

    .info-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #f0f0f0;
        padding: 30px;
        height: 100%;
    }

    .form-label-custom {
        font-size: 0.85rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-control-custom {
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 12px 16px;
        font-size: 0.95rem;
        transition: all 0.2s;
    }

    .form-control-custom:focus {
        border-color: #f26522;
        box-shadow: 0 0 0 4px rgba(242, 101, 34, 0.1);
        outline: none;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: #f26522;
    }

    .upload-btn-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }

    .btn-upload {
        border: 1px solid #f26522;
        background-color: white;
        color: #f26522;
        padding: 8px 20px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-upload:hover {
        background-color: #f26522;
        color: white;
    }

    .profile-stats-item {
        padding: 15px;
        border-radius: 15px;
        background: #f9fafb;
        text-align: center;
    }

    .profile-stats-label {
        font-size: 0.75rem;
        color: #6b7280;
        text-transform: uppercase;
        font-weight: 700;
        display: block;
        margin-bottom: 5px;
    }

    .profile-stats-value {
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
    }
</style>

<div class="row justify-content-center">
    <div class="col-xl-10">
        <!-- Hero Section -->
        <div class="profile-hero shadow-sm">
            <div class="row align-items-center g-4">
                <div class="col-auto">
                    <div class="profile-avatar-wrapper">
                        @if($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile" id="main-profile-preview">
                        @else
                            <div class="profile-initial" id="main-profile-initial">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col">
                    <h2 class="fw-bold text-dark mb-1">{{ $user->name }}</h2>
                    <p class="text-muted fs-15 mb-3">{{ $user->role->name ?? 'Member' }} • <span class="text-primary fw-medium">{{ $user->email }}</span></p>
                    
                    <div class="d-flex flex-wrap gap-2">
                        <div class="profile-stats-item shadow-sm">
                            <span class="profile-stats-label">Joined</span>
                            <span class="profile-stats-value">{{ $user->created_at->format('M Y') }}</span>
                        </div>
                        <div class="profile-stats-item shadow-sm">
                            <span class="profile-stats-label">Status</span>
                            <span class="profile-stats-value text-success">Active</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-auto">
                    <a href="{{ route('dashboard') }}" class="btn btn-light rounded-pill px-4 shadow-none border">
                        <i class="ti ti-arrow-left me-2"></i>Dashboard
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                <i class="ti ti-circle-check-filled me-2"></i>{{ session('success') }}
            </div>
        @endif

        <!-- Tabbed Interface -->
        <ul class="nav nav-tabs nav-tabs-custom mb-4" id="profileTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab">Personal Details</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="uae-tab" data-bs-toggle="tab" data-bs-target="#uae" type="button" role="tab">UAE Information</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">Account Security</button>
            </li>
        </ul>

        <div class="tab-content" id="profileTabsContent">
            <!-- Personal Details Tab -->
            <div class="tab-pane fade show active" id="details" role="tabpanel">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="info-card shadow-sm mb-4">
                        <div class="section-title">
                            <i class="ti ti-user-circle"></i>
                            General Information
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label-custom">Profile Picture</label>
                                <div class="d-flex align-items-center gap-4 p-3 bg-light rounded-4">
                                    <div class="avatar avatar-lg rounded-circle overflow-hidden bg-white shadow-sm border border-2 border-white" style="width: 60px; height: 60px;">
                                        @if($user->profile_picture)
                                            <img id="form-profile-preview" src="{{ asset('storage/' . $user->profile_picture) }}" alt="Preview" class="w-100 h-100 object-fit-cover">
                                        @else
                                            <div id="form-profile-placeholder" class="d-flex align-items-center justify-content-center w-100 h-100 text-muted bg-soft-primary">
                                                <i class="ti ti-user fs-24"></i>
                                            </div>
                                            <img id="form-profile-preview" src="" alt="Preview" class="w-100 h-100 object-fit-cover d-none">
                                        @endif
                                    </div>
                                    <div class="d-flex gap-2">
                                        <label for="profile_picture" class="btn btn-upload mb-0">
                                            Change Photo
                                            <input type="file" id="profile_picture" name="profile_picture" class="d-none" accept="image/*" onchange="previewProfileImage(this)">
                                        </label>
                                        <button type="button" class="btn btn-light rounded-pill px-3 border fs-13" onclick="clearImage()">Clear</button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label-custom">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-custom @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label-custom">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control form-control-custom @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Phone Number</label>
                                <input type="text" name="phone" class="form-control form-control-custom" value="{{ old('phone', $user->phone) }}" placeholder="+1 234 567 890">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Designation / Role</label>
                                <input type="text" class="form-control form-control-custom bg-soft-light" value="{{ $user->role->name ?? 'N/A' }}" readonly>
                            </div>

                            <div class="col-12">
                                <label class="form-label-custom">Residential Address</label>
                                <textarea name="address" class="form-control form-control-custom" rows="3" placeholder="Enter your full address">{{ old('address', $user->address) }}</textarea>
                            </div>

                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm">Save Personal Details</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- UAE Information Tab -->
            <div class="tab-pane fade" id="uae" role="tabpanel">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="info-card shadow-sm mb-4">
                        <div class="section-title">
                            <i class="ti ti-map-pin"></i>
                            Regional & Work Documents
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label-custom">Emirates ID</label>
                                <input type="text" name="emirates_id" class="form-control form-control-custom" value="{{ old('emirates_id', $user->emirates_id) }}" placeholder="784-XXXX-XXXXXXX-X">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label-custom">Nationality</label>
                                <input type="text" name="nationality" class="form-control form-control-custom" value="{{ old('nationality', $user->nationality) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Passport Number</label>
                                <input type="text" name="passport_number" class="form-control form-control-custom" value="{{ old('passport_number', $user->passport_number) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Passport Expiry</label>
                                <input type="date" name="passport_expiry_date" class="form-control form-control-custom" value="{{ old('passport_expiry_date', $user->passport_expiry_date?->format('Y-m-d')) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Visa Type</label>
                                <select name="visa_type" class="form-select form-control-custom">
                                    <option value="">Select Visa</option>
                                    @foreach(['employment', 'dependent', 'investor', 'student', 'tourist', 'other'] as $type)
                                        <option value="{{ $type }}" {{ old('visa_type', $user->visa_type) == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Bank Name</label>
                                <input type="text" name="bank_name" class="form-control form-control-custom" value="{{ old('bank_name', $user->bank_name) }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label-custom">IBAN Number</label>
                                <input type="text" name="iban" class="form-control form-control-custom" value="{{ old('iban', $user->iban) }}" placeholder="AE 0000 0000 0000 0000 0000">
                            </div>

                            <div class="col-12 text-end mt-4">
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm">Save Regional Info</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Password Tab -->
            <div class="tab-pane fade" id="password" role="tabpanel">
                <form action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="info-card shadow-sm mb-4">
                        <div class="section-title">
                            <i class="ti ti-lock"></i>
                            Security Settings
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label-custom">Current Password <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <input type="password" name="current_password" class="form-control form-control-custom @error('current_password') is-invalid @enderror" required>
                                    <span class="ti ti-eye-off position-absolute end-0 top-50 translate-middle-y me-3 cursor-pointer text-muted toggle-password"></span>
                                </div>
                                @error('current_password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label-custom">New Password <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <input type="password" name="password" class="form-control form-control-custom @error('password') is-invalid @enderror" required>
                                    <span class="ti ti-eye-off position-absolute end-0 top-50 translate-middle-y me-3 cursor-pointer text-muted toggle-password"></span>
                                </div>
                                @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Confirm New Password <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <input type="password" name="password_confirmation" class="form-control form-control-custom" required>
                                    <span class="ti ti-eye-off position-absolute end-0 top-50 translate-middle-y me-3 cursor-pointer text-muted toggle-password"></span>
                                </div>
                            </div>

                            <div class="col-12 text-end mt-4">
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm">Update Password</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function previewProfileImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Update hero avatar
                const heroImg = document.getElementById('main-profile-preview');
                const heroInitial = document.getElementById('main-profile-initial');
                if (heroImg) {
                    heroImg.src = e.target.result;
                } else if (heroInitial) {
                    heroInitial.style.display = 'none';
                    const newImg = document.createElement('img');
                    newImg.src = e.target.result;
                    newImg.id = 'main-profile-preview';
                    heroInitial.parentNode.appendChild(newImg);
                }

                // Update form preview
                const formImg = document.getElementById('form-profile-preview');
                const formPlaceholder = document.getElementById('form-profile-placeholder');
                formImg.src = e.target.result;
                formImg.classList.remove('d-none');
                if (formPlaceholder) formPlaceholder.classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function clearImage() {
        document.getElementById('profile_picture').value = '';
        // In a real app, you might want to handle resetting to original or default
        location.reload(); 
    }

    document.querySelectorAll('.toggle-password').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.previousElementSibling;
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

@endsection

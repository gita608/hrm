@extends('layouts.app')

@section('title', 'Personnel Profile')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Personnel Profile</h2>
			<p class="text-muted mb-0 fs-13">Detailed view of user identity and professional documentation</p>
		</div>
		<div class="d-flex align-items-center gap-2 flex-wrap mt-md-0 mt-3">
			<a href="{{ route('users.index') }}" class="btn btn-light rounded-pill px-4 shadow-sm border border-light-subtle fw-600 fs-13">
                <i class="ti ti-arrow-left me-2"></i>Back to Directory
            </a>
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary rounded-pill px-4 shadow-sm fw-600 fs-13">
                <i class="ti ti-edit me-2"></i>Modify Records
            </a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="row g-4">
        <!-- Profile Sidecard -->
		<div class="col-xl-3 col-lg-4">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-primary py-5 position-relative">
                    <div class="position-absolute start-0 top-0 w-100 h-100 opacity-10" style="background: url('{{ asset('assets/img/pattern.png') }}');"></div>
                </div>
				<div class="card-body text-center pt-0 position-relative" style="margin-top: -50px;">
					<div class="avatar-container mb-3 d-inline-block">
						@if($user->profile_picture)
							<div class="avatar avatar-xxl border border-4 border-white shadow-sm p-1 rounded-circle bg-white overflow-hidden" style="width: 100px; height: 100px;">
                                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="User" class="img-fluid rounded-circle w-100 h-100 object-fit-cover">
                            </div>
						@else
							<div class="avatar avatar-xxl border border-4 border-white shadow-sm rounded-circle bg-primary-transparent text-primary d-flex align-items-center justify-content-center fw-bold" style="width: 100px; height: 100px; font-size: 2.5rem;">
								{{ strtoupper(substr($user->name, 0, 1)) }}
							</div>
						@endif
					</div>
					<h4 class="fw-bold mb-1 text-dark">{{ $user->name }}</h4>
					<div class="badge bg-soft-info border border-info-subtle rounded-pill px-3 py-1 text-info fs-11 fw-700 mb-3">
                         <i class="ti ti-briefcase-2 me-1"></i>{{ strtoupper($user->role->name ?? 'SYSTEM USER') }}
                    </div>
					
                    <div class="text-start border-top border-light-subtle pt-4 mt-2">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-light-transparent rounded-pill p-2 me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="ti ti-mail text-muted fs-14"></i>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-muted fs-11 mb-0 fw-medium">Primary Email</p>
                                <p class="text-dark fs-12 mb-0 text-truncate fw-600">{{ $user->email }}</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-light-transparent rounded-pill p-2 me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="ti ti-phone text-muted fs-14"></i>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-muted fs-11 mb-0 fw-medium">Contact Number</p>
                                <p class="text-dark fs-12 mb-0 fw-600">{{ $user->phone ?? '--' }}</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="bg-light-transparent rounded-pill p-2 me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="ti ti-shield-check text-muted fs-14"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted fs-11 mb-0 fw-medium">Account Status</p>
                                @if($user->email_verified_at)
                                    <span class="text-success fs-12 fw-bold"><i class="ti ti-point-filled me-1"></i>Verified</span>
                                @else
                                    <span class="text-warning fs-12 fw-bold"><i class="ti ti-point-filled me-1"></i>Unverified</span>
                                @endif
                            </div>
                        </div>
                    </div>
				</div>
                <div class="card-footer bg-light-50 border-0 p-3">
                    @if($user->id !== auth()->id())
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('CRITICAL: Permanently delete this records? This action is irreversible.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100 btn-sm rounded-pill fw-bold border-0 hover-danger-bg">
                                <i class="ti ti-trash-x me-2"></i>Purge Personnel Record
                            </button>
                        </form>
                    @endif
                </div>
			</div>
		</div>

        <!-- Details Content -->
		<div class="col-xl-9 col-lg-8">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-white py-4 border-bottom border-light">
					<h5 class="fw-bold mb-0 border-start border-4 border-primary ps-3">Personnel Documentation</h5>
				</div>
				<div class="card-body p-4 p-md-5">
                    <div class="row g-4">
                        <!-- Identity Section -->
                        <div class="col-12 mb-2">
                            <h6 class="text-uppercase tracking-wider fs-11 fw-800 text-muted border-bottom border-light pb-2 mb-4">Professional Identity</h6>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <label class="fs-12 text-muted fw-medium mb-1 d-block text-uppercase">Full Display Name</label>
                            <p class="text-dark fw-bold fs-14 mb-0">{{ $user->name }}</p>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <label class="fs-12 text-muted fw-medium mb-1 d-block text-uppercase">Email Identity</label>
                            <p class="text-dark fw-bold fs-14 mb-0">{{ $user->email }}</p>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <label class="fs-12 text-muted fw-medium mb-1 d-block text-uppercase">Contact Reach</label>
                            <p class="text-dark fw-bold fs-14 mb-0">{{ $user->phone ?? 'Not Registered' }}</p>
                        </div>

                        <!-- Legal Section -->
                        <div class="col-12 mt-5 mb-2">
                            <h6 class="text-uppercase tracking-wider fs-11 fw-800 text-muted border-bottom border-light pb-2 mb-4">Legal & Domicile Information</h6>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <label class="fs-12 text-muted fw-medium mb-1 d-block text-uppercase">Emirates Identity</label>
                            <p class="text-dark fw-bold fs-14 mb-0">{{ $user->emirates_id ?? 'Pending Verification' }}</p>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <label class="fs-12 text-muted fw-medium mb-1 d-block text-uppercase">Nationality</label>
                            <p class="text-dark fw-bold fs-14 mb-0">{{ $user->nationality ?? '--' }}</p>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <label class="fs-12 text-muted fw-medium mb-1 d-block text-uppercase">Passport Summary</label>
                            <p class="text-dark fw-bold fs-14 mb-0">
                                @if($user->passport_number)
                                    {{ $user->passport_number }} <span class="text-muted fw-normal fs-11 ms-1">(Exp: {{ $user->passport_expiry_date ? $user->passport_expiry_date->format('M d, Y') : 'N/A' }})</span>
                                @else
                                    <span class="text-muted italic opacity-50">Requires Upload</span>
                                @endif
                            </p>
                        </div>

                        <div class="col-md-6 col-lg-4 mt-3">
                            <label class="fs-12 text-muted fw-medium mb-1 d-block text-uppercase">Visa Status</label>
                            <p class="text-dark fw-bold fs-14 mb-1">
                                {{ ucfirst($user->visa_type) ?? 'N/A' }} 
                                @if($user->visa_number)
                                    <span class="text-muted fw-normal fs-13 ms-1">({{ $user->visa_number }})</span>
                                @endif
                            </p>
                            @if($user->visa_expiry_date)
                                <p class="text-muted fs-11 mb-0"><i class="ti ti-clock me-1"></i>Expires {{ $user->visa_expiry_date->format('M d, Y') }}</p>
                            @endif
                        </div>

                        <div class="col-md-6 col-lg-8 mt-3">
                            <label class="fs-12 text-muted fw-medium mb-1 d-block text-uppercase">UAE Domicile Location</label>
                            <p class="text-dark fw-bold fs-14 mb-0">
                                @if($user->uae_emirate)
                                    {{ $user->uae_emirate }}{{ $user->uae_city ? ', ' . $user->uae_city : '' }}{{ $user->uae_area ? ', ' . $user->uae_area : '' }}
                                @else
                                    <span class="text-muted italic opacity-50">Physical address not set</span>
                                @endif
                            </p>
                        </div>

                        <!-- Financial Section -->
                        <div class="col-12 mt-5 mb-2">
                            <h6 class="text-uppercase tracking-wider fs-11 fw-800 text-muted border-bottom border-light pb-2 mb-4">Financial & Banking Context</h6>
                        </div>

                        <div class="col-md-6 mt-0">
                            <div class="p-3 bg-light-transparent rounded-4 border border-light-subtle">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="ti ti-building-bank text-primary me-2 fs-18"></i>
                                    <h6 class="mb-0 fw-bold fs-13">Primary Bank Account</h6>
                                </div>
                                <p class="mb-1 fs-12 text-muted">Bank: <span class="text-dark fw-bold ms-1">{{ $user->bank_name ?? 'NOT SET' }}</span></p>
                                <p class="mb-0 fs-12 text-muted">IBAN: <span class="text-dark fw-bold ms-1">{{ $user->iban ?? 'NOT SET' }}</span></p>
                            </div>
                        </div>

                        <div class="col-md-6 mt-0">
                            <div class="p-3 bg-light-transparent rounded-4 border border-light-subtle">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="ti ti-heart-handshake text-danger me-2 fs-18"></i>
                                    <h6 class="mb-0 fw-bold fs-13">Emergency Contact</h6>
                                </div>
                                <p class="mb-1 fs-12 text-muted">Identity: <span class="text-dark fw-bold ms-1">{{ $user->emergency_contact_name ?? 'NOT SET' }}</span></p>
                                <p class="mb-0 fs-12 text-muted">Protocol: <span class="text-dark fw-bold ms-1">{{ $user->emergency_contact_phone ?? 'NOT SET' }}</span></p>
                            </div>
                        </div>

                        <!-- System Audit Section -->
                        <div class="col-12 mt-5 mb-2">
                            <h6 class="text-uppercase tracking-wider fs-11 fw-800 text-muted border-bottom border-light pb-2 mb-4">System Audit Timeline</h6>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary shadow-sm rounded-circle me-3" style="width: 8px; height: 8px;"></div>
                                <div>
                                    <p class="fs-10 text-uppercase fw-bold text-muted mb-0">Record Initialization</p>
                                    <p class="fs-13 fw-medium text-dark mb-0">{{ $user->created_at->format('M d, Y - H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-success shadow-sm rounded-circle me-3" style="width: 8px; height: 8px;"></div>
                                <div>
                                    <p class="fs-10 text-uppercase fw-bold text-muted mb-0">Last Synchronization</p>
                                    <p class="fs-13 fw-medium text-dark mb-0 text-success">{{ $user->updated_at->diffForHumans() }} <span class="text-muted fw-normal fs-11 ms-1">({{ $user->updated_at->format('M d, Y') }})</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="card-footer bg-white py-4 border-top border-light d-flex align-items-center">
                    <i class="ti ti-info-circle text-muted me-2 fs-14"></i>
                    <p class="text-muted mb-0 fs-12">This data is protected under system security protocols. Updates are logged for audit purposes.</p>
                </div>
			</div>
		</div>
	</div>

    <style>
        .fs-10 { font-size: 10px; }
        .fs-11 { font-size: 11px; }
        .fs-13 { font-size: 13.5px; }
        .fw-600 { font-weight: 600; }
        .fw-700 { font-weight: 700; }
        .fw-800 { font-weight: 800; }
        .bg-light-50 { background-color: #f9fafb; }
        .bg-light-transparent { background-color: rgba(0, 0, 0, 0.03); }
        .bg-primary-transparent { background-color: rgba(242, 101, 34, 0.08); }
        .bg-soft-info { background-color: rgba(0, 191, 255, 0.06); }
        .tracking-wider { letter-spacing: 0.8px; }
        .italic { font-style: italic; }
        .object-fit-cover { object-fit: cover; }
        .hover-danger-bg:hover { background-color: #ef4444 !important; color: white !important; }
        @media (max-width: 991px) {
            .card-header.bg-primary { py-4 !important; }
        }
    </style>

@endsection

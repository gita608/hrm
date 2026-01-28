@extends('layouts.app')

@section('title', 'Professional Certifications')

@section('content')

@php
    function getCertificateTheme($type) {
        $themes = [
            'education' => ['icon' => 'ti-school', 'color' => 'primary', 'bg' => 'rgba(13, 110, 253, 0.1)'],
            'training' => ['icon' => 'ti-device-laptop', 'color' => 'success', 'bg' => 'rgba(25, 135, 84, 0.1)'],
            'achievement' => ['icon' => 'ti-trophy', 'color' => 'warning', 'bg' => 'rgba(255, 193, 7, 0.1)'],
            'professional' => ['icon' => 'ti-award', 'color' => 'info', 'bg' => 'rgba(13, 202, 240, 0.1)'],
            'other' => ['icon' => 'ti-file-certificate', 'color' => 'dark', 'bg' => 'rgba(33, 37, 41, 0.1)'],
        ];
        return $themes[$type] ?? $themes['other'];
    }
@endphp

<style>
    .cert-card {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: none;
        background: #fff;
        border-radius: 20px;
        position: relative;
        overflow: hidden;
    }
    .cert-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    .cert-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        transition: all 0.3s ease;
    }
    .cert-card.theme-primary::before { background: #0d6efd; }
    .cert-card.theme-success::before { background: #198754; }
    .cert-card.theme-warning::before { background: #ffc107; }
    .cert-card.theme-info::before { background: #0dcaf0; }
    .cert-card.theme-dark::before { background: #212529; }

    .glass-panel {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 24px;
    }
    .cert-icon-box {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 20px;
    }
    .status-stamp {
        position: absolute;
        top: 20px;
        right: -35px;
        transform: rotate(45deg);
        width: 120px;
        text-align: center;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 4px 0;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .search-input-fancy {
        background: #f8f9fa;
        border: none;
        border-radius: 15px;
        padding: 12px 20px 12px 45px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    .search-input-fancy:focus {
        background: #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .stat-mini-card {
        padding: 20px;
        border-radius: 20px;
        background: #fff;
        border: 1px solid rgba(0,0,0,0.02);
    }
</style>

<div class="row g-4">
    <!-- Sidebar Filters -->
    <div class="col-xl-3">
        <div class="glass-panel p-4 h-100 position-sticky" style="top: 100px;">
            <div class="mb-4">
                <h5 class="fw-bold text-dark mb-1">Credentials</h5>
                <p class="text-muted fs-13">Employee Qualifications</p>
            </div>

            <form action="{{ route('certificates.index') }}" method="GET">
                <div class="mb-3 position-relative">
                    <i class="ti ti-search position-absolute text-muted" style="left: 15px; top: 15px;"></i>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control search-input-fancy shadow-none" placeholder="Search title or number...">
                </div>

                <div class="mb-4">
                    <label class="form-label fs-12 fw-bold text-uppercase text-muted ls-1">Filter by Employee</label>
                    <select name="employee_id" class="form-select rounded-3 border-light shadow-none fs-13" onchange="this.form.submit()">
                        <option value="">Search employee...</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fs-12 fw-bold text-uppercase text-muted ls-1">Status</label>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="status" id="statusAll" value="" {{ !request('status') ? 'checked' : '' }} onchange="this.form.submit()">
                        <label class="form-check-label fs-13 text-dark" for="statusAll">All Records</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input text-success" type="radio" name="status" id="statusActive" value="active" {{ request('status') == 'active' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label class="form-check-label fs-13 text-dark" for="statusActive">Active (Valid)</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input text-warning" type="radio" name="status" id="statusExpired" value="expired" {{ request('status') == 'expired' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label class="form-check-label fs-13 text-dark" for="statusExpired">Expired</label>
                    </div>
                </div>

                @if(request()->hasAny(['q', 'status', 'employee_id']))
                    <a href="{{ route('certificates.index') }}" class="btn btn-light w-100 rounded-pill fs-13 fw-bold">Reset Filters</a>
                @endif
            </form>

            <div class="mt-5 p-4 bg-info rounded-4 text-white text-center position-relative overflow-hidden">
                <i class="ti ti-certificate position-absolute" style="font-size: 80px; opacity: 0.1; right: -20px; bottom: -20px;"></i>
                <h6 class="fw-bold mb-2">Add New Credential</h6>
                <p class="fs-11 opacity-75 mb-3">Upload and track professional certifications and licenses.</p>
                <a href="{{ route('certificates.create') }}" class="btn btn-white btn-sm px-4 rounded-pill fw-bold text-info">Add Certificate</a>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="col-xl-9">
        <!-- Stats Bar -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stat-mini-card shadow-sm d-flex align-items-center">
                    <div class="avatar avatar-lg bg-primary-transparent text-primary rounded-circle me-3">
                        <i class="ti ti-diploma"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">{{ $certificates->count() }}</h4>
                        <p class="text-muted fs-12 mb-0">Total Documents</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-mini-card shadow-sm d-flex align-items-center">
                    <div class="avatar avatar-lg bg-success-transparent text-success rounded-circle me-3">
                        <i class="ti ti-circle-check"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">{{ $certificates->where('status', 'active')->count() }}</h4>
                        <p class="text-muted fs-12 mb-0">Active Credentials</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-mini-card shadow-sm d-flex align-items-center">
                    <div class="avatar avatar-lg bg-warning-transparent text-warning rounded-circle me-3">
                        <i class="ti ti-calendar-x"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">{{ $certificates->where('status', 'expired')->count() }}</h4>
                        <p class="text-muted fs-12 mb-0">Expired Records</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Certificates Grid -->
        <div class="row g-4">
            @forelse($certificates as $certificate)
                @php $theme = getCertificateTheme($certificate->certificate_type); @endphp
                <div class="col-md-6 col-lg-4">
                    <div class="card cert-card shadow-sm h-100 theme-{{ $theme['color'] }}">
                        @if($certificate->status == 'active')
                            <div class="status-stamp bg-success text-white">Active</div>
                        @elseif($certificate->status == 'expired')
                            <div class="status-stamp bg-warning text-dark">Expired</div>
                        @else
                            <div class="status-stamp bg-danger text-white">Revoked</div>
                        @endif

                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="cert-icon-box" style="background: {{ $theme['bg'] }}; color: var(--bs-{{ $theme['color'] }});">
                                    <i class="ti {{ $theme['icon'] }}"></i>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-icon btn-sm btn-light border-0 rounded-circle" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3">
                                        <li><a class="dropdown-item py-2" href="{{ route('certificates.show', $certificate->id) }}"><i class="ti ti-eye me-2"></i>View Details</a></li>
                                        <li><a class="dropdown-item py-2" href="{{ route('certificates.edit', $certificate->id) }}"><i class="ti ti-edit me-2"></i>Edit Certificate</a></li>
                                        @if($certificate->file_path)
                                            <li><a class="dropdown-item py-2" href="{{ asset('storage/' . $certificate->file_path) }}" target="_blank"><i class="ti ti-download me-2"></i>Download File</a></li>
                                        @endif
                                        <li><hr class="dropdown-divider opacity-50"></li>
                                        <li>
                                            <form action="{{ route('certificates.destroy', $certificate->id) }}" method="POST" onsubmit="return confirm('Delete this certificate?');">
                                                @csrf @method('DELETE')
                                                <button class="dropdown-item py-2 text-danger"><i class="ti ti-trash me-2"></i>Delete Forever</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <p class="text-muted fs-11 mb-1 fw-bold text-uppercase ls-1">#{{ $certificate->certificate_number }}</p>
                            <h6 class="fw-bold text-dark mb-3 text-truncate-2" style="min-height: 44px;">{{ $certificate->title }}</h6>
                            <p class="text-muted fs-12 mb-3 text-truncate">{{ $certificate->issuing_authority ?? 'Unknown Authority' }}</p>
                            
                            <div class="d-flex align-items-center p-3 bg-light-50 rounded-4 mb-3">
                                <div class="avatar avatar-md rounded-circle me-3 border border-2 border-white shadow-sm">
                                    <img src="{{ $certificate->employee->profile_picture ? asset('storage/' . $certificate->employee->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($certificate->employee->name) }}" alt="">
                                </div>
                                <div>
                                    <h6 class="fs-13 fw-bold text-dark mb-0 text-truncate" style="max-width: 120px;">{{ $certificate->employee->name }}</h6>
                                    <span class="fs-11 text-muted">{{ ucfirst($certificate->certificate_type) }}</span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-column">
                                    <span class="fs-10 text-muted text-uppercase fw-bold ls-1">Expiry Date</span>
                                    <span class="fs-11 fw-bold {{ $certificate->expiry_date && $certificate->expiry_date->isPast() ? 'text-danger' : 'text-dark' }}">
                                        {{ $certificate->expiry_date ? $certificate->expiry_date->format('d M, Y') : 'No Expiry' }}
                                    </span>
                                </div>
                                <div class="avatar avatar-xs rounded-circle bg-light border">
                                    <i class="ti ti-award text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 py-5 text-center">
                    <div class="avatar avatar-xxl bg-light-50 rounded-circle mb-4 mx-auto text-muted">
                        <i class="ti ti-award-off fs-40"></i>
                    </div>
                    <h5 class="fw-bold text-dark">No certificates found</h5>
                    <p class="text-muted">No employee certifications have been loaded matching your current filters.</p>
                    <a href="{{ route('certificates.create') }}" class="btn btn-info rounded-pill px-5 mt-3 shadow-sm text-white">Add Your First Certificate</a>
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection

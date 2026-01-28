@extends('layouts.app')

@section('title', 'Corporate Correspondence')

@section('content')

@php
    function getLetterTheme($type) {
        $themes = [
            'offer' => ['icon' => 'ti-user-plus', 'color' => 'primary', 'bg' => 'rgba(13, 110, 253, 0.1)'],
            'appointment' => ['icon' => 'ti-briefcase', 'color' => 'success', 'bg' => 'rgba(25, 135, 84, 0.1)'],
            'experience' => ['icon' => 'ti-certificate', 'color' => 'info', 'bg' => 'rgba(13, 202, 240, 0.1)'],
            'relieving' => ['icon' => 'ti-logout', 'color' => 'secondary', 'bg' => 'rgba(108, 117, 125, 0.1)'],
            'warning' => ['icon' => 'ti-alert-triangle', 'color' => 'danger', 'bg' => 'rgba(220, 53, 69, 0.1)'],
            'appreciation' => ['icon' => 'ti-award', 'color' => 'warning', 'bg' => 'rgba(255, 193, 7, 0.1)'],
            'promotion' => ['icon' => 'ti-trending-up', 'color' => 'purple', 'bg' => 'rgba(111, 66, 193, 0.1)'],
            'transfer' => ['icon' => 'ti-arrows-transfer-down', 'color' => 'orange', 'bg' => 'rgba(253, 126, 20, 0.1)'],
            'other' => ['icon' => 'ti-file-text', 'color' => 'dark', 'bg' => 'rgba(33, 37, 41, 0.1)'],
        ];
        return $themes[$type] ?? $themes['other'];
    }
@endphp

<style>
    .letter-card {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: none;
        background: #fff;
        border-radius: 20px;
        position: relative;
        overflow: hidden;
    }
    .letter-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    .letter-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        transition: all 0.3s ease;
    }
    .letter-card.theme-primary::before { background: #0d6efd; }
    .letter-card.theme-success::before { background: #198754; }
    .letter-card.theme-danger::before { background: #dc3545; }
    .letter-card.theme-warning::before { background: #ffc107; }
    .letter-card.theme-info::before { background: #0dcaf0; }
    .letter-card.theme-secondary::before { background: #6c757d; }
    .letter-card.theme-purple::before { background: #6f42c1; }
    .letter-card.theme-orange::before { background: #fd7e14; }
    .letter-card.theme-dark::before { background: #212529; }

    .glass-panel {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 24px;
    }
    .letter-icon-box {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 20px;
    }
    .stamp-badge {
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
    .avatar-stack .avatar {
        border: 2px solid #fff;
        margin-left: -10px;
        transition: all 0.2s ease;
    }
    .avatar-stack .avatar:first-child { margin-left: 0; }
    .avatar-stack .avatar:hover { transform: translateY(-5px); z-index: 10; }
</style>

<div class="row g-4">
    <!-- Sidebar Filters -->
    <div class="col-xl-3">
        <div class="glass-panel p-4 h-100 position-sticky" style="top: 100px;">
            <div class="mb-4">
                <h5 class="fw-bold text-dark mb-1">Correspondence</h5>
                <p class="text-muted fs-13">HR Official Communications</p>
            </div>

            <form action="{{ route('hr-letters.index') }}" method="GET">
                <div class="mb-3 position-relative">
                    <i class="ti ti-search position-absolute text-muted" style="left: 15px; top: 15px;"></i>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control search-input-fancy shadow-none" placeholder="Search reference or title...">
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
                        <label class="form-check-label fs-13 text-dark" for="statusAll">All Statuses</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input text-success" type="radio" name="status" id="statusIssued" value="issued" {{ request('status') == 'issued' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label class="form-check-label fs-13 text-dark" for="statusIssued">Issued Letter</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input text-warning" type="radio" name="status" id="statusDraft" value="draft" {{ request('status') == 'draft' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label class="form-check-label fs-13 text-dark" for="statusDraft">Draft Pending</label>
                    </div>
                </div>

                @if(request()->hasAny(['q', 'status', 'employee_id', 'letter_type']))
                    <a href="{{ route('hr-letters.index') }}" class="btn btn-light w-100 rounded-pill fs-13 fw-bold">Reset Filters</a>
                @endif
            </form>

            <div class="mt-5 p-4 bg-primary rounded-4 text-white text-center position-relative overflow-hidden">
                <i class="ti ti-mail-fast position-absolute" style="font-size: 80px; opacity: 0.1; right: -20px; bottom: -20px;"></i>
                <h6 class="fw-bold mb-2">Create New Letter</h6>
                <p class="fs-11 opacity-75 mb-3">Generate official correspondence in seconds with templates.</p>
                <a href="{{ route('hr-letters.create') }}" class="btn btn-white btn-sm px-4 rounded-pill fw-bold text-primary">Add New</a>
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
                        <i class="ti ti-mail-opened"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">{{ $letters->where('status', 'issued')->count() }}</h4>
                        <p class="text-muted fs-12 mb-0">Issued Letters</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-mini-card shadow-sm d-flex align-items-center">
                    <div class="avatar avatar-lg bg-warning-transparent text-warning rounded-circle me-3">
                        <i class="ti ti-edit"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">{{ $letters->where('status', 'draft')->count() }}</h4>
                        <p class="text-muted fs-12 mb-0">Pending Drafts</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-mini-card shadow-sm d-flex align-items-center">
                    <div class="avatar-stack d-flex me-3">
                        @foreach($letters->take(3) as $l)
                            <div class="avatar avatar-sm rounded-circle">
                                <img src="{{ $l->employee->profile_picture ? asset('storage/' . $l->employee->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($l->employee->name) }}" alt="">
                            </div>
                        @endforeach
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">{{ $letters->groupBy('employee_id')->count() }}</h4>
                        <p class="text-muted fs-12 mb-0">Employees Reached</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Letters Grid -->
        <div class="row g-4">
            @forelse($letters as $letter)
                @php $theme = getLetterTheme($letter->letter_type); @endphp
                <div class="col-md-6 col-lg-4">
                    <div class="card letter-card shadow-sm h-100 theme-{{ $theme['color'] }}">
                        @if($letter->status == 'issued')
                            <div class="stamp-badge bg-success text-white">Issued</div>
                        @elseif($letter->status == 'draft')
                            <div class="stamp-badge bg-warning text-dark">Draft</div>
                        @else
                            <div class="stamp-badge bg-danger text-white">X Cancelled</div>
                        @endif

                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="letter-icon-box" style="background: {{ $theme['bg'] }}; color: var(--bs-{{ $theme['color'] }});">
                                    <i class="ti {{ $theme['icon'] }}"></i>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-icon btn-sm btn-light border-0 rounded-circle" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3">
                                        <li><a class="dropdown-item py-2" href="{{ route('hr-letters.show', $letter->id) }}"><i class="ti ti-eye me-2"></i>View Letter</a></li>
                                        <li><a class="dropdown-item py-2" href="{{ route('hr-letters.edit', $letter->id) }}"><i class="ti ti-edit me-2"></i>Edit Details</a></li>
                                        <li><hr class="dropdown-divider opacity-50"></li>
                                        <li>
                                            <form action="{{ route('hr-letters.destroy', $letter->id) }}" method="POST" onsubmit="return confirm('Delete this record?');">
                                                @csrf @method('DELETE')
                                                <button class="dropdown-item py-2 text-danger"><i class="ti ti-trash me-2"></i>Delete Forever</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <p class="text-muted fs-11 mb-1 fw-bold text-uppercase ls-1">REF: {{ $letter->letter_number }}</p>
                            <h6 class="fw-bold text-dark mb-3 text-truncate-2" style="min-height: 44px;">{{ $letter->title }}</h6>
                            
                            <div class="d-flex align-items-center p-3 bg-light-50 rounded-4 mb-3">
                                <div class="avatar avatar-md rounded-circle me-3 border border-2 border-white">
                                    <img src="{{ $letter->employee->profile_picture ? asset('storage/' . $letter->employee->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($letter->employee->name) }}" alt="">
                                </div>
                                <div>
                                    <h6 class="fs-13 fw-bold text-dark mb-0">{{ $letter->employee->name }}</h6>
                                    <span class="fs-11 text-muted">{{ ucfirst($letter->letter_type) }} Letter</span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center text-muted fs-11">
                                    <i class="ti ti-calendar-event me-1"></i>
                                    {{ $letter->issue_date->format('d M, Y') }}
                                </div>
                                <div class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" title="Issuer: {{ $letter->issuer->name }}">
                                    <img src="{{ $letter->issuer->profile_picture ? asset('storage/' . $letter->issuer->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($letter->issuer->name) }}" class="rounded-circle" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 py-5 text-center">
                    <div class="avatar avatar-xxl bg-light-50 rounded-circle mb-4 mx-auto text-muted">
                        <i class="ti ti-mail-off fs-40"></i>
                    </div>
                    <h5 class="fw-bold text-dark">No correspondence found</h5>
                    <p class="text-muted">No official letters have been issued matching your current filters.</p>
                    <a href="{{ route('hr-letters.create') }}" class="btn btn-primary rounded-pill px-5 mt-3 shadow-sm">Generate First Letter</a>
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection

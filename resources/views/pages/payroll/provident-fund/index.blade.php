@extends('layouts.app')

@section('title', 'Social Security & Funds')

@section('content')

<style>
    .pf-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 20px;
        background: #fff;
    }
    .pf-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05) !important;
    }
    .fund-icon {
        width: 40px;
        height: 40px;
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    .share-box {
        padding: 12px;
        border-radius: 14px;
        background: #f8fafc;
        border: 1px solid #f1f5f9;
    }
</style>

<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
    <div class="my-auto">
        <h2 class="mb-1 text-dark fw-bold">Provident Fund Ledger</h2>
        <p class="text-muted mb-0 fs-13">Monitoring statutory pension and retirement contributions</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('payroll.provident-fund.create') }}" class="btn btn-primary d-flex align-items-center rounded-pill shadow-sm px-4">
            <i class="ti ti-plus me-2"></i>Log Contribution
        </a>
    </div>
</div>

<div class="row g-4">
    @forelse($providentFunds as $pf)
        <div class="col-md-6 col-lg-4">
            <div class="card pf-card shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-lg rounded-circle me-3 border border-2 border-white shadow-sm overflow-hidden">
                                <img src="{{ $pf->employee->profile_picture ? asset('storage/' . $pf->employee->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($pf->employee->name ?? 'N/A') }}" alt="">
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">{{ $pf->employee->name ?? 'N/A' }}</h6>
                                <span class="badge bg-light text-muted fs-10 fw-bold border">{{ $pf->month }} {{ $pf->year }}</span>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-icon btn-sm" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li><a class="dropdown-item py-2" href="{{ route('payroll.provident-fund.edit', $pf->id) }}"><i class="ti ti-edit me-2 text-info"></i>Modify Record</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item py-2 text-danger" href="#"><i class="ti ti-trash me-2"></i>Remove</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="share-box">
                                <span class="fs-10 text-muted fw-bold text-uppercase d-block mb-1">Staff Share</span>
                                <span class="fs-14 fw-bold text-dark">AED {{ number_format($pf->employee_contribution, 2) }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="share-box">
                                <span class="fs-10 text-muted fw-bold text-uppercase d-block mb-1">Company Share</span>
                                <span class="fs-14 fw-bold text-dark">AED {{ number_format($pf->employer_contribution, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-primary-transparent p-3 rounded-4 border border-primary-transparent d-flex align-items-center justify-content-between">
                        <div>
                            <span class="fs-11 text-muted d-block">Monthly Accumulation</span>
                            <span class="h5 fw-bold text-primary mb-0">AED {{ number_format($pf->total_contribution, 2) }}</span>
                        </div>
                        <div class="fund-icon">
                            <i class="ti ti-piggy-bank"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 py-5 text-center">
            <div class="avatar avatar-xxl bg-light-50 rounded-circle mb-4 mx-auto text-muted">
                <i class="ti ti-piggy-bank fs-40"></i>
            </div>
            <h5 class="fw-bold text-dark">No Fund Records Found</h5>
            <p class="text-muted">Start tracking employee provident fund contributions.</p>
        </div>
    @endforelse
</div>

@endsection

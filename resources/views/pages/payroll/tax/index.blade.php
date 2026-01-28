@extends('layouts.app')

@section('title', 'Tax Compliance')

@section('content')

<style>
    .tax-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 20px;
        background: #fff;
        height: 100%;
    }
    .tax-card:hover {
        transform: scale(1.02);
        box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
    }
    .tax-rate-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #fef2f2;
        color: #ef4444;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 16px;
        border: 2px solid #fee2e2;
    }
    .range-pills {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        color: #475569;
        background: #f8fafc;
        padding: 4px 12px;
        border-radius: 10px;
        font-size: 12px;
    }
</style>

<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
    <div class="my-auto">
        <h2 class="mb-1 text-dark fw-bold">Tax Jurisdictions</h2>
        <p class="text-muted mb-0 fs-13">Regulatory tax compliance and tiered income bracket management</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('payroll.tax.create') }}" class="btn btn-danger d-flex align-items-center rounded-pill shadow-sm px-4">
            <i class="ti ti-plus me-2"></i>Add Tax Rules
        </a>
    </div>
</div>

<div class="row g-4">
    @forelse($taxes as $tax)
        <div class="col-md-6 col-lg-4">
            <div class="card tax-card shadow-sm border-top border-4 border-danger">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="tax-rate-circle shadow-sm">
                            {{ number_format($tax->tax_rate, 0) }}%
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-icon btn-sm" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li><a class="dropdown-item py-2" href="{{ route('payroll.tax.edit', $tax->id) }}"><i class="ti ti-settings me-2"></i>Adjust Rate</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item py-2 text-danger" href="#"><i class="ti ti-trash me-2"></i>Remove Bracket</a></li>
                            </ul>
                        </div>
                    </div>

                    <h5 class="fw-bold text-dark mb-1">{{ $tax->name }}</h5>
                    <span class="fs-11 text-muted d-block mb-3 text-uppercase fw-bold ls-1">{{ $tax->calculation_method }} Basis</span>

                    <div class="mb-4">
                        <span class="fs-10 text-muted d-block mb-2 text-uppercase fw-bold">Applicable Income Range</span>
                        <div class="d-flex align-items-center gap-2">
                            <span class="range-pills">AED {{ number_format($tax->min_income, 0) }}</span>
                            <i class="ti ti-arrow-narrow-right text-muted"></i>
                            <span class="range-pills">{{ $tax->max_income ? 'AED ' . number_format($tax->max_income, 0) : '∞ No Limit' }}</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                        <span class="fs-11 text-muted">Status</span>
                        @if($tax->is_active)
                            <span class="badge bg-success-transparent text-success rounded-pill px-3 py-1 fw-bold fs-10">ACTIVE COMPLIANCE</span>
                        @else
                            <span class="badge bg-secondary-transparent text-secondary rounded-pill px-3 py-1 fw-bold fs-10">ARCHIVED</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 py-5 text-center">
            <div class="avatar avatar-xxl bg-light-50 rounded-circle mb-4 mx-auto text-muted">
                <i class="ti ti-receipt-tax fs-40"></i>
            </div>
            <h5 class="fw-bold text-dark">No Tax Brackets Found</h5>
            <p class="text-muted">Set up your local tax regulations to begin deduction processing.</p>
        </div>
    @endforelse
</div>

@endsection

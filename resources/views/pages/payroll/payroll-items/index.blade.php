@extends('layouts.app')

@section('title', 'Payroll Components')

@section('content')

<style>
    .component-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 20px;
        background: #fff;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .component-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05) !important;
    }
    .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .calc-pill {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 4px 10px;
        border-radius: 6px;
        background: #f1f5f9;
        color: #475569;
    }
    .value-display {
        font-size: 24px;
        font-weight: 800;
        color: #1e293b;
    }
</style>

<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
    <div class="my-auto">
        <h2 class="mb-1 text-dark fw-bold">Payroll Components</h2>
        <p class="text-muted mb-0 fs-13">Configure additions, deductions, and statutory payment rules</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('payroll.items.create') }}" class="btn btn-primary d-flex align-items-center rounded-pill shadow-sm px-4">
            <i class="ti ti-plus me-2"></i>New Component
        </a>
    </div>
</div>

<div class="row g-4">
    @php
        $additions = $payrollItems->where('type', 'addition');
        $deductions = $payrollItems->where('type', 'deduction');
    @endphp

    <!-- Additions Column -->
    <div class="col-lg-6">
        <div class="d-flex align-items-center mb-3">
            <div class="avatar avatar-sm bg-success-transparent text-success rounded-circle me-2">
                <i class="ti ti-trending-up"></i>
            </div>
            <h5 class="fw-bold text-dark mb-0">Allowances & Additions</h5>
        </div>
        <div class="row g-3">
            @forelse($additions as $item)
                <div class="col-md-6">
                    <div class="card component-card shadow-sm border-start border-4 border-success">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="icon-box bg-success-transparent text-success">
                                    <i class="ti {{ $item->calculation_type == 'percentage' ? 'ti-percentage' : 'ti-cash' }}"></i>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-icon btn-sm btn-light border-0 rounded-circle" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                                        <li><a class="dropdown-item py-2" href="{{ route('payroll.items.edit', $item->id) }}"><i class="ti ti-edit me-2"></i>Configure</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item py-2 text-danger" href="#"><i class="ti ti-trash me-2"></i>Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">{{ $item->name }}</h6>
                            <div class="calc-pill d-inline-block mb-3">{{ str_replace('_', ' ', $item->calculation_type) }}</div>
                            
                            <div class="value-display mt-auto">
                                @if($item->calculation_type == 'percentage')
                                    {{ number_format($item->percentage, 1) }}%
                                @else
                                    <span class="fs-14 fw-bold text-muted me-1">AED</span>{{ number_format($item->amount ?? 0, 0) }}
                                @endif
                            </div>
                            
                            <div class="d-flex align-items-center mt-3 justify-content-between">
                                <span class="fs-11 {{ $item->is_taxable ? 'text-info fw-bold' : 'text-muted' }}">
                                    <i class="ti {{ $item->is_taxable ? 'ti-receipt-tax' : 'ti-receipt-off' }} me-1"></i>
                                    {{ $item->is_taxable ? 'Taxable' : 'Non-Taxable' }}
                                </span>
                                @if(!$item->is_active)
                                    <span class="badge bg-danger-transparent text-danger fs-10">Inactive</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="p-4 bg-light-50 rounded-4 text-center border border-dashed">
                        <p class="text-muted fs-13 mb-0">No allowance components defined.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Deductions Column -->
    <div class="col-lg-6">
        <div class="d-flex align-items-center mb-3">
            <div class="avatar avatar-sm bg-danger-transparent text-danger rounded-circle me-2">
                <i class="ti ti-trending-down"></i>
            </div>
            <h5 class="fw-bold text-dark mb-0">Deductions & Statutory</h5>
        </div>
        <div class="row g-3">
            @forelse($deductions as $item)
                <div class="col-md-6">
                    <div class="card component-card shadow-sm border-start border-4 border-danger">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="icon-box bg-danger-transparent text-danger">
                                    <i class="ti {{ $item->calculation_type == 'percentage' ? 'ti-percentage' : 'ti-wallet-off' }}"></i>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-icon btn-sm btn-light border-0 rounded-circle" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                                        <li><a class="dropdown-item py-2" href="{{ route('payroll.items.edit', $item->id) }}"><i class="ti ti-edit me-2"></i>Configure</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item py-2 text-danger" href="#"><i class="ti ti-trash me-2"></i>Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">{{ $item->name }}</h6>
                            <div class="calc-pill d-inline-block mb-3">{{ str_replace('_', ' ', $item->calculation_type) }}</div>
                            
                            <div class="value-display mt-auto">
                                @if($item->calculation_type == 'percentage')
                                    {{ number_format($item->percentage, 1) }}%
                                @else
                                    <span class="fs-14 fw-bold text-muted me-1">AED</span>{{ number_format($item->amount ?? 0, 0) }}
                                @endif
                            </div>

                            <div class="d-flex align-items-center mt-3 justify-content-between">
                                <span class="fs-11 {{ $item->is_taxable ? 'text-info fw-bold' : 'text-muted' }}">
                                    <i class="ti {{ $item->is_taxable ? 'ti-receipt-tax' : 'ti-receipt-off' }} me-1"></i>
                                    {{ $item->is_taxable ? 'Impacts Tax' : 'Post-Tax' }}
                                </span>
                                @if(!$item->is_active)
                                    <span class="badge bg-danger-transparent text-danger fs-10">Inactive</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="p-4 bg-light-50 rounded-4 text-center border border-dashed">
                        <p class="text-muted fs-13 mb-0">No deduction components defined.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection

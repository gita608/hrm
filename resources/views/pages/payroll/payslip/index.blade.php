@extends('layouts.app')

@section('title', 'Payroll Disbursements')

@section('content')

<style>
    .payslip-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        border-radius: 20px;
        background: #fff;
        position: relative;
        overflow: hidden;
    }
    .payslip-card:hover {
        transform: scale(1.02);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
    }
    .payslip-status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }
    .period-badge {
        background: #f1f5f9;
        color: #475569;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .voucher-id {
        font-family: 'Monaco', 'Consolas', monospace;
        font-size: 12px;
        color: #6366f1;
        background: rgba(99, 102, 241, 0.1);
        padding: 2px 8px;
        border-radius: 6px;
    }
    .net-payment {
        font-size: 18px;
        font-weight: 800;
        color: #1e293b;
    }
    .glass-filter {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.4);
    }
</style>

<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
    <div class="my-auto">
        <h2 class="mb-1 text-dark fw-bold">Payment Disbursements</h2>
        <p class="text-muted mb-0 fs-13">Track and manage issued employee payslips and historical payouts</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('payroll.payslip.create') }}" class="btn btn-dark d-flex align-items-center rounded-pill shadow-sm px-4 py-2">
            <i class="ti ti-receipt me-2"></i>Run New Payroll
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Filters Sidebar -->
    <div class="col-xl-3">
        <div class="glass-filter p-4 h-100 position-sticky" style="top: 100px;">
            <div class="mb-4 text-center">
                <div class="avatar avatar-xxl bg-indigo-transparent text-indigo rounded-circle mb-3 mx-auto">
                    <i class="ti ti-cash-banknote fs-40"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">Payroll Hub</h5>
                <p class="text-muted fs-12">Search historical payments</p>
            </div>

            <form action="{{ route('payroll.payslip.index') }}" method="GET">
                <div class="mb-4">
                    <label class="form-label fs-12 fw-bold text-uppercase text-muted ls-1">Recipient</label>
                    <select name="employee_id" class="form-select rounded-3 border-light shadow-none fs-13" onchange="this.form.submit()">
                        <option value="">All Employees</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fs-12 fw-bold text-uppercase text-muted ls-1">Payment Status</label>
                    <select name="status" class="form-select rounded-3 border-light shadow-none fs-13" onchange="this.form.submit()">
                        <option value="">Filter Status</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid Out</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Drafting</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Voided</option>
                    </select>
                </div>

                @if(request()->hasAny(['employee_id', 'status']))
                    <a href="{{ route('payroll.payslip.index') }}" class="btn btn-light w-100 rounded-pill fs-12 fw-bold border">Reset Search</a>
                @endif
            </form>

            <div class="mt-5 text-center">
                <p class="text-muted fs-11 px-3">Official payment records are encrypted and timestamped for audit compliance.</p>
            </div>
        </div>
    </div>

    <!-- Payslips Main Area -->
    <div class="col-xl-9">
        <!-- Quick Stats Line -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 rounded-4 shadow-sm bg-success text-white">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <p class="fs-11 fw-bold text-uppercase mb-0 opacity-75">Paid Successful</p>
                            <h4 class="fw-bold mb-0">{{ $payslips->where('status', 'paid')->count() }}</h4>
                        </div>
                        <i class="ti ti-circle-check fs-24 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 rounded-4 shadow-sm bg-warning text-dark">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <p class="fs-11 fw-bold text-uppercase mb-0 opacity-75">Pending Payout</p>
                            <h4 class="fw-bold mb-0">{{ $payslips->where('status', 'approved')->count() }}</h4>
                        </div>
                        <i class="ti ti-hand-pay fs-24 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 rounded-4 shadow-sm bg-white border border-light">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between text-dark">
                        <div>
                            <p class="fs-11 fw-bold text-uppercase mb-0 text-muted">Total Workforce Net</p>
                            <h4 class="fw-bold mb-0">AED {{ number_format($payslips->where('status', 'paid')->sum('net_salary'), 0) }}</h4>
                        </div>
                        <i class="ti ti-cash fs-24 text-muted opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payslips Grid -->
        <div class="row g-4">
            @forelse($payslips as $payslip)
                <div class="col-md-6 col-lg-4">
                    <div class="card payslip-card shadow-sm h-100">
                        <div class="card-body p-4">
                            <!-- Top Info -->
                            <div class="d-flex justify-content-between mb-3 align-items-center">
                                <span class="voucher-id">{{ $payslip->payslip_number }}</span>
                                <div class="dropdown">
                                    <button class="btn btn-icon btn-sm" data-bs-toggle="dropdown"><i class="ti ti-dots"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                                        <li><a class="dropdown-item py-2" href="{{ route('payroll.payslip.show', $payslip->id) }}"><i class="ti ti-eye me-2"></i>Full Breakdown</a></li>
                                        @if($payslip->status != 'paid')
                                            <li><a class="dropdown-item py-2" href="{{ route('payroll.payslip.edit', $payslip->id) }}"><i class="ti ti-edit me-2"></i>Amend Values</a></li>
                                        @endif
                                        <li><a class="dropdown-item py-2" href="#"><i class="ti ti-file-export me-2"></i>Export as PDF</a></li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Recipient -->
                            <div class="text-center mb-4">
                                <div class="avatar avatar-xl bg-light rounded-circle mb-2 mx-auto border border-2 border-white shadow-sm overflow-hidden">
                                    <img src="{{ $payslip->employee->profile_picture ? asset('storage/' . $payslip->employee->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($payslip->employee->name ?? 'N/A') }}" alt="">
                                </div>
                                <h6 class="fw-bold text-dark mb-0">{{ $payslip->employee->name ?? 'N/A' }}</h6>
                                <span class="fs-11 text-muted">{{ $payslip->employee->designation->name ?? 'Staff' }}</span>
                            </div>

                            <hr class="opacity-10">

                            <!-- Payment Detail -->
                            <div class="d-flex justify-content-between text-center mb-4">
                                <div class="flex-grow-1 border-end">
                                    <span class="fs-10 text-muted text-uppercase fw-bold d-block">Period</span>
                                    <span class="fs-11 fw-bold text-dark">{{ $payslip->pay_period_end->format('M Y') }}</span>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fs-10 text-muted text-uppercase fw-bold d-block">Status</span>
                                    @php
                                        $statusClass = [
                                            'paid' => 'success',
                                            'approved' => 'info',
                                            'draft' => 'warning',
                                            'cancelled' => 'danger'
                                        ][$payslip->status] ?? 'secondary';
                                    @endphp
                                    <span class="fs-11 fw-bold text-{{ $statusClass }}">
                                        {{ ucfirst($payslip->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="bg-light-50 p-3 rounded-4 text-center">
                                <span class="fs-11 text-muted d-block mb-1">Total Credited Amount</span>
                                <div class="net-payment">AED {{ number_format($payslip->net_salary, 2) }}</div>
                            </div>
                        </div>
                        
                        <!-- Footer bar -->
                        @if($payslip->status == 'paid')
                            <div class="bg-success py-1 w-100 text-center text-white fs-10 fw-bold text-uppercase ls-1">Paid on {{ $payslip->payment_date->format('d M') }}</div>
                        @elseif($payslip->status == 'approved')
                            <div class="bg-info py-1 w-100 text-center text-white fs-10 fw-bold text-uppercase ls-1">Ready for Payout</div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-12 py-5 text-center">
                    <div class="avatar avatar-xxl bg-light-50 rounded-circle mb-4 mx-auto text-muted">
                        <i class="ti ti-receipt-off fs-40"></i>
                    </div>
                    <h5 class="fw-bold text-dark">No Disbursement History</h5>
                    <p class="text-muted">Generate your first batch of payslips to see them here.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection

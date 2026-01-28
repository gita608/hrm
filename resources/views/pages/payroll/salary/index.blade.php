@extends('layouts.app')

@section('title', 'Compensation Management')

@section('content')

<style>
    .salary-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 20px;
        background: #fff;
        overflow: hidden;
    }
    .salary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important;
    }
    .finance-badge {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 5px 12px;
        border-radius: 8px;
    }
    .glass-sidebar {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    .amount-label {
        font-size: 11px;
        color: #9ca3af;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .amount-value {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
    }
    .net-salary-box {
        background: #f8fafc;
        border-radius: 16px;
        padding: 15px;
        border: 1px dashed #e2e8f0;
    }
</style>

<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
    <div class="my-auto">
        <h2 class="mb-1 text-dark fw-bold">Compensation & Benefits</h2>
        <p class="text-muted mb-0 fs-13">Financial overview and salary structures for your workforce</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('payroll.salary.create') }}" class="btn btn-primary d-flex align-items-center rounded-pill shadow-sm px-4 py-2">
            <i class="ti ti-plus me-2"></i>Set New Salary
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Filters Sidebar -->
    <div class="col-xl-3">
        <div class="glass-sidebar p-4 h-100 position-sticky" style="top: 100px;">
            <div class="mb-4">
                <h6 class="fw-bold text-dark mb-1">Financial Filters</h6>
                <p class="text-muted fs-12">Slice and dice compensation data</p>
            </div>

            <form action="{{ route('payroll.salary.index') }}" method="GET">
                <div class="mb-4">
                    <label class="form-label fs-12 fw-bold text-uppercase text-muted ls-1">By Employee</label>
                    <select name="employee_id" class="form-select rounded-3 border-light shadow-none fs-13" onchange="this.form.submit()">
                        <option value="">All Staff Members</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fs-12 fw-bold text-uppercase text-muted ls-1">Structure Status</label>
                    <div class="d-flex flex-column gap-2 mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="statusAll" value="" {{ !request('status') ? 'checked' : '' }} onchange="this.form.submit()">
                            <label class="form-check-label fs-13 text-dark" for="statusAll">All Structures</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input text-success" type="radio" name="status" id="statusActive" value="active" {{ request('status') == 'active' ? 'checked' : '' }} onchange="this.form.submit()">
                            <label class="form-check-label fs-13 text-dark" for="statusActive">Active Only</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input text-danger" type="radio" name="status" id="statusInactive" value="inactive" {{ request('status') == 'inactive' ? 'checked' : '' }} onchange="this.form.submit()">
                            <label class="form-check-label fs-13 text-dark" for="statusInactive">Inactive/Historical</label>
                        </div>
                    </div>
                </div>

                @if(request()->hasAny(['employee_id', 'status']))
                    <a href="{{ route('payroll.salary.index') }}" class="btn btn-light w-100 rounded-pill fs-12 fw-bold mb-3">Clear Filters</a>
                @endif
            </form>

            <div class="mt-5 p-4 bg-primary rounded-4 text-white position-relative overflow-hidden shadow">
                <i class="ti ti-chart-pie position-absolute" style="font-size: 80px; opacity: 0.1; right: -20px; bottom: -20px;"></i>
                <h6 class="fw-bold mb-2">Total Monthly Budget</h6>
                <p class="fs-12 opacity-75 mb-0">Calculated from active salaries</p>
                <h3 class="fw-bold mt-2">AED {{ number_format($salaries->where('status', 'active')->sum('net_salary'), 2) }}</h3>
            </div>
        </div>
    </div>

    <!-- Salaries Grid -->
    <div class="col-xl-9">
        <div class="row g-4">
            @forelse($salaries as $salary)
                <div class="col-md-6 col-lg-4">
                    <div class="card salary-card shadow-sm h-100 border-top border-4 {{ $salary->status == 'active' ? 'border-success' : 'border-secondary' }}">
                        <div class="card-body p-4">
                            <!-- Header -->
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-lg rounded-circle me-3 border border-2 border-white shadow-sm">
                                        <img src="{{ $salary->employee->profile_picture ? asset('storage/' . $salary->employee->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($salary->employee->name ?? 'N/A') }}" alt="">
                                    </div>
                                    <div class="overflow-hidden">
                                        <h6 class="fw-bold text-dark mb-0 text-truncate" style="max-width: 140px;">{{ $salary->employee->name ?? 'N/A' }}</h6>
                                        <span class="fs-11 text-muted">{{ $salary->employee->designation->name ?? 'Staff' }}</span>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-icon btn-sm btn-light border-0 rounded-circle" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3">
                                        <li><a class="dropdown-item py-2" href="{{ route('payroll.salary.show', $salary->id) }}"><i class="ti ti-eye me-2 text-primary"></i>View Full Structure</a></li>
                                        <li><a class="dropdown-item py-2" href="{{ route('payroll.salary.edit', $salary->id) }}"><i class="ti ti-edit me-2 text-info"></i>Adjust Compensation</a></li>
                                        <li><hr class="dropdown-divider opacity-50"></li>
                                        <li>
                                            <form action="{{ route('payroll.salary.destroy', $salary->id) }}" method="POST" onsubmit="return confirm('Archive this financial record?');">
                                                @csrf @method('DELETE')
                                                <button class="dropdown-item py-2 text-danger"><i class="ti ti-trash me-2"></i>Delete Record</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Financial details -->
                            <div class="row g-3 mb-4">
                                <div class="col-6">
                                    <div class="amount-label">Basic</div>
                                    <div class="amount-value">{{ number_format($salary->basic_salary, 0) }}</div>
                                </div>
                                <div class="col-6">
                                    <div class="amount-label">Allowances</div>
                                    <div class="amount-value text-success">+{{ number_format($salary->total_allowances, 0) }}</div>
                                </div>
                                <div class="col-6">
                                    <div class="amount-label text-danger">Deductions</div>
                                    <div class="amount-value text-danger">-{{ number_format($salary->total_deductions, 0) }}</div>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="finance-badge {{ $salary->status == 'active' ? 'bg-success-transparent text-success' : 'bg-secondary-transparent text-secondary' }}">
                                        {{ ucfirst($salary->status) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Total Net -->
                            <div class="net-salary-box text-center">
                                <div class="amount-label d-block mb-1">Take Home Pay</div>
                                <div class="h4 fw-bold text-dark mb-0">AED {{ number_format($salary->net_salary, 2) }}</div>
                                <div class="fs-10 text-muted mt-1 mt-1"><i class="ti ti-calendar-event me-1"></i>Effective {{ $salary->effective_from->format('M Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 py-5 text-center">
                    <div class="avatar avatar-xxl bg-light-50 rounded-circle mb-4 mx-auto text-muted">
                        <i class="ti ti-coin-off fs-40"></i>
                    </div>
                    <h5 class="fw-bold text-dark">No Compensation Records</h5>
                    <p class="text-muted">You haven't set up any salary structures yet.</p>
                    <a href="{{ route('payroll.salary.create') }}" class="btn btn-primary rounded-pill px-5 mt-3 shadow-sm">Set Up First Salary</a>
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection

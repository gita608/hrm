@extends('layouts.app')

@section('title', 'Set Up Compensation')

@section('content')

<style>
    .finance-wizard-card {
        border: none;
        border-radius: 24px;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    }
    .step-indicator {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: #f1f5f9;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        margin-right: 12px;
    }
    .wizard-section-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
    }
    .finance-input-group {
        background: #f8fafc;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #f1f5f9;
        transition: all 0.2s ease;
    }
    .finance-input-group:focus-within {
        border-color: #6366f1;
        background: #fff;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.05);
    }
    .summary-widget {
        background: #1e293b;
        color: #fff;
        border-radius: 24px;
        padding: 30px;
        position: sticky;
        top: 100px;
    }
    .summary-line {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 13px;
        opacity: 0.8;
    }
    .summary-total {
        border-top: 1px solid rgba(255,255,255,0.1);
        padding-top: 15px;
        margin-top: 15px;
    }
</style>

<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
    <div class="my-auto">
        <h2 class="mb-1 text-dark fw-bold">Assign Compensation</h2>
        <p class="text-muted mb-0 fs-13">Configure the financial package for a staff member</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('payroll.salary.index') }}" class="btn btn-light rounded-pill px-4">Exit Wizard</a>
    </div>
</div>

<form action="{{ route('payroll.salary.store') }}" method="POST" id="salaryForm">
    @csrf
    <div class="row g-4">
        <div class="col-xl-8">
            <div class="card finance-wizard-card">
                <div class="card-body p-4 p-md-5">
                    
                    <!-- Section 1: Individual -->
                    <div class="mb-5">
                        <div class="wizard-section-title">
                            <div class="step-indicator">1</div>
                            Recipient & Core Package
                        </div>
                        <p class="text-muted fs-12 mb-4 ms-5">Select the employee and their primary base salary</p>
                        
                        <div class="row g-3 ms-md-4">
                            <div class="col-md-6">
                                <label class="form-label fs-12 fw-bold text-uppercase text-muted">Employee Reference</label>
                                <select class="form-select finance-input-group border-0 @error('employee_id') is-invalid @enderror" name="employee_id" required>
                                    <option value="">Choose Staff Member</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                                @error('employee_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fs-12 fw-bold text-uppercase text-muted">Base Monthly Salary</label>
                                <div class="input-group finance-input-group border-0">
                                    <span class="input-group-text bg-transparent border-0 text-muted fw-bold">AED</span>
                                    <input type="number" step="0.01" class="form-control bg-transparent border-0 shadow-none fw-bold @error('basic_salary') is-invalid @enderror" name="basic_salary" id="basic_salary" value="{{ old('basic_salary') }}" placeholder="0.00" required>
                                </div>
                                @error('basic_salary') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Fixed Additions -->
                    <div class="mb-5">
                        <div class="wizard-section-title">
                            <div class="step-indicator">2</div>
                            Allowance Distribution
                        </div>
                        <p class="text-muted fs-12 mb-4 ms-5">Define fixed monthly allowances for housing, travel, etc.</p>
                        
                        <div class="row g-3 ms-md-4">
                            <div class="col-md-6">
                                <label class="form-label fs-11 fw-bold text-muted">Housing</label>
                                <input type="number" step="0.01" class="form-control finance-input-group border-0" name="housing_allowance" id="housing_allowance" value="{{ old('housing_allowance', 0) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fs-11 fw-bold text-muted">Transport</label>
                                <input type="number" step="0.01" class="form-control finance-input-group border-0" name="transport_allowance" id="transport_allowance" value="{{ old('transport_allowance', 0) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fs-11 fw-bold text-muted">Food / Utility</label>
                                <input type="number" step="0.01" class="form-control finance-input-group border-0" name="food_allowance" id="food_allowance" value="{{ old('food_allowance', 0) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fs-11 fw-bold text-muted">Other Perks</label>
                                <input type="number" step="0.01" class="form-control finance-input-group border-0" name="other_allowances" id="other_allowances" value="{{ old('other_allowances', 0) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Deductions -->
                    <div class="mb-5">
                        <div class="wizard-section-title">
                            <div class="step-indicator">3</div>
                            Statutory Deductions
                        </div>
                        <p class="text-muted fs-12 mb-4 ms-5">Configure tax and mandatory fund deductions</p>
                        
                        <div class="row g-3 ms-md-4">
                            <div class="col-md-4">
                                <label class="form-label fs-11 fw-bold text-muted">Tax Estimate</label>
                                <input type="number" step="0.01" class="form-control finance-input-group border-0 text-danger" name="tax_deduction" id="tax_deduction" value="{{ old('tax_deduction', 0) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fs-11 fw-bold text-muted">Provident Fund</label>
                                <input type="number" step="0.01" class="form-control finance-input-group border-0 text-danger" name="provident_fund" id="provident_fund" value="{{ old('provident_fund', 0) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fs-11 fw-bold text-muted">Misc. Deductions</label>
                                <input type="number" step="0.01" class="form-control finance-input-group border-0 text-danger" name="other_deductions" id="other_deductions" value="{{ old('other_deductions', 0) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Final Config -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fs-12 fw-bold text-muted">Effective Date</label>
                            <input type="date" class="form-control finance-input-group border-0" name="effective_from" value="{{ old('effective_from', date('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-12 fw-bold text-muted">Package Status</label>
                            <select class="form-select finance-input-group border-0" name="status" required>
                                <option value="active">Immediate Active</option>
                                <option value="inactive">Draft / Future</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-5 d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-lg">Finalize Compensation</button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Sticky Summary -->
        <div class="col-xl-4">
            <div class="summary-widget shadow-lg">
                <h5 class="fw-bold mb-4">Financial Reality</h5>
                
                <div class="summary-line">
                    <span>Base Monthly</span>
                    <span id="sum_base">0.00</span>
                </div>
                <div class="summary-line">
                    <span>Total Allowances</span>
                    <span class="text-success" id="sum_allowance">+ 0.00</span>
                </div>
                <div class="summary-line">
                    <span>Gross Calculation</span>
                    <span id="sum_gross">0.00</span>
                </div>
                <div class="summary-line">
                    <span>Total Deductions</span>
                    <span class="text-danger" id="sum_deduction">- 0.00</span>
                </div>

                <div class="summary-total text-center">
                    <p class="fs-11 fw-bold text-uppercase opacity-50 mb-1">Estimated Net Take-Home</p>
                    <h2 class="fw-bold mb-0" id="sum_net">AED 0.00</h2>
                </div>

                <div class="mt-4 p-3 bg-white-transparent rounded-4 fs-11 opacity-75">
                    <i class="ti ti-info-circle me-1"></i> These figures are estimates based on the monthly structure configured. Actual payslip values may vary based on attendance.
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function updateCalculations() {
        const getVal = (id) => parseFloat(document.getElementById(id).value) || 0;
        
        const basic = getVal('basic_salary');
        const housing = getVal('housing_allowance');
        const transport = getVal('transport_allowance');
        const food = getVal('food_allowance');
        const other = getVal('other_allowances');
        const tax = getVal('tax_deduction');
        const pf = getVal('provident_fund');
        const otherDed = getVal('other_deductions');

        const allowances = housing + transport + food + other;
        const gross = basic + allowances;
        const deductions = tax + pf + otherDed;
        const net = gross - deductions;

        document.getElementById('sum_base').textContent = basic.toLocaleString(undefined, {minimumFractionDigits: 2});
        document.getElementById('sum_allowance').textContent = '+ ' + allowances.toLocaleString(undefined, {minimumFractionDigits: 2});
        document.getElementById('sum_gross').textContent = gross.toLocaleString(undefined, {minimumFractionDigits: 2});
        document.getElementById('sum_deduction').textContent = '- ' + deductions.toLocaleString(undefined, {minimumFractionDigits: 2});
        document.getElementById('sum_net').textContent = 'AED ' + net.toLocaleString(undefined, {minimumFractionDigits: 2});
    }

    const inputs = ['basic_salary', 'housing_allowance', 'transport_allowance', 'food_allowance', 'other_allowances', 'tax_deduction', 'provident_fund', 'other_deductions'];
    inputs.forEach(id => document.getElementById(id).addEventListener('input', updateCalculations));
    
    // Initial Run
    updateCalculations();
</script>

@endsection

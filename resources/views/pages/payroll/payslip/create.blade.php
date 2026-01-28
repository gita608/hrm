@extends('layouts.app')

@section('title', 'Generate Payment Voucher')

@section('content')

<style>
    .payslip-wizard-card {
        border: none;
        border-radius: 24px;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
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
    }
    .summary-widget {
        background: #0f172a;
        color: #fff;
        border-radius: 24px;
        padding: 30px;
        position: sticky;
        top: 100px;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .summary-title {
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        color: #94a3b8;
        letter-spacing: 1px;
        margin-bottom: 20px;
    }
    .val-line {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 14px;
        color: #cbd5e1;
    }
    .val-highlight {
        color: #fff;
        font-weight: 700;
    }
    .big-check {
        font-size: 32px;
        font-weight: 800;
        color: #10b981;
    }
</style>

<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
    <div class="my-auto">
        <h2 class="mb-1 text-dark fw-bold">Manual Payroll Entry</h2>
        <p class="text-muted mb-0 fs-13">Initiate a specific disbursement for an individual staff member</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('payroll.payslip.index') }}" class="btn btn-light rounded-pill px-4">Exit Entry Mode</a>
    </div>
</div>

<form action="{{ route('payroll.payslip.store') }}" method="POST" id="payslipForm">
    @csrf
    <div class="row g-4">
        <div class="col-xl-8">
            <div class="card payslip-wizard-card">
                <div class="card-body p-4 p-md-5">
                    
                    <!-- Section 1: Template Selection -->
                    <div class="mb-5">
                        <h6 class="fw-bold text-dark mb-4 d-flex align-items-center">
                            <i class="ti ti-template me-2 text-primary"></i> 
                            Standard Entry Profile
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fs-11 fw-bold text-muted text-uppercase">Import from Salary Structure</label>
                                <select class="form-select finance-input-group border-0" name="salary_id" id="salary_id">
                                    <option value="">Manual Entry (No Profile)</option>
                                    @foreach($salaries as $salary)
                                        <option value="{{ $salary->id }}" 
                                                data-employee="{{ $salary->employee_id }}" 
                                                data-basic="{{ $salary->basic_salary }}" 
                                                data-allowances="{{ $salary->total_allowances }}" 
                                                data-tax="{{ $salary->tax_deduction }}" 
                                                data-pf="{{ $salary->provident_fund }}">
                                            {{ $salary->employee->name ?? 'N/A' }} — Monthly Package: AED {{ number_format($salary->net_salary, 0) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Recipient & Period -->
                    <div class="mb-5">
                        <h6 class="fw-bold text-dark mb-4 d-flex align-items-center">
                            <i class="ti ti-calendar-time me-2 text-primary"></i> 
                            Service Period & Recipient
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fs-11 fw-bold text-muted text-uppercase">Beneficiary</label>
                                <select class="form-select finance-input-group border-0 @error('employee_id') is-invalid @enderror" name="employee_id" id="employee_id" required>
                                    <option value="">Select Target Employee</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fs-11 fw-bold text-muted text-uppercase">Start Cycle</label>
                                <input type="date" class="form-control finance-input-group border-0" name="pay_period_start" value="{{ old('pay_period_start', date('Y-m-01')) }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fs-11 fw-bold text-muted text-uppercase">End Cycle</label>
                                <input type="date" class="form-control finance-input-group border-0" name="pay_period_end" value="{{ old('pay_period_end', date('Y-m-t')) }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Financial Components -->
                    <div class="mb-5">
                        <h6 class="fw-bold text-dark mb-4 d-flex align-items-center">
                            <i class="ti ti-coins me-2 text-primary"></i> 
                            Earnings & Adjustments
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fs-11 fw-bold text-muted">Base Earnings</label>
                                <input type="number" step="0.01" class="form-control finance-input-group border-0 fw-bold" name="basic_salary" id="basic_salary" placeholder="0.00" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fs-11 fw-bold text-muted">Package Allowances</label>
                                <input type="number" step="0.01" class="form-control finance-input-group border-0 text-success" name="allowances" id="allowances" value="0.00">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fs-11 fw-bold text-muted">Overtime</label>
                                <input type="number" step="0.01" class="form-control finance-input-group border-0 text-success" name="overtime" id="overtime" value="0.00">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fs-11 fw-bold text-muted">Bonus</label>
                                <input type="number" step="0.01" class="form-control finance-input-group border-0 text-success" name="bonuses" id="bonuses" value="0.00">
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label fs-11 fw-bold text-muted">Income Tax</label>
                                <input type="number" step="0.01" class="form-control finance-input-group border-0 text-danger" name="tax_deduction" id="tax_deduction" value="0.00">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fs-11 fw-bold text-muted">Provident Fund</label>
                                <input type="number" step="0.01" class="form-control finance-input-group border-0 text-danger" name="provident_fund" id="provident_fund" value="0.00">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fs-11 fw-bold text-muted">Other Deductions</label>
                                <input type="number" step="0.01" class="form-control finance-input-group border-0 text-danger" name="other_deductions" id="other_deductions" value="0.00">
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fs-11 fw-bold text-muted">Disbursement Date</label>
                            <input type="date" class="form-control finance-input-group border-0" name="payment_date" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fs-11 fw-bold text-muted">Control Status</label>
                            <select class="form-select finance-input-group border-0 fw-bold" name="status" required>
                                <option value="draft">Review Pattern (Draft)</option>
                                <option value="approved">Authorize (Approved)</option>
                                <option value="paid" selected>Executed (Paid)</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-5">
                        <button type="submit" class="btn btn-dark rounded-pill px-5 py-3 fw-bold shadow">Authorize Disbursement</button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Live Totals -->
        <div class="col-xl-4">
            <div class="summary-widget shadow-lg">
                <div class="summary-title">Disbursement Summary</div>
                
                <div class="val-line">
                    <span>Gross Earnings</span>
                    <span class="val-highlight" id="sum_gross">AED 0.00</span>
                </div>
                <div class="val-line">
                    <span>Total Retentions</span>
                    <span class="val-highlight text-danger" id="sum_deduction">AED 0.00</span>
                </div>

                <hr class="opacity-10 my-4">

                <div class="text-center">
                    <p class="fs-12 text-muted fw-bold text-uppercase mb-2">Net Payable Amount</p>
                    <div class="big-check" id="sum_net">AED 0.00</div>
                </div>

                <div class="mt-5 pt-5 opacity-25 text-center">
                    <i class="ti ti-lock fs-50"></i>
                    <p class="fs-10 mt-3">Immutable payroll record. Authorized transactions are logged for compliance audits.</p>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function calculate() {
        const v = (id) => parseFloat(document.getElementById(id).value) || 0;
        
        const earnings = v('basic_salary') + v('allowances') + v('overtime') + v('bonuses');
        const retentions = v('tax_deduction') + v('provident_fund') + v('other_deductions');
        const net = earnings - retentions;

        document.getElementById('sum_gross').textContent = 'AED ' + earnings.toLocaleString(undefined, {minimumFractionDigits: 2});
        document.getElementById('sum_deduction').textContent = 'AED ' + retentions.toLocaleString(undefined, {minimumFractionDigits: 2});
        document.getElementById('sum_net').textContent = 'AED ' + net.toLocaleString(undefined, {minimumFractionDigits: 2});
    }

    // Auto-fill from salary choice
    document.getElementById('salary_id').addEventListener('change', function() {
        const opt = this.options[this.selectedIndex];
        if (opt.value) {
            document.getElementById('employee_id').value = opt.dataset.employee;
            document.getElementById('basic_salary').value = opt.dataset.basic;
            document.getElementById('allowances').value = opt.dataset.allowances;
            document.getElementById('tax_deduction').value = opt.dataset.tax;
            document.getElementById('provident_fund').value = opt.dataset.pf;
            calculate();
        }
    });

    ['basic_salary', 'allowances', 'overtime', 'bonuses', 'tax_deduction', 'provident_fund', 'other_deductions'].forEach(id => {
        document.getElementById(id).addEventListener('input', calculate);
    });

    calculate();
</script>

@endsection

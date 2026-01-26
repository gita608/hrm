@extends('layouts.app')

@section('title', 'Create Payslip')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Create Payslip</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('payroll.payslip.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="card">
		<div class="card-header">
			<h5>Payslip Information</h5>
		</div>
		<div class="card-body">
			<form action="{{ route('payroll.payslip.store') }}" method="POST" id="payslipForm">
				@csrf
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Employee <span class="text-danger">*</span></label>
							<select class="form-select @error('employee_id') is-invalid @enderror" name="employee_id" id="employee_id" required>
								<option value="">Select Employee</option>
								@foreach($employees as $employee)
									<option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
								@endforeach
							</select>
							@error('employee_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Salary Record</label>
							<select class="form-select @error('salary_id') is-invalid @enderror" name="salary_id" id="salary_id">
								<option value="">Select Salary Record</option>
								@foreach($salaries as $salary)
									<option value="{{ $salary->id }}" data-employee="{{ $salary->employee_id }}" data-basic="{{ $salary->basic_salary }}" data-allowances="{{ $salary->total_allowances }}" data-tax="{{ $salary->tax_deduction }}" data-pf="{{ $salary->provident_fund }}">{{ $salary->employee->name ?? 'N/A' }} - {{ number_format($salary->net_salary, 2) }}</option>
								@endforeach
							</select>
							@error('salary_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Pay Period Start <span class="text-danger">*</span></label>
							<input type="date" class="form-control @error('pay_period_start') is-invalid @enderror" name="pay_period_start" value="{{ old('pay_period_start', date('Y-m-01')) }}" required>
							@error('pay_period_start')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Pay Period End <span class="text-danger">*</span></label>
							<input type="date" class="form-control @error('pay_period_end') is-invalid @enderror" name="pay_period_end" value="{{ old('pay_period_end', date('Y-m-t')) }}" required>
							@error('pay_period_end')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Payment Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control @error('payment_date') is-invalid @enderror" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required>
							@error('payment_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Status <span class="text-danger">*</span></label>
							<select class="form-select @error('status') is-invalid @enderror" name="status" required>
								<option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
								<option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
								<option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
							</select>
							@error('status')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Basic Salary <span class="text-danger">*</span></label>
							<input type="number" step="0.01" class="form-control @error('basic_salary') is-invalid @enderror" name="basic_salary" id="basic_salary" value="{{ old('basic_salary') }}" required>
							@error('basic_salary')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Allowances</label>
							<input type="number" step="0.01" class="form-control @error('allowances') is-invalid @enderror" name="allowances" id="allowances" value="{{ old('allowances', 0) }}">
							@error('allowances')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Overtime</label>
							<input type="number" step="0.01" class="form-control @error('overtime') is-invalid @enderror" name="overtime" id="overtime" value="{{ old('overtime', 0) }}">
							@error('overtime')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Bonuses</label>
							<input type="number" step="0.01" class="form-control @error('bonuses') is-invalid @enderror" name="bonuses" id="bonuses" value="{{ old('bonuses', 0) }}">
							@error('bonuses')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Tax Deduction</label>
							<input type="number" step="0.01" class="form-control @error('tax_deduction') is-invalid @enderror" name="tax_deduction" id="tax_deduction" value="{{ old('tax_deduction', 0) }}">
							@error('tax_deduction')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Provident Fund</label>
							<input type="number" step="0.01" class="form-control @error('provident_fund') is-invalid @enderror" name="provident_fund" id="provident_fund" value="{{ old('provident_fund', 0) }}">
							@error('provident_fund')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Other Deductions</label>
							<input type="number" step="0.01" class="form-control @error('other_deductions') is-invalid @enderror" name="other_deductions" id="other_deductions" value="{{ old('other_deductions', 0) }}">
							@error('other_deductions')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Working Days</label>
							<input type="number" class="form-control @error('working_days') is-invalid @enderror" name="working_days" value="{{ old('working_days', 0) }}">
							@error('working_days')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Present Days</label>
							<input type="number" class="form-control @error('present_days') is-invalid @enderror" name="present_days" value="{{ old('present_days', 0) }}">
							@error('present_days')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Notes</label>
							<textarea class="form-control @error('notes') is-invalid @enderror" name="notes" rows="3">{{ old('notes') }}</textarea>
							@error('notes')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="alert alert-info">
							<h6>Summary:</h6>
							<p class="mb-1">Gross Salary: <strong id="gross_salary">0.00</strong></p>
							<p class="mb-1">Total Deductions: <strong id="total_deductions">0.00</strong></p>
							<p class="mb-0">Net Salary: <strong id="net_salary">0.00</strong></p>
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2">
					<a href="{{ route('payroll.payslip.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Generate Payslip</button>
				</div>
			</form>
		</div>
	</div>

	<script>
		function calculatePayslip() {
			const basic = parseFloat(document.getElementById('basic_salary').value) || 0;
			const allowances = parseFloat(document.getElementById('allowances').value) || 0;
			const overtime = parseFloat(document.getElementById('overtime').value) || 0;
			const bonuses = parseFloat(document.getElementById('bonuses').value) || 0;
			const tax = parseFloat(document.getElementById('tax_deduction').value) || 0;
			const pf = parseFloat(document.getElementById('provident_fund').value) || 0;
			const otherDed = parseFloat(document.getElementById('other_deductions').value) || 0;

			const grossSalary = basic + allowances + overtime + bonuses;
			const totalDeductions = tax + pf + otherDed;
			const netSalary = grossSalary - totalDeductions;

			document.getElementById('gross_salary').textContent = grossSalary.toFixed(2);
			document.getElementById('total_deductions').textContent = totalDeductions.toFixed(2);
			document.getElementById('net_salary').textContent = netSalary.toFixed(2);
		}

		// Auto-fill from salary record
		document.getElementById('salary_id').addEventListener('change', function() {
			const selectedOption = this.options[this.selectedIndex];
			if (selectedOption.value) {
				document.getElementById('employee_id').value = selectedOption.getAttribute('data-employee');
				document.getElementById('basic_salary').value = selectedOption.getAttribute('data-basic');
				document.getElementById('allowances').value = selectedOption.getAttribute('data-allowances');
				document.getElementById('tax_deduction').value = selectedOption.getAttribute('data-tax');
				document.getElementById('provident_fund').value = selectedOption.getAttribute('data-pf');
				calculatePayslip();
			}
		});

		['basic_salary', 'allowances', 'overtime', 'bonuses', 'tax_deduction', 'provident_fund', 'other_deductions'].forEach(id => {
			document.getElementById(id).addEventListener('input', calculatePayslip);
		});

		calculatePayslip();
	</script>

@endsection

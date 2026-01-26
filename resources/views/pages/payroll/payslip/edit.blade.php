@extends('layouts.app')

@section('title', 'Edit Payslip')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Edit Payslip</h2>
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
			<form action="{{ route('payroll.payslip.update', $payslip->id) }}" method="POST" id="payslipForm">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Employee <span class="text-danger">*</span></label>
							<select class="form-select" name="employee_id" id="employee_id" required>
								<option value="">Select Employee</option>
								@foreach($employees as $employee)
									<option value="{{ $employee->id }}" {{ old('employee_id', $payslip->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Payslip Number</label>
							<input type="text" class="form-control" value="{{ $payslip->payslip_number }}" readonly>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Pay Period Start <span class="text-danger">*</span></label>
							<input type="date" class="form-control" name="pay_period_start" value="{{ old('pay_period_start', $payslip->pay_period_start->format('Y-m-d')) }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Pay Period End <span class="text-danger">*</span></label>
							<input type="date" class="form-control" name="pay_period_end" value="{{ old('pay_period_end', $payslip->pay_period_end->format('Y-m-d')) }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Payment Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control" name="payment_date" value="{{ old('payment_date', $payslip->payment_date->format('Y-m-d')) }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Status <span class="text-danger">*</span></label>
							<select class="form-select" name="status" required>
								<option value="draft" {{ old('status', $payslip->status) == 'draft' ? 'selected' : '' }}>Draft</option>
								<option value="approved" {{ old('status', $payslip->status) == 'approved' ? 'selected' : '' }}>Approved</option>
								<option value="paid" {{ old('status', $payslip->status) == 'paid' ? 'selected' : '' }}>Paid</option>
								<option value="cancelled" {{ old('status', $payslip->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Basic Salary <span class="text-danger">*</span></label>
							<input type="number" step="0.01" class="form-control" name="basic_salary" id="basic_salary" value="{{ old('basic_salary', $payslip->basic_salary) }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Allowances</label>
							<input type="number" step="0.01" class="form-control" name="allowances" id="allowances" value="{{ old('allowances', $payslip->allowances) }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Overtime</label>
							<input type="number" step="0.01" class="form-control" name="overtime" id="overtime" value="{{ old('overtime', $payslip->overtime) }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Bonuses</label>
							<input type="number" step="0.01" class="form-control" name="bonuses" id="bonuses" value="{{ old('bonuses', $payslip->bonuses) }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Tax Deduction</label>
							<input type="number" step="0.01" class="form-control" name="tax_deduction" id="tax_deduction" value="{{ old('tax_deduction', $payslip->tax_deduction) }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Provident Fund</label>
							<input type="number" step="0.01" class="form-control" name="provident_fund" id="provident_fund" value="{{ old('provident_fund', $payslip->provident_fund) }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Other Deductions</label>
							<input type="number" step="0.01" class="form-control" name="other_deductions" id="other_deductions" value="{{ old('other_deductions', $payslip->other_deductions) }}">
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Notes</label>
							<textarea class="form-control" name="notes" rows="3">{{ old('notes', $payslip->notes) }}</textarea>
						</div>
					</div>
					<div class="col-md-12">
						<div class="alert alert-info">
							<h6>Summary:</h6>
							<p class="mb-1">Gross Salary: <strong id="gross_salary">{{ number_format($payslip->gross_salary, 2) }}</strong></p>
							<p class="mb-1">Total Deductions: <strong id="total_deductions">{{ number_format($payslip->total_deductions, 2) }}</strong></p>
							<p class="mb-0">Net Salary: <strong id="net_salary">{{ number_format($payslip->net_salary, 2) }}</strong></p>
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2">
					<a href="{{ route('payroll.payslip.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Update Payslip</button>
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

		['basic_salary', 'allowances', 'overtime', 'bonuses', 'tax_deduction', 'provident_fund', 'other_deductions'].forEach(id => {
			document.getElementById(id).addEventListener('input', calculatePayslip);
		});
	</script>

@endsection

@extends('layouts.app')

@section('title', 'Edit Salary')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Edit Salary</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('payroll.salary.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="card">
		<div class="card-header">
			<h5>Salary Information</h5>
		</div>
		<div class="card-body">
			<form action="{{ route('payroll.salary.update', $salary->id) }}" method="POST" id="salaryForm">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Employee <span class="text-danger">*</span></label>
							<select class="form-select @error('employee_id') is-invalid @enderror" name="employee_id" required>
								<option value="">Select Employee</option>
								@foreach($employees as $employee)
									<option value="{{ $employee->id }}" {{ old('employee_id', $salary->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
								@endforeach
							</select>
							@error('employee_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Basic Salary <span class="text-danger">*</span></label>
							<input type="number" step="0.01" class="form-control @error('basic_salary') is-invalid @enderror" name="basic_salary" id="basic_salary" value="{{ old('basic_salary', $salary->basic_salary) }}" required>
							@error('basic_salary')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Housing Allowance</label>
							<input type="number" step="0.01" class="form-control" name="housing_allowance" id="housing_allowance" value="{{ old('housing_allowance', $salary->housing_allowance) }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Transport Allowance</label>
							<input type="number" step="0.01" class="form-control" name="transport_allowance" id="transport_allowance" value="{{ old('transport_allowance', $salary->transport_allowance) }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Food Allowance</label>
							<input type="number" step="0.01" class="form-control" name="food_allowance" id="food_allowance" value="{{ old('food_allowance', $salary->food_allowance) }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Other Allowances</label>
							<input type="number" step="0.01" class="form-control" name="other_allowances" id="other_allowances" value="{{ old('other_allowances', $salary->other_allowances) }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Tax Deduction</label>
							<input type="number" step="0.01" class="form-control" name="tax_deduction" id="tax_deduction" value="{{ old('tax_deduction', $salary->tax_deduction) }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Provident Fund</label>
							<input type="number" step="0.01" class="form-control" name="provident_fund" id="provident_fund" value="{{ old('provident_fund', $salary->provident_fund) }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Other Deductions</label>
							<input type="number" step="0.01" class="form-control" name="other_deductions" id="other_deductions" value="{{ old('other_deductions', $salary->other_deductions) }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Effective From <span class="text-danger">*</span></label>
							<input type="date" class="form-control" name="effective_from" value="{{ old('effective_from', $salary->effective_from->format('Y-m-d')) }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Status <span class="text-danger">*</span></label>
							<select class="form-select" name="status" required>
								<option value="active" {{ old('status', $salary->status) == 'active' ? 'selected' : '' }}>Active</option>
								<option value="inactive" {{ old('status', $salary->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Notes</label>
							<textarea class="form-control" name="notes" rows="3">{{ old('notes', $salary->notes) }}</textarea>
						</div>
					</div>
					<div class="col-md-12">
						<div class="alert alert-info">
							<h6>Summary:</h6>
							<p class="mb-1">Total Allowances: <strong id="total_allowances">{{ number_format($salary->total_allowances, 2) }}</strong></p>
							<p class="mb-1">Gross Salary: <strong id="gross_salary">{{ number_format($salary->gross_salary, 2) }}</strong></p>
							<p class="mb-1">Total Deductions: <strong id="total_deductions">{{ number_format($salary->total_deductions, 2) }}</strong></p>
							<p class="mb-0">Net Salary: <strong id="net_salary">{{ number_format($salary->net_salary, 2) }}</strong></p>
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2">
					<a href="{{ route('payroll.salary.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Update Salary</button>
				</div>
			</form>
		</div>
	</div>

	<script>
		function calculateSalary() {
			const basic = parseFloat(document.getElementById('basic_salary').value) || 0;
			const housing = parseFloat(document.getElementById('housing_allowance').value) || 0;
			const transport = parseFloat(document.getElementById('transport_allowance').value) || 0;
			const food = parseFloat(document.getElementById('food_allowance').value) || 0;
			const other = parseFloat(document.getElementById('other_allowances').value) || 0;
			const tax = parseFloat(document.getElementById('tax_deduction').value) || 0;
			const pf = parseFloat(document.getElementById('provident_fund').value) || 0;
			const otherDed = parseFloat(document.getElementById('other_deductions').value) || 0;

			const totalAllowances = housing + transport + food + other;
			const grossSalary = basic + totalAllowances;
			const totalDeductions = tax + pf + otherDed;
			const netSalary = grossSalary - totalDeductions;

			document.getElementById('total_allowances').textContent = totalAllowances.toFixed(2);
			document.getElementById('gross_salary').textContent = grossSalary.toFixed(2);
			document.getElementById('total_deductions').textContent = totalDeductions.toFixed(2);
			document.getElementById('net_salary').textContent = netSalary.toFixed(2);
		}

		['basic_salary', 'housing_allowance', 'transport_allowance', 'food_allowance', 'other_allowances', 'tax_deduction', 'provident_fund', 'other_deductions'].forEach(id => {
			document.getElementById(id).addEventListener('input', calculateSalary);
		});
	</script>

@endsection

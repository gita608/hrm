@extends('layouts.app')

@section('title', 'Create Salary')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Create Salary</h2>
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
			<form action="{{ route('payroll.salary.store') }}" method="POST" id="salaryForm">
				@csrf
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Employee <span class="text-danger">*</span></label>
							<select class="form-select @error('employee_id') is-invalid @enderror" name="employee_id" required>
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
							<label class="form-label">Basic Salary <span class="text-danger">*</span></label>
							<input type="number" step="0.01" class="form-control @error('basic_salary') is-invalid @enderror" name="basic_salary" id="basic_salary" value="{{ old('basic_salary') }}" required>
							@error('basic_salary')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Housing Allowance</label>
							<input type="number" step="0.01" class="form-control @error('housing_allowance') is-invalid @enderror" name="housing_allowance" id="housing_allowance" value="{{ old('housing_allowance', 0) }}">
							@error('housing_allowance')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Transport Allowance</label>
							<input type="number" step="0.01" class="form-control @error('transport_allowance') is-invalid @enderror" name="transport_allowance" id="transport_allowance" value="{{ old('transport_allowance', 0) }}">
							@error('transport_allowance')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Food Allowance</label>
							<input type="number" step="0.01" class="form-control @error('food_allowance') is-invalid @enderror" name="food_allowance" id="food_allowance" value="{{ old('food_allowance', 0) }}">
							@error('food_allowance')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Other Allowances</label>
							<input type="number" step="0.01" class="form-control @error('other_allowances') is-invalid @enderror" name="other_allowances" id="other_allowances" value="{{ old('other_allowances', 0) }}">
							@error('other_allowances')
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
							<label class="form-label">Effective From <span class="text-danger">*</span></label>
							<input type="date" class="form-control @error('effective_from') is-invalid @enderror" name="effective_from" value="{{ old('effective_from', date('Y-m-d')) }}" required>
							@error('effective_from')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Effective To</label>
							<input type="date" class="form-control @error('effective_to') is-invalid @enderror" name="effective_to" value="{{ old('effective_to') }}">
							@error('effective_to')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Status <span class="text-danger">*</span></label>
							<select class="form-select @error('status') is-invalid @enderror" name="status" required>
								<option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
								<option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
							</select>
							@error('status')
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
							<p class="mb-1">Total Allowances: <strong id="total_allowances">0.00</strong></p>
							<p class="mb-1">Gross Salary: <strong id="gross_salary">0.00</strong></p>
							<p class="mb-1">Total Deductions: <strong id="total_deductions">0.00</strong></p>
							<p class="mb-0">Net Salary: <strong id="net_salary">0.00</strong></p>
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2">
					<a href="{{ route('payroll.salary.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Save Salary</button>
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

		calculateSalary();
	</script>

@endsection

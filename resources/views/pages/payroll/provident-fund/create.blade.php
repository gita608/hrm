@extends('layouts.app')

@section('title', 'Create Provident Fund')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Create Provident Fund Contribution</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('payroll.provident-fund.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="card">
		<div class="card-header">
			<h5>Provident Fund Information</h5>
		</div>
		<div class="card-body">
			<form action="{{ route('payroll.provident-fund.store') }}" method="POST">
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
							<label class="form-label">Contribution Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control @error('contribution_date') is-invalid @enderror" name="contribution_date" value="{{ old('contribution_date', date('Y-m-d')) }}" required>
							@error('contribution_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Month <span class="text-danger">*</span></label>
							<select class="form-select @error('month') is-invalid @enderror" name="month" required>
								<option value="">Select Month</option>
								@foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
									<option value="{{ $month }}" {{ old('month', date('F')) == $month ? 'selected' : '' }}>{{ $month }}</option>
								@endforeach
							</select>
							@error('month')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Year <span class="text-danger">*</span></label>
							<input type="number" class="form-control @error('year') is-invalid @enderror" name="year" value="{{ old('year', date('Y')) }}" min="2000" max="2100" required>
							@error('year')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Employee Percentage (%)</label>
							<input type="number" step="0.01" class="form-control @error('employee_percentage') is-invalid @enderror" name="employee_percentage" value="{{ old('employee_percentage', 5) }}">
							@error('employee_percentage')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Employer Percentage (%)</label>
							<input type="number" step="0.01" class="form-control @error('employer_percentage') is-invalid @enderror" name="employer_percentage" value="{{ old('employer_percentage', 5) }}">
							@error('employer_percentage')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Employee Contribution</label>
							<input type="number" step="0.01" class="form-control @error('employee_contribution') is-invalid @enderror" name="employee_contribution" value="{{ old('employee_contribution', 0) }}">
							@error('employee_contribution')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Employer Contribution</label>
							<input type="number" step="0.01" class="form-control @error('employer_contribution') is-invalid @enderror" name="employer_contribution" value="{{ old('employer_contribution', 0) }}">
							@error('employer_contribution')
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
				</div>
				<div class="d-flex justify-content-end gap-2">
					<a href="{{ route('payroll.provident-fund.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Save Contribution</button>
				</div>
			</form>
		</div>
	</div>

@endsection

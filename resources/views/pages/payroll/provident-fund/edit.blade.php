@extends('layouts.app')

@section('title', 'Edit Provident Fund')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Edit Provident Fund</h2>
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
			<form action="{{ route('payroll.provident-fund.update', $providentFund->id) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Employee <span class="text-danger">*</span></label>
							<select class="form-select" name="employee_id" required>
								<option value="">Select Employee</option>
								@foreach($employees as $employee)
									<option value="{{ $employee->id }}" {{ old('employee_id', $providentFund->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Contribution Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control" name="contribution_date" value="{{ old('contribution_date', $providentFund->contribution_date->format('Y-m-d')) }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Month <span class="text-danger">*</span></label>
							<select class="form-select" name="month" required>
								@foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
									<option value="{{ $month }}" {{ old('month', $providentFund->month) == $month ? 'selected' : '' }}>{{ $month }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Year <span class="text-danger">*</span></label>
							<input type="number" class="form-control" name="year" value="{{ old('year', $providentFund->year) }}" min="2000" max="2100" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Employee Contribution</label>
							<input type="number" step="0.01" class="form-control" name="employee_contribution" value="{{ old('employee_contribution', $providentFund->employee_contribution) }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Employer Contribution</label>
							<input type="number" step="0.01" class="form-control" name="employer_contribution" value="{{ old('employer_contribution', $providentFund->employer_contribution) }}">
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Notes</label>
							<textarea class="form-control" name="notes" rows="3">{{ old('notes', $providentFund->notes) }}</textarea>
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2">
					<a href="{{ route('payroll.provident-fund.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Update Contribution</button>
				</div>
			</form>
		</div>
	</div>

@endsection

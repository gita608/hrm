@extends('layouts.app')

@section('title', 'Create Promotion')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Create Promotion</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('promotions.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="card">
		<div class="card-header">
			<h5>Promotion Information</h5>
		</div>
		<div class="card-body">
			<form action="{{ route('promotions.store') }}" method="POST">
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
							<label class="form-label">Promotion Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control @error('promotion_date') is-invalid @enderror" name="promotion_date" value="{{ old('promotion_date') }}" required>
							@error('promotion_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">From Department</label>
							<select class="form-select @error('from_department_id') is-invalid @enderror" name="from_department_id">
								<option value="">Select Department</option>
								@foreach($departments as $department)
									<option value="{{ $department->id }}" {{ old('from_department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
								@endforeach
							</select>
							@error('from_department_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">To Department</label>
							<select class="form-select @error('to_department_id') is-invalid @enderror" name="to_department_id">
								<option value="">Select Department</option>
								@foreach($departments as $department)
									<option value="{{ $department->id }}" {{ old('to_department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
								@endforeach
							</select>
							@error('to_department_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">From Designation</label>
							<select class="form-select @error('from_designation_id') is-invalid @enderror" name="from_designation_id">
								<option value="">Select Designation</option>
								@foreach($designations as $designation)
									<option value="{{ $designation->id }}" {{ old('from_designation_id') == $designation->id ? 'selected' : '' }}>{{ $designation->name }}</option>
								@endforeach
							</select>
							@error('from_designation_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">To Designation</label>
							<select class="form-select @error('to_designation_id') is-invalid @enderror" name="to_designation_id">
								<option value="">Select Designation</option>
								@foreach($designations as $designation)
									<option value="{{ $designation->id }}" {{ old('to_designation_id') == $designation->id ? 'selected' : '' }}>{{ $designation->name }}</option>
								@endforeach
							</select>
							@error('to_designation_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Salary</label>
							<input type="number" step="0.01" class="form-control @error('salary') is-invalid @enderror" name="salary" value="{{ old('salary') }}">
							@error('salary')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Status</label>
							<select class="form-select @error('is_active') is-invalid @enderror" name="is_active">
								<option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
								<option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
							</select>
							@error('is_active')
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
					<a href="{{ route('promotions.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Save Promotion</button>
				</div>
			</form>
		</div>
	</div>

@endsection

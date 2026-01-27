@extends('layouts.app')

@section('title', 'Create Promotion')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Create Promotion</h2>
			<p class="text-muted mb-0 fs-13">Record a new employee promotion</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('promotions.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
			<h5 class="mb-0 fw-bold text-dark">Promotion Information</h5>
		</div>
		<div class="card-body p-4">
			<form action="{{ route('promotions.store') }}" method="POST">
				@csrf
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Employee <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none @error('employee_id') is-invalid @enderror" name="employee_id" required>
								<option value="">Select Employee</option>
								@foreach($employees as $employee)
									<option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
								@endforeach
							</select>
							@error('employee_id')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Promotion Date <span class="text-danger">*</span></label>
							<div class="input-group">
								<span class="input-group-text bg-light border-light"><i class="ti ti-calendar"></i></span>
								<input type="date" class="form-control rounded-end-3 border-light shadow-none @error('promotion_date') is-invalid @enderror" name="promotion_date" value="{{ old('promotion_date') }}" required>
							</div>
							@error('promotion_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>

					<div class="col-md-12">
						<div class="card bg-light-50 border-0 rounded-3 mb-3">
							<div class="card-body">
								<h6 class="fw-bold text-dark mb-3">Department Change</h6>
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3 mb-md-0">
											<label class="form-label text-muted fs-12 text-uppercase fw-medium">From Department</label>
											<select class="form-select rounded-3 border-light shadow-none @error('from_department_id') is-invalid @enderror" name="from_department_id">
												<option value="">Select Department</option>
												@foreach($departments as $department)
													<option value="{{ $department->id }}" {{ old('from_department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
												@endforeach
											</select>
											@error('from_department_id')
												<div class="invalid-feedback d-block">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-0">
											<label class="form-label text-muted fs-12 text-uppercase fw-medium">To Department</label>
											<select class="form-select rounded-3 border-light shadow-none @error('to_department_id') is-invalid @enderror" name="to_department_id">
												<option value="">Select Department</option>
												@foreach($departments as $department)
													<option value="{{ $department->id }}" {{ old('to_department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
												@endforeach
											</select>
											@error('to_department_id')
												<div class="invalid-feedback d-block">{{ $message }}</div>
											@enderror
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-12">
						<div class="card bg-light-50 border-0 rounded-3 mb-3">
							<div class="card-body">
								<h6 class="fw-bold text-dark mb-3">Designation Change</h6>
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3 mb-md-0">
											<label class="form-label text-muted fs-12 text-uppercase fw-medium">From Designation</label>
											<select class="form-select rounded-3 border-light shadow-none @error('from_designation_id') is-invalid @enderror" name="from_designation_id">
												<option value="">Select Designation</option>
												@foreach($designations as $designation)
													<option value="{{ $designation->id }}" {{ old('from_designation_id') == $designation->id ? 'selected' : '' }}>{{ $designation->name }}</option>
												@endforeach
											</select>
											@error('from_designation_id')
												<div class="invalid-feedback d-block">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-0">
											<label class="form-label text-muted fs-12 text-uppercase fw-medium">To Designation</label>
											<select class="form-select rounded-3 border-light shadow-none @error('to_designation_id') is-invalid @enderror" name="to_designation_id">
												<option value="">Select Designation</option>
												@foreach($designations as $designation)
													<option value="{{ $designation->id }}" {{ old('to_designation_id') == $designation->id ? 'selected' : '' }}>{{ $designation->name }}</option>
												@endforeach
											</select>
											@error('to_designation_id')
												<div class="invalid-feedback d-block">{{ $message }}</div>
											@enderror
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Salary Increase Amount</label>
							<div class="input-group">
								<span class="input-group-text bg-light border-light">$</span>
								<input type="number" step="0.01" class="form-control rounded-end-3 border-light shadow-none @error('salary') is-invalid @enderror" name="salary" value="{{ old('salary') }}">
							</div>
							@error('salary')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Record Status</label>
							<select class="form-select rounded-3 border-light shadow-none @error('is_active') is-invalid @enderror" name="is_active">
								<option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
								<option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
							</select>
							@error('is_active')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Notes</label>
							<textarea class="form-control rounded-3 border-light shadow-none @error('notes') is-invalid @enderror" name="notes" rows="3">{{ old('notes') }}</textarea>
							@error('notes')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2 mt-4">
					<a href="{{ route('promotions.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
					<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Save Promotion</button>
				</div>
			</form>
		</div>
	</div>

@endsection

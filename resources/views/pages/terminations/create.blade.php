@extends('layouts.app')

@section('title', 'Create Termination')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Create Termination</h2>
			<p class="text-muted mb-0 fs-13">Record a new employee termination</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('terminations.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
			<h5 class="mb-0 fw-bold text-dark">Termination Information</h5>
		</div>
		<div class="card-body p-4">
			<form action="{{ route('terminations.store') }}" method="POST">
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
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Termination Date <span class="text-danger">*</span></label>
							<div class="input-group">
								<span class="input-group-text bg-light border-light"><i class="ti ti-calendar"></i></span>
								<input type="date" class="form-control rounded-end-3 border-light shadow-none @error('termination_date') is-invalid @enderror" name="termination_date" value="{{ old('termination_date') }}" required>
							</div>
							@error('termination_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Notice Date</label>
							<div class="input-group">
								<span class="input-group-text bg-light border-light"><i class="ti ti-calendar"></i></span>
								<input type="date" class="form-control rounded-end-3 border-light shadow-none @error('notice_date') is-invalid @enderror" name="notice_date" value="{{ old('notice_date') }}">
							</div>
							@error('notice_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Type <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none @error('type') is-invalid @enderror" name="type" required>
								<option value="">Select Type</option>
								<option value="voluntary" {{ old('type') == 'voluntary' ? 'selected' : '' }}>Voluntary</option>
								<option value="involuntary" {{ old('type', 'involuntary') == 'involuntary' ? 'selected' : '' }}>Involuntary</option>
								<option value="retirement" {{ old('type') == 'retirement' ? 'selected' : '' }}>Retirement</option>
								<option value="end_of_contract" {{ old('type') == 'end_of_contract' ? 'selected' : '' }}>End of Contract</option>
								<option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
							</select>
							@error('type')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Status</label>
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
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Reason</label>
							<textarea class="form-control rounded-3 border-light shadow-none @error('reason') is-invalid @enderror" name="reason" rows="3">{{ old('reason') }}</textarea>
							@error('reason')
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

				<!-- UAE-Specific Information Section -->
				<hr class="my-4 border-light">
				<h5 class="mb-3 fw-bold text-dark">UAE-Specific Information</h5>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Visa Cancellation Date</label>
							<div class="input-group">
								<span class="input-group-text bg-light border-light"><i class="ti ti-calendar"></i></span>
								<input type="date" class="form-control rounded-end-3 border-light shadow-none @error('visa_cancellation_date') is-invalid @enderror" name="visa_cancellation_date" value="{{ old('visa_cancellation_date') }}">
							</div>
							@error('visa_cancellation_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Labor Card Cancellation Date</label>
							<div class="input-group">
								<span class="input-group-text bg-light border-light"><i class="ti ti-calendar"></i></span>
								<input type="date" class="form-control rounded-end-3 border-light shadow-none @error('labor_card_cancellation_date') is-invalid @enderror" name="labor_card_cancellation_date" value="{{ old('labor_card_cancellation_date') }}">
							</div>
							@error('labor_card_cancellation_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2 mt-4">
					<a href="{{ route('terminations.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
					<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Save Termination</button>
				</div>
			</form>
		</div>
	</div>

@endsection

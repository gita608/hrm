@extends('layouts.app')

@section('title', 'Create Termination')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Create Termination</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('terminations.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="card">
		<div class="card-header">
			<h5>Termination Information</h5>
		</div>
		<div class="card-body">
			<form action="{{ route('terminations.store') }}" method="POST">
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
							<label class="form-label">Termination Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control @error('termination_date') is-invalid @enderror" name="termination_date" value="{{ old('termination_date') }}" required>
							@error('termination_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Notice Date</label>
							<input type="date" class="form-control @error('notice_date') is-invalid @enderror" name="notice_date" value="{{ old('notice_date') }}">
							@error('notice_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Type <span class="text-danger">*</span></label>
							<select class="form-select @error('type') is-invalid @enderror" name="type" required>
								<option value="">Select Type</option>
								<option value="voluntary" {{ old('type') == 'voluntary' ? 'selected' : '' }}>Voluntary</option>
								<option value="involuntary" {{ old('type', 'involuntary') == 'involuntary' ? 'selected' : '' }}>Involuntary</option>
								<option value="retirement" {{ old('type') == 'retirement' ? 'selected' : '' }}>Retirement</option>
								<option value="end_of_contract" {{ old('type') == 'end_of_contract' ? 'selected' : '' }}>End of Contract</option>
								<option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
							</select>
							@error('type')
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
							<label class="form-label">Reason</label>
							<textarea class="form-control @error('reason') is-invalid @enderror" name="reason" rows="3">{{ old('reason') }}</textarea>
							@error('reason')
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

				<!-- UAE-Specific Information Section -->
				<hr class="my-4">
				<h5 class="mb-3">UAE-Specific Information</h5>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Visa Cancellation Date</label>
							<input type="date" class="form-control @error('visa_cancellation_date') is-invalid @enderror" name="visa_cancellation_date" value="{{ old('visa_cancellation_date') }}">
							@error('visa_cancellation_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Labor Card Cancellation Date</label>
							<input type="date" class="form-control @error('labor_card_cancellation_date') is-invalid @enderror" name="labor_card_cancellation_date" value="{{ old('labor_card_cancellation_date') }}">
							@error('labor_card_cancellation_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2">
					<a href="{{ route('terminations.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Save Termination</button>
				</div>
			</form>
		</div>
	</div>

@endsection

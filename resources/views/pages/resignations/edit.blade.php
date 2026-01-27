@extends('layouts.app')

@section('title', 'Edit Resignation')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Edit Resignation</h2>
			<p class="text-muted mb-0 fs-13">Update resignation records</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('resignations.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
			<h5 class="mb-0 fw-bold text-dark">Resignation Information</h5>
		</div>
		<div class="card-body p-4">
			<form action="{{ route('resignations.update', $resignation->id) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Employee <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none @error('employee_id') is-invalid @enderror" name="employee_id" required>
								<option value="">Select Employee</option>
								@foreach($employees as $employee)
									<option value="{{ $employee->id }}" {{ old('employee_id', $resignation->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
								@endforeach
							</select>
							@error('employee_id')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Resignation Date <span class="text-danger">*</span></label>
							<div class="input-group">
								<span class="input-group-text bg-light border-light"><i class="ti ti-calendar"></i></span>
								<input type="date" class="form-control rounded-end-3 border-light shadow-none @error('resignation_date') is-invalid @enderror" name="resignation_date" value="{{ old('resignation_date', $resignation->resignation_date->format('Y-m-d')) }}" required>
							</div>
							@error('resignation_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Notice Date</label>
							<div class="input-group">
								<span class="input-group-text bg-light border-light"><i class="ti ti-calendar"></i></span>
								<input type="date" class="form-control rounded-end-3 border-light shadow-none @error('notice_date') is-invalid @enderror" name="notice_date" value="{{ old('notice_date', $resignation->notice_date ? $resignation->notice_date->format('Y-m-d') : '') }}">
							</div>
							@error('notice_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Last Working Day</label>
							<div class="input-group">
								<span class="input-group-text bg-light border-light"><i class="ti ti-calendar"></i></span>
								<input type="date" class="form-control rounded-end-3 border-light shadow-none @error('last_working_day') is-invalid @enderror" name="last_working_day" value="{{ old('last_working_day', $resignation->last_working_day ? $resignation->last_working_day->format('Y-m-d') : '') }}">
							</div>
							@error('last_working_day')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Status <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none @error('status') is-invalid @enderror" name="status" required>
								<option value="">Select Status</option>
								<option value="pending" {{ old('status', $resignation->status) == 'pending' ? 'selected' : '' }}>Pending</option>
								<option value="accepted" {{ old('status', $resignation->status) == 'accepted' ? 'selected' : '' }}>Accepted</option>
								<option value="rejected" {{ old('status', $resignation->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
								<option value="withdrawn" {{ old('status', $resignation->status) == 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
							</select>
							@error('status')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Record Status</label>
							<select class="form-select rounded-3 border-light shadow-none @error('is_active') is-invalid @enderror" name="is_active">
								<option value="1" {{ old('is_active', $resignation->is_active) == '1' ? 'selected' : '' }}>Active</option>
								<option value="0" {{ old('is_active', $resignation->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
							</select>
							@error('is_active')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Reason</label>
							<textarea class="form-control rounded-3 border-light shadow-none @error('reason') is-invalid @enderror" name="reason" rows="3">{{ old('reason', $resignation->reason) }}</textarea>
							@error('reason')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Notes</label>
							<textarea class="form-control rounded-3 border-light shadow-none @error('notes') is-invalid @enderror" name="notes" rows="3">{{ old('notes', $resignation->notes) }}</textarea>
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
								<input type="date" class="form-control rounded-end-3 border-light shadow-none @error('visa_cancellation_date') is-invalid @enderror" name="visa_cancellation_date" value="{{ old('visa_cancellation_date', $resignation->visa_cancellation_date?->format('Y-m-d')) }}">
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
								<input type="date" class="form-control rounded-end-3 border-light shadow-none @error('labor_card_cancellation_date') is-invalid @enderror" name="labor_card_cancellation_date" value="{{ old('labor_card_cancellation_date', $resignation->labor_card_cancellation_date?->format('Y-m-d')) }}">
							</div>
							@error('labor_card_cancellation_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2 mt-4">
					<a href="{{ route('resignations.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
					<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Update Resignation</button>
				</div>
			</form>
		</div>
	</div>

@endsection

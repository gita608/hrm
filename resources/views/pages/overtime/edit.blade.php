@extends('layouts.app')

@section('title', 'Edit Overtime')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Edit Overtime</h2>
			<p class="text-muted mb-0 fs-13">Update overtime request details</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('overtime.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
			<h5 class="mb-0 fw-bold text-dark">Overtime Information</h5>
		</div>
		<div class="card-body p-4">
			<form action="{{ route('overtime.update', $overtime->id) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Employee <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none" name="employee_id" required>
								<option value="">Select Employee</option>
								@foreach($employees as $employee)
									<option value="{{ $employee->id }}" {{ old('employee_id', $overtime->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
								@endforeach
							</select>
							@error('employee_id')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control rounded-3 border-light shadow-none" name="date" value="{{ old('date', $overtime->date->format('Y-m-d')) }}" required>
							@error('date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Start Time <span class="text-danger">*</span></label>
							<input type="time" class="form-control rounded-3 border-light shadow-none" name="start_time" value="{{ old('start_time', date('H:i', strtotime($overtime->start_time))) }}" required>
							@error('start_time')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">End Time <span class="text-danger">*</span></label>
							<input type="time" class="form-control rounded-3 border-light shadow-none" name="end_time" value="{{ old('end_time', date('H:i', strtotime($overtime->end_time))) }}" required>
							@error('end_time')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Status <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none" name="status" required>
								<option value="pending" {{ old('status', $overtime->status) == 'pending' ? 'selected' : '' }}>Pending</option>
								<option value="approved" {{ old('status', $overtime->status) == 'approved' ? 'selected' : '' }}>Approved</option>
								<option value="rejected" {{ old('status', $overtime->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
							</select>
							@error('status')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Hours</label>
							<input type="text" class="form-control rounded-3 border-light shadow-none bg-light-subtle" value="{{ number_format($overtime->hours, 2) }} hrs" readonly>
							<small class="text-muted">Calculated automatically</small>
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Reason</label>
							<textarea class="form-control rounded-3 border-light shadow-none" name="reason" rows="3" placeholder="Enter reason for overtime...">{{ old('reason', $overtime->reason) }}</textarea>
							@error('reason')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Notes</label>
							<textarea class="form-control rounded-3 border-light shadow-none" name="notes" rows="3" placeholder="Additional notes...">{{ old('notes', $overtime->notes) }}</textarea>
							@error('notes')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2 mt-3">
					<a href="{{ route('overtime.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
					<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Update Overtime</button>
				</div>
			</form>
		</div>
	</div>

@endsection

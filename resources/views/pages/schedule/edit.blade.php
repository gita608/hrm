@extends('layouts.app')

@section('title', 'Edit Schedule')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Edit Schedule</h2>
			<p class="text-muted mb-0 fs-13">Update employee shift schedule</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('schedule.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	@if(session('error'))
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			{{ session('error') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
			<h5 class="mb-0 fw-bold text-dark">Schedule Information</h5>
		</div>
		<div class="card-body p-4">
			<form action="{{ route('schedule.update', $schedule->id) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Employee <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none" name="employee_id" required>
								<option value="">Select Employee</option>
								@foreach($employees as $employee)
									<option value="{{ $employee->id }}" {{ old('employee_id', $schedule->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
								@endforeach
							</select>
							@error('employee_id')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Shift Type <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none" name="shift_type_id" id="shift_type_id" required>
								<option value="">Select Shift Type</option>
								@foreach($shiftTypes as $shiftType)
									<option value="{{ $shiftType->id }}" 
										data-start-time="{{ date('H:i', strtotime($shiftType->start_time)) }}"
										data-end-time="{{ date('H:i', strtotime($shiftType->end_time)) }}"
										{{ old('shift_type_id', $schedule->shift_type_id) == $shiftType->id ? 'selected' : '' }}>{{ $shiftType->name }}</option>
								@endforeach
							</select>
							@error('shift_type_id')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control rounded-3 border-light shadow-none" name="date" value="{{ old('date', $schedule->date->format('Y-m-d')) }}" required>
							@error('date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Status <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none" name="status" required>
								<option value="scheduled" {{ old('status', $schedule->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
								<option value="completed" {{ old('status', $schedule->status) == 'completed' ? 'selected' : '' }}>Completed</option>
								<option value="cancelled" {{ old('status', $schedule->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
								<option value="absent" {{ old('status', $schedule->status) == 'absent' ? 'selected' : '' }}>Absent</option>
							</select>
							@error('status')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Start Time</label>
							<input type="time" class="form-control rounded-3 border-light shadow-none" name="start_time" id="start_time" value="{{ old('start_time', $schedule->start_time ? date('H:i', strtotime($schedule->start_time)) : '') }}">
							@error('start_time')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">End Time</label>
							<input type="time" class="form-control rounded-3 border-light shadow-none" name="end_time" id="end_time" value="{{ old('end_time', $schedule->end_time ? date('H:i', strtotime($schedule->end_time)) : '') }}">
							@error('end_time')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Notes</label>
							<textarea class="form-control rounded-3 border-light shadow-none" name="notes" rows="3" placeholder="Additional notes">{{ old('notes', $schedule->notes) }}</textarea>
							@error('notes')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2 mt-3">
					<a href="{{ route('schedule.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
					<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Update Schedule</button>
				</div>
			</form>
		</div>
	</div>

	<script>
		document.getElementById('shift_type_id').addEventListener('change', function() {
			const selectedOption = this.options[this.selectedIndex];
			const startTime = selectedOption.getAttribute('data-start-time');
			const endTime = selectedOption.getAttribute('data-end-time');
			
			if (startTime && !document.getElementById('start_time').value) {
				document.getElementById('start_time').value = startTime;
			}
			if (endTime && !document.getElementById('end_time').value) {
				document.getElementById('end_time').value = endTime;
			}
		});
	</script>

@endsection

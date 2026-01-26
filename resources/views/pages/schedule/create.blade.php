@extends('layouts.app')

@section('title', 'Create Schedule')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Create Schedule</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('schedule.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	@if(session('error'))
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			{{ session('error') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	<div class="card">
		<div class="card-header">
			<h5>Schedule Information</h5>
		</div>
		<div class="card-body">
			<form action="{{ route('schedule.store') }}" method="POST">
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
							<label class="form-label">Shift Type <span class="text-danger">*</span></label>
							<select class="form-select @error('shift_type_id') is-invalid @enderror" name="shift_type_id" id="shift_type_id" required>
								<option value="">Select Shift Type</option>
								@foreach($shiftTypes as $shiftType)
									<option value="{{ $shiftType->id }}" 
										data-start-time="{{ date('H:i', strtotime($shiftType->start_time)) }}"
										data-end-time="{{ date('H:i', strtotime($shiftType->end_time)) }}"
										{{ old('shift_type_id') == $shiftType->id ? 'selected' : '' }}>{{ $shiftType->name }}</option>
								@endforeach
							</select>
							@error('shift_type_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
							@error('date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Status <span class="text-danger">*</span></label>
							<select class="form-select @error('status') is-invalid @enderror" name="status" required>
								<option value="scheduled" {{ old('status', 'scheduled') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
								<option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
								<option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
								<option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>Absent</option>
							</select>
							@error('status')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Start Time <small class="text-muted">(Leave empty to use shift type default)</small></label>
							<input type="time" class="form-control @error('start_time') is-invalid @enderror" name="start_time" id="start_time" value="{{ old('start_time') }}">
							@error('start_time')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">End Time <small class="text-muted">(Leave empty to use shift type default)</small></label>
							<input type="time" class="form-control @error('end_time') is-invalid @enderror" name="end_time" id="end_time" value="{{ old('end_time') }}">
							@error('end_time')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Notes</label>
							<textarea class="form-control @error('notes') is-invalid @enderror" name="notes" rows="3" placeholder="Additional notes">{{ old('notes') }}</textarea>
							@error('notes')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2">
					<a href="{{ route('schedule.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Save Schedule</button>
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

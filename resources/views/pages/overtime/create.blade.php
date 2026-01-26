@extends('layouts.app')

@section('title', 'Create Overtime')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Create Overtime</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('overtime.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="card">
		<div class="card-header">
			<h5>Overtime Information</h5>
		</div>
		<div class="card-body">
			<form action="{{ route('overtime.store') }}" method="POST">
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
							<label class="form-label">Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
							@error('date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Start Time <span class="text-danger">*</span></label>
							<input type="time" class="form-control @error('start_time') is-invalid @enderror" name="start_time" value="{{ old('start_time') }}" required>
							@error('start_time')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">End Time <span class="text-danger">*</span></label>
							<input type="time" class="form-control @error('end_time') is-invalid @enderror" name="end_time" value="{{ old('end_time') }}" required>
							@error('end_time')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Reason</label>
							<textarea class="form-control @error('reason') is-invalid @enderror" name="reason" rows="3" placeholder="Enter reason for overtime">{{ old('reason') }}</textarea>
							@error('reason')
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
					<a href="{{ route('overtime.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Save Overtime</button>
				</div>
			</form>
		</div>
	</div>

@endsection

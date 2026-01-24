@extends('layouts.app')

@section('title', 'Edit Resignation')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Edit Resignation</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('resignations.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="card">
		<div class="card-header">
			<h5>Resignation Information</h5>
		</div>
		<div class="card-body">
			<form action="{{ route('resignations.update', $resignation->id) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Employee <span class="text-danger">*</span></label>
							<select class="form-select @error('employee_id') is-invalid @enderror" name="employee_id" required>
								<option value="">Select Employee</option>
								@foreach($employees as $employee)
									<option value="{{ $employee->id }}" {{ old('employee_id', $resignation->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
								@endforeach
							</select>
							@error('employee_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Resignation Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control @error('resignation_date') is-invalid @enderror" name="resignation_date" value="{{ old('resignation_date', $resignation->resignation_date->format('Y-m-d')) }}" required>
							@error('resignation_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Notice Date</label>
							<input type="date" class="form-control @error('notice_date') is-invalid @enderror" name="notice_date" value="{{ old('notice_date', $resignation->notice_date ? $resignation->notice_date->format('Y-m-d') : '') }}">
							@error('notice_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Last Working Day</label>
							<input type="date" class="form-control @error('last_working_day') is-invalid @enderror" name="last_working_day" value="{{ old('last_working_day', $resignation->last_working_day ? $resignation->last_working_day->format('Y-m-d') : '') }}">
							@error('last_working_day')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Status <span class="text-danger">*</span></label>
							<select class="form-select @error('status') is-invalid @enderror" name="status" required>
								<option value="">Select Status</option>
								<option value="pending" {{ old('status', $resignation->status) == 'pending' ? 'selected' : '' }}>Pending</option>
								<option value="accepted" {{ old('status', $resignation->status) == 'accepted' ? 'selected' : '' }}>Accepted</option>
								<option value="rejected" {{ old('status', $resignation->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
								<option value="withdrawn" {{ old('status', $resignation->status) == 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
							</select>
							@error('status')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Status</label>
							<select class="form-select @error('is_active') is-invalid @enderror" name="is_active">
								<option value="1" {{ old('is_active', $resignation->is_active) == '1' ? 'selected' : '' }}>Active</option>
								<option value="0" {{ old('is_active', $resignation->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
							</select>
							@error('is_active')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Reason</label>
							<textarea class="form-control @error('reason') is-invalid @enderror" name="reason" rows="3">{{ old('reason', $resignation->reason) }}</textarea>
							@error('reason')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Notes</label>
							<textarea class="form-control @error('notes') is-invalid @enderror" name="notes" rows="3">{{ old('notes', $resignation->notes) }}</textarea>
							@error('notes')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2">
					<a href="{{ route('resignations.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Update Resignation</button>
				</div>
			</form>
		</div>
	</div>

@endsection

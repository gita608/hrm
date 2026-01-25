@extends('layouts.app')

@section('title', 'Create Onboarding')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Create Onboarding</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('onboarding.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="card">
		<div class="card-header">
			<h5>Onboarding Information</h5>
		</div>
		<div class="card-body">
			<form action="{{ route('onboarding.store') }}" method="POST">
				@csrf
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Employee <span class="text-danger">*</span></label>
							<select class="form-select @error('employee_id') is-invalid @enderror" name="employee_id" required>
								<option value="">Select Employee</option>
								@foreach($employees as $employee)
									<option value="{{ $employee->id }}" {{ old('employee_id', $employeeId ?? null) == $employee->id ? 'selected' : '' }}>{{ $employee->name }} ({{ $employee->email }})</option>
								@endforeach
							</select>
							@error('employee_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Template</label>
							<select class="form-select @error('template_id') is-invalid @enderror" name="template_id" id="template_id">
								<option value="">Select Template (Optional)</option>
								@foreach($templates as $template)
									<option value="{{ $template->id }}" {{ old('template_id') == $template->id ? 'selected' : '' }}>{{ $template->name }}</option>
								@endforeach
							</select>
							<small class="text-muted">Selecting a template will automatically create checklist items</small>
							@error('template_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Status <span class="text-danger">*</span></label>
							<select class="form-select @error('status') is-invalid @enderror" name="status" required>
								<option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
								<option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
								<option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
								<option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
							</select>
							@error('status')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Start Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required>
							@error('start_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Expected Completion Date</label>
							<input type="date" class="form-control @error('expected_completion_date') is-invalid @enderror" name="expected_completion_date" value="{{ old('expected_completion_date') }}">
							@error('expected_completion_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Assigned To</label>
							<select class="form-select @error('assigned_to') is-invalid @enderror" name="assigned_to">
								<option value="">Select User</option>
								@foreach($users as $user)
									<option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
								@endforeach
							</select>
							@error('assigned_to')
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
					<a href="{{ route('onboarding.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Create Onboarding</button>
				</div>
			</form>
		</div>
	</div>

@endsection

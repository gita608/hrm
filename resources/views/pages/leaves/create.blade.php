@extends('layouts.app')

@section('title', 'Request Leave')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Request Leave</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('leaves.employee') }}" class="btn btn-outline-light border">Back to List</a>
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
			<h5>Leave Request Information</h5>
		</div>
		<div class="card-body">
			<form action="{{ route('leaves.store') }}" method="POST">
				@csrf
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Leave Type <span class="text-danger">*</span></label>
							<select class="form-select @error('leave_type_id') is-invalid @enderror" name="leave_type_id" required>
								<option value="">Select Leave Type</option>
								@foreach($leaveTypes as $type)
									<option value="{{ $type->id }}" {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>
										{{ $type->name }} ({{ $type->days_per_year }} days/year)
									</option>
								@endforeach
							</select>
							@error('leave_type_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">From Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control @error('from_date') is-invalid @enderror" name="from_date" value="{{ old('from_date') }}" min="{{ date('Y-m-d') }}" required>
							@error('from_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">To Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control @error('to_date') is-invalid @enderror" name="to_date" value="{{ old('to_date') }}" min="{{ date('Y-m-d') }}" required>
							@error('to_date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Reason <span class="text-danger">*</span></label>
							<textarea class="form-control @error('reason') is-invalid @enderror" name="reason" rows="4" placeholder="Enter reason for leave..." required>{{ old('reason') }}</textarea>
							@error('reason')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>

				<div class="card-footer d-flex justify-content-end gap-2">
					<a href="{{ route('leaves.employee') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Submit Request</button>
				</div>
			</form>
		</div>
	</div>

@endsection

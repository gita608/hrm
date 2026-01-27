@extends('layouts.app')

@section('title', 'Request Leave')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Request Leave</h2>
			<p class="text-muted mb-0 fs-13">Submit a new leave request</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('leaves.employee') }}" class="btn btn-light rounded-pill border shadow-sm">
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
			<h5 class="mb-0 fw-bold text-dark">Leave Request Information</h5>
		</div>
		<div class="card-body p-4">
			<form action="{{ route('leaves.store') }}" method="POST">
				@csrf
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Leave Type <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none" name="leave_type_id" required>
								<option value="">Select Leave Type</option>
								@foreach($leaveTypes as $type)
									<option value="{{ $type->id }}" {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>
										{{ $type->name }} ({{ $type->days_per_year }} days/year)
									</option>
								@endforeach
							</select>
							@error('leave_type_id')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<!-- Spacer to align the grid properly if needed, or can be used for remaining leave balance display later -->
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">From Date <span class="text-danger">*</span></label>
							<div class="input-group">
								<span class="input-group-text bg-light-50 border-light border-end-0 rounded-start-3 text-muted"><i class="ti ti-calendar"></i></span>
								<input type="date" class="form-control rounded-end-3 border-light shadow-none border-start-0 ps-0" name="from_date" value="{{ old('from_date') }}" min="{{ date('Y-m-d') }}" required>
							</div>
							@error('from_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">To Date <span class="text-danger">*</span></label>
							<div class="input-group">
								<span class="input-group-text bg-light-50 border-light border-end-0 rounded-start-3 text-muted"><i class="ti ti-calendar"></i></span>
								<input type="date" class="form-control rounded-end-3 border-light shadow-none border-start-0 ps-0" name="to_date" value="{{ old('to_date') }}" min="{{ date('Y-m-d') }}" required>
							</div>
							@error('to_date')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Reason <span class="text-danger">*</span></label>
							<textarea class="form-control rounded-3 border-light shadow-none" name="reason" rows="4" placeholder="Enter reason for leave..." required>{{ old('reason') }}</textarea>
							@error('reason')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>

				<div class="d-flex justify-content-end gap-2 mt-4">
					<a href="{{ route('leaves.employee') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
					<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Submit Request</button>
				</div>
			</form>
		</div>
	</div>

@endsection

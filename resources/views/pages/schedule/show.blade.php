@extends('layouts.app')

@section('title', 'Schedule Details')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Schedule Details</h2>
			<p class="text-muted mb-0 fs-13">View detailed schedule information</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('schedule.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="row">
		<div class="col-md-8">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Schedule Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row mb-4">
						<div class="col-md-6 border-end border-light">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Employee</label>
							@if($schedule->employee)
							<div class="d-flex align-items-center mt-1">
								<div class="avatar avatar-sm bg-primary-transparent text-primary rounded-circle me-2 fw-bold">
									{{ strtoupper(substr($schedule->employee->name, 0, 1)) }}
								</div>
								<p class="mb-0 fw-bold fs-15 text-dark">{{ $schedule->employee->name }}</p>
							</div>
							@else
								<p class="text-muted">N/A</p>
							@endif
						</div>
						<div class="col-md-6 ps-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Date</label>
							<p class="mb-0 fw-bold fs-15 text-dark mt-1">{{ $schedule->date->format('d M Y') }}</p>
						</div>
					</div>
					<div class="row mb-4">
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Shift Type</label>
							<div class="mt-1">
								<span class="badge bg-light text-dark border border-light-subtle fs-12 px-3 py-2">
									<i class="ti ti-clock me-1"></i>{{ $schedule->shiftType->name ?? 'N/A' }}
								</span>
							</div>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Status</label>
							<div class="mt-1">
								@if($schedule->status == 'completed')
									<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
										<i class="ti ti-point-filled me-1 fs-10"></i>Completed
									</span>
								@elseif($schedule->status == 'cancelled')
									<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
										<i class="ti ti-point-filled me-1 fs-10"></i>Cancelled
									</span>
								@elseif($schedule->status == 'absent')
									<span class="badge bg-warning-transparent text-warning rounded-pill d-inline-flex align-items-center px-2 py-1">
										<i class="ti ti-point-filled me-1 fs-10"></i>Absent
									</span>
								@else
									<span class="badge bg-info-transparent text-info rounded-pill d-inline-flex align-items-center px-2 py-1">
										<i class="ti ti-point-filled me-1 fs-10"></i>Scheduled
									</span>
								@endif
							</div>
						</div>
					</div>
					<div class="row mb-4">
						<div class="col-md-6">
							<div class="p-3 bg-light-50 rounded-3 border border-light h-100">
								<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-2">Start Time</label>
								<p class="mb-0 fw-bold fs-18 text-dark">{{ $schedule->start_time ? date('h:i A', strtotime($schedule->start_time)) : 'N/A' }}</p>
							</div>
						</div>
						<div class="col-md-6 mt-3 mt-md-0">
							<div class="p-3 bg-light-50 rounded-3 border border-light h-100">
								<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-2">End Time</label>
								<p class="mb-0 fw-bold fs-18 text-dark">{{ $schedule->end_time ? date('h:i A', strtotime($schedule->end_time)) : 'N/A' }}</p>
							</div>
						</div>
					</div>
					@if($schedule->notes)
						<div class="mt-4 pt-3 border-top border-light">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-2">Notes</label>
							<p class="mb-0 text-dark bg-light-50 p-3 rounded-3">{{ $schedule->notes }}</p>
						</div>
					@endif
					<div class="row mt-4 pt-3 border-top border-light">
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Created At</label>
							<p class="mb-0 fw-medium text-dark">{{ $schedule->created_at->format('d M Y h:i A') }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Updated At</label>
							<p class="mb-0 fw-medium text-dark">{{ $schedule->updated_at->format('d M Y h:i A') }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Actions</h5>
				</div>
				<div class="card-body p-4">
					<div class="d-grid gap-3">
						<a href="{{ route('schedule.edit', $schedule->id) }}" class="btn btn-primary rounded-pill py-2 shadow-sm">
							<i class="ti ti-edit me-2"></i>Edit Schedule
						</a>
						<form action="{{ route('schedule.destroy', $schedule->id) }}" method="POST" class="d-grid" onsubmit="return confirm('Are you sure you want to delete this schedule?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger rounded-pill py-2">
								<i class="ti ti-trash me-2"></i>Delete Schedule
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

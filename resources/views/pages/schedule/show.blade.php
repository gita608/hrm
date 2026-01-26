@extends('layouts.app')

@section('title', 'Schedule Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Schedule Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('schedule.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5>Schedule Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Employee</label>
							<p class="mb-0 fw-semibold">{{ $schedule->employee->name ?? 'N/A' }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">Date</label>
							<p class="mb-0 fw-semibold">{{ $schedule->date->format('d M Y') }}</p>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Shift Type</label>
							<p class="mb-0 fw-semibold">{{ $schedule->shiftType->name ?? 'N/A' }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">Status</label>
							<p class="mb-0">
								@if($schedule->status == 'completed')
									<span class="badge badge-success d-inline-flex align-items-center badge-sm">
										<i class="ti ti-point-filled me-1"></i>Completed
									</span>
								@elseif($schedule->status == 'cancelled')
									<span class="badge badge-danger d-inline-flex align-items-center badge-sm">
										<i class="ti ti-point-filled me-1"></i>Cancelled
									</span>
								@elseif($schedule->status == 'absent')
									<span class="badge badge-warning d-inline-flex align-items-center badge-sm">
										<i class="ti ti-point-filled me-1"></i>Absent
									</span>
								@else
									<span class="badge badge-info d-inline-flex align-items-center badge-sm">
										<i class="ti ti-point-filled me-1"></i>Scheduled
									</span>
								@endif
							</p>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Start Time</label>
							<p class="mb-0 fw-semibold">{{ $schedule->start_time ? date('h:i A', strtotime($schedule->start_time)) : 'N/A' }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">End Time</label>
							<p class="mb-0 fw-semibold">{{ $schedule->end_time ? date('h:i A', strtotime($schedule->end_time)) : 'N/A' }}</p>
						</div>
					</div>
					@if($schedule->notes)
						<div class="mb-3">
							<label class="form-label text-muted">Notes</label>
							<p class="mb-0">{{ $schedule->notes }}</p>
						</div>
					@endif
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Created At</label>
							<p class="mb-0 fw-semibold">{{ $schedule->created_at->format('d M Y h:i A') }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">Updated At</label>
							<p class="mb-0 fw-semibold">{{ $schedule->updated_at->format('d M Y h:i A') }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-header">
					<h5>Actions</h5>
				</div>
				<div class="card-body">
					<div class="d-grid gap-2">
						<a href="{{ route('schedule.edit', $schedule->id) }}" class="btn btn-primary">
							<i class="ti ti-edit me-2"></i>Edit Schedule
						</a>
						<form action="{{ route('schedule.destroy', $schedule->id) }}" method="POST" class="d-grid" onsubmit="return confirm('Are you sure you want to delete this schedule?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger">
								<i class="ti ti-trash me-2"></i>Delete
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

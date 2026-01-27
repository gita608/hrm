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
		<div class="col-xl-8">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Schedule Details</h5>
				</div>
				<div class="card-body p-4">
					<div class="row g-4 mb-4">
						<div class="col-md-6">
							<div class="p-3 bg-light rounded-4 h-100 border border-light-subtle">
								<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1 mb-2">Employee assigned</label>
								@if($schedule->employee)
									<div class="d-flex align-items-center">
										<div class="avatar avatar-lg bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold shadow-sm">
											{{ strtoupper(substr($schedule->employee->name, 0, 1)) }}
										</div>
										<div>
											<h6 class="mb-0 fw-bold text-dark fs-16">{{ $schedule->employee->name }}</h6>
											<p class="mb-0 text-muted fs-12">{{ $schedule->employee->designation->name ?? 'Employee' }}</p>
										</div>
									</div>
								@else
									<p class="mb-0 text-muted">No employee assigned</p>
								@endif
							</div>
						</div>
						<div class="col-md-6">
							<div class="p-3 bg-light rounded-4 h-100 border border-light-subtle">
								<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1 mb-2">Shift Schedule Date</label>
								<div class="d-flex align-items-center">
									<div class="avatar avatar-lg bg-info-transparent text-info rounded-circle d-flex align-items-center justify-content-center me-3 shadow-none">
										<i class="ti ti-calendar-event fs-24"></i>
									</div>
									<div>
										<h6 class="mb-0 fw-bold text-dark fs-16">{{ $schedule->date->format('d M, Y') }}</h6>
										<p class="mb-0 text-muted fs-12">{{ $schedule->date->format('l') }}</p>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row g-4 mb-4">
						<div class="col-md-4">
							<div class="text-center p-3 rounded-4 bg-white border border-light-subtle shadow-sm">
								<p class="text-muted fs-11 text-uppercase fw-bold mb-2">Shift Type</p>
								<h6 class="mb-0 text-dark fw-bold badge bg-primary-transparent text-primary rounded-pill px-3 py-2 border-0">
									<i class="ti ti-clock-hour-4 me-1"></i>{{ $schedule->shiftType->name ?? 'Standard Shift' }}
								</h6>
							</div>
						</div>
						<div class="col-md-4">
							<div class="text-center p-3 rounded-4 bg-white border border-light-subtle shadow-sm">
								<p class="text-muted fs-11 text-uppercase fw-bold mb-2">Start Time</p>
								<h6 class="mb-0 text-dark fw-bold fs-18">
									{{ $schedule->start_time ? date('h:i A', strtotime($schedule->start_time)) : '--:--' }}
								</h6>
							</div>
						</div>
						<div class="col-md-4">
							<div class="text-center p-3 rounded-4 bg-white border border-light-subtle shadow-sm">
								<p class="text-muted fs-11 text-uppercase fw-bold mb-2">End Time</p>
								<h6 class="mb-0 text-dark fw-bold fs-18">
									{{ $schedule->end_time ? date('h:i A', strtotime($schedule->end_time)) : '--:--' }}
								</h6>
							</div>
						</div>
					</div>

					<div class="mb-4">
						<label class="form-label text-muted fs-12 text-uppercase fw-bold ls-1 mb-2">Work Status</label>
						<div class="mt-1">
							@if($schedule->status == 'completed')
								<span class="badge bg-success text-white rounded-pill px-4 py-2 shadow-sm">
									<i class="ti ti-circle-check-filled me-1"></i>Completed
								</span>
							@elseif($schedule->status == 'cancelled')
								<span class="badge bg-danger text-white rounded-pill px-4 py-2 shadow-sm">
									<i class="ti ti-circle-x-filled me-1"></i>Cancelled
								</span>
							@elseif($schedule->status == 'absent')
								<span class="badge bg-warning text-dark rounded-pill px-4 py-2 shadow-sm">
									<i class="ti ti-alert-triangle-filled me-1"></i>Absent
								</span>
							@else
								<span class="badge bg-primary text-white rounded-pill px-4 py-2 shadow-sm">
									<i class="ti ti-calendar-check me-1"></i>Scheduled
								</span>
							@endif
						</div>
					</div>

					@if($schedule->notes)
						<div class="mb-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-bold ls-1 mb-2">Remarks & Notes</label>
							<div class="p-3 bg-light rounded-3 border-start border-primary border-4 text-dark fs-14 italic">
								"{{ $schedule->notes }}"
							</div>
						</div>
					@endif

					<div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3 border border-light-subtle mt-5">
						<div class="d-flex align-items-center gap-4">
							<div>
								<p class="mb-0 text-muted fs-11 text-uppercase fw-bold">Created On</p>
								<p class="mb-0 text-dark fs-12 fw-medium">{{ $schedule->created_at->format('M d, Y H:i') }}</p>
							</div>
							<div>
								<p class="mb-0 text-muted fs-11 text-uppercase fw-bold">Last Modified</p>
								<p class="mb-0 text-dark fs-12 fw-medium">{{ $schedule->updated_at->format('M d, Y H:i') }}</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-4">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden sticky-top" style="top: 20px;">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Management Actions</h5>
				</div>
				<div class="card-body p-4">
					<div class="d-grid gap-3">
						<a href="{{ route('schedule.edit', $schedule->id) }}" class="btn btn-primary rounded-pill py-3 fw-bold shadow">
							<i class="ti ti-edit me-2"></i>Edit Schedule Details
						</a>
						<hr class="my-2 opacity-50">
						<form action="{{ route('schedule.destroy', $schedule->id) }}" method="POST" class="d-grid" onsubmit="return confirm('Attention: Are you certain you want to permanently remove this schedule entry? This action cannot be undone.');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger rounded-pill py-2 border-0 fw-medium">
								<i class="ti ti-trash me-2"></i>Delete Schedule Record
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

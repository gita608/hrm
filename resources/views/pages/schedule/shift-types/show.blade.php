@extends('layouts.app')

@section('title', 'Shift Type Details')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Shift Type Details</h2>
			<p class="text-muted mb-0 fs-13">View shift type configuration</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('shift-types.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="row">
		<div class="col-xl-8">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Shift Configuration Data</h5>
				</div>
				<div class="card-body p-4">
					<div class="row g-4 mb-4 pb-4 border-bottom border-light">
						<div class="col-md-7">
							<div class="d-flex align-items-center mb-3">
								<div class="avatar avatar-xl bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold shadow-sm">
									<i class="ti ti-clock-plus fs-24"></i>
								</div>
								<div>
									<h4 class="mb-0 fw-bold text-dark">{{ $shiftType->name }}</h4>
									<span class="fs-13 text-muted">Internal Shift ID: #ST-{{ str_pad($shiftType->id, 4, '0', STR_PAD_LEFT) }}</span>
								</div>
							</div>
						</div>
						<div class="col-md-5 text-md-end">
							<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1 d-block mb-2">Current System Status</label>
							@if($shiftType->is_active)
								<span class="badge bg-success text-white rounded-pill px-3 py-2 fs-12 shadow-sm">
									<i class="ti ti-circle-check-filled me-1"></i>Active / Enabled
								</span>
							@else
								<span class="badge bg-danger text-white rounded-pill px-3 py-2 fs-12 shadow-sm">
									<i class="ti ti-circle-x-filled me-1"></i>Disabled / Inactive
								</span>
							@endif
						</div>
					</div>

					<div class="row g-4 mb-4">
						<div class="col-md-4">
							<div class="p-3 bg-light rounded-4 border border-light-subtle text-center">
								<p class="text-muted fs-11 text-uppercase fw-bold mb-2">Starts At</p>
								<h5 class="mb-0 text-dark fw-bold">{{ date('h:i A', strtotime($shiftType->start_time)) }}</h5>
							</div>
						</div>
						<div class="col-md-4">
							<div class="p-3 bg-light rounded-4 border border-light-subtle text-center">
								<p class="text-muted fs-11 text-uppercase fw-bold mb-2">Ends At</p>
								<h5 class="mb-0 text-dark fw-bold">{{ date('h:i A', strtotime($shiftType->end_time)) }}</h5>
							</div>
						</div>
						<div class="col-md-4">
							@php
								$start = \Carbon\Carbon::parse($shiftType->start_time);
								$end = \Carbon\Carbon::parse($shiftType->end_time);
								$duration = $start->diffInHours($end);
							@endphp
							<div class="p-3 bg-primary-transparent rounded-4 border border-primary-subtle text-center">
								<p class="text-primary fs-11 text-uppercase fw-bold mb-2">Daily Duration</p>
								<h5 class="mb-0 text-primary fw-bold">{{ $duration }} Work Hours</h5>
							</div>
						</div>
					</div>

					@if($shiftType->description)
						<div class="mb-4">
							<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1 mb-2">Operational Notes</label>
							<div class="p-3 bg-light-50 rounded-3 border-start border-light border-4">
								<p class="mb-0 text-dark fs-14 lh-lg">{{ $shiftType->description }}</p>
							</div>
						</div>
					@endif

					<div class="d-flex align-items-center gap-4 p-3 bg-light rounded-3 border border-light-subtle mt-4">
						<div class="avatar avatar-md bg-white text-muted rounded-circle border d-flex align-items-center justify-content-center shadow-none">
							<i class="ti ti-history fs-18"></i>
						</div>
						<div>
							<p class="mb-0 text-muted fs-11 text-uppercase fw-bold">Record Timeline</p>
							<p class="mb-0 fs-12 text-dark">
								Added on <span class="fw-bold">{{ $shiftType->created_at->format('M d, Y') }}</span> 
								&bull; Last modified <span class="fw-bold">{{ $shiftType->updated_at->diffForHumans() }}</span>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-4">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden sticky-top" style="top: 20px;">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Administration</h5>
				</div>
				<div class="card-body p-4">
					<div class="d-grid gap-3">
						<a href="{{ route('shift-types.edit', $shiftType->id) }}" class="btn btn-primary rounded-pill py-3 fw-bold shadow">
							<i class="ti ti-edit me-2"></i>Edit Shift Details
						</a>
						<hr class="my-1 opacity-25">
						<form action="{{ route('shift-types.destroy', $shiftType->id) }}" method="POST" class="d-grid" onsubmit="return confirm('Warning: You are about to permanently delete this shift type. Existing schedules using this shift might be affected. Proceed?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger rounded-pill py-2 border-0 fw-medium">
								<i class="ti ti-trash me-2"></i>Remove from System
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

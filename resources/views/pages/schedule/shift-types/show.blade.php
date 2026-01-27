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
		<div class="col-md-8">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Shift Type Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Name</label>
							<p class="mb-0 fw-bold text-dark">{{ $shiftType->name }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Status</label>
							<p class="mb-0">
								@if($shiftType->is_active)
									<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
										<i class="ti ti-point-filled me-1 fs-10"></i>Active
									</span>
								@else
									<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
										<i class="ti ti-point-filled me-1 fs-10"></i>Inactive
									</span>
								@endif
							</p>
						</div>
					</div>
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Start Time</label>
							<p class="mb-0 fw-medium text-dark">{{ date('h:i A', strtotime($shiftType->start_time)) }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">End Time</label>
							<p class="mb-0 fw-medium text-dark">{{ date('h:i A', strtotime($shiftType->end_time)) }}</p>
						</div>
					</div>
					@php
						$start = \Carbon\Carbon::parse($shiftType->start_time);
						$end = \Carbon\Carbon::parse($shiftType->end_time);
						$duration = $start->diffInHours($end);
					@endphp
					<div class="row mb-3 pb-3 border-bottom border-light">
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Duration</label>
							<p class="mb-0 fw-medium text-dark">{{ $duration }} hours</p>
						</div>
					</div>
					@if($shiftType->description)
						<div class="mb-3 pb-3 border-bottom border-light">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Description</label>
							<p class="mb-0 text-dark">{{ $shiftType->description }}</p>
						</div>
					@endif
					<div class="row">
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Created At</label>
							<p class="mb-0 text-muted fs-13">{{ $shiftType->created_at->format('d M Y h:i A') }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Updated At</label>
							<p class="mb-0 text-muted fs-13">{{ $shiftType->updated_at->format('d M Y h:i A') }}</p>
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
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('shift-types.edit', $shiftType->id) }}" class="btn btn-primary rounded-pill shadow-sm py-2">
							<i class="ti ti-edit me-2"></i>Edit Shift Type
						</a>
						<form action="{{ route('shift-types.destroy', $shiftType->id) }}" method="POST" class="d-grid" onsubmit="return confirm('Are you sure you want to delete this shift type?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger rounded-pill py-2">
								<i class="ti ti-trash me-2"></i>Delete
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

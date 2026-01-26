@extends('layouts.app')

@section('title', 'Shift Type Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Shift Type Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('shift-types.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5>Shift Type Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Name</label>
							<p class="mb-0 fw-semibold">{{ $shiftType->name }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">Status</label>
							<p class="mb-0">
								@if($shiftType->is_active)
									<span class="badge badge-success d-inline-flex align-items-center badge-sm">
										<i class="ti ti-point-filled me-1"></i>Active
									</span>
								@else
									<span class="badge badge-danger d-inline-flex align-items-center badge-sm">
										<i class="ti ti-point-filled me-1"></i>Inactive
									</span>
								@endif
							</p>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Start Time</label>
							<p class="mb-0 fw-semibold">{{ date('h:i A', strtotime($shiftType->start_time)) }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">End Time</label>
							<p class="mb-0 fw-semibold">{{ date('h:i A', strtotime($shiftType->end_time)) }}</p>
						</div>
					</div>
					@php
						$start = \Carbon\Carbon::parse($shiftType->start_time);
						$end = \Carbon\Carbon::parse($shiftType->end_time);
						$duration = $start->diffInHours($end);
					@endphp
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Duration</label>
							<p class="mb-0 fw-semibold">{{ $duration }} hours</p>
						</div>
					</div>
					@if($shiftType->description)
						<div class="mb-3">
							<label class="form-label text-muted">Description</label>
							<p class="mb-0">{{ $shiftType->description }}</p>
						</div>
					@endif
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Created At</label>
							<p class="mb-0 fw-semibold">{{ $shiftType->created_at->format('d M Y h:i A') }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">Updated At</label>
							<p class="mb-0 fw-semibold">{{ $shiftType->updated_at->format('d M Y h:i A') }}</p>
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
						<a href="{{ route('shift-types.edit', $shiftType->id) }}" class="btn btn-primary">
							<i class="ti ti-edit me-2"></i>Edit Shift Type
						</a>
						<form action="{{ route('shift-types.destroy', $shiftType->id) }}" method="POST" class="d-grid" onsubmit="return confirm('Are you sure you want to delete this shift type?');">
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

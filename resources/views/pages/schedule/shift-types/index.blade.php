@extends('layouts.app')

@section('title', 'Shift Types')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Shift Types</h2>
			<p class="text-muted mb-0 fs-13">Manage work shifts and timings for employee schedules</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('schedule.index') }}" class="btn btn-light rounded-pill border shadow-sm me-2">
				<i class="ti ti-arrow-left me-2"></i>Back to Schedule
			</a>
			<a href="{{ route('shift-types.create') }}" class="btn btn-primary rounded-pill shadow-sm py-2 px-3">
				<i class="ti ti-plus me-2"></i>Add Shift Type
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	@if(session('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			{{ session('success') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	@if(session('error'))
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			{{ session('error') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2 d-flex align-items-center justify-content-between flex-wrap gap-3">
			<h5 class="mb-0 fw-bold text-dark">Available Shift Types</h5>
			<div class="d-flex align-items-center gap-2">
				<div class="input-group input-group-sm rounded-pill border-light-subtle overflow-hidden" style="width: 250px;">
					<span class="input-group-text bg-light border-0"><i class="ti ti-search fs-12 text-muted"></i></span>
					<input type="text" class="form-control border-0 bg-light fs-12 shadow-none" placeholder="Search shift types...">
				</div>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="bg-light-50">
						<tr>
							<th class="ps-3 border-0 text-muted fs-12 fw-medium text-uppercase" style="width: 40px;">#</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Shift Name</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Time Window</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Duration</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Visibility</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Description</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($shiftTypes as $shiftType)
							@php
								$start = \Carbon\Carbon::parse($shiftType->start_time);
								$end = \Carbon\Carbon::parse($shiftType->end_time);
								$duration = $start->diffInHours($end);
							@endphp
							<tr class="border-bottom border-light">
								<td class="ps-3 text-muted fs-12">{{ $loop->iteration }}</td>
								<td>
									<div class="d-flex align-items-center">
										<div class="avatar avatar-md bg-primary-transparent text-primary rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold shadow-none">
											<i class="ti ti-clock-hour-4 fs-16"></i>
										</div>
										<div>
											<h6 class="mb-0 fw-bold fs-14"><a href="{{ route('shift-types.show', $shiftType->id) }}" class="text-dark text-decoration-none hover-text-primary transition-all">{{ $shiftType->name }}</a></h6>
											<span class="fs-11 text-muted">Last updated: {{ $shiftType->updated_at->diffForHumans() }}</span>
										</div>
									</div>
								</td>
								<td>
									<div class="d-flex align-items-center gap-2">
										<span class="badge bg-light text-dark border border-light-subtle rounded-pill fw-bold px-2 py-1 fs-11">
											{{ date('h:i A', strtotime($shiftType->start_time)) }}
										</span>
										<i class="ti ti-arrow-right fs-10 text-muted"></i>
										<span class="badge bg-light text-dark border border-light-subtle rounded-pill fw-bold px-2 py-1 fs-11">
											{{ date('h:i A', strtotime($shiftType->end_time)) }}
										</span>
									</div>
								</td>
								<td>
									<div class="d-flex align-items-center">
										<span class="text-dark fw-bold fs-13">{{ $duration }} hrs</span>
										<small class="text-muted ms-1 fs-11 text-nowrap">/ day</small>
									</div>
								</td>
								<td>
									@if($shiftType->is_active)
										<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1 fs-11 fw-bold">
											<i class="ti ti-circle-check-filled me-1 fs-12"></i>Active
										</span>
									@else
										<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1 fs-11 fw-bold">
											<i class="ti ti-circle-x-filled me-1 fs-12"></i>Inactive
										</span>
									@endif
								</td>
								<td class="text-muted fs-12" style="max-width: 200px;">{{ Str::limit($shiftType->description ?? 'No description provided', 50) }}</td>
								<td class="pe-3 text-end">
									<div class="d-flex justify-content-end gap-1">
										<a href="{{ route('shift-types.show', $shiftType->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('shift-types.edit', $shiftType->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										<form action="{{ route('shift-types.destroy', $shiftType->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this shift type?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-danger hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="7" class="text-center py-5">
									<div class="d-flex flex-column align-items-center justify-content-center">
										<div class="avatar avatar-xxl bg-light-50 rounded-circle mb-3 text-muted">
											<i class="ti ti-clock-off fs-30"></i>
										</div>
										<p class="text-muted mb-0">No shift types found. Create your first shift to get started.</p>
										<a href="{{ route('shift-types.create') }}" class="btn btn-sm btn-primary rounded-pill mt-3 px-4 shadow-sm">Add New Shift</a>
									</div>
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

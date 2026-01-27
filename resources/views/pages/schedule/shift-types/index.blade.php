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
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
			<h5 class="mb-0 fw-bold text-dark">Shift Types List</h5>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="bg-light-50">
						<tr>
							<th class="ps-3" style="width: 50px;">
								<div class="form-check">
									<input class="form-check-input shadow-none" type="checkbox" id="select-all">
								</div>
							</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">#</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Name</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Start Time</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">End Time</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Duration</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
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
								<td class="ps-3">
									<div class="form-check">
										<input class="form-check-input shadow-none" type="checkbox" value="{{ $shiftType->id }}">
									</div>
								</td>
								<td class="text-muted fs-12">{{ $loop->iteration }}</td>
								<td>
									<h6 class="mb-0 fw-bold"><a href="{{ route('shift-types.show', $shiftType->id) }}" class="text-dark text-decoration-none hover-text-primary transition-all">{{ $shiftType->name }}</a></h6>
								</td>
								<td class="text-muted fs-13">{{ date('h:i A', strtotime($shiftType->start_time)) }}</td>
								<td class="text-muted fs-13">{{ date('h:i A', strtotime($shiftType->end_time)) }}</td>
								<td class="text-dark fs-13">{{ $duration }} hrs</td>
								<td>
									@if($shiftType->is_active)
										<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Active
										</span>
									@else
										<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Inactive
										</span>
									@endif
								</td>
								<td class="text-muted fs-13">{{ Str::limit($shiftType->description ?? 'N/A', 30) }}</td>
								<td class="pe-3 text-end">
									<div class="d-flex justify-content-end gap-2">
										<a href="{{ route('shift-types.show', $shiftType->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="View">
											<i class="ti ti-eye"></i>
										</a>
										<a href="{{ route('shift-types.edit', $shiftType->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="Edit">
											<i class="ti ti-edit"></i>
										</a>
										<form action="{{ route('shift-types.destroy', $shiftType->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this shift type?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-danger hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="Delete">
												<i class="ti ti-trash"></i>
											</button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="9" class="text-center py-5">
									<div class="d-flex flex-column align-items-center justify-content-center">
										<div class="avatar avatar-xxl bg-light-50 rounded-circle mb-3 text-muted">
											<i class="ti ti-clock-off fs-30"></i>
										</div>
										<p class="text-muted mb-0">No shift types found.</p>
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

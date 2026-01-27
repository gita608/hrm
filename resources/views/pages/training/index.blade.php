@extends('layouts.app')

@section('title', 'Training List')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Training Sessions</h2>
			<p class="text-muted mb-0 fs-13">Manage employee training programs and schedules</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('training.create') }}" class="btn btn-primary rounded-pill shadow-sm py-2 px-3">
				<i class="ti ti-plus me-2"></i>Add Training
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

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
			<h5 class="mb-0 fw-bold text-dark">Training List</h5>
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
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Training Type</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Trainer</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Time Duration</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Location</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Description</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($trainings as $training)
							<tr class="border-bottom border-light">
								<td class="ps-3">
									<div class="form-check">
										<input class="form-check-input shadow-none" type="checkbox" value="{{ $training->id }}">
									</div>
								</td>
								<td class="text-muted fs-12">{{ $loop->iteration }}</td>
								<td>
									<div class="fw-bold text-dark">{{ $training->title }}</div>
									@if($training->trainingType)
										<div class="text-muted fs-11">{{ $training->trainingType->name }}</div>
									@endif
								</td>
								<td>
									@if($training->trainer)
										<div class="d-flex align-items-center">
											<div class="avatar avatar-md bg-light-subtle rounded-circle d-flex align-items-center justify-content-center me-2 border border-light shadow-sm text-primary fw-bold">
												{{ substr($training->trainer->name, 0, 1) }}
											</div>
											<div>
												<h6 class="mb-0 fs-13 fw-bold text-dark">{{ $training->trainer->name }}</h6>
											</div>
										</div>
									@else
										<span class="text-muted fs-13">N/A</span>
									@endif
								</td>
								<td class="text-muted fs-13">
									<div>{{ $training->start_date->format('d M Y') }}</div>
									<div class="fs-11">to {{ $training->end_date->format('d M Y') }}</div>
								</td>
								<td class="text-dark fs-13">{{ $training->location ?? 'N/A' }}</td>
								<td class="text-muted fs-13">{{ Str::limit($training->description ?? 'N/A', 30) }}</td>
								<td>
									@if($training->status == 'scheduled')
										<span class="badge bg-info-transparent text-info rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-calendar me-1 fs-10"></i>Scheduled
										</span>
									@elseif($training->status == 'ongoing')
										<span class="badge bg-warning-transparent text-warning rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-loader me-1 fs-10"></i>Ongoing
										</span>
									@elseif($training->status == 'completed')
										<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-check me-1 fs-10"></i>Completed
										</span>
									@else
										<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-x me-1 fs-10"></i>Cancelled
										</span>
									@endif
								</td>
								<td class="pe-3 text-end">
									<div class="d-flex justify-content-end gap-2">
										<a href="{{ route('training.show', $training->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="View">
											<i class="ti ti-eye"></i>
										</a>
										<a href="{{ route('training.edit', $training->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="Edit">
											<i class="ti ti-edit"></i>
										</a>
										<form action="{{ route('training.destroy', $training->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this training?');">
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
											<i class="ti ti-school-off fs-30"></i>
										</div>
										<p class="text-muted mb-0">No training sessions found.</p>
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

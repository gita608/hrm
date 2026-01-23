@extends('layouts.app')

@section('title', 'Training List')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Training</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<a href="{{ route('training.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Training</a>
			</div>
			<div class="head-icons ms-2">
				<a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header">
					<i class="ti ti-chevrons-up"></i>
				</a>
			</div>
		</div>
	</div>
	<!-- /Page Header -->

	@if(session('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			{{ session('success') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	<div class="card">
		<div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
			<h5>Training List</h5>
		</div>
		<div class="card-body p-0">
			<div class="custom-datatable-filter table-responsive">
				<table class="table datatable">
					<thead class="thead-light">
						<tr>
							<th class="no-sort">
								<div class="form-check form-check-md">
									<input class="form-check-input" type="checkbox" id="select-all">
								</div>
							</th>
							<th>Training Type</th>
							<th>Trainer</th>
							<th>Time Duration</th>
							<th>Location</th>
							<th>Description</th>
							<th>Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@forelse($trainings as $training)
							<tr>
								<td>
									<div class="form-check form-check-md">
										<input class="form-check-input" type="checkbox" value="{{ $training->id }}">
									</div>
								</td>
								<td>
									{{ $training->title }}
									@if($training->trainingType)
										<br><small class="text-muted">{{ $training->trainingType->name }}</small>
									@endif
								</td>
								<td>
									@if($training->trainer)
										<div class="d-flex align-items-center file-name-icon">
											<div class="avatar avatar-md border avatar-rounded bg-primary text-white d-flex align-items-center justify-content-center">
												{{ substr($training->trainer->name, 0, 1) }}
											</div>
											<div class="ms-2">
												<h6 class="fw-medium mb-0">{{ $training->trainer->name }}</h6>
											</div>
										</div>
									@else
										<span class="text-muted">N/A</span>
									@endif
								</td>
								<td>{{ $training->start_date->format('d M Y') }} - {{ $training->end_date->format('d M Y') }}</td>
								<td>{{ $training->location ?? 'N/A' }}</td>
								<td>{{ Str::limit($training->description ?? 'N/A', 50) }}</td>
								<td>
									@if($training->status == 'scheduled')
										<span class="badge badge-info d-inline-flex align-items-center badge-xs">
											<i class="ti ti-point-filled me-1"></i>Scheduled
										</span>
									@elseif($training->status == 'ongoing')
										<span class="badge badge-warning d-inline-flex align-items-center badge-xs">
											<i class="ti ti-point-filled me-1"></i>Ongoing
										</span>
									@elseif($training->status == 'completed')
										<span class="badge badge-success d-inline-flex align-items-center badge-xs">
											<i class="ti ti-point-filled me-1"></i>Completed
										</span>
									@else
										<span class="badge badge-danger d-inline-flex align-items-center badge-xs">
											<i class="ti ti-point-filled me-1"></i>Cancelled
										</span>
									@endif
								</td>
								<td>
									<div class="action-icon d-inline-flex">
										<a href="{{ route('training.show', $training->id) }}" class="me-2" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('training.edit', $training->id) }}" class="me-2" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										<form action="{{ route('training.destroy', $training->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this training?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-link p-0 text-danger" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="8" class="text-center">No trainings found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

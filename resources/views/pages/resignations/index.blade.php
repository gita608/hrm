@extends('layouts.app')

@section('title', 'Resignations')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Resignations</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<a href="{{ route('resignations.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Resignation</a>
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
			<h5>Resignations List</h5>
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
							<th>#</th>
							<th>Employee</th>
							<th>Resignation Date</th>
							<th>Notice Date</th>
							<th>Last Working Day</th>
							<th>Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@forelse($resignations as $resignation)
							<tr>
								<td>
									<div class="form-check form-check-md">
										<input class="form-check-input" type="checkbox" value="{{ $resignation->id }}">
									</div>
								</td>
								<td>{{ $loop->iteration }}</td>
								<td>
									<h6 class="fw-medium"><a href="#">{{ $resignation->employee->name ?? 'N/A' }}</a></h6>
								</td>
								<td>{{ $resignation->resignation_date->format('d M Y') }}</td>
								<td>{{ $resignation->notice_date ? $resignation->notice_date->format('d M Y') : 'N/A' }}</td>
								<td>{{ $resignation->last_working_day ? $resignation->last_working_day->format('d M Y') : 'N/A' }}</td>
								<td>
									@if($resignation->status == 'pending')
										<span class="badge badge-warning">Pending</span>
									@elseif($resignation->status == 'accepted')
										<span class="badge badge-success">Accepted</span>
									@elseif($resignation->status == 'rejected')
										<span class="badge badge-danger">Rejected</span>
									@elseif($resignation->status == 'withdrawn')
										<span class="badge badge-secondary">Withdrawn</span>
									@endif
								</td>
								<td>
									<div class="action-icon d-inline-flex">
										<a href="{{ route('resignations.show', $resignation->id) }}" class="me-2" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('resignations.edit', $resignation->id) }}" class="me-2" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										<form action="{{ route('resignations.destroy', $resignation->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this resignation?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-link p-0 text-danger" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="8" class="text-center">No resignations found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

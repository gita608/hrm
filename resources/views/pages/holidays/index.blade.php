@extends('layouts.app')

@section('title', 'Holidays')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Holidays</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<a href="{{ route('holidays.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Holiday</a>
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
			<h5>Holidays List</h5>
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
							<th>Title</th>
							<th>Date</th>
							<th>Description</th>
							<th>Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@forelse($holidays as $holiday)
							<tr>
								<td>
									<div class="form-check form-check-md">
										<input class="form-check-input" type="checkbox" value="{{ $holiday->id }}">
									</div>
								</td>
								<td>{{ $loop->iteration }}</td>
								<td>
									<h6 class="fw-medium"><a href="#">{{ $holiday->name }}</a></h6>
								</td>
								<td>{{ $holiday->date->format('d M Y') }}</td>
								<td>{{ Str::limit($holiday->description ?? 'N/A', 50) }}</td>
								<td>
									@if($holiday->is_active)
										<span class="badge badge-success d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Active
										</span>
									@else
										<span class="badge badge-danger d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Inactive
										</span>
									@endif
								</td>
								<td>
									<div class="action-icon d-inline-flex">
										<a href="{{ route('holidays.show', $holiday->id) }}" class="me-2" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('holidays.edit', $holiday->id) }}" class="me-2" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										<form action="{{ route('holidays.destroy', $holiday->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this holiday?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-link p-0 text-danger" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="7" class="text-center">No holidays found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

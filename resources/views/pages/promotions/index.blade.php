@extends('layouts.app')

@section('title', 'Promotions')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Promotions</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<a href="{{ route('promotions.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Promotion</a>
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
			<h5>Promotions List</h5>
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
							<th>Employee</th>
							<th>From Department</th>
							<th>To Department</th>
							<th>From Designation</th>
							<th>To Designation</th>
							<th>Promotion Date</th>
							<th>Salary</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@forelse($promotions as $promotion)
							<tr>
								<td>
									<div class="form-check form-check-md">
										<input class="form-check-input" type="checkbox" value="{{ $promotion->id }}">
									</div>
								</td>
								<td>
									<h6 class="fw-medium"><a href="#">{{ $promotion->employee->name ?? 'N/A' }}</a></h6>
								</td>
								<td>{{ $promotion->fromDepartment->name ?? 'N/A' }}</td>
								<td>{{ $promotion->toDepartment->name ?? 'N/A' }}</td>
								<td>{{ $promotion->fromDesignation->name ?? 'N/A' }}</td>
								<td>{{ $promotion->toDesignation->name ?? 'N/A' }}</td>
								<td>{{ $promotion->promotion_date->format('d M Y') }}</td>
								<td>{{ $promotion->salary ? number_format($promotion->salary, 2) : 'N/A' }}</td>
								<td>
									<div class="action-icon d-inline-flex">
										<a href="{{ route('promotions.show', $promotion->id) }}" class="me-2" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('promotions.edit', $promotion->id) }}" class="me-2" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										<form action="{{ route('promotions.destroy', $promotion->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this promotion?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-link p-0 text-danger" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="9" class="text-center">No promotions found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

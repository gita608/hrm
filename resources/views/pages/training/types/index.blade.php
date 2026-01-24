@extends('layouts.app')

@section('title', 'Training Types')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Training Types</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<a href="{{ route('training.types.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Training Type</a>
			</div>
			<div class="head-icons ms-2">
				<a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header">
					<i class="ti ti-chevrons-up"></i>
				</a>
			</div>
		</div>
	</div>
	<!-- /Breadcrumb -->

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

	<div class="row">
		<!-- Total Types -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-lg bg-primary rounded-circle"><i class="ti ti-category"></i></span>
						</div>
						<div class="ms-2 overflow-hidden">
							<p class="fs-12 fw-medium mb-1 text-truncate">Total Types</p>
							<h4>{{ $trainingTypes->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Total Types -->

		<!-- Active Types -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-lg bg-success rounded-circle"><i class="ti ti-check"></i></span>
						</div>
						<div class="ms-2 overflow-hidden">
							<p class="fs-12 fw-medium mb-1 text-truncate">Active</p>
							<h4>{{ $trainingTypes->where('is_active', true)->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Active Types -->
	</div>

	<div class="card">
		<div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
			<h5>Training Type List</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('training.types.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
					<div>
						<select name="status" class="form-select form-select-sm">
							<option value="">All Status</option>
							<option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
							<option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
						</select>
					</div>
					<div>
						<button type="submit" class="btn btn-sm btn-primary">Filter</button>
						@if(request()->has('status'))
							<a href="{{ route('training.types.index') }}" class="btn btn-sm btn-outline-light border">Clear</a>
						@endif
					</div>
				</form>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="custom-datatable-filter table-responsive">
				<table class="table datatable">
					<thead class="thead-light">
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Code</th>
							<th>Description</th>
							<th>Trainings</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($trainingTypes as $type)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td><strong>{{ $type->name }}</strong></td>
								<td>{{ $type->code ?? 'N/A' }}</td>
								<td>{{ Str::limit($type->description ?? 'N/A', 50) }}</td>
								<td>{{ $type->trainings()->count() }}</td>
								<td>
									@if($type->is_active)
										<span class="badge badge-success d-inline-flex align-items-center badge-xs">
											<i class="ti ti-point-filled me-1"></i>Active
										</span>
									@else
										<span class="badge badge-danger d-inline-flex align-items-center badge-xs">
											<i class="ti ti-point-filled me-1"></i>Inactive
										</span>
									@endif
								</td>
								<td>
									<div class="action-icon d-inline-flex">
										<a href="{{ route('training.types.show', $type->id) }}" class="me-2" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('training.types.edit', $type->id) }}" class="me-2" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										<form action="{{ route('training.types.destroy', $type->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this training type?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-link p-0 text-danger" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="7" class="text-center">No training types found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

@extends('layouts.app')

@section('title', 'Employee Documents')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Employee Documents</h2>
			<p class="text-muted mb-0 fs-13">Manage and organize employee documentation</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('documents.create') }}" class="btn btn-primary d-flex align-items-center rounded-pill shadow-sm">
				<i class="ti ti-upload me-2"></i>Upload Document
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

	<div class="row mb-4">
		<!-- Total Documents -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body p-4">
					<div class="d-flex align-items-center justify-content-between">
						<div>
							<p class="text-muted fw-medium mb-1 fs-13">Total Documents</p>
							<h3 class="mb-0 fw-bold text-dark">{{ $documents->count() }}</h3>
						</div>
						<div class="avatar avatar-lg bg-primary-transparent text-primary rounded-circle">
							<i class="ti ti-file-text fs-24"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Total Documents -->

		<!-- Active Documents -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body p-4">
					<div class="d-flex align-items-center justify-content-between">
						<div>
							<p class="text-muted fw-medium mb-1 fs-13">Active</p>
							<h3 class="mb-0 fw-bold text-dark">{{ $documents->where('status', 'active')->count() }}</h3>
						</div>
						<div class="avatar avatar-lg bg-success-transparent text-success rounded-circle">
							<i class="ti ti-check fs-24"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Active Documents -->

		<!-- Expired Documents -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body p-4">
					<div class="d-flex align-items-center justify-content-between">
						<div>
							<p class="text-muted fw-medium mb-1 fs-13">Expired</p>
							<h3 class="mb-0 fw-bold text-dark">{{ $documents->where('status', 'expired')->count() }}</h3>
						</div>
						<div class="avatar avatar-lg bg-warning-transparent text-warning rounded-circle">
							<i class="ti ti-clock fs-24"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Expired Documents -->

		<!-- Archived Documents -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body p-4">
					<div class="d-flex align-items-center justify-content-between">
						<div>
							<p class="text-muted fw-medium mb-1 fs-13">Archived</p>
							<h3 class="mb-0 fw-bold text-dark">{{ $documents->where('status', 'archived')->count() }}</h3>
						</div>
						<div class="avatar avatar-lg bg-secondary-transparent text-secondary rounded-circle">
							<i class="ti ti-archive fs-24"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Archived Documents -->
	</div>

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-0 d-flex align-items-center justify-content-between pt-3 pb-2 flex-wrap row-gap-3">
			<h5 class="mb-0 fw-bold text-dark">Document List</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('documents.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
					<div class="input-group input-group-sm rounded-pill overflow-hidden border-light-subtle" style="min-width:260px;">
						<span class="input-group-text bg-white border-0 ps-3"><i class="ti ti-search text-muted"></i></span>
						<input type="text" name="q" value="{{ request('q') }}" class="form-control border-0 shadow-none ps-1" placeholder="Search title or number" onchange="this.form.submit()">
					</div>
					<div>
						<select name="employee_id" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" onchange="this.form.submit()">
							<option value="">All Employees</option>
							@foreach($employees as $employee)
								<option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<select name="status" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" onchange="this.form.submit()">
							<option value="">All Status</option>
							<option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
							<option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
							<option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
						</select>
					</div>
					<div>
						@if(request()->hasAny(['status', 'employee_id', 'q']))
							<a href="{{ route('documents.index') }}" class="btn btn-sm btn-light rounded-pill px-3 shadow-none">Clear</a>
						@endif
					</div>
				</form>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="bg-light-50">
						<tr>
							<th class="ps-3 border-0 text-muted fs-12 fw-medium text-uppercase">#</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Employee</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Title</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Document Number</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Issue Date</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($documents as $document)
							<tr class="border-bottom border-light">
								<td class="ps-3 text-muted">{{ $loop->iteration }}</td>
								<td>
									<div class="d-flex align-items-center">
										@if($document->employee && $document->employee->profile_picture)
											<span class="avatar avatar-sm me-2">
												<img src="{{ asset('storage/' . $document->employee->profile_picture) }}" alt="User" class="img-fluid rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
											</span>
										@elseif($document->employee)
											<span class="avatar avatar-sm bg-primary-transparent text-primary rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold" style="font-size: 0.75rem;">
												{{ strtoupper(substr($document->employee->name, 0, 1)) }}
											</span>
										@endif
										@if($document->employee)
											<a href="{{ route('employees.show', $document->employee->id) }}" class="text-dark fw-medium text-decoration-none transition-all hover-text-primary">{{ $document->employee->name }}</a>
										@else
											<span class="text-muted">N/A</span>
										@endif
									</div>
								</td>
								<td><strong class="text-dark fw-bold">{{ $document->title }}</strong></td>
								<td class="text-muted">{{ $document->document_number ?? 'N/A' }}</td>
								<td class="text-muted">{{ $document->issue_date ? $document->issue_date->format('d M, Y') : 'N/A' }}</td>
								<td>
									@if($document->status == 'active')
										<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Active
										</span>
									@elseif($document->status == 'expired')
										<span class="badge bg-warning-transparent text-warning rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Expired
										</span>
									@else
										<span class="badge bg-secondary-transparent text-secondary rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Archived
										</span>
									@endif
								</td>
								<td class="pe-3 text-end">
									<div class="d-flex justify-content-end gap-2">
										<a href="{{ route('documents.show', $document->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('documents.edit', $document->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-info hover-text-white transition-all" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										@if($document->file_path)
											<a href="{{ asset('storage/' . $document->file_path) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-success hover-text-white transition-all" target="_blank" data-bs-toggle="tooltip" title="Download"><i class="ti ti-download"></i></a>
										@endif
										<form action="{{ route('documents.destroy', $document->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this document?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-danger hover-text-white transition-all" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="7" class="text-center py-5">
									<div class="d-flex flex-column align-items-center">
										<div class="avatar avatar-xxl bg-light-50 rounded-circle mb-3 text-muted">
											<i class="ti ti-file-off fs-30"></i>
										</div>
										<h6 class="text-muted mb-0">No documents found</h6>
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

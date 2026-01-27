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

	<div class="row">
		<!-- Total Documents -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden position-relative">
				<div class="card-body d-flex align-items-center justify-content-between p-4">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-xl bg-primary-transparent text-primary rounded-circle shadow-sm"><i class="ti ti-file-text fs-24"></i></span>
						</div>
						<div class="ms-3 overflow-hidden">
							<p class="fs-13 fw-medium mb-1 text-muted text-truncate text-uppercase ls-1">Total Files</p>
							<h4 class="mb-0 fw-bold text-dark">{{ $documents->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Total Documents -->

		<!-- Active Documents -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden position-relative">
				<div class="card-body d-flex align-items-center justify-content-between p-4">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-xl bg-success-transparent text-success rounded-circle shadow-sm"><i class="ti ti-check fs-24"></i></span>
						</div>
						<div class="ms-3 overflow-hidden">
							<p class="fs-13 fw-medium mb-1 text-muted text-truncate text-uppercase ls-1">Active</p>
							<h4 class="mb-0 fw-bold text-dark">{{ $documents->where('status', 'active')->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Active Documents -->

		<!-- Expired Documents -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden position-relative">
				<div class="card-body d-flex align-items-center justify-content-between p-4">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-xl bg-danger-transparent text-danger rounded-circle shadow-sm"><i class="ti ti-clock fs-24"></i></span>
						</div>
						<div class="ms-3 overflow-hidden">
							<p class="fs-13 fw-medium mb-1 text-muted text-truncate text-uppercase ls-1">Expired</p>
							<h4 class="mb-0 fw-bold text-dark">{{ $documents->where('status', 'expired')->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Expired Documents -->

		<!-- Archived Documents -->
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden position-relative">
				<div class="card-body d-flex align-items-center justify-content-between p-4">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-xl bg-warning-transparent text-warning rounded-circle shadow-sm"><i class="ti ti-archive fs-24"></i></span>
						</div>
						<div class="ms-3 overflow-hidden">
							<p class="fs-13 fw-medium mb-1 text-muted text-truncate text-uppercase ls-1">Archived</p>
							<h4 class="mb-0 fw-bold text-dark">{{ $documents->where('status', 'archived')->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Archived Documents -->
	</div>

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2 d-flex align-items-center justify-content-between flex-wrap gap-3">
			<h5 class="mb-0 fw-bold text-dark">Document List</h5>
			<div class="d-flex align-items-center gap-2 flex-wrap">
				<form method="GET" action="{{ route('documents.index') }}" class="d-flex gap-2 flex-wrap align-items-center">
					<div class="search-box">
						<div class="input-group input-group-sm rounded-pill overflow-hidden border-light-subtle shadow-none" style="min-width:240px;">
							<span class="input-group-text bg-transparent border-0 ps-3"><i class="ti ti-search text-muted"></i></span>
							<input type="text" name="q" value="{{ request('q') }}" class="form-control border-0 shadow-none ps-1 fs-12" placeholder="Search documents...">
						</div>
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
					@if(request()->hasAny(['status', 'employee_id', 'q']))
						<a href="{{ route('documents.index') }}" class="btn btn-sm btn-light rounded-pill px-3 shadow-none">Clear</a>
					@endif
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
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Document Details</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Dates</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($documents as $document)
							<tr class="border-bottom border-light">
								<td class="ps-3 text-muted fs-12">{{ $loop->iteration }}</td>
								<td>
									<div class="d-flex align-items-center">
										@if($document->employee && $document->employee->profile_picture)
											<div class="avatar avatar-md rounded-circle me-2 overflow-hidden shadow-sm border border-2 border-white">
												<img src="{{ asset('storage/' . $document->employee->profile_picture) }}" alt="User" class="img-fluid" style="object-fit: cover;">
											</div>
										@elseif($document->employee)
											<div class="avatar avatar-md bg-primary-transparent text-primary rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold shadow-sm">
												{{ strtoupper(substr($document->employee->name, 0, 1)) }}
											</div>
										@endif
										<div>
											@if($document->employee)
												<h6 class="mb-0 fs-14"><a href="{{ route('employees.show', $document->employee->id) }}" class="text-dark fw-bold text-decoration-none hover-text-primary transition-all">{{ $document->employee->name }}</a></h6>
												<span class="fs-12 text-muted">{{ $document->employee->employee_id ?? 'EMP-ID' }}</span>
											@else
												<span class="text-muted">N/A</span>
											@endif
										</div>
									</div>
								</td>
								<td>
									<h6 class="mb-0 fs-14 fw-bold text-dark">{{ $document->title }}</h6>
									<span class="fs-12 text-muted">No: {{ $document->document_number ?? 'N/A' }}</span>
								</td>
								<td>
									<div class="d-flex flex-column">
										<span class="fs-13 text-dark"><i class="ti ti-calendar-event me-1 text-muted"></i>{{ $document->issue_date ? $document->issue_date->format('d M, Y') : 'N/A' }}</span>
										@if($document->expiry_date)
											<span class="fs-11 text-{{ $document->expiry_date->isPast() ? 'danger' : 'muted' }}">Expires: {{ $document->expiry_date->format('d M, Y') }}</span>
										@endif
									</div>
								</td>
								<td>
									@if($document->status == 'active')
										<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Active
										</span>
									@elseif($document->status == 'expired')
										<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
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
										<a href="{{ route('documents.show', $document->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('documents.edit', $document->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										@if($document->file_path)
											<a href="{{ asset('storage/' . $document->file_path) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-success hover-text-white transition-all shadow-sm" target="_blank" data-bs-toggle="tooltip" title="Download"><i class="ti ti-download"></i></a>
										@endif
										<form action="{{ route('documents.destroy', $document->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this document?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-danger hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="6" class="text-center py-5">
									<div class="d-flex flex-column align-items-center justify-content-center">
										<div class="avatar avatar-xxl bg-light-50 rounded-circle mb-3 text-muted">
											<i class="ti ti-file-off fs-30"></i>
										</div>
										<p class="text-muted mb-0">No documents found.</p>
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

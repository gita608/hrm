@extends('layouts.app')

@section('title', 'Employee Documents')

@section('content')

	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Employee Documents</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<a href="{{ route('documents.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-upload me-2"></i>Upload Employee Document</a>
			</div>
			<div class="head-icons ms-2">
				<a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header">
					<i class="ti ti-chevrons-up"></i>
				</a>
			</div>
		</div>
	</div>

	@if(session('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			{{ session('success') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	<div class="row">
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-lg bg-primary rounded-circle"><i class="ti ti-file-text"></i></span>
						</div>
						<div class="ms-2 overflow-hidden">
							<p class="fs-12 fw-medium mb-1 text-truncate">Total Documents</p>
							<h4>{{ $documents->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-lg bg-success rounded-circle"><i class="ti ti-check"></i></span>
						</div>
						<div class="ms-2 overflow-hidden">
							<p class="fs-12 fw-medium mb-1 text-truncate">Active</p>
							<h4>{{ $documents->where('status', 'active')->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-lg bg-warning rounded-circle"><i class="ti ti-clock"></i></span>
						</div>
						<div class="ms-2 overflow-hidden">
							<p class="fs-12 fw-medium mb-1 text-truncate">Expired</p>
							<h4>{{ $documents->where('status', 'expired')->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-lg bg-secondary rounded-circle"><i class="ti ti-archive"></i></span>
						</div>
						<div class="ms-2 overflow-hidden">
							<p class="fs-12 fw-medium mb-1 text-truncate">Archived</p>
							<h4>{{ $documents->where('status', 'archived')->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
			<h5>Employee Document List</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('documents.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
					<div class="input-group input-group-sm" style="min-width:260px;">
						<span class="input-group-text bg-white"><i class="ti ti-search"></i></span>
						<input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search title or number">
					</div>
					<div>
						<select name="employee_id" class="form-select form-select-sm">
							<option value="">All Employees</option>
							@foreach($employees as $employee)
								<option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<select name="status" class="form-select form-select-sm">
							<option value="">All Status</option>
							<option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
							<option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
							<option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
						</select>
					</div>
					<div>
						<button type="submit" class="btn btn-sm btn-primary">Filter</button>
						@if(request()->hasAny(['status', 'employee_id', 'q']))
							<a href="{{ route('documents.index') }}" class="btn btn-sm btn-outline-light border">Clear</a>
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
							<th>Employee</th>
							<th>Title</th>
							<th>Document Number</th>
							<th>Issue Date</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($documents as $document)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>
									<div class="d-flex align-items-center">
										@if($document->employee && $document->employee->profile_picture)
											<span class="avatar avatar-sm me-2">
												<img src="{{ asset('storage/' . $document->employee->profile_picture) }}" alt="User" class="img-fluid rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
											</span>
										@elseif($document->employee)
											<span class="avatar avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="font-size: 0.875rem; font-weight: 600;">
												{{ strtoupper(substr($document->employee->name, 0, 1)) }}
											</span>
										@endif
										@if($document->employee)
											<a href="{{ route('employees.show', $document->employee->id) }}" class="text-decoration-none">{{ $document->employee->name }}</a>
										@else
											<span class="text-muted">N/A</span>
										@endif
									</div>
								</td>
								<td><strong>{{ $document->title }}</strong></td>
								<td>{{ $document->document_number ?? 'N/A' }}</td>
								<td>{{ $document->issue_date ? $document->issue_date->format('d M, Y') : 'N/A' }}</td>
								<td>
									@if($document->status == 'active')
										<span class="badge badge-success d-inline-flex align-items-center badge-xs">
											<i class="ti ti-point-filled me-1"></i>Active
										</span>
									@elseif($document->status == 'expired')
										<span class="badge badge-warning d-inline-flex align-items-center badge-xs">
											<i class="ti ti-point-filled me-1"></i>Expired
										</span>
									@else
										<span class="badge badge-secondary d-inline-flex align-items-center badge-xs">
											<i class="ti ti-point-filled me-1"></i>Archived
										</span>
									@endif
								</td>
								<td>
									<div class="action-icon d-inline-flex">
										<a href="{{ route('documents.show', $document->id) }}" class="me-2" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('documents.edit', $document->id) }}" class="me-2" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										@if($document->file_path)
											<a href="{{ asset('storage/' . $document->file_path) }}" class="me-2" target="_blank" data-bs-toggle="tooltip" title="Download"><i class="ti ti-download"></i></a>
										@endif
										<form action="{{ route('documents.destroy', $document->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this document?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-link p-0 text-danger" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="7" class="text-center">No documents found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

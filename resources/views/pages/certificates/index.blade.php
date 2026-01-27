@extends('layouts.app')

@section('title', 'Certificates')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Certificates</h2>
			<p class="text-muted mb-0 fs-13">Manage employee certifications and licenses</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('certificates.create') }}" class="btn btn-primary rounded-pill shadow-sm py-2 px-3">
				<i class="ti ti-plus me-2"></i>Add Certificate
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
		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-lg bg-primary-transparent text-primary rounded-circle"><i class="ti ti-certificate fs-24"></i></span>
						</div>
						<div class="ms-3 overflow-hidden">
							<p class="fs-12 fw-medium mb-1 text-muted text-uppercase">Total Certificates</p>
							<h4 class="mb-0 fw-bold text-dark">{{ $certificates->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-lg bg-success-transparent text-success rounded-circle"><i class="ti ti-check fs-24"></i></span>
						</div>
						<div class="ms-3 overflow-hidden">
							<p class="fs-12 fw-medium mb-1 text-muted text-uppercase">Active</p>
							<h4 class="mb-0 fw-bold text-dark">{{ $certificates->where('status', 'active')->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-lg bg-warning-transparent text-warning rounded-circle"><i class="ti ti-clock fs-24"></i></span>
						</div>
						<div class="ms-3 overflow-hidden">
							<p class="fs-12 fw-medium mb-1 text-muted text-uppercase">Expired</p>
							<h4 class="mb-0 fw-bold text-dark">{{ $certificates->where('status', 'expired')->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-lg bg-danger-transparent text-danger rounded-circle"><i class="ti ti-x fs-24"></i></span>
						</div>
						<div class="ms-3 overflow-hidden">
							<p class="fs-12 fw-medium mb-1 text-muted text-uppercase">Revoked</p>
							<h4 class="mb-0 fw-bold text-dark">{{ $certificates->where('status', 'revoked')->count() }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2 d-flex align-items-center justify-content-between flex-wrap row-gap-3">
			<h5 class="mb-0 fw-bold text-dark">Certificate List</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('certificates.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
					<div>
						<select name="status" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" onchange="this.form.submit()">
							<option value="">All Status</option>
							<option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
							<option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
							<option value="revoked" {{ request('status') == 'revoked' ? 'selected' : '' }}>Revoked</option>
						</select>
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
						@if(request()->hasAny(['status', 'employee_id']))
							<a href="{{ route('certificates.index') }}" class="btn btn-sm btn-light rounded-pill px-3 shadow-sm border-0">Clear</a>
						@endif
					</div>
				</form>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="custom-datatable-filter table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="bg-light-50">
						<tr>
							<th class="ps-3 border-0 text-muted fs-12 fw-medium text-uppercase">#</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Certificate Number</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Title</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Type</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Employee</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Issue Date</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($certificates as $certificate)
							<tr class="border-bottom border-light">
								<td class="ps-3 text-muted fs-12">{{ $loop->iteration }}</td>
								<td class="text-dark fw-bold fs-13">{{ $certificate->certificate_number }}</td>
								<td class="text-dark fs-13">{{ $certificate->title }}</td>
								<td><span class="badge bg-light text-dark border rounded-pill">{{ ucfirst($certificate->certificate_type) }}</span></td>
								<td>
									<div class="d-flex align-items-center">
										@if($certificate->employee->profile_picture)
											<a href="#" class="avatar avatar-sm rounded-circle me-2 overflow-hidden shadow-sm border border-2 border-white">
												<img src="{{ asset('storage/' . $certificate->employee->profile_picture) }}" class="img-fluid" alt="img" style="object-fit: cover;">
											</a>
										@else
											<div class="avatar avatar-sm bg-primary-transparent text-primary rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold shadow-sm">
												{{ strtoupper(substr($certificate->employee->name, 0, 1)) }}
											</div>
										@endif
										<span class="text-dark fw-medium fs-13">{{ $certificate->employee->name }}</span>
									</div>
								</td>
								<td class="text-muted fs-12">{{ $certificate->issue_date->format('d M, Y') }}</td>
								<td>
									@if($certificate->status == 'active')
										<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Active
										</span>
									@elseif($certificate->status == 'expired')
										<span class="badge bg-warning-transparent text-warning rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Expired
										</span>
									@else
										<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Revoked
										</span>
									@endif
								</td>
								<td class="pe-3 text-end">
									<div class="d-flex justify-content-end gap-2">
										<a href="{{ route('certificates.show', $certificate->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="View">
											<i class="ti ti-eye"></i>
										</a>
										<a href="{{ route('certificates.edit', $certificate->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all shadow-sm" data-bs-toggle="tooltip" title="Edit">
											<i class="ti ti-edit"></i>
										</a>
										@if($certificate->file_path)
											<a href="{{ asset('storage/' . $certificate->file_path) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-info hover-text-white transition-all shadow-sm" target="_blank" data-bs-toggle="tooltip" title="Download">
												<i class="ti ti-download"></i>
											</a>
										@endif
										<form action="{{ route('certificates.destroy', $certificate->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this certificate?');">
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
								<td colspan="8" class="text-center py-5">
									<div class="d-flex flex-column align-items-center justify-content-center">
										<div class="avatar avatar-xxl bg-light-50 rounded-circle mb-3 text-muted">
											<i class="ti ti-files-off fs-30"></i>
										</div>
										<p class="text-muted mb-0">No certificates found.</p>
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

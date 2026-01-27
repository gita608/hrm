@extends('layouts.app')

@section('title', 'Employees')

@section('content')

		<!-- Page Header -->
		<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
			<div class="my-auto">
				<h2 class="mb-1 text-dark fw-bold">Employees</h2>
				<p class="text-muted mb-0 fs-13">Manage your workforce</p>
			</div>
			<div class="d-flex align-items-center gap-2">
				<div class="d-flex align-items-center bg-white rounded-pill p-1 shadow-sm border border-light">
					<a href="{{ url("/employees") }}" class="btn btn-primary rounded-circle btn-icon btn-sm"><i class="ti ti-list-tree fs-14"></i></a>
					<a href="{{ url("/employees/grid") }}" class="btn btn-light rounded-circle btn-icon btn-sm text-muted hover-text-primary"><i class="ti ti-layout-grid fs-14"></i></a>
				</div>
				<a href="{{ route('employees.create') }}" class="btn btn-primary rounded-pill shadow-sm py-2 px-3">
					<i class="ti ti-plus me-1"></i>Add Employee
				</a>
			</div>
		</div>
		<!-- /Page Header -->

		<div class="row mb-4">
			<!-- Total Employee -->
			<div class="col-xl-3 col-md-6 d-flex">
				<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
					<div class="card-body p-4">
						<div class="d-flex align-items-center justify-content-between">
							<div>
								<p class="text-muted fw-medium mb-1 fs-13">Total Employees</p>
								<h3 class="mb-0 fw-bold text-dark">{{ $totalEmployees ?? 0 }}</h3>
							</div>
							<div class="avatar avatar-lg bg-dark-transparent text-dark rounded-circle">
								<i class="ti ti-users fs-24"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /Total Employee -->

			<!-- Active -->
			<div class="col-xl-3 col-md-6 d-flex">
				<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
					<div class="card-body p-4">
						<div class="d-flex align-items-center justify-content-between">
							<div>
								<p class="text-muted fw-medium mb-1 fs-13">Active</p>
								<h3 class="mb-0 fw-bold text-dark">{{ $activeEmployees ?? 0 }}</h3>
							</div>
							<div class="avatar avatar-lg bg-success-transparent text-success rounded-circle">
								<i class="ti ti-user-check fs-24"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /Active -->

			<!-- Inactive -->
			<div class="col-xl-3 col-md-6 d-flex">
				<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
					<div class="card-body p-4">
						<div class="d-flex align-items-center justify-content-between">
							<div>
								<p class="text-muted fw-medium mb-1 fs-13">Inactive</p>
								<h3 class="mb-0 fw-bold text-dark">{{ $inactiveEmployees ?? 0 }}</h3>
							</div>
							<div class="avatar avatar-lg bg-danger-transparent text-danger rounded-circle">
								<i class="ti ti-user-x fs-24"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /Inactive -->

			<!-- New Joiners -->
			<div class="col-xl-3 col-md-6 d-flex">
				<div class="card flex-fill border-0 shadow-sm rounded-4 overflow-hidden">
					<div class="card-body p-4">
						<div class="d-flex align-items-center justify-content-between">
							<div>
								<p class="text-muted fw-medium mb-1 fs-13">New Joiners</p>
								<h3 class="mb-0 fw-bold text-dark">{{ $newJoiners ?? 0 }}</h3>
							</div>
							<div class="avatar avatar-lg bg-info-transparent text-info rounded-circle">
								<i class="ti ti-user-plus fs-24"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /New Joiners -->
		</div>

		<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
			<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2 d-flex align-items-center justify-content-between flex-wrap row-gap-3">
				<h5 class="mb-0 fw-bold text-dark">Employee List</h5>
				<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
					<form method="GET" action="{{ route('employees.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
						<div>
							<select name="department_id" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none">
								<option value="">All Departments</option>
								@foreach($departments as $dept)
									<option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
								@endforeach
							</select>
						</div>
						<div>
							<select name="designation_id" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none">
								<option value="">All Designations</option>
								@foreach($designations as $desig)
									<option value="{{ $desig->id }}" {{ request('designation_id') == $desig->id ? 'selected' : '' }}>{{ $desig->name }}</option>
								@endforeach
							</select>
						</div>
						<div>
							<select name="status" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none">
								<option value="">All Status</option>
								<option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
								<option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
							</select>
						</div>
						<div>
							<button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">Filter</button>
							@if(request()->hasAny(['department_id', 'designation_id', 'status']))
								<a href="{{ route('employees.index') }}" class="btn btn-sm btn-light rounded-pill px-3">Clear</a>
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
								<th class="ps-3 border-0 text-muted fs-12 fw-medium text-uppercase" style="width: 50px;">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" id="select-all">
									</div>
								</th>
								<th class="border-0 text-muted fs-12 fw-medium text-uppercase">#</th>
								<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Emp ID</th>
								<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Name</th>
								<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Email</th>
								<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Phone</th>
								<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Role</th>
								<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Joining Date</th>
								<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
								<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
							</tr>
						</thead>
						<tbody>
							@forelse($employees ?? [] as $index => $employee)
							<tr class="border-bottom border-light">
								<td class="ps-3">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="{{ $employee->id }}">
									</div>
								</td>
								<td class="text-muted">{{ $index + 1 }}</td>
								<td><a href="{{ route('employees.show', $employee->id) }}" class="text-primary fw-medium">EMP-{{ str_pad($employee->id, 3, '0', STR_PAD_LEFT) }}</a></td>
								<td>
									<div class="d-flex align-items-center">
										@if($employee->profile_picture)
											<a href="{{ route('employees.show', $employee->id) }}" class="avatar avatar-md rounded-circle me-2 overflow-hidden shadow-sm border border-2 border-white">
												<img src="{{ asset('storage/' . $employee->profile_picture) }}" class="img-fluid" alt="img" style="object-fit: cover;">
											</a>
										@else
											<a href="{{ route('employees.show', $employee->id) }}" class="avatar avatar-md bg-primary-transparent text-primary rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold shadow-sm" style="text-decoration: none;">
												{{ strtoupper(substr($employee->name, 0, 1)) }}
											</a>
										@endif
										<div>
											<h6 class="text-dark mb-0 fw-bold"><a href="{{ route('employees.show', $employee->id) }}" class="text-dark">{{ $employee->name }}</a></h6>
											@if($employee->designation)
												<span class="fs-11 text-muted">{{ $employee->designation->name }}</span>
											@elseif($employee->role)
												<span class="fs-11 text-muted">{{ $employee->role->name }}</span>
											@endif
										</div>
									</div>
								</td>
								<td class="text-muted">{{ $employee->email }}</td>
								<td class="text-muted">{{ $employee->phone ?? 'N/A' }}</td>
								<td>
									@if($employee->role)
										<span class="badge bg-light text-dark border border-light-subtle rounded-pill px-2 py-1 fw-normal">{{ $employee->role->name }}</span>
									@else
										<span class="text-muted">N/A</span>
									@endif
								</td>
								<td class="text-muted">{{ $employee->created_at ? $employee->created_at->format('d M Y') : 'N/A' }}</td>
								<td>
									@if($employee->email_verified_at || $employee->status === 'active')
										<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Active
										</span>
									@else
										<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-point-filled me-1 fs-10"></i>Inactive
										</span>
									@endif
								</td>
								<td class="pe-3 text-end">
									<div class="d-flex justify-content-end gap-2">
										<a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-info hover-text-white transition-all"><i class="ti ti-edit"></i></a>
										<a href="#" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-danger hover-text-white transition-all" data-bs-toggle="modal" data-bs-target="#delete_modal" onclick="setDeleteEmployeeId({{ $employee->id }})"><i class="ti ti-trash"></i></a>
									</div>
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="10" class="text-center py-5">
									<div class="d-flex flex-column align-items-center">
										<div class="avatar avatar-xxl bg-light-50 rounded-circle mb-3 text-muted">
											<i class="ti ti-users-minus fs-30"></i>
										</div>
										<h6 class="text-muted mb-0">No employees found</h6>
									</div>
								</td>
							</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>

		</div>

	<!-- Delete Modal -->
	<div class="modal fade" id="success_modal" role="dialog">
		<div class="modal-dialog modal-dialog-centered modal-sm">
		<div class="modal-content">
			<div class="modal-body">
			<div class="text-center p-3">
				<span class="avatar avatar-lg avatar-rounded bg-success mb-3"><i class="ti ti-check fs-24"></i></span>
				<h5 class="mb-2">Employee Added Successfully</h5>
				<p class="mb-3">Stephan Peralt has been added with Client ID : <span class="text-primary">#EMP - 0001</span>
				</p>
				<div>
					<div class="row g-2">
						<div class="col-6">
							<a href="{{ url("/employees") }}" class="btn btn-dark w-100">Back to List</a>
						</div>
						<div class="col-6">
							<a href="{{ url("/employees/details") }}" class="btn btn-primary w-100">Detail Page</a>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
		</div>
	</div>
	<!-- /Add Client Success -->

	<!-- Delete Modal -->
	<div class="modal fade" id="delete_modal">
		<div class="modal-dialog modal-dialog-centered modal-sm">
		<div class="modal-content">
			<div class="modal-body text-center">
			<span class="avatar avatar-xl bg-transparent-danger text-danger mb-3">
				<i class="ti ti-trash-x fs-36"></i>
			</span>
			<h4 class="mb-1">Confirm Delete</h4>
			<p class="mb-3">You want to delete all the marked items, this cant be undone once you delete.</p>
			<div class="d-flex justify-content-center">
				<a href="javascript:void(0);" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</a>
				<a href="{{ url("/employees") }}" class="btn btn-danger">Yes, Delete</a>
			</div>
			</div>
		</div>
		</div>
	</div>
	<!-- /Delete Modal -->
@endsection

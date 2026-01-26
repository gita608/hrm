@extends('layouts.app')

@section('title', 'Employees')

@section('content')

		<!-- Breadcrumb -->
		<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
			<div class="my-auto mb-2">
			<h2 class="mb-1">Employee</h2>

			</div>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
			<div class="me-2 mb-2">
				<div class="d-flex align-items-center border bg-white rounded p-1 me-2 icon-list">
					<a href="{{ url("/employees") }}" class="btn btn-icon btn-sm active bg-primary text-white me-1"><i class="ti ti-list-tree"></i></a>
					<a href="{{ url("/employees/grid") }}" class="btn btn-icon btn-sm"><i class="ti ti-layout-grid"></i></a>
				</div>
			</div>
			<div class="me-2 mb-2">
				<div class="dropdown">
					<a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center" data-bs-toggle="dropdown">
						<i class="ti ti-file-export me-1"></i>Export
					</a>
					<ul class="dropdown-menu  dropdown-menu-end p-3">
						<li>
							<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-file-type-pdf me-1"></i>Export as PDF</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-file-type-xls me-1"></i>Export as Excel </a>
						</li>
					</ul>
				</div>
			</div>
			<div class="mb-2">
				<a href="{{ route('employees.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Employee</a>
			</div>
			<div class="head-icons ms-2">
				<a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header">
					<i class="ti ti-chevrons-up"></i>
				</a>
			</div>
			</div>
		</div>
		<!-- /Breadcrumb -->

		<div class="row">

			<!-- Total Plans -->
			<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-lg bg-dark rounded-circle"><i class="ti ti-users"></i></span>
						</div>
						<div class="ms-2 overflow-hidden">
							<p class="fs-12 fw-medium mb-1 text-truncate">Total Employee</p>
							<h4>{{ $totalEmployees ?? 0 }}</h4>
						</div>
					</div>
					<div>                                    
						<span class="badge badge-soft-purple badge-sm fw-normal">
							<i class="ti ti-users"></i>
						</span>
                                </div>
				</div>
			</div>
			</div>
			<!-- /Total Plans -->

			<!-- Total Plans -->
			<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-lg bg-success rounded-circle"><i class="ti ti-user-share"></i></span>
						</div>
						<div class="ms-2 overflow-hidden">
							<p class="fs-12 fw-medium mb-1 text-truncate">Active</p>
							<h4>{{ $activeEmployees ?? 0 }}</h4>
						</div>
					</div>
					<div>                                    
						<span class="badge badge-soft-primary badge-sm fw-normal">
							<i class="ti ti-user-share"></i>
						</span>
                                </div>
				</div>
			</div>
			</div>
			<!-- /Total Plans -->

			<!-- Inactive Plans -->
			<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-lg bg-danger rounded-circle"><i class="ti ti-user-pause"></i></span>
						</div>
						<div class="ms-2 overflow-hidden">
							<p class="fs-12 fw-medium mb-1 text-truncate">InActive</p>
							<h4>{{ $inactiveEmployees ?? 0 }}</h4>
						</div>
					</div>
					<div>                                    
						<span class="badge badge-soft-dark badge-sm fw-normal">
							<i class="ti ti-user-pause"></i>
						</span>
                                </div>
				</div>
			</div>
			</div>
			<!-- /Inactive Companies -->

			<!-- No of Plans  -->
			<div class="col-lg-3 col-md-6 d-flex">
			<div class="card flex-fill">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div class="d-flex align-items-center overflow-hidden">
						<div>
							<span class="avatar avatar-lg bg-info rounded-circle"><i class="ti ti-user-plus"></i></span>
						</div>
						<div class="ms-2 overflow-hidden">
							<p class="fs-12 fw-medium mb-1 text-truncate">New Joiners</p>
							<h4>{{ $newJoiners ?? 0 }}</h4>
						</div>
					</div>
					<div>                                    
						<span class="badge badge-soft-secondary badge-sm fw-normal">
							<i class="ti ti-user-plus"></i>
						</span>
                                </div>
				</div>
			</div>
			</div>
			<!-- /No of Plans -->

		</div>

		<div class="card">
			<div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
			<h5>Employee List</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('employees.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
					<div>
						<select name="department_id" class="form-select form-select-sm">
							<option value="">All Departments</option>
							@foreach($departments as $dept)
								<option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<select name="designation_id" class="form-select form-select-sm">
							<option value="">All Designations</option>
							@foreach($designations as $desig)
								<option value="{{ $desig->id }}" {{ request('designation_id') == $desig->id ? 'selected' : '' }}>{{ $desig->name }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<select name="status" class="form-select form-select-sm">
							<option value="">All Status</option>
							<option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
							<option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
						</select>
					</div>
					<div>
						<button type="submit" class="btn btn-sm btn-primary">Filter</button>
						@if(request()->hasAny(['department_id', 'designation_id', 'status']))
							<a href="{{ route('employees.index') }}" class="btn btn-sm btn-outline-light border">Clear</a>
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
							<th class="no-sort">
								<div class="form-check form-check-md">
									<input class="form-check-input" type="checkbox" id="select-all">
								</div>
							</th>
							<th>#</th>
							<th>Emp ID</th>
							<th>Name</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Designation</th>
							<th>Joining Date</th>
							<th>Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@forelse($employees ?? [] as $index => $employee)
						<tr>
							<td>
								<div class="form-check form-check-md">
									<input class="form-check-input" type="checkbox" value="{{ $employee->id }}">
								</div>
							</td>
							<td>{{ $index + 1 }}</td>
							<td><a href="{{ route('employees.show', $employee->id) }}">EMP-{{ str_pad($employee->id, 3, '0', STR_PAD_LEFT) }}</a></td>
							<td>
								<div class="d-flex align-items-center">
									<a href="{{ route('employees.show', $employee->id) }}" class="avatar avatar-md">
										@if($employee->profile_picture)
											<img src="{{ asset('storage/' . $employee->profile_picture) }}" class="img-fluid rounded-circle" alt="img">
										@else
											<div class="avatar-initial bg-primary text-white rounded-circle d-flex align-items-center justify-content-center">
												{{ strtoupper(substr($employee->name, 0, 1)) }}
											</div>
										@endif
									</a>
									<div class="ms-2">
										<p class="text-dark mb-0"><a href="{{ route('employees.show', $employee->id) }}">{{ $employee->name }}</a></p>
										@if($employee->role)
											<span class="fs-12">{{ $employee->role->name }}</span>
										@endif
									</div>
								</div>
							</td>
							<td><a href="mailto:{{ $employee->email }}">{{ $employee->email }}</a></td>
							<td>{{ $employee->phone ?? 'N/A' }}</td>
							<td>
								@if($employee->role)
									<span class="badge badge-soft-primary">{{ $employee->role->name }}</span>
								@else
									<span class="text-muted">N/A</span>
								@endif
							</td>
							<td>{{ $employee->created_at ? $employee->created_at->format('d M Y') : 'N/A' }}</td>
							<td>
								@if($employee->email_verified_at)
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
									<a href="{{ route('employees.edit', $employee->id) }}" class="me-2"><i class="ti ti-edit"></i></a>
									<a href="#" data-bs-toggle="modal" data-bs-target="#delete_modal" onclick="setDeleteEmployeeId({{ $employee->id }})"><i class="ti ti-trash"></i></a>
								</div>
							</td>
						</tr>
						@empty
						<tr>
							<td colspan="9" class="text-center py-4">
								<p class="text-muted mb-0">No employees found.</p>
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

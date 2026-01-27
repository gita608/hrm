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

		<div class="row g-3 mb-4">
			<div class="col-xl-3 col-sm-6">
				<div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
					<div class="card-body p-4 bg-primary text-white position-relative overflow-hidden">
						<div class="position-absolute top-0 end-0 p-3 opacity-10">
							<i class="ti ti-users fs-48"></i>
						</div>
						<div class="d-flex align-items-center mb-3">
							<div class="avatar avatar-md bg-white-transparent text-white rounded-3 d-flex align-items-center justify-content-center me-3 shadow-none">
								<i class="ti ti-users fs-20"></i>
							</div>
							<p class="mb-0 fw-medium fs-13 opacity-75">Workforce Strength</p>
						</div>
						<div class="d-flex align-items-end justify-content-between">
							<div>
								<h2 class="mb-0 fw-bold">{{ $totalEmployees ?? 0 }}</h2>
								<span class="fs-11 fw-medium opacity-75">Total Headcount</span>
							</div>
							<div class="text-end">
								@php $growth = 4.5; @endphp
								<span class="badge bg-white text-primary rounded-pill px-2 py-1 fs-11 fw-bold">
									<i class="ti ti-trending-up me-1"></i>{{ $growth }}%
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6">
				<div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
					<div class="card-body p-4 bg-white position-relative">
						<div class="d-flex align-items-center mb-3">
							<div class="avatar avatar-md bg-success-transparent text-success rounded-3 d-flex align-items-center justify-content-center me-3 shadow-none">
								<i class="ti ti-user-check fs-20"></i>
							</div>
							<p class="mb-0 fw-medium fs-13 text-muted">Active Users</p>
						</div>
						<div class="d-flex align-items-end justify-content-between">
							<div>
								<h2 class="mb-0 fw-bold text-dark">{{ $activeEmployees ?? 0 }}</h2>
								<span class="fs-11 fw-medium text-muted">Current Presence</span>
							</div>
							<div class="text-end">
								<div class="progress progress-xs w-60px bg-success-transparent mt-2">
									<div class="progress-bar bg-success" role="progressbar" style="width: 85%"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6">
				<div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
					<div class="card-body p-4 bg-white position-relative">
						<div class="d-flex align-items-center mb-3">
							<div class="avatar avatar-md bg-danger-transparent text-danger rounded-3 d-flex align-items-center justify-content-center me-3 shadow-none">
								<i class="ti ti-user-x fs-20"></i>
							</div>
							<p class="mb-0 fw-medium fs-13 text-muted">Inactive Personnel</p>
						</div>
						<div class="d-flex align-items-end justify-content-between">
							<div>
								<h2 class="mb-0 fw-bold text-dark">{{ $inactiveEmployees ?? 0 }}</h2>
								<span class="fs-11 fw-medium text-muted">On Probation/Leave</span>
							</div>
							<div class="text-end">
								<p class="mb-0 text-danger fs-11 fw-bold">Manual Audit</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6">
				<div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
					<div class="card-body p-4 bg-white position-relative">
						<div class="d-flex align-items-center mb-3">
							<div class="avatar avatar-md bg-info-transparent text-info rounded-3 d-flex align-items-center justify-content-center me-3 shadow-none">
								<i class="ti ti-user-plus fs-20"></i>
							</div>
							<p class="mb-0 fw-medium fs-13 text-muted">New Recruitment</p>
						</div>
						<div class="d-flex align-items-end justify-content-between">
							<div>
								<h2 class="mb-0 fw-bold text-dark">{{ $newJoiners ?? 0 }}</h2>
								<span class="fs-11 fw-medium text-muted">Joined This Month</span>
							</div>
							<div class="text-end">
								<div class="avatar-list-stacked d-flex">
									<span class="avatar avatar-xs rounded-circle border border-2 border-white bg-light text-muted fw-bold">
										<i class="ti ti-plus fs-10"></i>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
			<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2 d-flex align-items-center justify-content-between flex-wrap g-3">
				<h5 class="mb-0 fw-bold text-dark">Staff Directory</h5>
				<div class="d-flex align-items-center flex-wrap gap-2">
					<form method="GET" action="{{ route('employees.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
						<div class="input-group input-group-sm rounded-3 overflow-hidden border">
							<span class="input-group-text bg-light border-0"><i class="ti ti-filter fs-12"></i></span>
							<select name="department_id" class="form-select border-0 fs-12 shadow-none bg-light" style="min-width: 140px;">
								<option value="">Departments</option>
								@foreach($departments as $dept)
									<option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="input-group input-group-sm rounded-3 overflow-hidden border">
							<select name="status" class="form-select border-0 fs-12 shadow-none bg-light" style="min-width: 110px;">
								<option value="">All Status</option>
								<option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
								<option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
							</select>
						</div>
						<button type="submit" class="btn btn-sm btn-primary rounded-3 px-3 shadow-none">Apply</button>
						@if(request()->hasAny(['department_id', 'designation_id', 'status']))
							<a href="{{ route('employees.index') }}" class="btn btn-sm btn-light rounded-3 px-2 text-muted border"><i class="ti ti-refresh"></i></a>
						@endif
					</form>
				</div>
			</div>
			<div class="card-body p-0">
				<div class="table-responsive">
					<table class="table table-hover align-middle mb-0">
						<thead class="bg-light-50">
							<tr>
								<th class="ps-4 border-0 text-muted fs-11 fw-bold text-uppercase ls-1">Employee Profile</th>
								<th class="border-0 text-muted fs-11 fw-bold text-uppercase ls-1">Contact Info</th>
								<th class="border-0 text-muted fs-11 fw-bold text-uppercase ls-1">Organization</th>
								<th class="border-0 text-muted fs-11 fw-bold text-uppercase ls-1">Joining Details</th>
								<th class="border-0 text-muted fs-11 fw-bold text-uppercase ls-1 text-center">System Access</th>
								<th class="pe-4 border-0 text-end text-muted fs-11 fw-bold text-uppercase ls-1">Action</th>
							</tr>
						</thead>
						<tbody>
							@forelse($employees ?? [] as $index => $employee)
							<tr class="border-bottom border-light">
								<td class="ps-4">
									<div class="d-flex align-items-center">
										@if($employee->profile_picture)
											<div class="position-relative">
												<img src="{{ asset('storage/' . $employee->profile_picture) }}" class="avatar avatar-lg rounded-4 shadow-sm object-fit-cover border border-2 border-white" alt="img">
												<span class="position-absolute bottom-0 end-0 p-1 bg-{{ $employee->status === 'active' ? 'success' : 'danger' }} border border-2 border-white rounded-circle"></span>
											</div>
										@else
											<div class="position-relative">
												<div class="avatar avatar-lg bg-primary-transparent text-primary rounded-4 d-flex align-items-center justify-content-center fw-bold shadow-sm border border-2 border-white">
													{{ strtoupper(substr($employee->name, 0, 1)) }}
												</div>
												<span class="position-absolute bottom-0 end-0 p-1 bg-{{ $employee->status === 'active' ? 'success' : 'danger' }} border border-2 border-white rounded-circle"></span>
											</div>
										@endif
										<div class="ms-3">
											<h6 class="text-dark mb-0 fw-bold fs-14"><a href="{{ route('employees.show', $employee->id) }}" class="text-dark">{{ $employee->name }}</a></h6>
											<span class="badge bg-light text-muted fs-10 border-0 rounded-pill px-2">#EMP-{{ str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</span>
										</div>
									</div>
								</td>
								<td>
									<div class="d-flex flex-column gap-1">
										<div class="d-flex align-items-center fs-12 text-dark">
											<i class="ti ti-mail me-2 text-muted fs-14"></i>{{ $employee->email }}
										</div>
										<div class="d-flex align-items-center fs-12 text-muted">
											<i class="ti ti-phone me-2 fs-14"></i>{{ $employee->phone ?? '--' }}
										</div>
									</div>
								</td>
								<td>
									<div class="d-flex flex-column gap-1">
										<span class="text-dark fw-bold fs-12">{{ $employee->department->name ?? 'No Dept' }}</span>
										<span class="text-muted fs-11">{{ $employee->designation->name ?? ($employee->role->name ?? 'Personnel') }}</span>
									</div>
								</td>
								<td>
									<div class="d-flex flex-column gap-1">
										<span class="text-dark fw-medium fs-12">{{ $employee->created_at ? $employee->created_at->format('M d, Y') : '--' }}</span>
										<small class="text-muted fs-10 fw-bold text-uppercase">{{ $employee->created_at ? $employee->created_at->diffForHumans() : '' }}</small>
									</div>
								</td>
								<td class="text-center">
									@if($employee->status === 'active')
										<span class="badge bg-success-transparent text-success rounded-pill px-3 py-1 fs-11 fw-bold">
											<i class="ti ti-check me-1"></i>Active
										</span>
									@else
										<span class="badge bg-danger-transparent text-danger rounded-pill px-3 py-1 fs-11 fw-bold">
											<i class="ti ti-x me-1"></i>Inactive
										</span>
									@endif
								</td>
								<td class="pe-4 text-end">
									<div class="dropdown">
										<button class="btn btn-icon btn-sm btn-light border-0 rounded-circle shadow-none" data-bs-toggle="dropdown">
											<i class="ti ti-dots-vertical fs-16"></i>
										</button>
										<ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 p-2">
											<li><a class="dropdown-item rounded-3 py-2 fs-13" href="{{ route('employees.show', $employee->id) }}"><i class="ti ti-id me-2 text-primary"></i>View Full Profile</a></li>
											<li><a class="dropdown-item rounded-3 py-2 fs-13" href="{{ route('employees.edit', $employee->id) }}"><i class="ti ti-edit me-2 text-info"></i>Edit Details</a></li>
											<li><hr class="dropdown-divider opacity-50"></li>
											<li><a class="dropdown-item rounded-3 py-2 fs-13 text-danger" href="javascript:void(0);" onclick="setDeleteEmployeeId({{ $employee->id }})" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Terminate Record</a></li>
										</ul>
									</div>
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="6" class="text-center py-5">
									<div class="d-flex flex-column align-items-center py-4">
										<div class="avatar avatar-xxl bg-light border border-dashed rounded-circle mb-3 d-flex align-items-center justify-content-center">
											<i class="ti ti-users-minus fs-48 text-muted opacity-50"></i>
										</div>
										<h5 class="text-dark fw-bold mb-1">No employees matches found</h5>
										<p class="text-muted fs-13 mb-0">Try adjusting your filters or search keywords.</p>
										<a href="{{ route('employees.index') }}" class="btn btn-sm btn-primary rounded-pill mt-3 px-4">Refresh Directory</a>
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

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
				<a href="#" data-bs-toggle="modal" data-bs-target="#add_employee" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Employee</a>
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
										@if($employee->avatar)
											<img src="{{ asset('storage/' . $employee->avatar) }}" class="img-fluid rounded-circle" alt="img">
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
									<a href="#" class="me-2" data-bs-toggle="modal" data-bs-target="#edit_employee" onclick="loadEmployeeData({{ $employee->id }})"><i class="ti ti-edit"></i></a>
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

	
	<!-- Add Employee -->
	<div class="modal fade" id="add_employee">
		<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
			<div class="d-flex align-items-center">
				<h4 class="modal-title me-2">Add New Employee</h4><span>Employee ID : EMP-{{ str_pad((($totalEmployees ?? 0) + 1), 4, '0', STR_PAD_LEFT) }}</span>
			</div>
			<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
				<i class="ti ti-x"></i>
			</button>
			</div>
			<form action="{{ url("/employees") }}">
			<div class="contact-grids-tab">
				<ul class="nav nav-underline" id="myTab" role="tablist">
					<li class="nav-item" role="presentation">
					  <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#basic-info" type="button" role="tab" aria-selected="true">Basic Information</button>
					</li>
					<li class="nav-item" role="presentation">
					  <button class="nav-link" id="uae-tab" data-bs-toggle="tab" data-bs-target="#uae-info" type="button" role="tab" aria-selected="false">UAE Information</button>
					</li>
					<li class="nav-item" role="presentation">
					  <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-selected="false">Permissions</button>
					</li>
				</ul>
			</div>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="basic-info" role="tabpanel" aria-labelledby="info-tab" tabindex="0">
						<div class="modal-body pb-0 ">	
							<div class="row">
								<div class="col-md-12">
									<div class="d-flex align-items-center flex-wrap row-gap-3 bg-light w-100 rounded p-3 mb-4">                                                
										<div class="d-flex align-items-center justify-content-center avatar avatar-xxl rounded-circle border border-dashed me-2 flex-shrink-0 text-dark frames">
											<i class="ti ti-photo text-gray-2 fs-16"></i>
										</div>                                              
										<div class="profile-upload">
											<div class="mb-2">
												<h6 class="mb-1">Upload Profile Image</h6>
												<p class="fs-12">Image should be below 4 mb</p>
											</div>
											<div class="profile-uploader d-flex align-items-center">
												<div class="drag-upload-btn btn btn-sm btn-primary me-2">
													Upload
													<input type="file" class="form-control image-sign" multiple="">
												</div>
												<a href="javascript:void(0);" class="btn btn-light btn-sm">Cancel</a>
											</div>
											
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">First Name <span class="text-danger"> *</span></label>
										<input type="text" class="form-control">
									</div>									
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Last Name</label>
										<input type="email" class="form-control">
									</div>									
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Employee ID <span class="text-danger"> *</span></label>
										<input type="text" class="form-control">
									</div>									
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Joining Date <span class="text-danger"> *</span></label>
										<div class="input-icon-end position-relative">
											<input type="text" class="form-control datetimepicker" placeholder="dd/mm/yyyy">
											<span class="input-icon-addon">
												<i class="ti ti-calendar text-gray-7"></i>
											</span>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Username <span class="text-danger"> *</span></label>
										<input type="text" class="form-control">
									</div>									
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Email <span class="text-danger"> *</span></label>
										<input type="email" class="form-control">
									</div>									
								</div>
								<div class="col-md-6">
									<div class="mb-3 ">
										<label class="form-label">Password <span class="text-danger"> *</span></label>
										<div class="pass-group">
											<input type="password" class="pass-input form-control">
											<span class="ti toggle-password ti-eye-off"></span>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3 ">
										<label class="form-label">Confirm Password <span class="text-danger"> *</span></label>
										<div class="pass-group">
											<input type="password" class="pass-inputs form-control">
											<span class="ti toggle-passwords ti-eye-off"></span>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Phone Number <span class="text-danger"> *</span></label>
										<input type="text" class="form-control">
									</div>									
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Company<span class="text-danger"> *</span></label>
										<input type="text" class="form-control">
									</div>									
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Department</label>
										<select class="select">
											<option>Select</option>
											<option>All Department</option>
											<option>Finance</option>
											<option>Developer</option>
											<option>Executive</option>
										</select>
									</div>		
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Designation</label>
										<select class="select">
											<option>Select</option>
											<option>Finance</option>
											<option>Developer</option>
											<option>Executive</option>
										</select>
									</div>		
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label class="form-label">About <span class="text-danger"> *</span></label>
										<textarea class="form-control" rows="3"></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-outline-light border me-2" data-bs-dismiss="modal">Cancel</button>
							<button type="button" class="btn btn-primary" data-bs-toggle="tab" data-bs-target="#uae-info" type="button">Next: UAE Information</button>
						</div>
				</div>
				<div class="tab-pane fade" id="uae-info" role="tabpanel" aria-labelledby="uae-tab" tabindex="0">
					<div class="modal-body pb-0">
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Emirates ID</label>
									<input type="text" class="form-control" name="emirates_id" placeholder="e.g., 784-1234-1234567-1">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Nationality</label>
									<input type="text" class="form-control" name="nationality">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Passport Number</label>
									<input type="text" class="form-control" name="passport_number">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Passport Expiry Date</label>
									<input type="date" class="form-control" name="passport_expiry_date">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Visa Type</label>
									<select class="form-select" name="visa_type">
										<option value="">Select Visa Type</option>
										<option value="employment">Employment</option>
										<option value="dependent">Dependent</option>
										<option value="investor">Investor</option>
										<option value="student">Student</option>
										<option value="tourist">Tourist</option>
										<option value="other">Other</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Visa Number</label>
									<input type="text" class="form-control" name="visa_number">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Visa Expiry Date</label>
									<input type="date" class="form-control" name="visa_expiry_date">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Labor Card Number</label>
									<input type="text" class="form-control" name="labor_card_number">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Labor Card Expiry Date</label>
									<input type="date" class="form-control" name="labor_card_expiry_date">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">UAE Emirate</label>
									<select class="form-select" name="uae_emirate">
										<option value="">Select Emirate</option>
										<option value="Abu Dhabi">Abu Dhabi</option>
										<option value="Dubai">Dubai</option>
										<option value="Sharjah">Sharjah</option>
										<option value="Ajman">Ajman</option>
										<option value="Umm Al Quwain">Umm Al Quwain</option>
										<option value="Ras Al Khaimah">Ras Al Khaimah</option>
										<option value="Fujairah">Fujairah</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">UAE City</label>
									<input type="text" class="form-control" name="uae_city">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">UAE Area</label>
									<input type="text" class="form-control" name="uae_area">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Bank Name</label>
									<input type="text" class="form-control" name="bank_name" placeholder="e.g., Emirates NBD, ADCB">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">IBAN</label>
									<input type="text" class="form-control" name="iban" placeholder="AE123456789012345678901">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Emergency Contact Name</label>
									<input type="text" class="form-control" name="emergency_contact_name">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Emergency Contact Phone</label>
									<input type="text" class="form-control" name="emergency_contact_phone">
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-light border me-2" data-bs-toggle="tab" data-bs-target="#basic-info" type="button">Previous</button>
						<button type="button" class="btn btn-primary" data-bs-toggle="tab" data-bs-target="#address" type="button">Next: Permissions</button>
					</div>
				</div>
				<div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab" tabindex="0">
					<div class="modal-body">	
						<div class="card bg-light-500 shadow-none">
							<div class="card-body d-flex align-items-center justify-content-between flex-wrap row-gap-3">
								<h6>Enable Options</h6>
								<div class="d-flex align-items-center justify-content-end">
									<div class="form-check form-switch me-2">
										<label class="form-check-label mt-0">
										<input class="form-check-input me-2" type="checkbox" role="switch">
											Enable all Module
										</label>
									</div>
									<div class="form-check d-flex align-items-center">
										<label class="form-check-label mt-0">
											<input class="form-check-input" type="checkbox" checked="">
											Select All
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="table-responsive border rounded">
							<table class="table">
								<tbody>
									<tr>
										<td>
											<div class="form-check form-switch me-2">
												<label class="form-check-label mt-0">
												<input class="form-check-input me-2" type="checkbox" role="switch" checked>
													Holidays
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox" checked="">
													Read
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Write
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Create
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox" checked="">
													Delete
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Import
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Export
												</label>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-check form-switch me-2">
												<label class="form-check-label mt-0">
												<input class="form-check-input me-2" type="checkbox" role="switch">
												Leaves
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Read
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Write
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Create
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Delete
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Import
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Export
												</label>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-check form-switch me-2">
												<label class="form-check-label mt-0">
												<input class="form-check-input me-2" type="checkbox" role="switch">
												Clients
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Read
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Write
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Create
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Delete
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Import
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Export
												</label>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-check form-switch me-2">
												<label class="form-check-label mt-0">
												<input class="form-check-input me-2" type="checkbox" role="switch">
												Projects
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Read
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Write
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Create
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Delete
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Import
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Export
												</label>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-check form-switch me-2">
												<label class="form-check-label mt-0">
												<input class="form-check-input me-2" type="checkbox" role="switch">
												Tasks
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Read
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Write
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Create
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Delete
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Import
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Export
												</label>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-check form-switch me-2">
												<label class="form-check-label mt-0">
												<input class="form-check-input me-2" type="checkbox" role="switch">
												Chats
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Read
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Write
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Create
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Delete
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Import
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Export
												</label>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-check form-switch me-2">
												<label class="form-check-label mt-0">
												<input class="form-check-input me-2" type="checkbox" role="switch" checked>
												Assets
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Read
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Write
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox" checked="">
													Create
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Delete
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox" checked="">
													Import
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Export
												</label>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-check form-switch me-2">
												<label class="form-check-label mt-0">
												<input class="form-check-input me-2" type="checkbox" role="switch">
												Timing Sheets
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Read
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Write
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Create
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Delete
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Import
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Export
												</label>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-light border me-2" data-bs-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-primary" data-bs-toggle="tab" data-bs-target="#uae-info" type="button">Previous: UAE Information</button>
						<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#success_modal">Save </button>
					</div>
				</div>
			</div>
			</form>
		</div>
		</div>
	</div>
	<!-- /Add Employee -->

	<!-- Edit Employee -->
	<div class="modal fade" id="edit_employee">
		<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
			<div class="d-flex align-items-center">
				<h4 class="modal-title me-2">Edit Employee</h4><span>Employee  ID : EMP -0024</span>
			</div>
			<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
				<i class="ti ti-x"></i>
			</button>
			</div>
			<form action="{{ url("/employees") }}">
			<div class="contact-grids-tab">
				<ul class="nav nav-underline" id="myTab2" role="tablist">
					<li class="nav-item" role="presentation">
					  <button class="nav-link active" id="info-tab2" data-bs-toggle="tab" data-bs-target="#basic-info2" type="button" role="tab" aria-selected="true">Basic Information</button>
					</li>
					<li class="nav-item" role="presentation">
					  <button class="nav-link" id="uae-tab2" data-bs-toggle="tab" data-bs-target="#uae-info2" type="button" role="tab" aria-selected="false">UAE Information</button>
					</li>
					<li class="nav-item" role="presentation">
					  <button class="nav-link" id="address-tab2" data-bs-toggle="tab" data-bs-target="#address2" type="button" role="tab" aria-selected="false">Permissions</button>
					</li>
				</ul>
			</div>
			<div class="tab-content" id="myTabContent2">
				<div class="tab-pane fade show active" id="basic-info2" role="tabpanel" aria-labelledby="info-tab2" tabindex="0">
						<div class="modal-body pb-0 ">	
							<div class="row">
								<div class="col-md-12">
									<div class="d-flex align-items-center flex-wrap row-gap-3 bg-light w-100 rounded p-3 mb-4">                                                
										<div class="d-flex align-items-center justify-content-center avatar avatar-xxl rounded-circle border border-dashed me-2 flex-shrink-0 text-dark frames">
											<img src="{{ asset("assets/img/users/user-13.jpg") }}" alt="img" class="rounded-circle">
										</div>                                              
										<div class="profile-upload">
											<div class="mb-2">
												<h6 class="mb-1">Upload Profile Image</h6>
												<p class="fs-12">Image should be below 4 mb</p>
											</div>
											<div class="profile-uploader d-flex align-items-center">
												<div class="drag-upload-btn btn btn-sm btn-primary me-2">
													Upload
													<input type="file" class="form-control image-sign" multiple="">
												</div>
												<a href="javascript:void(0);" class="btn btn-light btn-sm">Cancel</a>
											</div>
											
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">First Name <span class="text-danger"> *</span></label>
										<input type="text" class="form-control" value="Anthony">
									</div>									
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Last Name</label>
										<input type="email" class="form-control" value="Lewis">
									</div>									
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Employee ID <span class="text-danger"> *</span></label>
										<input type="text" class="form-control" value="Emp-001">
									</div>									
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Joining Date <span class="text-danger"> *</span></label>
										<div class="input-icon-end position-relative">
											<input type="text" class="form-control datetimepicker" placeholder="dd/mm/yyyy" value="17-10-2022">
											<span class="input-icon-addon">
												<i class="ti ti-calendar text-gray-7"></i>
											</span>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Username <span class="text-danger"> *</span></label>
										<input type="text" class="form-control" value="Anthony">
									</div>									
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Email <span class="text-danger"> *</span></label>
										<input type="email" class="form-control" value="anthony@example.com	">
									</div>									
								</div>
								<div class="col-md-6">
									<div class="mb-3 ">
										<label class="form-label">Password <span class="text-danger"> *</span></label>
										<div class="pass-group">
											<input type="password" class="pass-input form-control">
											<span class="ti toggle-password ti-eye-off"></span>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3 ">
										<label class="form-label">Confirm Password <span class="text-danger"> *</span></label>
										<div class="pass-group">
											<input type="password" class="pass-inputs form-control">
											<span class="ti toggle-passwords ti-eye-off"></span>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Phone Number <span class="text-danger"> *</span></label>
										<input type="text" class="form-control" value="(123) 4567 890">
									</div>									
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Company<span class="text-danger"> *</span></label>
										<input type="text" class="form-control" value="Abac Company">
									</div>									
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Department</label>
										<select class="select">
											<option>Select</option>
											<option>All Department</option>
											<option selected>Finance</option>
											<option>Developer</option>
											<option>Executive</option>
										</select>
									</div>		
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Designation</label>
										<select class="select">
											<option>Select</option>
											<option selected>Finance</option>
											<option>Developer</option>
											<option>Executive</option>
										</select>
									</div>		
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label class="form-label">About <span class="text-danger"> *</span></label>
										<textarea class="form-control" rows="3"></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-outline-light border me-2" data-bs-dismiss="modal">Cancel</button>
							<button type="button" class="btn btn-primary" data-bs-toggle="tab" data-bs-target="#uae-info2" type="button">Next: UAE Information</button>
						</div>
				</div>
				<div class="tab-pane fade" id="uae-info2" role="tabpanel" aria-labelledby="uae-tab2" tabindex="0">
					<div class="modal-body pb-0">
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Emirates ID</label>
									<input type="text" class="form-control" name="emirates_id" value="" placeholder="e.g., 784-1234-1234567-1">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Nationality</label>
									<input type="text" class="form-control" name="nationality" value="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Passport Number</label>
									<input type="text" class="form-control" name="passport_number" value="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Passport Expiry Date</label>
									<input type="date" class="form-control" name="passport_expiry_date" value="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Visa Type</label>
									<select class="form-select" name="visa_type">
										<option value="">Select Visa Type</option>
										<option value="employment">Employment</option>
										<option value="dependent">Dependent</option>
										<option value="investor">Investor</option>
										<option value="student">Student</option>
										<option value="tourist">Tourist</option>
										<option value="other">Other</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Visa Number</label>
									<input type="text" class="form-control" name="visa_number" value="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Visa Expiry Date</label>
									<input type="date" class="form-control" name="visa_expiry_date" value="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Labor Card Number</label>
									<input type="text" class="form-control" name="labor_card_number" value="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Labor Card Expiry Date</label>
									<input type="date" class="form-control" name="labor_card_expiry_date" value="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">UAE Emirate</label>
									<select class="form-select" name="uae_emirate">
										<option value="">Select Emirate</option>
										<option value="Abu Dhabi">Abu Dhabi</option>
										<option value="Dubai">Dubai</option>
										<option value="Sharjah">Sharjah</option>
										<option value="Ajman">Ajman</option>
										<option value="Umm Al Quwain">Umm Al Quwain</option>
										<option value="Ras Al Khaimah">Ras Al Khaimah</option>
										<option value="Fujairah">Fujairah</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">UAE City</label>
									<input type="text" class="form-control" name="uae_city" value="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">UAE Area</label>
									<input type="text" class="form-control" name="uae_area" value="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Bank Name</label>
									<input type="text" class="form-control" name="bank_name" value="" placeholder="e.g., Emirates NBD, ADCB">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">IBAN</label>
									<input type="text" class="form-control" name="iban" value="" placeholder="AE123456789012345678901">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Emergency Contact Name</label>
									<input type="text" class="form-control" name="emergency_contact_name" value="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Emergency Contact Phone</label>
									<input type="text" class="form-control" name="emergency_contact_phone" value="">
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-light border me-2" data-bs-toggle="tab" data-bs-target="#basic-info2" type="button">Previous</button>
						<button type="button" class="btn btn-primary" data-bs-toggle="tab" data-bs-target="#address2" type="button">Next: Permissions</button>
					</div>
				</div>
				<div class="tab-pane fade" id="address2" role="tabpanel" aria-labelledby="address-tab2" tabindex="0">
					<div class="modal-body">	
						<div class="card bg-light-500 shadow-none">
							<div class="card-body d-flex align-items-center justify-content-between flex-wrap row-gap-3">
								<h6>Enable Options</h6>
								<div class="d-flex align-items-center justify-content-end">
									<div class="form-check form-switch me-2">
										<label class="form-check-label mt-0">
										<input class="form-check-input me-2" type="checkbox" role="switch">
											Enable all Module
										</label>
									</div>
									<div class="form-check d-flex align-items-center">
										<label class="form-check-label mt-0">
											<input class="form-check-input" type="checkbox" checked="">
											Select All
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="table-responsive border rounded">
							<table class="table">
								<tbody>
									<tr>
										<td>
											<div class="form-check form-switch me-2">
												<label class="form-check-label mt-0">
												<input class="form-check-input me-2" type="checkbox" role="switch" checked>
													Holidays
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox" checked="">
													Read
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Write
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Create
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox" checked="">
													Delete
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Import
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Export
												</label>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-check form-switch me-2">
												<label class="form-check-label mt-0">
												<input class="form-check-input me-2" type="checkbox" role="switch">
												Leaves
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Read
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Write
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Create
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Delete
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Import
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Export
												</label>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-check form-switch me-2">
												<label class="form-check-label mt-0">
												<input class="form-check-input me-2" type="checkbox" role="switch">
												Clients
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Read
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Write
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Create
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Delete
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Import
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Export
												</label>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-check form-switch me-2">
												<label class="form-check-label mt-0">
												<input class="form-check-input me-2" type="checkbox" role="switch">
												Projects
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Read
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Write
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Create
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Delete
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Import
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Export
												</label>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-check form-switch me-2">
												<label class="form-check-label mt-0">
												<input class="form-check-input me-2" type="checkbox" role="switch">
												Tasks
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Read
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Write
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Create
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Delete
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Import
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Export
												</label>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-check form-switch me-2">
												<label class="form-check-label mt-0">
												<input class="form-check-input me-2" type="checkbox" role="switch">
												Chats
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Read
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Write
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Create
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Delete
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Import
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Export
												</label>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-check form-switch me-2">
												<label class="form-check-label mt-0">
												<input class="form-check-input me-2" type="checkbox" role="switch" checked>
												Assets
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Read
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Write
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox" checked="">
													Create
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Delete
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox" checked="">
													Import
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Export
												</label>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-check form-switch me-2">
												<label class="form-check-label mt-0">
												<input class="form-check-input me-2" type="checkbox" role="switch">
												Timing Sheets
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Read
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Write
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Create
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Delete
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Import
												</label>
											</div>
										</td>
										<td>
											<div class="form-check d-flex align-items-center">
												<label class="form-check-label mt-0">
													<input class="form-check-input" type="checkbox">
													Export
												</label>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-light border me-2" data-bs-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-primary" data-bs-toggle="tab" data-bs-target="#uae-info2" type="button">Previous: UAE Information</button>
						<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#success_modal">Save </button>
					</div>
				</div>
			</div>
			</form>
		</div>
		</div>
	</div>
	<!-- /Edit Employee -->

	<!-- Add Employee Success -->
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

@extends('layouts.app')

@section('title', 'Attendance (Admin)')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Attendance Management</h2>
			<p class="text-muted mb-0 fs-13">Monitor and manage employee daily attendance</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<button type="button" class="btn btn-primary rounded-pill shadow-sm py-2 px-3" data-bs-toggle="modal" data-bs-target="#addManualAttendance">
				<i class="ti ti-plus me-2"></i>Add Attendance
			</button>
		</div>
	</div>
	<!-- /Page Header -->

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

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2 d-flex align-items-center justify-content-between flex-wrap row-gap-3">
			<h5 class="mb-0 fw-bold text-dark">Attendance List</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('attendance.admin') }}" class="d-flex align-items-center gap-2 flex-wrap">
					<div>
						<select name="employee_id" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" onchange="this.form.submit()">
							<option value="">All Employees</option>
							@foreach($employees as $employee)
								<option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<input type="date" name="date_from" class="form-control form-control-sm rounded-pill fs-12 border-light-subtle shadow-none" value="{{ request('date_from') }}" placeholder="From Date" onchange="this.form.submit()">
					</div>
					<div>
						<input type="date" name="date_to" class="form-control form-control-sm rounded-pill fs-12 border-light-subtle shadow-none" value="{{ request('date_to') }}" placeholder="To Date" onchange="this.form.submit()">
					</div>
					<div>
						<select name="status" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" onchange="this.form.submit()">
							<option value="">All Status</option>
							<option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Present</option>
							<option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
							<option value="half_day" {{ request('status') == 'half_day' ? 'selected' : '' }}>Half Day</option>
							<option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Late</option>
							<option value="on_leave" {{ request('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
						</select>
					</div>
					@if(request()->hasAny(['employee_id', 'date_from', 'date_to', 'status']))
						<a href="{{ route('attendance.admin') }}" class="btn btn-sm btn-light rounded-pill px-3">Clear</a>
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
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Date</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Check In</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Check Out</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Total Hours</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($attendances as $attendance)
							<tr class="border-bottom border-light">
								<td class="ps-3 text-muted">{{ $loop->iteration }}</td>
								<td>
									<div class="d-flex align-items-center">
										@if($attendance->employee->profile_picture)
											<a href="#" class="avatar avatar-md rounded-circle me-2 overflow-hidden shadow-sm border border-2 border-white">
												<img src="{{ asset('storage/' . $attendance->employee->profile_picture) }}" class="img-fluid" alt="img" style="object-fit: cover;">
											</a>
										@else
											<a href="#" class="avatar avatar-md bg-primary-transparent text-primary rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold shadow-sm" style="text-decoration: none;">
												{{ strtoupper(substr($attendance->employee->name, 0, 1)) }}
											</a>
										@endif
										<div>
											<h6 class="text-dark mb-0 fw-bold">{{ $attendance->employee->name }}</h6>
											<span class="fs-11 text-muted">{{ $attendance->employee->email }}</span>
										</div>
									</div>
								</td>
								<td class="text-muted">{{ $attendance->date->format('d M Y') }}</td>
								<td class="text-dark fw-medium">{{ $attendance->check_in ? substr($attendance->check_in, 0, 5) : '-' }}</td>
								<td class="text-dark fw-medium">{{ $attendance->check_out ? substr($attendance->check_out, 0, 5) : '-' }}</td>
								<td class="text-muted">
									@if($attendance->total_hours)
										<span class="badge bg-light text-dark border rounded-pill">{{ floor($attendance->total_hours / 60) }}h {{ $attendance->total_hours % 60 }}m</span>
									@else
										-
									@endif
								</td>
								<td>
									@if($attendance->status == 'present')
										<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-circle-check-filled me-1 fs-10"></i>{{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
										</span>
									@elseif($attendance->status == 'absent')
										<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-circle-x-filled me-1 fs-10"></i>{{ ucfirst($attendance->status) }}
										</span>
									@elseif($attendance->status == 'late')
										<span class="badge bg-warning-transparent text-warning rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-clock-exclamation me-1 fs-10"></i>{{ ucfirst($attendance->status) }}
										</span>
									@else
										<span class="badge bg-info-transparent text-info rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-info-circle-filled me-1 fs-10"></i>{{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
										</span>
									@endif
								</td>
								<td class="pe-3 text-end">
									<button type="button" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all shadow-sm" data-bs-toggle="modal" data-bs-target="#editAttendance{{ $attendance->id }}" title="Edit">
										<i class="ti ti-edit"></i>
									</button>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="8" class="text-center py-5">
									<div class="d-flex flex-column align-items-center">
										<div class="avatar avatar-xxl bg-light-50 rounded-circle mb-3 text-muted">
											<i class="ti ti-clock-off fs-30"></i>
										</div>
										<h6 class="text-muted mb-0">No attendance records found</h6>
									</div>
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Edit Attendance Modal -->
	<!-- Edit Attendance Modal -->
	@foreach($attendances as $attendance)
	<div class="modal fade" id="editAttendance{{ $attendance->id }}" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content border-0 shadow-lg rounded-4">
				<div class="modal-header bg-light-50 border-bottom border-light">
					<h5 class="modal-title fw-bold text-dark">Edit Attendance</h5>
					<button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
				</div>
				<form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
					@csrf
					@method('PUT')
					<div class="modal-body p-4">
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Employee</label>
									<input type="text" class="form-control rounded-3 border-light shadow-none bg-light-50" value="{{ $attendance->employee->name }}" disabled>
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Date</label>
									<input type="date" class="form-control rounded-3 border-light shadow-none bg-light-50" value="{{ $attendance->date->format('Y-m-d') }}" disabled>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Check In</label>
									<input type="time" class="form-control rounded-3 border-light shadow-none" name="check_in" value="{{ $attendance->check_in ? substr($attendance->check_in, 0, 5) : '' }}">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Check Out</label>
									<input type="time" class="form-control rounded-3 border-light shadow-none" name="check_out" value="{{ $attendance->check_out ? substr($attendance->check_out, 0, 5) : '' }}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Break Start</label>
									<input type="time" class="form-control rounded-3 border-light shadow-none" name="break_start" value="{{ $attendance->break_start ? substr($attendance->break_start, 0, 5) : '' }}">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Break End</label>
									<input type="time" class="form-control rounded-3 border-light shadow-none" name="break_end" value="{{ $attendance->break_end ? substr($attendance->break_end, 0, 5) : '' }}">
								</div>
							</div>
						</div>
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Status <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none" name="status" required>
								<option value="present" {{ $attendance->status == 'present' ? 'selected' : '' }}>Present</option>
								<option value="absent" {{ $attendance->status == 'absent' ? 'selected' : '' }}>Absent</option>
								<option value="half_day" {{ $attendance->status == 'half_day' ? 'selected' : '' }}>Half Day</option>
								<option value="late" {{ $attendance->status == 'late' ? 'selected' : '' }}>Late</option>
								<option value="on_leave" {{ $attendance->status == 'on_leave' ? 'selected' : '' }}>On Leave</option>
							</select>
						</div>
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Notes</label>
							<textarea class="form-control rounded-3 border-light shadow-none" name="notes" rows="2" placeholder="Add any management notes...">{{ $attendance->notes }}</textarea>
						</div>
					</div>
					<div class="modal-footer border-top border-light">
						<button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Update Attendance</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	@endforeach

	<!-- Add Manual Attendance Modal -->
	<div class="modal fade" id="addManualAttendance" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content border-0 shadow-lg rounded-4">
				<div class="modal-header bg-light-50 border-bottom border-light">
					<h5 class="modal-title fw-bold text-dark">Add Manual Attendance</h5>
					<button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
				</div>
				<form action="{{ route('attendance.store') }}" method="POST">
					@csrf
					<div class="modal-body p-4">
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Employee <span class="text-danger">*</span></label>
									<select class="form-select rounded-3 border-light shadow-none" name="employee_id" required>
										<option value="">Select Employee</option>
										@foreach($employees as $employee)
											<option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
										@endforeach
									</select>
									@error('employee_id')
										<div class="invalid-feedback d-block">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Date <span class="text-danger">*</span></label>
									<input type="date" class="form-control rounded-3 border-light shadow-none" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
									@error('date')
										<div class="invalid-feedback d-block">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Check In</label>
									<input type="time" class="form-control rounded-3 border-light shadow-none" name="check_in" value="{{ old('check_in') }}">
									@error('check_in')
										<div class="invalid-feedback d-block">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Check Out</label>
									<input type="time" class="form-control rounded-3 border-light shadow-none" name="check_out" value="{{ old('check_out') }}">
									@error('check_out')
										<div class="invalid-feedback d-block">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Break Start</label>
									<input type="time" class="form-control rounded-3 border-light shadow-none" name="break_start" value="{{ old('break_start') }}">
									@error('break_start')
										<div class="invalid-feedback d-block">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label text-muted fs-12 text-uppercase fw-medium">Break End</label>
									<input type="time" class="form-control rounded-3 border-light shadow-none" name="break_end" value="{{ old('break_end') }}">
									@error('break_end')
										<div class="invalid-feedback d-block">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Status <span class="text-danger">*</span></label>
							<select class="form-select rounded-3 border-light shadow-none" name="status" required>
								<option value="present" {{ old('status', 'present') == 'present' ? 'selected' : '' }}>Present</option>
								<option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>Absent</option>
								<option value="half_day" {{ old('status') == 'half_day' ? 'selected' : '' }}>Half Day</option>
								<option value="late" {{ old('status') == 'late' ? 'selected' : '' }}>Late</option>
								<option value="on_leave" {{ old('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
							</select>
							@error('status')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
						<div class="mb-3">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium">Notes</label>
							<textarea class="form-control rounded-3 border-light shadow-none" name="notes" rows="3" placeholder="Add any notes about this attendance entry...">{{ old('notes') }}</textarea>
							@error('notes')
								<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="modal-footer border-top border-light">
						<button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Save Attendance</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection

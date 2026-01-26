@extends('layouts.app')

@section('title', 'Attendance (Admin)')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Attendance (Admin)</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addManualAttendance">
					<i class="ti ti-circle-plus me-2"></i>Add Manual Attendance
				</button>
			</div>
			<div class="head-icons ms-2">
				<a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header">
					<i class="ti ti-chevrons-up"></i>
				</a>
			</div>
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

	<div class="card">
		<div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
			<h5>Attendance List</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('attendance.admin') }}" class="d-flex gap-2 flex-wrap">
					<div>
						<select name="employee_id" class="form-select form-select-sm" onchange="this.form.submit()">
							<option value="">All Employees</option>
							@foreach($employees as $employee)
								<option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}" placeholder="From Date" onchange="this.form.submit()">
					</div>
					<div>
						<input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}" placeholder="To Date" onchange="this.form.submit()">
					</div>
					<div>
						<select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
							<option value="">All Status</option>
							<option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Present</option>
							<option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
							<option value="half_day" {{ request('status') == 'half_day' ? 'selected' : '' }}>Half Day</option>
							<option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Late</option>
							<option value="on_leave" {{ request('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
						</select>
					</div>
					@if(request()->hasAny(['employee_id', 'date_from', 'date_to', 'status']))
						<a href="{{ route('attendance.admin') }}" class="btn btn-sm btn-outline-light border">Clear Filters</a>
					@endif
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
							<th>Date</th>
							<th>Check In</th>
							<th>Check Out</th>
							<th>Total Hours</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($attendances as $attendance)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>
									<div class="d-flex align-items-center">
										<div class="ms-2">
											<h6 class="fw-medium">{{ $attendance->employee->name }}</h6>
											<span class="d-block mt-1 text-muted">{{ $attendance->employee->email }}</span>
										</div>
									</div>
								</td>
								<td>{{ $attendance->date->format('d M Y') }}</td>
								<td>{{ $attendance->check_in ? substr($attendance->check_in, 0, 5) : '-' }}</td>
								<td>{{ $attendance->check_out ? substr($attendance->check_out, 0, 5) : '-' }}</td>
								<td>
									@if($attendance->total_hours)
										{{ floor($attendance->total_hours / 60) }}h {{ $attendance->total_hours % 60 }}m
									@else
										-
									@endif
								</td>
								<td>
									@if($attendance->status == 'present')
										<span class="badge badge-success">{{ ucfirst(str_replace('_', ' ', $attendance->status)) }}</span>
									@elseif($attendance->status == 'absent')
										<span class="badge badge-danger">{{ ucfirst($attendance->status) }}</span>
									@elseif($attendance->status == 'late')
										<span class="badge badge-warning">{{ ucfirst($attendance->status) }}</span>
									@else
										<span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $attendance->status)) }}</span>
									@endif
								</td>
								<td>
									<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editAttendance{{ $attendance->id }}">
										<i class="ti ti-edit"></i> Edit
									</button>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="8" class="text-center">No attendance records found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Edit Attendance Modal -->
	@foreach($attendances as $attendance)
	<div class="modal fade" id="editAttendance{{ $attendance->id }}" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit Attendance</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
					@csrf
					@method('PUT')
					<div class="modal-body">
						<div class="mb-3">
							<label class="form-label">Employee</label>
							<input type="text" class="form-control" value="{{ $attendance->employee->name }}" disabled>
						</div>
						<div class="mb-3">
							<label class="form-label">Date</label>
							<input type="date" class="form-control" value="{{ $attendance->date->format('Y-m-d') }}" disabled>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Check In</label>
									<input type="time" class="form-control" name="check_in" value="{{ $attendance->check_in ? substr($attendance->check_in, 0, 5) : '' }}">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Check Out</label>
									<input type="time" class="form-control" name="check_out" value="{{ $attendance->check_out ? substr($attendance->check_out, 0, 5) : '' }}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Break Start</label>
									<input type="time" class="form-control" name="break_start" value="{{ $attendance->break_start ? substr($attendance->break_start, 0, 5) : '' }}">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Break End</label>
									<input type="time" class="form-control" name="break_end" value="{{ $attendance->break_end ? substr($attendance->break_end, 0, 5) : '' }}">
								</div>
							</div>
						</div>
						<div class="mb-3">
							<label class="form-label">Status <span class="text-danger">*</span></label>
							<select class="form-select" name="status" required>
								<option value="present" {{ $attendance->status == 'present' ? 'selected' : '' }}>Present</option>
								<option value="absent" {{ $attendance->status == 'absent' ? 'selected' : '' }}>Absent</option>
								<option value="half_day" {{ $attendance->status == 'half_day' ? 'selected' : '' }}>Half Day</option>
								<option value="late" {{ $attendance->status == 'late' ? 'selected' : '' }}>Late</option>
								<option value="on_leave" {{ $attendance->status == 'on_leave' ? 'selected' : '' }}>On Leave</option>
							</select>
						</div>
						<div class="mb-3">
							<label class="form-label">Notes</label>
							<textarea class="form-control" name="notes" rows="2">{{ $attendance->notes }}</textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-light border" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary">Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	@endforeach

	<!-- Add Manual Attendance Modal -->
	<div class="modal fade" id="addManualAttendance" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Manual Attendance</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<form action="{{ route('attendance.store') }}" method="POST">
					@csrf
					<div class="modal-body">
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Employee <span class="text-danger">*</span></label>
									<select class="form-select @error('employee_id') is-invalid @enderror" name="employee_id" required>
										<option value="">Select Employee</option>
										@foreach($employees as $employee)
											<option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }} ({{ $employee->email }})</option>
										@endforeach
									</select>
									@error('employee_id')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Date <span class="text-danger">*</span></label>
									<input type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
									@error('date')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Check In</label>
									<input type="time" class="form-control @error('check_in') is-invalid @enderror" name="check_in" value="{{ old('check_in') }}">
									@error('check_in')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Check Out</label>
									<input type="time" class="form-control @error('check_out') is-invalid @enderror" name="check_out" value="{{ old('check_out') }}">
									@error('check_out')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Break Start</label>
									<input type="time" class="form-control @error('break_start') is-invalid @enderror" name="break_start" value="{{ old('break_start') }}">
									@error('break_start')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Break End</label>
									<input type="time" class="form-control @error('break_end') is-invalid @enderror" name="break_end" value="{{ old('break_end') }}">
									@error('break_end')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
						<div class="mb-3">
							<label class="form-label">Status <span class="text-danger">*</span></label>
							<select class="form-select @error('status') is-invalid @enderror" name="status" required>
								<option value="present" {{ old('status', 'present') == 'present' ? 'selected' : '' }}>Present</option>
								<option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>Absent</option>
								<option value="half_day" {{ old('status') == 'half_day' ? 'selected' : '' }}>Half Day</option>
								<option value="late" {{ old('status') == 'late' ? 'selected' : '' }}>Late</option>
								<option value="on_leave" {{ old('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
							</select>
							@error('status')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="mb-3">
							<label class="form-label">Notes</label>
							<textarea class="form-control @error('notes') is-invalid @enderror" name="notes" rows="3" placeholder="Add any notes about this attendance entry...">{{ old('notes') }}</textarea>
							@error('notes')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-light border" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary">Save Attendance</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection

@extends('layouts.app')

@section('title', 'Employee Salary')

@section('content')

	<!-- Page Header -->
	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Employee Salary</h2>
			<p class="text-muted mb-0 fs-13">Manage and view employee salary structures</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('payroll.salary.create') }}" class="btn btn-primary d-flex align-items-center rounded-pill shadow-sm">
				<i class="ti ti-plus me-2"></i>Add Salary
			</a>
		</div>
	</div>
	<!-- /Page Header -->
	<!-- /Page Header -->

	@if(session('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			{{ session('success') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-0 d-flex align-items-center justify-content-between flex-wrap row-gap-3 pt-3 pb-2">
			<h5 class="mb-0 fw-bold text-dark">Salary List</h5>
			<div class="d-flex gap-2 flex-wrap">
				<form method="GET" action="{{ route('payroll.salary.index') }}" class="d-flex gap-2">
					<select name="employee_id" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" style="width: auto;">
						<option value="">All Employees</option>
						@foreach($employees as $employee)
							<option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
						@endforeach
					</select>
					<select name="status" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" style="width: auto;">
						<option value="">All Status</option>
						<option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
						<option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
					</select>
					<button type="submit" class="btn btn-sm btn-outline-primary rounded-pill px-3">Filter</button>
					@if(request()->hasAny(['employee_id', 'status']))
						<a href="{{ route('payroll.salary.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Clear</a>
					@endif
				</form>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="bg-light-50">
						<tr>
							<th class="ps-3 border-0" style="width: 50px;">
								<div class="form-check form-check-md">
									<input class="form-check-input" type="checkbox" id="select-all">
								</div>
							</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">#</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Employee</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Basic Salary</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Gross Salary</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Deductions</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Net Salary</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Effective From</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($salaries as $salary)
							<tr class="border-bottom border-light">
								<td class="ps-3">
									<div class="form-check form-check-md">
										<input class="form-check-input" type="checkbox" value="{{ $salary->id }}">
									</div>
								</td>
								<td class="text-muted">{{ $loop->iteration }}</td>
								<td>
									<div class="d-flex align-items-center">
										<div class="avatar avatar-sm bg-primary-transparent text-primary rounded-circle me-2 fw-bold">
											{{ strtoupper(substr($salary->employee->name ?? 'U', 0, 1)) }}
										</div>
										<a href="#" class="text-dark fw-medium hover-text-primary">{{ $salary->employee->name ?? 'N/A' }}</a>
									</div>
								</td>
								<td class="text-muted">{{ number_format($salary->basic_salary, 2) }}</td>
								<td class="text-muted">{{ number_format($salary->gross_salary, 2) }}</td>
								<td class="text-danger">{{ number_format($salary->total_deductions, 2) }}</td>
								<td><strong class="text-success">{{ number_format($salary->net_salary, 2) }}</strong></td>
								<td class="text-muted">{{ $salary->effective_from->format('d M Y') }}</td>
								<td>
									@if($salary->status == 'active')
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
										<a href="{{ route('payroll.salary.show', $salary->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all" data-bs-toggle="tooltip" title="View">
											<i class="ti ti-eye"></i>
										</a>
										<a href="{{ route('payroll.salary.edit', $salary->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-info hover-text-white transition-all" data-bs-toggle="tooltip" title="Edit">
											<i class="ti ti-edit"></i>
										</a>
										<form action="{{ route('payroll.salary.destroy', $salary->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this salary?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-danger hover-text-white transition-all" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="10" class="text-center py-5">
									<div class="d-flex flex-column align-items-center">
										<div class="avatar avatar-xxl bg-light-50 rounded-circle mb-3 text-muted">
											<i class="ti ti-wallet fs-30"></i>
										</div>
										<h6 class="text-muted mb-0">No salaries found</h6>
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

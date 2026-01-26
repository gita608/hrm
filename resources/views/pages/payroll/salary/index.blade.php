@extends('layouts.app')

@section('title', 'Employee Salary')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Employee Salary</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<a href="{{ route('payroll.salary.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Salary</a>
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

	<div class="card">
		<div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
			<h5>Salary List</h5>
			<div class="d-flex gap-2 flex-wrap">
				<form method="GET" action="{{ route('payroll.salary.index') }}" class="d-flex gap-2">
					<select name="employee_id" class="form-select form-select-sm" style="width: auto;">
						<option value="">All Employees</option>
						@foreach($employees as $employee)
							<option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
						@endforeach
					</select>
					<select name="status" class="form-select form-select-sm" style="width: auto;">
						<option value="">All Status</option>
						<option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
						<option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
					</select>
					<button type="submit" class="btn btn-sm btn-outline-primary">Filter</button>
					@if(request()->hasAny(['employee_id', 'status']))
						<a href="{{ route('payroll.salary.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
					@endif
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
							<th>Employee</th>
							<th>Basic Salary</th>
							<th>Gross Salary</th>
							<th>Deductions</th>
							<th>Net Salary</th>
							<th>Effective From</th>
							<th>Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@forelse($salaries as $salary)
							<tr>
								<td>
									<div class="form-check form-check-md">
										<input class="form-check-input" type="checkbox" value="{{ $salary->id }}">
									</div>
								</td>
								<td>{{ $loop->iteration }}</td>
								<td>
									<h6 class="fw-medium"><a href="#">{{ $salary->employee->name ?? 'N/A' }}</a></h6>
								</td>
								<td>{{ number_format($salary->basic_salary, 2) }}</td>
								<td>{{ number_format($salary->gross_salary, 2) }}</td>
								<td>{{ number_format($salary->total_deductions, 2) }}</td>
								<td><strong>{{ number_format($salary->net_salary, 2) }}</strong></td>
								<td>{{ $salary->effective_from->format('d M Y') }}</td>
								<td>
									@if($salary->status == 'active')
										<span class="badge badge-success d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Active
										</span>
									@else
										<span class="badge badge-danger d-inline-flex align-items-center badge-sm">
											<i class="ti ti-point-filled me-1"></i>Inactive
										</span>
									@endif
								</td>
								<td>
									<div class="action-icon d-inline-flex">
										<a href="{{ route('payroll.salary.show', $salary->id) }}" class="me-2" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('payroll.salary.edit', $salary->id) }}" class="me-2" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										<form action="{{ route('payroll.salary.destroy', $salary->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this salary?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-link p-0 text-danger" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="10" class="text-center">No salaries found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

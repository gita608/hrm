@extends('layouts.app')

@section('title', 'Provident Fund')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Provident Fund</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<a href="{{ route('payroll.provident-fund.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Contribution</a>
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
		<div class="card-header">
			<h5>Provident Fund Contributions</h5>
		</div>
		<div class="card-body p-0">
			<div class="custom-datatable-filter table-responsive">
				<table class="table datatable">
					<thead class="thead-light">
						<tr>
							<th>#</th>
							<th>Employee</th>
							<th>Month/Year</th>
							<th>Employee Contribution</th>
							<th>Employer Contribution</th>
							<th>Total</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@forelse($providentFunds as $pf)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $pf->employee->name ?? 'N/A' }}</td>
								<td>{{ $pf->month }} {{ $pf->year }}</td>
								<td>{{ number_format($pf->employee_contribution, 2) }}</td>
								<td>{{ number_format($pf->employer_contribution, 2) }}</td>
								<td><strong>{{ number_format($pf->total_contribution, 2) }}</strong></td>
								<td>
									<div class="action-icon d-inline-flex">
										<a href="{{ route('payroll.provident-fund.show', $pf->id) }}" class="me-2" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('payroll.provident-fund.edit', $pf->id) }}" class="me-2" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="7" class="text-center">No provident fund contributions found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

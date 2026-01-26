@extends('layouts.app')

@section('title', 'Payslips')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Payslips</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<a href="{{ route('payroll.payslip.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Generate Payslip</a>
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
			<h5>Payslip List</h5>
		</div>
		<div class="card-body p-0">
			<div class="custom-datatable-filter table-responsive">
				<table class="table datatable">
					<thead class="thead-light">
						<tr>
							<th>#</th>
							<th>Payslip #</th>
							<th>Employee</th>
							<th>Pay Period</th>
							<th>Payment Date</th>
							<th>Gross Salary</th>
							<th>Net Salary</th>
							<th>Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@forelse($payslips as $payslip)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $payslip->payslip_number }}</td>
								<td>{{ $payslip->employee->name ?? 'N/A' }}</td>
								<td>{{ $payslip->pay_period_start->format('d M') }} - {{ $payslip->pay_period_end->format('d M Y') }}</td>
								<td>{{ $payslip->payment_date->format('d M Y') }}</td>
								<td>{{ number_format($payslip->gross_salary, 2) }}</td>
								<td><strong>{{ number_format($payslip->net_salary, 2) }}</strong></td>
								<td>
									@if($payslip->status == 'paid')
										<span class="badge badge-success">Paid</span>
									@elseif($payslip->status == 'approved')
										<span class="badge badge-info">Approved</span>
									@elseif($payslip->status == 'cancelled')
										<span class="badge badge-danger">Cancelled</span>
									@else
										<span class="badge badge-warning">Draft</span>
									@endif
								</td>
								<td>
									<div class="action-icon d-inline-flex">
										<a href="{{ route('payroll.payslip.show', $payslip->id) }}" class="me-2" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('payroll.payslip.edit', $payslip->id) }}" class="me-2" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="9" class="text-center">No payslips found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

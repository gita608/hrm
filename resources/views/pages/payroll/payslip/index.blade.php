@extends('layouts.app')

@section('title', 'Payslips')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Payslips</h2>
			<p class="text-muted mb-0 fs-13">Generate and manage employee payslips</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('payroll.payslip.create') }}" class="btn btn-primary d-flex align-items-center rounded-pill shadow-sm">
				<i class="ti ti-plus me-2"></i>Generate Payslip
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	@if(session('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			{{ session('success') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-0 d-flex align-items-center justify-content-between pt-3 pb-2">
			<h5 class="mb-0 fw-bold text-dark">Payslip History</h5>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="bg-light-50">
						<tr>
							<th class="ps-3 border-0 text-muted fs-12 fw-medium text-uppercase">#</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Payslip ID</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Employee</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Pay Period</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Payment Date</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Gross Salary</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Net Salary</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($payslips as $payslip)
							<tr class="border-bottom border-light">
								<td class="ps-3 text-muted">{{ $loop->iteration }}</td>
								<td><span class="text-primary fw-medium">{{ $payslip->payslip_number }}</span></td>
								<td>
									<div class="d-flex align-items-center">
										<div class="avatar avatar-sm bg-purple-transparent text-purple rounded-circle me-2 fw-bold">
											{{ strtoupper(substr($payslip->employee->name ?? 'U', 0, 1)) }}
										</div>
										<span class="text-dark fw-medium">{{ $payslip->employee->name ?? 'N/A' }}</span>
									</div>
								</td>
								<td class="text-muted">{{ $payslip->pay_period_start->format('d M') }} - {{ $payslip->pay_period_end->format('d M') }}</td>
								<td class="text-muted">{{ $payslip->payment_date->format('d M Y') }}</td>
								<td class="text-muted">{{ number_format($payslip->gross_salary, 2) }}</td>
								<td><strong class="text-dark">{{ number_format($payslip->net_salary, 2) }}</strong></td>
								<td>
									@if($payslip->status == 'paid')
										<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-check me-1 fs-10"></i>Paid
										</span>
									@elseif($payslip->status == 'approved')
										<span class="badge bg-info-transparent text-info rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-check me-1 fs-10"></i>Approved
										</span>
									@elseif($payslip->status == 'cancelled')
										<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-x me-1 fs-10"></i>Cancelled
										</span>
									@else
										<span class="badge bg-warning-transparent text-warning rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-clock me-1 fs-10"></i>Draft
										</span>
									@endif
								</td>
								<td class="pe-3 text-end">
									<div class="d-flex justify-content-end gap-2">
										<a href="{{ route('payroll.payslip.show', $payslip->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all" data-bs-toggle="tooltip" title="View">
											<i class="ti ti-eye"></i>
										</a>
										@if($payslip->status != 'paid')
										<a href="{{ route('payroll.payslip.edit', $payslip->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-info hover-text-white transition-all" data-bs-toggle="tooltip" title="Edit">
											<i class="ti ti-edit"></i>
										</a>
										@endif
										<a href="#" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-dark hover-text-white transition-all" data-bs-toggle="tooltip" title="Download PDF">
											<i class="ti ti-download"></i>
										</a>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="9" class="text-center py-5">
									<div class="d-flex flex-column align-items-center">
										<div class="avatar avatar-xxl bg-light-50 rounded-circle mb-3 text-muted">
											<i class="ti ti-file-dollar fs-30"></i>
										</div>
										<h6 class="text-muted mb-0">No payslips found</h6>
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

@extends('layouts.app')

@section('title', 'Payslip Details')

@section('content')

	<!-- Breadcrumb -->
	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Payslip Details</h2>
			<p class="text-muted mb-0 fs-13">View detailed salary slip</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('payroll.payslip.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Breadcrumb -->
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-md-8">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-primary bg-opacity-10 border-0 pt-4 pb-3">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h5 class="mb-1 fw-bold text-primary">Payslip #{{ $payslip->payslip_number }}</h5>
							<p class="mb-0 text-muted fs-12">{{ $payslip->pay_period_start->format('d M') }} - {{ $payslip->pay_period_end->format('d M Y') }}</p>
						</div>
						<div class="text-end">
							<p class="mb-1 text-muted fs-12 text-uppercase fw-medium">Status</p>
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
						</div>
					</div>
				</div>
				<div class="card-body p-4">
					<div class="row mb-4">
						<div class="col-md-6 border-end border-light">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Employee</label>
							<div class="d-flex align-items-center mt-1">
								<div class="avatar avatar-sm bg-purple-transparent text-purple rounded-circle me-2 fw-bold">
									{{ strtoupper(substr($payslip->employee->name ?? 'U', 0, 1)) }}
								</div>
								<p class="mb-0 fw-bold fs-15 text-dark">{{ $payslip->employee->name ?? 'N/A' }}</p>
							</div>
						</div>
						<div class="col-md-6 ps-md-4">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Payment Date</label>
							<p class="mb-0 fw-bold fs-15 text-dark mt-1">{{ $payslip->payment_date->format('d M Y') }}</p>
						</div>
					</div>

					<div class="row g-4">
						<!-- Earnings -->
						<div class="col-md-6">
							<div class="p-3 bg-light-50 rounded-3 border border-light h-100">
								<h6 class="text-success fw-bold mb-3 d-flex align-items-center">
									<i class="ti ti-circle-plus me-2"></i>Earnings
								</h6>
								<div class="d-flex justify-content-between mb-2">
									<span class="text-muted">Basic Salary</span>
									<span class="fw-medium text-dark">{{ number_format($payslip->basic_salary, 2) }}</span>
								</div>
								<div class="d-flex justify-content-between mb-2">
									<span class="text-muted">Allowances</span>
									<span class="fw-medium text-dark">{{ number_format($payslip->allowances, 2) }}</span>
								</div>
								<div class="d-flex justify-content-between mb-2">
									<span class="text-muted">Overtime</span>
									<span class="fw-medium text-dark">{{ number_format($payslip->overtime, 2) }}</span>
								</div>
								<div class="d-flex justify-content-between mb-2">
									<span class="text-muted">Bonuses</span>
									<span class="fw-medium text-dark">{{ number_format($payslip->bonuses, 2) }}</span>
								</div>
								<hr class="border-light my-2">
								<div class="d-flex justify-content-between">
									<span class="fw-bold text-dark">Gross Salary</span>
									<span class="fw-bold text-success">{{ number_format($payslip->gross_salary, 2) }}</span>
								</div>
							</div>
						</div>

						<!-- Deductions -->
						<div class="col-md-6">
							<div class="p-3 bg-light-50 rounded-3 border border-light h-100">
								<h6 class="text-danger fw-bold mb-3 d-flex align-items-center">
									<i class="ti ti-circle-minus me-2"></i>Deductions
								</h6>
								<div class="d-flex justify-content-between mb-2">
									<span class="text-muted">Tax</span>
									<span class="fw-medium text-dark">{{ number_format($payslip->tax_deduction, 2) }}</span>
								</div>
								<div class="d-flex justify-content-between mb-2">
									<span class="text-muted">Provident Fund</span>
									<span class="fw-medium text-dark">{{ number_format($payslip->provident_fund, 2) }}</span>
								</div>
								<div class="d-flex justify-content-between mb-2">
									<span class="text-muted">Other</span>
									<span class="fw-medium text-dark">{{ number_format($payslip->other_deductions, 2) }}</span>
								</div>
								<hr class="border-light my-2 invisible">
								<hr class="border-light my-2">
								<div class="d-flex justify-content-between">
									<span class="fw-bold text-dark">Total Deductions</span>
									<span class="fw-bold text-danger">{{ number_format($payslip->total_deductions, 2) }}</span>
								</div>
							</div>
						</div>
					</div>

					<div class="row mt-4">
						<div class="col-md-12">
							<div class="p-4 bg-primary-transparent rounded-4 border border-primary-transparent text-center d-flex flex-column align-items-center justify-content-center">
								<label class="form-label text-primary fs-13 text-uppercase fw-bold mb-1">Net Salary Payable</label>
								<p class="mb-0 fw-bolder display-5 text-primary">{{ number_format($payslip->net_salary, 2) }}</p>
							</div>
						</div>
					</div>

					@if($payslip->notes)
						<div class="mt-4 pt-3 border-top border-light">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-2">Notes</label>
							<p class="mb-0 text-dark bg-light-50 p-3 rounded-3">{{ $payslip->notes }}</p>
						</div>
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Actions</h5>
				</div>
				<div class="card-body p-4">
					<div class="d-grid gap-3">
						<a href="{{ route('payroll.payslip.edit', $payslip->id) }}" class="btn btn-primary rounded-pill py-2 shadow-sm">
							<i class="ti ti-edit me-2"></i>Edit Payslip
						</a>
						@if($payslip->status == 'draft')
							<form action="{{ route('payroll.payslip.approve', $payslip->id) }}" method="POST" class="d-grid">
								@csrf
								<button type="submit" class="btn btn-success rounded-pill py-2 shadow-sm">
									<i class="ti ti-check me-2"></i>Approve
								</button>
							</form>
						@endif
						<button class="btn btn-dark rounded-pill py-2 shadow-sm">
							<i class="ti ti-download me-2"></i>Download PDF
						</button>
						<form action="{{ route('payroll.payslip.destroy', $payslip->id) }}" method="POST" class="d-grid" onsubmit="return confirm('Are you sure?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger rounded-pill py-2">
								<i class="ti ti-trash me-2"></i>Delete
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

@extends('layouts.app')

@section('title', 'Payslip Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Payslip Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('payroll.payslip.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5>Payslip Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Payslip Number</label>
							<p class="mb-0 fw-semibold">{{ $payslip->payslip_number }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">Employee</label>
							<p class="mb-0 fw-semibold">{{ $payslip->employee->name ?? 'N/A' }}</p>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Pay Period</label>
							<p class="mb-0 fw-semibold">{{ $payslip->pay_period_start->format('d M Y') }} - {{ $payslip->pay_period_end->format('d M Y') }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">Payment Date</label>
							<p class="mb-0 fw-semibold">{{ $payslip->payment_date->format('d M Y') }}</p>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Status</label>
							<p class="mb-0">
								@if($payslip->status == 'paid')
									<span class="badge badge-success">Paid</span>
								@elseif($payslip->status == 'approved')
									<span class="badge badge-info">Approved</span>
								@elseif($payslip->status == 'cancelled')
									<span class="badge badge-danger">Cancelled</span>
								@else
									<span class="badge badge-warning">Draft</span>
								@endif
							</p>
						</div>
					</div>
					<hr>
					<h6 class="mb-3">Earnings</h6>
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Basic Salary</label>
							<p class="mb-0 fw-semibold">{{ number_format($payslip->basic_salary, 2) }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">Allowances</label>
							<p class="mb-0 fw-semibold">{{ number_format($payslip->allowances, 2) }}</p>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Overtime</label>
							<p class="mb-0 fw-semibold">{{ number_format($payslip->overtime, 2) }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">Bonuses</label>
							<p class="mb-0 fw-semibold">{{ number_format($payslip->bonuses, 2) }}</p>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-12">
							<label class="form-label text-muted">Gross Salary</label>
							<p class="mb-0 fw-semibold fs-18">{{ number_format($payslip->gross_salary, 2) }}</p>
						</div>
					</div>
					<hr>
					<h6 class="mb-3">Deductions</h6>
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Tax Deduction</label>
							<p class="mb-0 fw-semibold">{{ number_format($payslip->tax_deduction, 2) }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">Provident Fund</label>
							<p class="mb-0 fw-semibold">{{ number_format($payslip->provident_fund, 2) }}</p>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label text-muted">Other Deductions</label>
							<p class="mb-0 fw-semibold">{{ number_format($payslip->other_deductions, 2) }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted">Total Deductions</label>
							<p class="mb-0 fw-semibold">{{ number_format($payslip->total_deductions, 2) }}</p>
						</div>
					</div>
					<hr>
					<div class="row mb-3">
						<div class="col-md-12">
							<label class="form-label text-muted">Net Salary</label>
							<p class="mb-0 fw-semibold fs-20 text-primary">{{ number_format($payslip->net_salary, 2) }}</p>
						</div>
					</div>
					@if($payslip->notes)
						<div class="mb-3">
							<label class="form-label text-muted">Notes</label>
							<p class="mb-0">{{ $payslip->notes }}</p>
						</div>
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-header">
					<h5>Actions</h5>
				</div>
				<div class="card-body">
					<div class="d-grid gap-2">
						<a href="{{ route('payroll.payslip.edit', $payslip->id) }}" class="btn btn-primary">
							<i class="ti ti-edit me-2"></i>Edit Payslip
						</a>
						@if($payslip->status == 'draft')
							<form action="{{ route('payroll.payslip.approve', $payslip->id) }}" method="POST" class="d-grid">
								@csrf
								<button type="submit" class="btn btn-success">
									<i class="ti ti-check me-2"></i>Approve
								</button>
							</form>
						@endif
						<form action="{{ route('payroll.payslip.destroy', $payslip->id) }}" method="POST" class="d-grid" onsubmit="return confirm('Are you sure?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger">
								<i class="ti ti-trash me-2"></i>Delete
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

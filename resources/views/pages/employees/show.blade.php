@extends('layouts.app')

@section('title', 'Employee Details')

@section('content')
	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">Employee Details</h2>
			<p class="text-muted mb-0 fs-13">View employee profile and information</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('employees.index') }}" class="btn btn-light rounded-pill border shadow-sm">
				<i class="ti ti-arrow-left me-2"></i>Back to List
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	@php
		// TODO: Replace this with actual employee data when controller is implemented
		// $employee = \App\Models\User::findOrFail($id);
		// For now, showing placeholder structure
	@endphp

	<div class="row">
		<div class="col-md-4 mb-4 mb-md-0">
			<!-- Profile Card -->
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 text-center h-100">
				<div class="card-body p-4 d-flex flex-column align-items-center justify-content-center">
					<div class="avatar avatar-xxl rounded-circle mb-3 shadow-sm border border-4 border-light-subtle overflow-hidden" style="width: 120px; height: 120px;">
						@if($employee->profile_picture)
							<img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="Employee" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
						@else
							<div class="avatar-initial bg-primary-transparent text-primary fw-bold w-100 h-100 d-flex align-items-center justify-content-center" style="font-size: 3rem;">
								{{ strtoupper(substr($employee->name, 0, 1)) }}
							</div>
						@endif
					</div>
					<h4 class="mb-1 fw-bold text-dark">{{ $employee->name ?? 'Employee Name' }}</h4>
					<p class="text-muted mb-1 fs-14 fw-medium">{{ $employee->role->name ?? 'N/A' }}</p>
					<span class="badge bg-light text-dark border border-light-subtle rounded-pill px-3 py-1 mb-3">{{ $employee->email ?? 'N/A' }}</span>
					
					<div class="d-grid gap-2 w-100">
						<a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary rounded-pill py-2 shadow-sm">
							<i class="ti ti-edit me-2"></i>Edit Profile
						</a>
						<button class="btn btn-light rounded-pill py-2 border">
							<i class="ti ti-mail me-2"></i>Send Email
						</button>
					</div>

					<div class="row w-100 mt-4 pt-3 border-top border-light">
						<div class="col-6 border-end border-light">
							<p class="text-muted fs-12 text-uppercase mb-1">Joined</p>
							<h6 class="text-dark fw-bold mb-0">{{ isset($employee) && $employee->created_at ? $employee->created_at->format('d M Y') : 'N/A' }}</h6>
						</div>
						<div class="col-6">
							<p class="text-muted fs-12 text-uppercase mb-1">Status</p>
							<span class="badge bg-success-transparent text-success rounded-pill px-2 py-1">Active</span>
						</div>
					</div>
				</div>
			</div>
			<!-- /Profile Card -->
		</div>

		<div class="col-md-8">
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Personal Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row g-4">
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Full Name</label>
							<p class="mb-0 fw-bold fs-15 text-dark">{{ $employee->name ?? 'N/A' }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Phone</label>
							<p class="mb-0 fw-bold fs-15 text-dark">{{ $employee->phone ?? 'N/A' }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Email</label>
							<p class="mb-0 fw-medium text-dark">{{ $employee->email ?? 'N/A' }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Address</label>
							<p class="mb-0 fw-medium text-dark">{{ $employee->address ?? 'N/A' }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Nationality</label>
							<p class="mb-0 fw-medium text-dark">{{ $employee->nationality ?? 'N/A' }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Emergency Contact</label>
							<p class="mb-0 fw-medium text-dark">{{ $employee->emergency_contact_name ?? 'N/A' }} <span class="text-muted fs-12 ms-1">{{ $employee->emergency_contact_phone ? '(' . $employee->emergency_contact_phone . ')' : '' }}</span></p>
						</div>
					</div>
				</div>
			</div>

			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Employment & Visa Details</h5>
				</div>
				<div class="card-body p-4">
					<div class="row g-4">
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Emirates ID</label>
							<p class="mb-0 fw-bold fs-15 text-dark">{{ $employee->emirates_id ?? 'N/A' }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Passport Number</label>
							<p class="mb-0 fw-medium text-dark">{{ $employee->passport_number ?? 'N/A' }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Passport Expiry</label>
							<p class="mb-0 fw-medium text-dark">{{ isset($employee->passport_expiry_date) ? $employee->passport_expiry_date->format('d M Y') : 'N/A' }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Visa Type</label>
							<p class="mb-0 fw-medium text-dark">{{ ucfirst($employee->visa_type ?? 'N/A') }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Visa Number</label>
							<p class="mb-0 fw-medium text-dark">{{ $employee->visa_number ?? 'N/A' }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Visa Expiry</label>
							<p class="mb-0 fw-medium text-dark">{{ isset($employee->visa_expiry_date) ? $employee->visa_expiry_date->format('d M Y') : 'N/A' }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Labor Card</label>
							<p class="mb-0 fw-medium text-dark">{{ $employee->labor_card_number ?? 'N/A' }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Labor Card Expiry</label>
							<p class="mb-0 fw-medium text-dark">{{ isset($employee->labor_card_expiry_date) ? $employee->labor_card_expiry_date->format('d M Y') : 'N/A' }}</p>
						</div>
					</div>
				</div>
			</div>

			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-transparent border-bottom border-light pt-3 pb-2">
					<h5 class="mb-0 fw-bold text-dark">Bank Information</h5>
				</div>
				<div class="card-body p-4">
					<div class="row g-4">
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">Bank Name</label>
							<p class="mb-0 fw-bold fs-15 text-dark">{{ $employee->bank_name ?? 'N/A' }}</p>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-12 text-uppercase fw-medium mb-1">IBAN</label>
							<p class="mb-0 fw-medium text-dark">{{ $employee->iban ?? 'N/A' }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

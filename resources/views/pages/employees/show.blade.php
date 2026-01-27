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

	<div class="row g-4">
		<div class="col-xl-4 col-lg-5">
			<!-- Enhanced Profile Card -->
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden text-center sticky-top" style="top: 100px; z-index: 10;">
				<div class="card-header bg-primary py-5 position-relative">
					<div class="position-absolute start-50 translate-middle-x" style="bottom: -50px;">
						<div class="avatar-container">
							<div class="avatar avatar-xxxl rounded-circle border border-5 border-white shadow-lg overflow-hidden bg-white" style="width: 140px; height: 140px;">
								@if($employee->profile_picture)
									<img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="Profile" class="img-fluid w-100 h-100 object-fit-cover">
								@else
									<div class="avatar-initial bg-primary text-white fw-bold w-100 h-100 d-flex align-items-center justify-content-center" style="font-size: 3.5rem;">
										{{ strtoupper(substr($employee->name, 0, 1)) }}
									</div>
								@endif
							</div>
							<span class="position-absolute bottom-0 end-0 bg-success border border-white border-3 rounded-circle" style="width: 25px; height: 25px;"></span>
						</div>
					</div>
				</div>
				<div class="card-body pt-5 mt-4 px-4 pb-4">
					<h4 class="mb-1 fw-bold text-dark">{{ $employee->name ?? 'Staff Member' }}</h4>
					<p class="text-primary fw-bold mb-2 fs-14">{{ $employee->role->name ?? 'System User' }}</p>
					
					<div class="d-flex align-items-center justify-content-center gap-2 mb-4">
						<span class="badge bg-light text-muted border px-3 py-2 rounded-pill fs-12">
							<i class="ti ti-mail me-1"></i> {{ $employee->email ?? 'N/A' }}
						</span>
					</div>
					
					<div class="row g-2 mb-4">
						<div class="col-6">
							<a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary w-100 rounded-pill py-2 shadow-sm">
								<i class="ti ti-edit me-1"></i> Edit
							</a>
						</div>
						<div class="col-6">
							<a href="mailto:{{ $employee->email }}" class="btn btn-outline-dark w-100 rounded-pill py-2">
								<i class="ti ti-send me-1"></i> Message
							</a>
						</div>
					</div>

					<div class="list-group list-group-flush text-start border-top border-light-subtle">
						<div class="list-group-item bg-transparent px-0 py-3 border-light-subtle d-flex justify-content-between">
							<span class="text-muted fs-13"><i class="ti ti-calendar-event me-2"></i>Joined Date</span>
							<span class="text-dark fw-bold fs-13">{{ $employee->created_at ? $employee->created_at->format('M d, Y') : 'N/A' }}</span>
						</div>
						<div class="list-group-item bg-transparent px-0 py-3 border-light-subtle d-flex justify-content-between">
							<span class="text-muted fs-13"><i class="ti ti-fingerprint me-2"></i>System ID</span>
							<span class="text-dark fw-bold fs-13">#EMP-{{ str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</span>
						</div>
						<div class="list-group-item bg-transparent px-0 py-3 border-0 d-flex justify-content-between">
							<span class="text-muted fs-13"><i class="ti ti-circle-check me-2 text-success"></i>Employment Status</span>
							<span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">Active</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-8 col-lg-7">
			<!-- Detailed Information Cards -->
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-white py-3 border-bottom border-light">
					<h5 class="mb-0 fw-bold text-dark"><i class="ti ti-id me-2 text-primary"></i>Identity & Contact Details</h5>
				</div>
				<div class="card-body p-4">
					<div class="row g-4">
						<div class="col-sm-6">
							<div class="p-3 bg-light rounded-4 border border-light-subtle">
								<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1 mb-2">Primary Contact</label>
								<div class="d-flex align-items-center">
									<div class="bg-white rounded-3 p-2 shadow-sm me-3">
										<i class="ti ti-phone fs-20 text-primary"></i>
									</div>
									<h6 class="mb-0 fw-bold text-dark fs-15">{{ $employee->phone ?? 'Not Provided' }}</h6>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="p-3 bg-light rounded-4 border border-light-subtle">
								<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1 mb-2">Nationality</label>
								<div class="d-flex align-items-center">
									<div class="bg-white rounded-3 p-2 shadow-sm me-3">
										<i class="ti ti-world fs-20 text-primary"></i>
									</div>
									<h6 class="mb-0 fw-bold text-dark fs-15">{{ $employee->nationality ?? 'Not Specified' }}</h6>
								</div>
							</div>
						</div>
						<div class="col-12">
							<div class="p-3 bg-light rounded-4 border border-light-subtle">
								<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1 mb-2">Residential Address</label>
								<p class="mb-0 fw-medium text-dark lh-base fs-14">{{ $employee->address ?? 'No address registered in system.' }}</p>
							</div>
						</div>
						<div class="col-12">
							<div class="p-3 bg-danger-subtle rounded-4 border border-danger-subtle">
								<label class="form-label text-danger fs-11 text-uppercase fw-bold ls-1 mb-2">Emergency Contact</label>
								<div class="d-flex align-items-center justify-content-between">
									<div>
										<h6 class="mb-1 fw-bold text-dark fs-15">{{ $employee->emergency_contact_name ?? 'N/A' }}</h6>
										<span class="text-muted fs-13">Primary kinship link</span>
									</div>
									<div class="text-end">
										<h6 class="mb-0 fw-bold text-danger fs-15">{{ $employee->emergency_contact_phone ?? 'N/A' }}</h6>
										<span class="text-muted fs-13">Direct Mobile</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
				<div class="card-header bg-dark text-white py-3">
					<h5 class="mb-0 fw-bold"><i class="ti ti-file-certificate me-2 text-warning"></i>Statutory Documents & Visa</h5>
				</div>
				<div class="card-body p-4 bg-light-50">
					<div class="row g-4">
						<div class="col-md-6">
							<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1 mb-1">Emirates ID (EID)</label>
							<div class="d-flex align-items-center mb-3">
								<span class="fw-bold text-dark fs-15">{{ $employee->emirates_id ?? 'N/A' }}</span>
							</div>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1 mb-1">Passport Number</label>
							<div class="d-flex align-items-center mb-3">
								<span class="fw-medium text-dark fs-14">{{ $employee->passport_number ?? 'N/A' }}</span>
								@if($employee->passport_expiry_date)
									<span class="badge bg-white text-{{ $employee->passport_expiry_date->isPast() ? 'danger' : 'muted' }} border ms-2">Exp: {{ $employee->passport_expiry_date->format('M Y') }}</span>
								@endif
							</div>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1 mb-1">Visa Specification</label>
							<div class="d-flex align-items-center mb-0">
								<span class="badge bg-primary-subtle text-primary border border-primary-subtle me-2">{{ ucfirst($employee->visa_type ?? 'N/A') }}</span>
								<span class="text-dark fs-14">No: {{ $employee->visa_number ?? 'N/A' }}</span>
							</div>
						</div>
						<div class="col-md-6">
							<label class="form-label text-muted fs-11 text-uppercase fw-bold ls-1 mb-1">Visa Validity</label>
							<div class="d-flex align-items-center mb-0">
								<span class="text-dark fs-14">{{ $employee->visa_expiry_date ? $employee->visa_expiry_date->format('d M, Y') : 'N/A' }}</span>
								@if($employee->visa_expiry_date && $employee->visa_expiry_date->diffInDays(now()) < 30)
									<span class="ms-2 text-danger fs-11 fw-bold"><i class="ti ti-alert-triangle"></i> Expiring Soon</span>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
				<div class="card-header bg-white py-3 border-bottom border-light">
					<h5 class="mb-0 fw-bold text-dark"><i class="ti ti-building-bank me-2 text-success"></i>Financial Credentials</h5>
				</div>
				<div class="card-body p-4">
					<div class="p-3 rounded-4 bg-light border border-light-subtle">
						<div class="row align-items-center">
							<div class="col-auto">
								<div class="avatar avatar-lg bg-white rounded-3 shadow-sm border border-light-subtle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
									<i class="ti ti-credit-card fs-24 text-success"></i>
								</div>
							</div>
							<div class="col">
								<h6 class="mb-1 fw-bold text-dark fs-14">{{ $employee->bank_name ?? 'Bank name not recorded' }}</h6>
								<p class="mb-0 text-muted fs-12 fw-medium ls-1">IBAN: {{ $employee->iban ?? '---------------------------' }}</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

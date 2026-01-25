@extends('layouts.app')

@section('title', 'Employee Details')

@section('content')
	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Employee Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('employees.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	@php
		// TODO: Replace this with actual employee data when controller is implemented
		// $employee = \App\Models\User::findOrFail($id);
		// For now, showing placeholder structure
	@endphp

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5>Employee Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-4"><strong>Full Name:</strong></div>
						<div class="col-md-8">{{ $employee->name ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Email:</strong></div>
						<div class="col-md-8">{{ $employee->email ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Phone:</strong></div>
						<div class="col-md-8">{{ $employee->phone ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Address:</strong></div>
						<div class="col-md-8">{{ $employee->address ?? 'N/A' }}</div>
					</div>
					@if(isset($employee) && $employee->emirates_id)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Emirates ID:</strong></div>
						<div class="col-md-8">{{ $employee->emirates_id }}</div>
					</div>
					@endif
					@if(isset($employee) && $employee->nationality)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Nationality:</strong></div>
						<div class="col-md-8">{{ $employee->nationality }}</div>
					</div>
					@endif
					@if(isset($employee) && $employee->passport_number)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Passport Number:</strong></div>
						<div class="col-md-8">{{ $employee->passport_number }}</div>
					</div>
					@endif
					@if(isset($employee) && $employee->passport_expiry_date)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Passport Expiry:</strong></div>
						<div class="col-md-8">{{ $employee->passport_expiry_date->format('M d, Y') }}</div>
					</div>
					@endif
					@if(isset($employee) && $employee->visa_type)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Visa Type:</strong></div>
						<div class="col-md-8">{{ ucfirst($employee->visa_type) }}</div>
					</div>
					@endif
					@if(isset($employee) && $employee->visa_number)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Visa Number:</strong></div>
						<div class="col-md-8">{{ $employee->visa_number }}</div>
					</div>
					@endif
					@if(isset($employee) && $employee->visa_expiry_date)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Visa Expiry:</strong></div>
						<div class="col-md-8">{{ $employee->visa_expiry_date->format('M d, Y') }}</div>
					</div>
					@endif
					@if(isset($employee) && $employee->labor_card_number)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Labor Card Number:</strong></div>
						<div class="col-md-8">{{ $employee->labor_card_number }}</div>
					</div>
					@endif
					@if(isset($employee) && $employee->labor_card_expiry_date)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Labor Card Expiry:</strong></div>
						<div class="col-md-8">{{ $employee->labor_card_expiry_date->format('M d, Y') }}</div>
					</div>
					@endif
					@if(isset($employee) && $employee->uae_emirate)
					<div class="row mb-3">
						<div class="col-md-4"><strong>UAE Location:</strong></div>
						<div class="col-md-8">{{ $employee->uae_emirate }}{{ $employee->uae_city ? ', ' . $employee->uae_city : '' }}{{ $employee->uae_area ? ', ' . $employee->uae_area : '' }}</div>
					</div>
					@endif
					@if(isset($employee) && $employee->bank_name)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Bank Name:</strong></div>
						<div class="col-md-8">{{ $employee->bank_name }}</div>
					</div>
					@endif
					@if(isset($employee) && $employee->iban)
					<div class="row mb-3">
						<div class="col-md-4"><strong>IBAN:</strong></div>
						<div class="col-md-8">{{ $employee->iban }}</div>
					</div>
					@endif
					@if(isset($employee) && $employee->emergency_contact_name)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Emergency Contact:</strong></div>
						<div class="col-md-8">{{ $employee->emergency_contact_name }}{{ $employee->emergency_contact_phone ? ' - ' . $employee->emergency_contact_phone : '' }}</div>
					</div>
					@endif
					<div class="row mb-3">
						<div class="col-md-4"><strong>Created At:</strong></div>
						<div class="col-md-8">{{ isset($employee) && $employee->created_at ? $employee->created_at->format('M d, Y H:i') : 'N/A' }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body text-center">
					<div class="avatar avatar-xxl mb-3">
						@if($employee->profile_picture)
							<img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="Employee" class="img-fluid rounded-circle">
						@else
							<div class="avatar-initial bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; font-size: 2.5rem;">
								{{ strtoupper(substr($employee->name, 0, 1)) }}
							</div>
						@endif
					</div>
					<h4 class="mb-1">{{ $employee->name ?? 'Employee Name' }}</h4>
					<p class="text-muted mb-2">{{ $employee->role->name ?? 'N/A' }}</p>
					<p class="text-muted mb-3">{{ $employee->email ?? 'N/A' }}</p>
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary btn-sm">
							<i class="ti ti-edit me-2"></i>Edit Employee
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

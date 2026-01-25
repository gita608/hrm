@extends('layouts.app')

@section('title', 'User Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">User Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('users.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5>User Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-4"><strong>Full Name:</strong></div>
						<div class="col-md-8">{{ $user->name }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Email:</strong></div>
						<div class="col-md-8">{{ $user->email }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Role:</strong></div>
						<div class="col-md-8">
							@if($user->role)
								<span class="badge badge-info">{{ $user->role->name }}</span>
							@else
								<span class="text-muted">N/A</span>
							@endif
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Phone:</strong></div>
						<div class="col-md-8">{{ $user->phone ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Address:</strong></div>
						<div class="col-md-8">{{ $user->address ?? 'N/A' }}</div>
					</div>
					@if($user->emirates_id)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Emirates ID:</strong></div>
						<div class="col-md-8">{{ $user->emirates_id }}</div>
					</div>
					@endif
					@if($user->nationality)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Nationality:</strong></div>
						<div class="col-md-8">{{ $user->nationality }}</div>
					</div>
					@endif
					@if($user->passport_number)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Passport Number:</strong></div>
						<div class="col-md-8">{{ $user->passport_number }}</div>
					</div>
					@endif
					@if($user->passport_expiry_date)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Passport Expiry:</strong></div>
						<div class="col-md-8">{{ $user->passport_expiry_date->format('M d, Y') }}</div>
					</div>
					@endif
					@if($user->visa_type)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Visa Type:</strong></div>
						<div class="col-md-8">{{ ucfirst($user->visa_type) }}</div>
					</div>
					@endif
					@if($user->visa_number)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Visa Number:</strong></div>
						<div class="col-md-8">{{ $user->visa_number }}</div>
					</div>
					@endif
					@if($user->visa_expiry_date)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Visa Expiry:</strong></div>
						<div class="col-md-8">{{ $user->visa_expiry_date->format('M d, Y') }}</div>
					</div>
					@endif
					@if($user->labor_card_number)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Labor Card Number:</strong></div>
						<div class="col-md-8">{{ $user->labor_card_number }}</div>
					</div>
					@endif
					@if($user->labor_card_expiry_date)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Labor Card Expiry:</strong></div>
						<div class="col-md-8">{{ $user->labor_card_expiry_date->format('M d, Y') }}</div>
					</div>
					@endif
					@if($user->uae_emirate)
					<div class="row mb-3">
						<div class="col-md-4"><strong>UAE Location:</strong></div>
						<div class="col-md-8">{{ $user->uae_emirate }}{{ $user->uae_city ? ', ' . $user->uae_city : '' }}{{ $user->uae_area ? ', ' . $user->uae_area : '' }}</div>
					</div>
					@endif
					@if($user->bank_name)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Bank Name:</strong></div>
						<div class="col-md-8">{{ $user->bank_name }}</div>
					</div>
					@endif
					@if($user->iban)
					<div class="row mb-3">
						<div class="col-md-4"><strong>IBAN:</strong></div>
						<div class="col-md-8">{{ $user->iban }}</div>
					</div>
					@endif
					@if($user->emergency_contact_name)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Emergency Contact:</strong></div>
						<div class="col-md-8">{{ $user->emergency_contact_name }}{{ $user->emergency_contact_phone ? ' - ' . $user->emergency_contact_phone : '' }}</div>
					</div>
					@endif
					<div class="row mb-3">
						<div class="col-md-4"><strong>Email Verified:</strong></div>
						<div class="col-md-8">
							@if($user->email_verified_at)
								<span class="badge badge-success">Verified</span>
								<small class="text-muted"> ({{ $user->email_verified_at->format('M d, Y H:i') }})</small>
							@else
								<span class="badge badge-warning">Not Verified</span>
							@endif
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Created At:</strong></div>
						<div class="col-md-8">{{ $user->created_at->format('M d, Y H:i') }}</div>
					</div>
					<div class="row">
						<div class="col-md-4"><strong>Updated At:</strong></div>
						<div class="col-md-8">{{ $user->updated_at->format('M d, Y H:i') }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body text-center">
					<div class="avatar avatar-xxl mb-3">
						@if($user->profile_picture)
							<img src="{{ asset('storage/' . $user->profile_picture) }}" alt="User" class="img-fluid rounded-circle">
						@else
							<div class="avatar-initial bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; font-size: 2.5rem;">
								{{ strtoupper(substr($user->name, 0, 1)) }}
							</div>
						@endif
					</div>
					<h4 class="mb-1">{{ $user->name }}</h4>
					<p class="text-muted mb-2">{{ $user->role->name ?? 'N/A' }}</p>
					<p class="text-muted mb-3">{{ $user->email }}</p>
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">
							<i class="ti ti-edit me-2"></i>Edit User
						</a>
						@if($user->id !== auth()->id())
							<form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
								@csrf
								@method('DELETE')
								<button type="submit" class="btn btn-outline-danger btn-sm w-100">
									<i class="ti ti-trash me-2"></i>Delete User
								</button>
							</form>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

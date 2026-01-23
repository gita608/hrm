@extends('layouts.app')

@section('title', 'Trainer Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Trainer Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('trainers.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5>Trainer Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-4"><strong>Name:</strong></div>
						<div class="col-md-8">{{ $trainer->name }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Email:</strong></div>
						<div class="col-md-8">{{ $trainer->email }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Phone:</strong></div>
						<div class="col-md-8">{{ $trainer->phone ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Status:</strong></div>
						<div class="col-md-8">
							@if($trainer->is_active)
								<span class="badge badge-success">Active</span>
							@else
								<span class="badge badge-danger">Inactive</span>
							@endif
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Expertise:</strong></div>
						<div class="col-md-8">{{ $trainer->expertise ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Bio:</strong></div>
						<div class="col-md-8">{{ $trainer->bio ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Total Trainings:</strong></div>
						<div class="col-md-8">{{ $trainer->trainings_count ?? 0 }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Created At:</strong></div>
						<div class="col-md-8">{{ $trainer->created_at->format('M d, Y H:i') }}</div>
					</div>
					<div class="row">
						<div class="col-md-4"><strong>Updated At:</strong></div>
						<div class="col-md-8">{{ $trainer->updated_at->format('M d, Y H:i') }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body text-center">
					<div class="avatar avatar-xxl mb-3">
						<img src="{{ asset('assets/img/profiles/avatar-12.jpg') }}" alt="Trainer" class="img-fluid rounded-circle">
					</div>
					<h4 class="mb-1">{{ $trainer->name }}</h4>
					<p class="text-muted mb-2">{{ $trainer->email }}</p>
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('trainers.edit', $trainer->id) }}" class="btn btn-primary btn-sm">
							<i class="ti ti-edit me-2"></i>Edit Trainer
						</a>
						<form action="{{ route('trainers.destroy', $trainer->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this trainer?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger btn-sm w-100">
								<i class="ti ti-trash me-2"></i>Delete Trainer
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

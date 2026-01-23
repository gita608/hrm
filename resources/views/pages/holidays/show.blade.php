@extends('layouts.app')

@section('title', 'Holiday Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Holiday Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('holidays.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5>Holiday Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-4"><strong>Name:</strong></div>
						<div class="col-md-8">{{ $holiday->name }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Date:</strong></div>
						<div class="col-md-8">{{ $holiday->date->format('M d, Y') }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Type:</strong></div>
						<div class="col-md-8">
							@if($holiday->type == 'national')
								<span class="badge badge-primary">National</span>
							@elseif($holiday->type == 'regional')
								<span class="badge badge-info">Regional</span>
							@endif
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Status:</strong></div>
						<div class="col-md-8">
							@if($holiday->is_active)
								<span class="badge badge-success">Active</span>
							@else
								<span class="badge badge-danger">Inactive</span>
							@endif
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Description:</strong></div>
						<div class="col-md-8">{{ $holiday->description ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Created At:</strong></div>
						<div class="col-md-8">{{ $holiday->created_at->format('M d, Y H:i') }}</div>
					</div>
					<div class="row">
						<div class="col-md-4"><strong>Updated At:</strong></div>
						<div class="col-md-8">{{ $holiday->updated_at->format('M d, Y H:i') }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body text-center">
					<div class="avatar avatar-xxl mb-3">
						<i class="ti ti-calendar-event fs-48 text-primary"></i>
					</div>
					<h4 class="mb-1">{{ $holiday->name }}</h4>
					<p class="text-muted mb-2">{{ $holiday->date->format('M d, Y') }}</p>
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('holidays.edit', $holiday->id) }}" class="btn btn-primary btn-sm">
							<i class="ti ti-edit me-2"></i>Edit Holiday
						</a>
						<form action="{{ route('holidays.destroy', $holiday->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this holiday?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger btn-sm w-100">
								<i class="ti ti-trash me-2"></i>Delete Holiday
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

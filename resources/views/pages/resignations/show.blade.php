@extends('layouts.app')

@section('title', 'Resignation Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Resignation Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('resignations.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5>Resignation Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-4"><strong>Employee:</strong></div>
						<div class="col-md-8">{{ $resignation->employee->name ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Resignation Date:</strong></div>
						<div class="col-md-8">{{ $resignation->resignation_date->format('M d, Y') }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Notice Date:</strong></div>
						<div class="col-md-8">{{ $resignation->notice_date ? $resignation->notice_date->format('M d, Y') : 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Last Working Day:</strong></div>
						<div class="col-md-8">{{ $resignation->last_working_day ? $resignation->last_working_day->format('M d, Y') : 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Status:</strong></div>
						<div class="col-md-8">
							@if($resignation->status == 'pending')
								<span class="badge badge-warning">Pending</span>
							@elseif($resignation->status == 'accepted')
								<span class="badge badge-success">Accepted</span>
							@elseif($resignation->status == 'rejected')
								<span class="badge badge-danger">Rejected</span>
							@elseif($resignation->status == 'withdrawn')
								<span class="badge badge-secondary">Withdrawn</span>
							@endif
						</div>
					</div>
					@if($resignation->reason)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Reason:</strong></div>
						<div class="col-md-8">{{ $resignation->reason }}</div>
					</div>
					@endif
					@if($resignation->notes)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Notes:</strong></div>
						<div class="col-md-8">{{ $resignation->notes }}</div>
					</div>
					@endif
					<div class="row mb-3">
						<div class="col-md-4"><strong>Created At:</strong></div>
						<div class="col-md-8">{{ $resignation->created_at->format('M d, Y H:i') }}</div>
					</div>
					<div class="row">
						<div class="col-md-4"><strong>Updated At:</strong></div>
						<div class="col-md-8">{{ $resignation->updated_at->format('M d, Y H:i') }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body text-center">
					<div class="avatar avatar-xxl mb-3">
						<i class="ti ti-external-link fs-48 text-primary"></i>
					</div>
					<h4 class="mb-1">{{ $resignation->employee->name ?? 'N/A' }}</h4>
					<p class="text-muted mb-2">{{ $resignation->resignation_date->format('M d, Y') }}</p>
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('resignations.edit', $resignation->id) }}" class="btn btn-primary btn-sm">
							<i class="ti ti-edit me-2"></i>Edit Resignation
						</a>
						<form action="{{ route('resignations.destroy', $resignation->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this resignation?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger btn-sm w-100">
								<i class="ti ti-trash me-2"></i>Delete Resignation
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

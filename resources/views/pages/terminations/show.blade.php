@extends('layouts.app')

@section('title', 'Termination Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Termination Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('terminations.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5>Termination Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-4"><strong>Employee:</strong></div>
						<div class="col-md-8">{{ $termination->employee->name ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Termination Date:</strong></div>
						<div class="col-md-8">{{ $termination->termination_date->format('M d, Y') }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Notice Date:</strong></div>
						<div class="col-md-8">{{ $termination->notice_date ? $termination->notice_date->format('M d, Y') : 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Type:</strong></div>
						<div class="col-md-8">
							@if($termination->type == 'voluntary')
								<span class="badge badge-info">Voluntary</span>
							@elseif($termination->type == 'involuntary')
								<span class="badge badge-danger">Involuntary</span>
							@elseif($termination->type == 'retirement')
								<span class="badge badge-success">Retirement</span>
							@elseif($termination->type == 'end_of_contract')
								<span class="badge badge-warning">End of Contract</span>
							@else
								<span class="badge badge-secondary">Other</span>
							@endif
						</div>
					</div>
					@if($termination->reason)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Reason:</strong></div>
						<div class="col-md-8">{{ $termination->reason }}</div>
					</div>
					@endif
					@if($termination->notes)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Notes:</strong></div>
						<div class="col-md-8">{{ $termination->notes }}</div>
					</div>
					@endif
					<div class="row mb-3">
						<div class="col-md-4"><strong>Created At:</strong></div>
						<div class="col-md-8">{{ $termination->created_at->format('M d, Y H:i') }}</div>
					</div>
					<div class="row">
						<div class="col-md-4"><strong>Updated At:</strong></div>
						<div class="col-md-8">{{ $termination->updated_at->format('M d, Y H:i') }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body text-center">
					<div class="avatar avatar-xxl mb-3">
						<i class="ti ti-circle-x fs-48 text-primary"></i>
					</div>
					<h4 class="mb-1">{{ $termination->employee->name ?? 'N/A' }}</h4>
					<p class="text-muted mb-2">{{ $termination->termination_date->format('M d, Y') }}</p>
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('terminations.edit', $termination->id) }}" class="btn btn-primary btn-sm">
							<i class="ti ti-edit me-2"></i>Edit Termination
						</a>
						<form action="{{ route('terminations.destroy', $termination->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this termination?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger btn-sm w-100">
								<i class="ti ti-trash me-2"></i>Delete Termination
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

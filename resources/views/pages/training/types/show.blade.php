@extends('layouts.app')

@section('title', 'Training Type Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Training Type Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('training.types.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5>Training Type Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-4"><strong>Name:</strong></div>
						<div class="col-md-8">{{ $trainingType->name }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Code:</strong></div>
						<div class="col-md-8">{{ $trainingType->code ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Status:</strong></div>
						<div class="col-md-8">
							@if($trainingType->is_active)
								<span class="badge badge-success">Active</span>
							@else
								<span class="badge badge-danger">Inactive</span>
							@endif
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Description:</strong></div>
						<div class="col-md-8">{{ $trainingType->description ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Total Trainings:</strong></div>
						<div class="col-md-8">{{ $trainingType->trainings_count ?? 0 }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Created At:</strong></div>
						<div class="col-md-8">{{ $trainingType->created_at->format('M d, Y H:i') }}</div>
					</div>
					<div class="row">
						<div class="col-md-4"><strong>Updated At:</strong></div>
						<div class="col-md-8">{{ $trainingType->updated_at->format('M d, Y H:i') }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-header">
					<h5>Actions</h5>
				</div>
				<div class="card-body">
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('training.types.edit', $trainingType->id) }}" class="btn btn-primary btn-sm">
							<i class="ti ti-edit me-2"></i>Edit Training Type
						</a>
						@if($trainingType->trainings_count == 0)
							<form action="{{ route('training.types.destroy', $trainingType->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this training type?');">
								@csrf
								@method('DELETE')
								<button type="submit" class="btn btn-outline-danger btn-sm w-100">
									<i class="ti ti-trash me-2"></i>Delete Training Type
								</button>
							</form>
						@else
							<button type="button" class="btn btn-outline-danger btn-sm w-100" disabled title="Cannot delete training type with assigned trainings">
								<i class="ti ti-trash me-2"></i>Delete Training Type
							</button>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

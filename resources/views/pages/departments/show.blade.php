@extends('layouts.app')

@section('title', 'Department Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Department Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('departments.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5>Department Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-4"><strong>Name:</strong></div>
						<div class="col-md-8">{{ $department->name }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Code:</strong></div>
						<div class="col-md-8">{{ $department->code ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Manager:</strong></div>
						<div class="col-md-8">{{ $department->manager ? $department->manager->name : 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Status:</strong></div>
						<div class="col-md-8">
							@if($department->is_active)
								<span class="badge badge-success">Active</span>
							@else
								<span class="badge badge-danger">Inactive</span>
							@endif
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Description:</strong></div>
						<div class="col-md-8">{{ $department->description ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Created At:</strong></div>
						<div class="col-md-8">{{ $department->created_at->format('M d, Y H:i') }}</div>
					</div>
					<div class="row">
						<div class="col-md-4"><strong>Updated At:</strong></div>
						<div class="col-md-8">{{ $department->updated_at->format('M d, Y H:i') }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-header">
					<h5>Designations ({{ $department->designations->count() }})</h5>
				</div>
				<div class="card-body">
					@if($department->designations->count() > 0)
						<ul class="list-group">
							@foreach($department->designations as $designation)
								<li class="list-group-item d-flex justify-content-between align-items-center">
									{{ $designation->name }}
									@if($designation->is_active)
										<span class="badge badge-success badge-xs">Active</span>
									@else
										<span class="badge badge-danger badge-xs">Inactive</span>
									@endif
								</li>
							@endforeach
						</ul>
					@else
						<p class="text-muted">No designations assigned to this department.</p>
					@endif
				</div>
			</div>
		</div>
	</div>

@endsection

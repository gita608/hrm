@extends('layouts.app')

@section('title', 'Designation Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Designation Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('designations.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="card">
		<div class="card-header">
			<h5>Designation Information</h5>
		</div>
		<div class="card-body">
			<div class="row mb-3">
				<div class="col-md-4"><strong>Name:</strong></div>
				<div class="col-md-8">{{ $designation->name }}</div>
			</div>
			<div class="row mb-3">
				<div class="col-md-4"><strong>Code:</strong></div>
				<div class="col-md-8">{{ $designation->code ?? 'N/A' }}</div>
			</div>
			<div class="row mb-3">
				<div class="col-md-4"><strong>Department:</strong></div>
				<div class="col-md-8">{{ $designation->department ? $designation->department->name : 'N/A' }}</div>
			</div>
			<div class="row mb-3">
				<div class="col-md-4"><strong>Status:</strong></div>
				<div class="col-md-8">
					@if($designation->is_active)
						<span class="badge badge-success">Active</span>
					@else
						<span class="badge badge-danger">Inactive</span>
					@endif
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-md-4"><strong>Description:</strong></div>
				<div class="col-md-8">{{ $designation->description ?? 'N/A' }}</div>
			</div>
			<div class="row mb-3">
				<div class="col-md-4"><strong>Created At:</strong></div>
				<div class="col-md-8">{{ $designation->created_at->format('M d, Y H:i') }}</div>
			</div>
			<div class="row">
				<div class="col-md-4"><strong>Updated At:</strong></div>
				<div class="col-md-8">{{ $designation->updated_at->format('M d, Y H:i') }}</div>
			</div>
		</div>
	</div>

@endsection

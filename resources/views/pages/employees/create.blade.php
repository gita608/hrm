@extends('layouts.app')

@section('title', 'Create Employee')

@section('content')
	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Create Employee</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<a href="{{ route('employees.index') }}" class="btn btn-secondary d-flex align-items-center">
					<i class="ti ti-arrow-left me-2"></i>Back to List
				</a>
			</div>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body text-center">
					<p class="text-muted">Employee creation form will be implemented here.</p>
					<p>You can use the "Add Employee" modal from the employees list page, or implement a dedicated form here.</p>
				</div>
			</div>
		</div>
	</div>
@endsection

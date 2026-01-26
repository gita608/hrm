@extends('layouts.app')

@section('title', 'Edit Tax Bracket')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Edit Tax Bracket</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('payroll.tax.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="card">
		<div class="card-header">
			<h5>Tax Bracket Information</h5>
		</div>
		<div class="card-body">
			<form action="{{ route('payroll.tax.update', $tax->id) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="name" value="{{ old('name', $tax->name) }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Calculation Method <span class="text-danger">*</span></label>
							<select class="form-select" name="calculation_method" required>
								<option value="progressive" {{ old('calculation_method', $tax->calculation_method) == 'progressive' ? 'selected' : '' }}>Progressive</option>
								<option value="flat" {{ old('calculation_method', $tax->calculation_method) == 'flat' ? 'selected' : '' }}>Flat</option>
								<option value="fixed" {{ old('calculation_method', $tax->calculation_method) == 'fixed' ? 'selected' : '' }}>Fixed</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Minimum Income <span class="text-danger">*</span></label>
							<input type="number" step="0.01" class="form-control" name="min_income" value="{{ old('min_income', $tax->min_income) }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Maximum Income</label>
							<input type="number" step="0.01" class="form-control" name="max_income" value="{{ old('max_income', $tax->max_income) }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Tax Rate (%) <span class="text-danger">*</span></label>
							<input type="number" step="0.01" class="form-control" name="tax_rate" value="{{ old('tax_rate', $tax->tax_rate) }}" min="0" max="100" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Fixed Amount</label>
							<input type="number" step="0.01" class="form-control" name="fixed_amount" value="{{ old('fixed_amount', $tax->fixed_amount) }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Effective From <span class="text-danger">*</span></label>
							<input type="date" class="form-control" name="effective_from" value="{{ old('effective_from', $tax->effective_from->format('Y-m-d')) }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Status</label>
							<select class="form-select" name="is_active">
								<option value="1" {{ old('is_active', $tax->is_active) == '1' ? 'selected' : '' }}>Active</option>
								<option value="0" {{ old('is_active', $tax->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Description</label>
							<textarea class="form-control" name="description" rows="3">{{ old('description', $tax->description) }}</textarea>
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2">
					<a href="{{ route('payroll.tax.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Update Tax Bracket</button>
				</div>
			</form>
		</div>
	</div>

@endsection

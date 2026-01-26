@extends('layouts.app')

@section('title', 'Create Tax Bracket')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Create Tax Bracket</h2>
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
			<form action="{{ route('payroll.tax.store') }}" method="POST">
				@csrf
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="e.g., Tax Bracket 1" required>
							@error('name')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Calculation Method <span class="text-danger">*</span></label>
							<select class="form-select @error('calculation_method') is-invalid @enderror" name="calculation_method" required>
								<option value="">Select Method</option>
								<option value="progressive" {{ old('calculation_method') == 'progressive' ? 'selected' : '' }}>Progressive</option>
								<option value="flat" {{ old('calculation_method') == 'flat' ? 'selected' : '' }}>Flat</option>
								<option value="fixed" {{ old('calculation_method') == 'fixed' ? 'selected' : '' }}>Fixed</option>
							</select>
							@error('calculation_method')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Minimum Income <span class="text-danger">*</span></label>
							<input type="number" step="0.01" class="form-control @error('min_income') is-invalid @enderror" name="min_income" value="{{ old('min_income', 0) }}" required>
							@error('min_income')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Maximum Income</label>
							<input type="number" step="0.01" class="form-control @error('max_income') is-invalid @enderror" name="max_income" value="{{ old('max_income') }}" placeholder="Leave empty for unlimited">
							@error('max_income')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Tax Rate (%) <span class="text-danger">*</span></label>
							<input type="number" step="0.01" class="form-control @error('tax_rate') is-invalid @enderror" name="tax_rate" value="{{ old('tax_rate') }}" min="0" max="100" required>
							@error('tax_rate')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Fixed Amount</label>
							<input type="number" step="0.01" class="form-control @error('fixed_amount') is-invalid @enderror" name="fixed_amount" value="{{ old('fixed_amount', 0) }}">
							@error('fixed_amount')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Effective From <span class="text-danger">*</span></label>
							<input type="date" class="form-control @error('effective_from') is-invalid @enderror" name="effective_from" value="{{ old('effective_from', date('Y-m-d')) }}" required>
							@error('effective_from')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Status</label>
							<select class="form-select" name="is_active">
								<option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
								<option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Description</label>
							<textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description') }}</textarea>
							@error('description')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end gap-2">
					<a href="{{ route('payroll.tax.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Save Tax Bracket</button>
				</div>
			</form>
		</div>
	</div>

@endsection

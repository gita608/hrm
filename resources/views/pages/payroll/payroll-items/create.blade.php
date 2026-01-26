@extends('layouts.app')

@section('title', 'Create Payroll Item')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Create Payroll Item</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('payroll.items.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<div class="card">
		<div class="card-header">
			<h5>Payroll Item Information</h5>
		</div>
		<div class="card-body">
			<form action="{{ route('payroll.items.store') }}" method="POST">
				@csrf
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
							@error('name')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Type <span class="text-danger">*</span></label>
							<select class="form-select @error('type') is-invalid @enderror" name="type" required>
								<option value="">Select Type</option>
								<option value="allowance" {{ old('type') == 'allowance' ? 'selected' : '' }}>Allowance</option>
								<option value="deduction" {{ old('type') == 'deduction' ? 'selected' : '' }}>Deduction</option>
								<option value="bonus" {{ old('type') == 'bonus' ? 'selected' : '' }}>Bonus</option>
								<option value="overtime" {{ old('type') == 'overtime' ? 'selected' : '' }}>Overtime</option>
								<option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
							</select>
							@error('type')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Calculation Type <span class="text-danger">*</span></label>
							<select class="form-select @error('calculation_type') is-invalid @enderror" name="calculation_type" id="calculation_type" required>
								<option value="">Select Calculation Type</option>
								<option value="fixed" {{ old('calculation_type') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
								<option value="percentage" {{ old('calculation_type') == 'percentage' ? 'selected' : '' }}>Percentage</option>
								<option value="per_day" {{ old('calculation_type') == 'per_day' ? 'selected' : '' }}>Per Day</option>
								<option value="per_hour" {{ old('calculation_type') == 'per_hour' ? 'selected' : '' }}>Per Hour</option>
							</select>
							@error('calculation_type')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3" id="amount_field">
							<label class="form-label">Amount</label>
							<input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" name="amount" id="amount" value="{{ old('amount') }}">
							@error('amount')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="mb-3" id="percentage_field" style="display: none;">
							<label class="form-label">Percentage</label>
							<input type="number" step="0.01" class="form-control @error('percentage') is-invalid @enderror" name="percentage" id="percentage" value="{{ old('percentage') }}">
							@error('percentage')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Taxable</label>
							<select class="form-select" name="is_taxable">
								<option value="0" {{ old('is_taxable', '0') == '0' ? 'selected' : '' }}>No</option>
								<option value="1" {{ old('is_taxable') == '1' ? 'selected' : '' }}>Yes</option>
							</select>
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
					<a href="{{ route('payroll.items.index') }}" class="btn btn-outline-light border">Cancel</a>
					<button type="submit" class="btn btn-primary">Save Payroll Item</button>
				</div>
			</form>
		</div>
	</div>

	<script>
		document.getElementById('calculation_type').addEventListener('change', function() {
			const type = this.value;
			if (type === 'percentage') {
				document.getElementById('amount_field').style.display = 'none';
				document.getElementById('percentage_field').style.display = 'block';
			} else {
				document.getElementById('amount_field').style.display = 'block';
				document.getElementById('percentage_field').style.display = 'none';
			}
		});
	</script>

@endsection

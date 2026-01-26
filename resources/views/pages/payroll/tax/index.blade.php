@extends('layouts.app')

@section('title', 'Taxes')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Tax Brackets</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<a href="{{ route('payroll.tax.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Tax Bracket</a>
			</div>
		</div>
	</div>
	<!-- /Page Header -->

	@if(session('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			{{ session('success') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	<div class="card">
		<div class="card-header">
			<h5>Tax Brackets List</h5>
		</div>
		<div class="card-body p-0">
			<div class="custom-datatable-filter table-responsive">
				<table class="table datatable">
					<thead class="thead-light">
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Income Range</th>
							<th>Tax Rate</th>
							<th>Method</th>
							<th>Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@forelse($taxes as $tax)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $tax->name }}</td>
								<td>
									{{ number_format($tax->min_income, 2) }} - 
									{{ $tax->max_income ? number_format($tax->max_income, 2) : 'Above' }}
								</td>
								<td>{{ number_format($tax->tax_rate, 2) }}%</td>
								<td><span class="badge badge-info">{{ ucfirst($tax->calculation_method) }}</span></td>
								<td>
									@if($tax->is_active)
										<span class="badge badge-success">Active</span>
									@else
										<span class="badge badge-danger">Inactive</span>
									@endif
								</td>
								<td>
									<div class="action-icon d-inline-flex">
										<a href="{{ route('payroll.tax.show', $tax->id) }}" class="me-2" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('payroll.tax.edit', $tax->id) }}" class="me-2" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="7" class="text-center">No tax brackets found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

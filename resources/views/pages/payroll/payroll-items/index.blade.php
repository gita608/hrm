@extends('layouts.app')

@section('title', 'Payroll Items')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Payroll Items</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<a href="{{ route('payroll.items.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Payroll Item</a>
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
			<h5>Payroll Items List</h5>
		</div>
		<div class="card-body p-0">
			<div class="custom-datatable-filter table-responsive">
				<table class="table datatable">
					<thead class="thead-light">
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Type</th>
							<th>Calculation</th>
							<th>Amount/Percentage</th>
							<th>Taxable</th>
							<th>Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@forelse($payrollItems as $item)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $item->name }}</td>
								<td><span class="badge badge-info">{{ ucfirst($item->type) }}</span></td>
								<td>{{ ucfirst(str_replace('_', ' ', $item->calculation_type)) }}</td>
								<td>
									@if($item->calculation_type == 'percentage')
										{{ number_format($item->percentage, 2) }}%
									@else
										{{ number_format($item->amount ?? 0, 2) }}
									@endif
								</td>
								<td>
									@if($item->is_taxable)
										<span class="badge badge-warning">Yes</span>
									@else
										<span class="badge badge-secondary">No</span>
									@endif
								</td>
								<td>
									@if($item->is_active)
										<span class="badge badge-success">Active</span>
									@else
										<span class="badge badge-danger">Inactive</span>
									@endif
								</td>
								<td>
									<div class="action-icon d-inline-flex">
										<a href="{{ route('payroll.items.show', $item->id) }}" class="me-2" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('payroll.items.edit', $item->id) }}" class="me-2" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="8" class="text-center">No payroll items found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

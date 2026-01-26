@extends('layouts.app')

@section('title', 'HR Letters')

@section('content')

	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">HR Letters</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<div class="mb-2">
				<a href="{{ route('hr-letters.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add HR Letter</a>
			</div>
		</div>
	</div>

	@if(session('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			{{ session('success') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	<div class="card">
		<div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
			<h5>HR Letter List</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('hr-letters.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
					<div>
						<select name="status" class="form-select form-select-sm">
							<option value="">All Status</option>
							<option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
							<option value="issued" {{ request('status') == 'issued' ? 'selected' : '' }}>Issued</option>
							<option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
						</select>
					</div>
					<div>
						<button type="submit" class="btn btn-sm btn-primary">Filter</button>
						@if(request()->hasAny(['status', 'employee_id']))
							<a href="{{ route('hr-letters.index') }}" class="btn btn-sm btn-outline-light border">Clear</a>
						@endif
					</div>
				</form>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="custom-datatable-filter table-responsive">
				<table class="table datatable">
					<thead class="thead-light">
						<tr>
							<th>#</th>
							<th>Letter Number</th>
							<th>Title</th>
							<th>Type</th>
							<th>Employee</th>
							<th>Issue Date</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($letters as $letter)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td><strong>{{ $letter->letter_number }}</strong></td>
								<td>{{ $letter->title }}</td>
								<td><span class="badge badge-info">{{ ucfirst($letter->letter_type) }}</span></td>
								<td>{{ $letter->employee->name }}</td>
								<td>{{ $letter->issue_date->format('d M, Y') }}</td>
								<td>
									@if($letter->status == 'issued')
										<span class="badge badge-success">Issued</span>
									@elseif($letter->status == 'draft')
										<span class="badge badge-warning">Draft</span>
									@else
										<span class="badge badge-danger">Cancelled</span>
									@endif
								</td>
								<td>
									<div class="action-icon d-inline-flex">
										<a href="{{ route('hr-letters.show', $letter->id) }}" class="me-2" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('hr-letters.edit', $letter->id) }}" class="me-2" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										<form action="{{ route('hr-letters.destroy', $letter->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-link p-0 text-danger" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="8" class="text-center">No HR letters found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

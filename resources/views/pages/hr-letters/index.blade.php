@extends('layouts.app')

@section('title', 'HR Letters')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">HR Letters</h2>
			<p class="text-muted mb-0 fs-13">Generate and manage employee letters and certificates</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('hr-letters.create') }}" class="btn btn-primary d-flex align-items-center rounded-pill shadow-sm">
				<i class="ti ti-circle-plus me-2"></i>Add HR Letter
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	@if(session('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			{{ session('success') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
		<div class="card-header bg-transparent border-0 d-flex align-items-center justify-content-between pt-3 pb-2 flex-wrap row-gap-3">
			<h5 class="mb-0 fw-bold text-dark">HR Letter List</h5>
			<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
				<form method="GET" action="{{ route('hr-letters.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
					<div class="input-group input-group-sm rounded-pill overflow-hidden border-light-subtle" style="min-width: 250px;">
						<span class="input-group-text bg-white border-0 ps-3"><i class="ti ti-search text-muted"></i></span>
						<input type="text" name="q" class="form-control border-0 shadow-none ps-1" placeholder="Search by title or letter number..." value="{{ request('q') }}" onchange="this.form.submit()">
					</div>
					<div>
						<select name="letter_type" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" onchange="this.form.submit()">
							<option value="">All Letter Types</option>
							<option value="offer" {{ request('letter_type') == 'offer' ? 'selected' : '' }}>Offer Letter</option>
							<option value="appointment" {{ request('letter_type') == 'appointment' ? 'selected' : '' }}>Appointment Letter</option>
							<option value="experience" {{ request('letter_type') == 'experience' ? 'selected' : '' }}>Experience Certificate</option>
							<option value="relieving" {{ request('letter_type') == 'relieving' ? 'selected' : '' }}>Relieving Letter</option>
							<option value="warning" {{ request('letter_type') == 'warning' ? 'selected' : '' }}>Warning Letter</option>
							<option value="appreciation" {{ request('letter_type') == 'appreciation' ? 'selected' : '' }}>Appreciation Letter</option>
							<option value="promotion" {{ request('letter_type') == 'promotion' ? 'selected' : '' }}>Promotion Letter</option>
							<option value="transfer" {{ request('letter_type') == 'transfer' ? 'selected' : '' }}>Transfer Letter</option>
							<option value="other" {{ request('letter_type') == 'other' ? 'selected' : '' }}>Other</option>
						</select>
					</div>
					<div>
						<select name="status" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" onchange="this.form.submit()">
							<option value="">All Status</option>
							<option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
							<option value="issued" {{ request('status') == 'issued' ? 'selected' : '' }}>Issued</option>
							<option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
						</select>
					</div>
					<div>
						<select name="employee_id" class="form-select form-select-sm rounded-pill fs-12 border-light-subtle shadow-none" onchange="this.form.submit()">
							<option value="">All Employees</option>
							@foreach($employees as $employee)
								<option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
							@endforeach
						</select>
					</div>
					<div>
						@if(request()->hasAny(['q', 'status', 'employee_id', 'letter_type']))
							<a href="{{ route('hr-letters.index') }}" class="btn btn-sm btn-light rounded-pill px-3 shadow-none">Clear</a>
						@endif
					</div>
				</form>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="bg-light-50">
						<tr>
							<th class="ps-3 border-0 text-muted fs-12 fw-medium text-uppercase">#</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Letter Number</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Title</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Type</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Employee</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Issue Date</th>
							<th class="border-0 text-muted fs-12 fw-medium text-uppercase">Status</th>
							<th class="pe-3 border-0 text-end text-muted fs-12 fw-medium text-uppercase">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($letters as $letter)
							<tr class="border-bottom border-light">
								<td class="ps-3 text-muted">{{ $loop->iteration }}</td>
								<td><strong class="text-dark fw-bold">{{ $letter->letter_number }}</strong></td>
								<td><span class="text-dark">{{ $letter->title }}</span></td>
								<td><span class="badge bg-info-transparent text-info rounded-pill px-2 py-1 fs-11">{{ ucfirst($letter->letter_type) }}</span></td>
								<td>
									<div class="d-flex align-items-center">
										@if($letter->employee->profile_picture)
											<span class="avatar avatar-sm me-2">
												<img src="{{ asset('storage/' . $letter->employee->profile_picture) }}" alt="{{ $letter->employee->name }}" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
											</span>
										@else
											<div class="avatar avatar-sm bg-primary-transparent text-primary rounded-circle me-2 fw-bold d-flex align-items-center justify-content-center" style="font-size: 0.75rem;">
												{{ strtoupper(substr($letter->employee->name, 0, 1)) }}
											</div>
										@endif
										<span class="text-dark fw-medium">{{ $letter->employee->name }}</span>
									</div>
								</td>
								<td class="text-muted">{{ $letter->issue_date->format('d M, Y') }}</td>
								<td>
									@if($letter->status == 'issued')
										<span class="badge bg-success-transparent text-success rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-check me-1 fs-10"></i>Issued
										</span>
									@elseif($letter->status == 'draft')
										<span class="badge bg-warning-transparent text-warning rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-file-pencil me-1 fs-10"></i>Draft
										</span>
									@else
										<span class="badge bg-danger-transparent text-danger rounded-pill d-inline-flex align-items-center px-2 py-1">
											<i class="ti ti-x me-1 fs-10"></i>Cancelled
										</span>
									@endif
								</td>
								<td class="pe-3 text-end">
									<div class="d-flex justify-content-end gap-2">
										<a href="{{ route('hr-letters.show', $letter->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-primary hover-text-white transition-all" data-bs-toggle="tooltip" title="View"><i class="ti ti-eye"></i></a>
										<a href="{{ route('hr-letters.edit', $letter->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-info hover-text-white transition-all" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
										<form action="{{ route('hr-letters.destroy', $letter->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this letter?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-icon btn-light rounded-circle hover-bg-danger hover-text-white transition-all" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="8" class="text-center py-5">
									<div class="d-flex flex-column align-items-center">
										<div class="avatar avatar-xxl bg-light-50 rounded-circle mb-3 text-muted">
											<i class="ti ti-file-off fs-30"></i>
										</div>
										<h6 class="text-muted mb-0">No HR letters found</h6>
									</div>
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

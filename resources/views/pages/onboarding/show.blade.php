@extends('layouts.app')

@section('title', 'Onboarding Details')

@section('content')

	<!-- Breadcrumb -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
		<div class="my-auto mb-2">
			<h2 class="mb-1">Onboarding Details</h2>
		</div>
		<div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
			<a href="{{ route('onboarding.index') }}" class="btn btn-outline-light border">Back to List</a>
		</div>
	</div>
	<!-- /Breadcrumb -->

	@if(session('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			{{ session('success') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5>Onboarding Information</h5>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-4"><strong>Employee:</strong></div>
						<div class="col-md-8">{{ $onboarding->employee->name ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Email:</strong></div>
						<div class="col-md-8">{{ $onboarding->employee->email ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Template:</strong></div>
						<div class="col-md-8">{{ $onboarding->template->name ?? 'N/A' }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Status:</strong></div>
						<div class="col-md-8">
							@if($onboarding->status == 'completed')
								<span class="badge badge-success">Completed</span>
							@elseif($onboarding->status == 'cancelled')
								<span class="badge badge-danger">Cancelled</span>
							@elseif($onboarding->status == 'in_progress')
								<span class="badge badge-info">In Progress</span>
							@else
								<span class="badge badge-warning">Pending</span>
							@endif
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Start Date:</strong></div>
						<div class="col-md-8">{{ $onboarding->start_date->format('M d, Y') }}</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4"><strong>Expected Completion:</strong></div>
						<div class="col-md-8">{{ $onboarding->expected_completion_date ? $onboarding->expected_completion_date->format('M d, Y') : 'N/A' }}</div>
					</div>
					@if($onboarding->actual_completion_date)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Actual Completion:</strong></div>
						<div class="col-md-8">{{ $onboarding->actual_completion_date->format('M d, Y') }}</div>
					</div>
					@endif
					<div class="row mb-3">
						<div class="col-md-4"><strong>Assigned To:</strong></div>
						<div class="col-md-8">{{ $onboarding->assignedUser->name ?? 'N/A' }}</div>
					</div>
					@if($onboarding->notes)
					<div class="row mb-3">
						<div class="col-md-4"><strong>Notes:</strong></div>
						<div class="col-md-8">{{ $onboarding->notes }}</div>
					</div>
					@endif
				</div>
			</div>

			<!-- Checklist Section -->
			<div class="card">
				<div class="card-header d-flex align-items-center justify-content-between">
					<h5>Onboarding Checklist</h5>
					<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addChecklistModal">
						<i class="ti ti-plus me-1"></i>Add Item
					</button>
				</div>
				<div class="card-body">
					@forelse($onboarding->checklists->sortBy('order') as $item)
						<div class="d-flex align-items-start mb-3 p-3 border rounded {{ $item->is_completed ? 'bg-light' : '' }}">
							<div class="form-check me-3 mt-1">
								<input class="form-check-input" type="checkbox" {{ $item->is_completed ? 'checked' : '' }} disabled>
							</div>
							<div class="flex-grow-1">
								<h6 class="mb-1 {{ $item->is_completed ? 'text-decoration-line-through text-muted' : '' }}">
									{{ $item->task_name }}
									@if($item->is_required)
										<span class="badge badge-danger badge-xs">Required</span>
									@endif
								</h6>
								@if($item->description)
									<p class="text-muted mb-1">{{ $item->description }}</p>
								@endif
								<div class="d-flex align-items-center gap-3 text-muted fs-12">
									<span><i class="ti ti-tag me-1"></i>{{ ucfirst($item->task_type) }}</span>
									@if($item->due_date)
										<span><i class="ti ti-calendar me-1"></i>Due: {{ $item->due_date->format('M d, Y') }}</span>
									@endif
									@if($item->assignedUser)
										<span><i class="ti ti-user me-1"></i>{{ $item->assignedUser->name }}</span>
									@endif
									@if($item->is_completed && $item->completed_date)
										<span class="text-success"><i class="ti ti-check me-1"></i>Completed: {{ $item->completed_date->format('M d, Y') }}</span>
									@endif
								</div>
							</div>
							<div class="d-flex gap-2">
								@if(!$item->is_completed)
									<form action="{{ route('onboarding.checklist.complete', $item->id) }}" method="POST" class="d-inline">
										@csrf
										@method('PUT')
										<button type="submit" class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Mark Complete">
											<i class="ti ti-check"></i>
										</button>
									</form>
								@endif
								<form action="{{ route('onboarding.checklist.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this item?');">
									@csrf
									@method('DELETE')
									<button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Delete">
										<i class="ti ti-trash"></i>
									</button>
								</form>
							</div>
						</div>
					@empty
						<p class="text-muted text-center py-4">No checklist items yet. Click "Add Item" to create one.</p>
					@endforelse
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body text-center">
					<div class="avatar avatar-xxl mb-3">
						@if($onboarding->employee->profile_picture)
							<img src="{{ asset('storage/' . $onboarding->employee->profile_picture) }}" alt="Employee" class="img-fluid rounded-circle">
						@else
							<div class="avatar-initial bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px; font-size: 2.5rem;">
								{{ strtoupper(substr($onboarding->employee->name, 0, 1)) }}
							</div>
						@endif
					</div>
					<h4 class="mb-1">{{ $onboarding->employee->name }}</h4>
					<p class="text-muted mb-3">{{ $onboarding->employee->email }}</p>
					<div class="d-flex flex-column gap-2">
						<a href="{{ route('onboarding.edit', $onboarding->id) }}" class="btn btn-primary btn-sm">
							<i class="ti ti-edit me-2"></i>Edit Onboarding
						</a>
						<form action="{{ route('onboarding.destroy', $onboarding->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this onboarding?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-outline-danger btn-sm w-100">
								<i class="ti ti-trash me-2"></i>Delete Onboarding
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Add Checklist Modal -->
	<div class="modal fade" id="addChecklistModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Checklist Item</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="{{ route('onboarding.checklist.store', $onboarding->id) }}" method="POST">
					@csrf
					<div class="modal-body">
						<div class="mb-3">
							<label class="form-label">Task Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="task_name" required>
						</div>
						<div class="mb-3">
							<label class="form-label">Description</label>
							<textarea class="form-control" name="description" rows="3"></textarea>
						</div>
						<div class="mb-3">
							<label class="form-label">Task Type <span class="text-danger">*</span></label>
							<select class="form-select" name="task_type" required>
								<option value="document">Document</option>
								<option value="training">Training</option>
								<option value="setup">Setup</option>
								<option value="other">Other</option>
							</select>
						</div>
						<div class="mb-3">
							<label class="form-label">Due Date</label>
							<input type="date" class="form-control" name="due_date">
						</div>
						<div class="mb-3">
							<label class="form-label">Assigned To</label>
							<select class="form-select" name="assigned_to">
								<option value="">Select User</option>
								@foreach(\App\Models\User::whereNotNull('email_verified_at')->orderBy('name')->get() as $user)
									<option value="{{ $user->id }}">{{ $user->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="mb-3">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="is_required" value="1" checked>
								<label class="form-check-label">Required</label>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary">Add Item</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection

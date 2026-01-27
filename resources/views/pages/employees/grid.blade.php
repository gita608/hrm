@extends('layouts.app')

@section('title', 'Employees - Grid View')

@section('content')

    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
        <div class="my-auto">
            <h2 class="mb-1 text-dark fw-bold">Employee Directory</h2>
            <p class="text-muted mb-0 fs-13">Manage your workforce in a visual grid layout</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="d-flex align-items-center border bg-white rounded-pill p-1 shadow-sm me-2">
                <a href="{{ route('employees.index') }}" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-list"></i></a>
                <a href="{{ route('employees.grid') }}" class="btn btn-icon btn-sm rounded-circle active bg-primary text-white"><i class="ti ti-layout-grid"></i></a>
            </div>
            <a href="{{ route('employees.create') }}" class="btn btn-primary rounded-pill d-flex align-items-center shadow-sm px-3">
                <i class="ti ti-circle-plus me-2"></i>Add Employee
            </a>
        </div>
    </div>
    <!-- /Page Header -->

    <!-- Quick Stats -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg bg-primary-subtle rounded-4 text-primary me-3">
                            <i class="ti ti-users fs-24"></i>
                        </div>
                        <div>
                            <p class="text-muted fs-12 mb-0 fw-medium">Total Staff</p>
                            <h4 class="mb-0 fw-bold">{{ $totalEmployees ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg bg-success-subtle rounded-4 text-success me-3">
                            <i class="ti ti-user-check fs-24"></i>
                        </div>
                        <div>
                            <p class="text-muted fs-12 mb-0 fw-medium">Active Members</p>
                            <h4 class="mb-0 fw-bold">{{ $activeEmployees ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg bg-danger-subtle rounded-4 text-danger me-3">
                            <i class="ti ti-user-x fs-24"></i>
                        </div>
                        <div>
                            <p class="text-muted fs-12 mb-0 fw-medium">Inactive</p>
                            <h4 class="mb-0 fw-bold">{{ $inactiveEmployees ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg bg-info-subtle rounded-4 text-info me-3">
                            <i class="ti ti-clock-hour-4 fs-24"></i>
                        </div>
                        <div>
                            <p class="text-muted fs-12 mb-0 fw-medium">New Joiners</p>
                            <h4 class="mb-0 fw-bold">{{ $newJoiners ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('employees.grid') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-transparent border-end-0"><i class="ti ti-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search by name, email or ID..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="role" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Roles</option>
                        @foreach($designations ?? [] as $role)
                            <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-dark btn-sm rounded-pill w-100">Filter</button>
                    <a href="{{ route('employees.grid') }}" class="btn btn-light btn-sm rounded-pill w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Employee Grid -->
    <div class="row g-4">
        @forelse($employees as $employee)
            <div class="col-xxl-3 col-xl-4 col-sm-6">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 employee-grid-card">
                    <div class="card-body p-4 text-center">
                        <div class="dropdown position-absolute end-0 top-0 me-3 mt-3">
                            <button class="btn btn-icon btn-sm border-0 shadow-none" type="button" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical fs-18"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end p-2 rounded-3 border-0 shadow-lg">
                                <li><a class="dropdown-item rounded-2" href="{{ route('employees.show', $employee->id) }}"><i class="ti ti-eye me-2 text-info"></i>View Profile</a></li>
                                <li><a class="dropdown-item rounded-2" href="{{ route('employees.edit', $employee->id) }}"><i class="ti ti-edit me-2 text-primary"></i>Edit Record</a></li>
                                <li><hr class="dropdown-divider my-2"></li>
                                <li><a class="dropdown-item rounded-2 text-danger" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a></li>
                            </ul>
                        </div>
                        
                        <div class="avatar avatar-xxl rounded-circle mb-3 shadow-sm border border-4 border-light-50 mx-auto overflow-hidden bg-white" style="width: 100px; height: 100px;">
                            @if($employee->profile_picture)
                                <img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="Profile" class="img-fluid w-100 h-100 object-fit-cover">
                            @else
                                <div class="avatar-initial bg-primary-transparent text-primary fw-bold w-100 h-100 d-flex align-items-center justify-content-center" style="font-size: 2.5rem;">
                                    {{ strtoupper(substr($employee->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <h5 class="mb-1 fw-bold text-dark text-truncate px-2">
                            <a href="{{ route('employees.show', $employee->id) }}" class="text-dark hover-primary">{{ $employee->name }}</a>
                        </h5>
                        <p class="text-primary fw-bold fs-12 mb-3 text-uppercase ls-1">{{ $employee->role->name ?? 'Staff' }}</p>

                        <div class="d-flex align-items-center justify-content-center gap-2 mb-4">
                            <span class="badge bg-light text-muted border px-2 py-1 rounded-pill fs-11">
                                <i class="ti ti-mail me-1"></i> {{ Str::limit($employee->email, 20) }}
                            </span>
                        </div>

                        <div class="row g-2 pt-3 border-top border-light-subtle">
                            <div class="col-6 text-start">
                                <p class="text-muted fs-11 mb-0">Member Since</p>
                                <h6 class="mb-0 fs-12 fw-bold">{{ $employee->created_at ? $employee->created_at->format('M Y') : 'N/A' }}</h6>
                            </div>
                            <div class="col-6 text-end">
                                <p class="text-muted fs-11 mb-0">Status</p>
                                <span class="badge bg-success-subtle text-success rounded-pill px-2 fs-10">Active</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 text-center py-5">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="ti ti-users-minus fs-60 text-muted opacity-25"></i>
                        </div>
                        <h4 class="fw-bold text-dark">No employees found</h4>
                        <p class="text-muted mb-0">Try adjusting your filters or search terms.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination (Placeholder for now) -->
    <div class="d-flex justify-content-center mt-5">
        {{-- {{ $employees->links() }} --}}
    </div>

    <style>
        .employee-grid-card {
            transition: all 0.3s ease;
        }
        .employee-grid-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0,0,0,0.1) !important;
        }
        .hover-primary:hover {
            color: var(--bs-primary) !important;
        }
        .avatar-initial {
            background: linear-gradient(135deg, rgba(var(--bs-primary-rgb), 0.1) 0%, rgba(var(--bs-primary-rgb), 0.2) 100%);
        }
    </style>

@endsection

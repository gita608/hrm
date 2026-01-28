@extends('layouts.app')

@section('title', 'Document Archives')

@section('content')

@php
    function getFileIcon($mimeType) {
        $mimeType = strtolower($mimeType);
        if (str_contains($mimeType, 'pdf')) return 'ti-file-type-pdf text-danger';
        if (str_contains($mimeType, 'word') || str_contains($mimeType, 'officedocument.wordprocessingml')) return 'ti-file-type-doc text-primary';
        if (str_contains($mimeType, 'excel') || str_contains($mimeType, 'officedocument.spreadsheetml')) return 'ti-file-type-xls text-success';
        if (str_contains($mimeType, 'image')) return 'ti-file-type-jpg text-warning';
        if (str_contains($mimeType, 'zip') || str_contains($mimeType, 'rar')) return 'ti-file-zip text-secondary';
        return 'ti-file-text text-muted';
    }
@endphp

<style>
    .archive-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .archive-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
        border-color: var(--bs-primary-border-subtle);
    }
    .file-icon-box {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #f8f9fa;
        font-size: 24px;
        margin-right: 15px;
    }
    .folder-box {
        width: 100%;
        padding: 20px;
        background: #fff;
        border-radius: 16px;
        text-align: center;
        cursor: pointer;
    }
    .folder-icon {
        font-size: 48px;
        color: #ffc107;
        margin-bottom: 10px;
        display: block;
    }
    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }
    .glass-sidebar {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    .search-input-archive {
        border: none;
        background: #f0f2f5;
        border-radius: 12px;
        padding: 10px 15px 10px 40px;
        width: 100%;
        font-size: 14px;
    }
    .search-icon-archive {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #adb5bd;
    }
</style>

<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
    <div class="my-auto">
        <h2 class="mb-1 text-dark fw-bold">Document Archives</h2>
        <p class="text-muted mb-0 fs-13">Secure storage and management of employee records</p>
    </div>
    <div class="d-flex align-items-center gap-3">
        <div class="position-relative d-none d-lg-block">
            <form action="{{ route('documents.index') }}" method="GET">
                <i class="ti ti-search search-icon-archive"></i>
                <input type="text" name="q" value="{{ request('q') }}" class="search-input-archive shadow-none" placeholder="Search archives...">
            </form>
        </div>
        <a href="{{ route('documents.create') }}" class="btn btn-primary d-flex align-items-center rounded-pill px-4 shadow-sm">
            <i class="ti ti-plus me-2"></i>New Document
        </a>
    </div>
</div>
<!-- /Page Header -->

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="ti ti-circle-check fs-20 me-2"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">
    <!-- Sidebar Filters -->
    <div class="col-xl-3 col-lg-4">
        <div class="glass-sidebar p-4 shadow-sm mb-4">
            <h6 class="fw-bold mb-4 text-dark">Quick Filters</h6>
            
            <div class="mb-4">
                <p class="text-muted fs-11 text-uppercase fw-semibold ls-1 mb-2">Categories</p>
                <div class="list-group list-group-flush border-0">
                    <a href="{{ route('documents.index') }}" class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center justify-content-between {{ !request('status') && !request('employee_id') ? 'text-primary fw-bold' : 'text-muted' }}">
                        <span><i class="ti ti-layout-grid me-2"></i> All Files</span>
                        <span class="badge bg-light text-dark rounded-pill">{{ $documents->count() }}</span>
                    </a>
                    <a href="{{ route('documents.index', ['status' => 'active']) }}" class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center justify-content-between {{ request('status') == 'active' ? 'text-success fw-bold' : 'text-muted' }}">
                        <span><i class="ti ti-circle-check me-2"></i> Active</span>
                        <span class="badge bg-success-transparent text-success rounded-pill">{{ $documents->where('status', 'active')->count() }}</span>
                    </a>
                    <a href="{{ route('documents.index', ['status' => 'expired']) }}" class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center justify-content-between {{ request('status') == 'expired' ? 'text-danger fw-bold' : 'text-muted' }}">
                        <span><i class="ti ti-alert-circle me-2"></i> Expired</span>
                        <span class="badge bg-danger-transparent text-danger rounded-pill">{{ $documents->where('status', 'expired')->count() }}</span>
                    </a>
                    <a href="{{ route('documents.index', ['status' => 'archived']) }}" class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center justify-content-between {{ request('status') == 'archived' ? 'text-warning fw-bold' : 'text-muted' }}">
                        <span><i class="ti ti-archive me-2"></i> Archived</span>
                        <span class="badge bg-warning-transparent text-warning rounded-pill">{{ $documents->where('status', 'archived')->count() }}</span>
                    </a>
                </div>
            </div>

            <div class="mb-4">
                <p class="text-muted fs-11 text-uppercase fw-semibold ls-1 mb-2">Storage Usage</p>
                <div class="p-3 bg-light rounded-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fs-12 text-muted">Total Size</span>
                        <span class="fs-12 fw-bold text-dark">
                            @php
                                $totalSize = $documents->sum('file_size');
                                if($totalSize < 1024) $sizeStr = $totalSize . ' B';
                                elseif($totalSize < 1048576) $sizeStr = round($totalSize / 1024, 2) . ' KB';
                                else $sizeStr = round($totalSize / 1048576, 2) . ' MB';
                            @endphp
                            {{ $sizeStr }}
                        </span>
                    </div>
                    <div class="progress progress-xs mb-0">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="fs-10 text-muted mt-2 mb-0">Updated just now</p>
                </div>
            </div>

            <div class="mb-0">
                <p class="text-muted fs-11 text-uppercase fw-semibold ls-1 mb-2">Employee Filter</p>
                <form action="{{ route('documents.index') }}" method="GET">
                    <select name="employee_id" class="form-select form-select-sm rounded-3 border-light shadow-none" onchange="this.form.submit()">
                        <option value="">All Employees</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="col-xl-9 col-lg-8">
        
        <!-- Breadcrumbs / View Switcher -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('documents.index') }}" class="text-muted text-decoration-none">Archives</a></li>
                    @if(request('employee_id'))
                        <li class="breadcrumb-item text-dark fw-bold" aria-current="page">{{ $employees->find(request('employee_id'))->name }}</li>
                    @elseif(request('status'))
                        <li class="breadcrumb-item text-dark fw-bold text-capitalize" aria-current="page">{{ request('status') }}</li>
                    @else
                        <li class="breadcrumb-item text-dark fw-bold" aria-current="page">All Documents</li>
                    @endif
                </ol>
            </nav>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-light btn-icon btn-sm rounded-3 active view-toggle-btn" id="grid-view-btn" onclick="switchView('grid')">
                    <i class="ti ti-layout-grid"></i>
                </button>
                <button type="button" class="btn btn-light btn-icon btn-sm rounded-3 view-toggle-btn" id="list-view-btn" onclick="switchView('list')">
                    <i class="ti ti-list"></i>
                </button>
            </div>
        </div>

        <div id="archive-grid-view">
            @if(!request('employee_id') && !request('status') && !request('q'))
                <!-- Recent Documents Section -->
                <div class="mb-5">
                    <h6 class="fw-bold mb-3 text-dark">Recently Uploaded</h6>
                    <div class="row g-3">
                        @forelse($documents->sortByDesc('created_at')->take(4) as $doc)
                            <div class="col-md-3">
                                <div class="card archive-card border-0 shadow-sm rounded-4 h-100">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="file-icon-box">
                                                <i class="ti {{ getFileIcon($doc->file_type) }}"></i>
                                            </div>
                                            <div class="dropdown ms-auto">
                                                <button class="btn btn-icon btn-sm btn-light border-0 rounded-circle" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3">
                                                    <li><a class="dropdown-item py-2" href="{{ route('documents.show', $doc->id) }}"><i class="ti ti-eye me-2"></i>View Details</a></li>
                                                    @if($doc->file_path)
                                                    <li><a class="dropdown-item py-2" href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"><i class="ti ti-download me-2"></i>Download</a></li>
                                                    @endif
                                                    <li><hr class="dropdown-divider opacity-50"></li>
                                                    <li>
                                                        <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Delete this document?');">
                                                            @csrf @method('DELETE')
                                                            <button class="dropdown-item py-2 text-danger"><i class="ti ti-trash me-2"></i>Delete</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <h6 class="text-truncate fw-bold mb-1" title="{{ $doc->title }}">{{ $doc->title }}</h6>
                                        <p class="text-muted fs-11 mb-2">{{ $doc->created_at->diffForHumans() }}</p>
                                        <div class="d-flex align-items-center">
                                            @if($doc->employee)
                                                <div class="avatar avatar-xs rounded-circle me-1">
                                                    <img src="{{ $doc->employee->profile_picture ? asset('storage/' . $doc->employee->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($doc->employee->name) }}" alt="" class="rounded-circle">
                                                </div>
                                                <span class="fs-11 text-muted">{{ $doc->employee->name }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12"><p class="text-muted fs-13 italic">No recent uploads</p></div>
                        @endforelse
                    </div>
                </div>

                <!-- Folders Section (Grouping by Employee) -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3 text-dark">Employee Archives</h6>
                    <div class="row g-4">
                        @php
                            $groupedDocs = $documents->groupBy('employee_id');
                        @endphp
                        @foreach($groupedDocs as $empId => $docs)
                            @php $employee = $employees->find($empId); @endphp
                            @if($employee)
                            <div class="col-lg-4 col-md-6">
                                <a href="{{ route('documents.index', ['employee_id' => $empId]) }}" class="text-decoration-none">
                                    <div class="card archive-card border-0 shadow-sm rounded-4 text-center p-4">
                                        <div class="mb-3">
                                            <i class="ti ti-folder text-warning" style="font-size: 64px;"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-1">{{ $employee->name }}</h6>
                                        <p class="text-muted fs-12 mb-0">{{ $docs->count() }} Documents</p>
                                    </div>
                                </a>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @else
                <!-- File Grid View (Filtered) -->
                <div class="row g-4">
                    @forelse($documents as $document)
                        <div class="col-xl-4 col-md-6">
                            <div class="card archive-card border-0 shadow-sm rounded-4">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="file-icon-box bg-white border shadow-sm rounded-4">
                                            <i class="ti {{ getFileIcon($document->file_type) }}"></i>
                                        </div>
                                        <div class="ms-auto d-flex flex-column align-items-end">
                                            <div class="dropdown">
                                                <button class="btn btn-icon btn-sm btn-light border-0 rounded-circle" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3">
                                                    <li><a class="dropdown-item py-2" href="{{ route('documents.show', $document->id) }}"><i class="ti ti-eye me-2"></i>View</a></li>
                                                    <li><a class="dropdown-item py-2" href="{{ route('documents.edit', $document->id) }}"><i class="ti ti-edit me-2"></i>Edit</a></li>
                                                    @if($document->file_path)
                                                    <li><a class="dropdown-item py-2" href="{{ asset('storage/' . $document->file_path) }}" target="_blank"><i class="ti ti-download me-2"></i>Download</a></li>
                                                    @endif
                                                    <li><hr class="dropdown-divider opacity-50"></li>
                                                    <li>
                                                        <form action="{{ route('documents.destroy', $document->id) }}" method="POST" onsubmit="return confirm('Delete this document?');">
                                                            @csrf @method('DELETE')
                                                            <button class="dropdown-item py-2 text-danger"><i class="ti ti-trash me-2"></i>Delete</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                            @if($document->status == 'active')
                                                <span class="badge bg-success-transparent text-success rounded-pill mt-2 fs-10 px-2">Active</span>
                                            @elseif($document->status == 'expired')
                                                <span class="badge bg-danger-transparent text-danger rounded-pill mt-2 fs-10 px-2">Expired</span>
                                            @else
                                                <span class="badge bg-secondary-transparent text-secondary rounded-pill mt-2 fs-10 px-2">Archived</span>
                                            @endif
                                        </div>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1 text-truncate" title="{{ $document->title }}">{{ $document->title }}</h6>
                                    <p class="text-muted fs-12 mb-3">#{{ $document->document_number ?? 'N/A' }}</p>
                                    
                                    <div class="d-flex align-items-center justify-content-between p-2 bg-light rounded-3">
                                        <div class="d-flex align-items-center">
                                            <i class="ti ti-calendar-event me-2 text-muted fs-14"></i>
                                            <span class="fs-11 text-dark">{{ $document->issue_date ? $document->issue_date->format('d M, Y') : 'No Date' }}</span>
                                        </div>
                                        @if($document->file_size)
                                            <span class="fs-11 text-muted">
                                                @php
                                                    $size = $document->file_size;
                                                    if($size < 1024) echo $size . ' B';
                                                    elseif($size < 1048576) echo round($size / 1024, 2) . ' KB';
                                                    else echo round($size / 1048576, 2) . ' MB';
                                                @endphp
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="mt-3 pt-3 border-top border-light d-flex align-items-center">
                                        @if($document->employee)
                                            <div class="avatar avatar-sm rounded-circle me-2 border border-2 border-white shadow-sm">
                                                <img src="{{ $document->employee->profile_picture ? asset('storage/' . $document->employee->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($document->employee->name) }}" alt="">
                                            </div>
                                            <div>
                                                <h6 class="fs-12 fw-bold text-dark mb-0">{{ $document->employee->name }}</h6>
                                                <span class="fs-10 text-muted">{{ $document->employee->employee_id ?? 'EMP' }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <div class="avatar avatar-xxl bg-light-50 rounded-circle mb-3 mx-auto text-muted">
                                <i class="ti ti-file-off fs-40"></i>
                            </div>
                            <h5 class="fw-bold text-dark">No documents found</h5>
                            <p class="text-muted">Try adjusting your filters or search keywords.</p>
                            <a href="{{ route('documents.index') }}" class="btn btn-primary rounded-pill px-4 mt-2">Clear All Filters</a>
                        </div>
                    @endforelse
                </div>
            @endif
        </div>

        <div id="archive-list-view" style="display: none;">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 border-0 text-muted fs-12 text-uppercase ls-1">Document</th>
                                    <th class="border-0 text-muted fs-12 text-uppercase ls-1">Owner</th>
                                    <th class="border-0 text-muted fs-12 text-uppercase ls-1">Reference</th>
                                    <th class="border-0 text-muted fs-12 text-uppercase ls-1">Expiry</th>
                                    <th class="border-0 text-muted fs-12 text-uppercase ls-1">Status</th>
                                    <th class="pe-4 border-0 text-end text-muted fs-12 text-uppercase ls-1">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($documents as $doc)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <i class="ti {{ getFileIcon($doc->file_type) }} fs-20 me-2"></i>
                                                <span class="text-dark fw-bold">{{ $doc->title }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $doc->employee && $doc->employee->profile_picture ? asset('storage/' . $doc->employee->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($doc->employee->name ?? 'N/A') }}" class="avatar avatar-xs rounded-circle me-2" alt="">
                                                <span class="text-muted fs-13">{{ $doc->employee->name ?? 'N/A' }}</span>
                                            </div>
                                        </td>
                                        <td><span class="text-dark fs-13">#{{ $doc->document_number ?? '---' }}</span></td>
                                        <td><span class="text-muted fs-13">{{ $doc->expiry_date ? $doc->expiry_date->format('d M, Y') : 'Life-long' }}</span></td>
                                        <td>
                                            @if($doc->status == 'active')
                                                <span class="badge bg-success-transparent text-success rounded-pill px-2">Active</span>
                                            @elseif($doc->status == 'expired')
                                                <span class="badge bg-danger-transparent text-danger rounded-pill px-2">Expired</span>
                                            @else
                                                <span class="badge bg-secondary-transparent text-secondary rounded-pill px-2">Archived</span>
                                            @endif
                                        </td>
                                        <td class="pe-4 text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('documents.show', $doc->id) }}" class="btn btn-sm btn-icon btn-light rounded-circle"><i class="ti ti-eye"></i></a>
                                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm btn-icon btn-light rounded-circle"><i class="ti ti-download"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center py-4">No documents available</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function switchView(type) {
        const gridView = document.getElementById('archive-grid-view');
        const listView = document.getElementById('archive-list-view');
        const gridBtn = document.getElementById('grid-view-btn');
        const listBtn = document.getElementById('list-view-btn');

        if (type === 'grid') {
            gridView.style.display = 'block';
            listView.style.display = 'none';
            gridBtn.classList.add('active');
            listBtn.classList.remove('active');
            localStorage.setItem('archive-view-pref', 'grid');
        } else {
            gridView.style.display = 'none';
            listView.style.display = 'block';
            gridBtn.classList.remove('active');
            listBtn.classList.add('active');
            localStorage.setItem('archive-view-pref', 'list');
        }
    }

    // Restore preference on load
    document.addEventListener('DOMContentLoaded', function() {
        const pref = localStorage.getItem('archive-view-pref');
        if (pref === 'list') {
            switchView('list');
        }
    });
</script>

@endsection

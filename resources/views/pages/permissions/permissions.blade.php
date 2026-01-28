@extends('layouts.app')

@section('title', 'Set Permissions - ' . $role->name)

@section('content')

    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
        <div class="my-auto">
            <h2 class="mb-1 text-dark fw-bold">Role Permissions: {{ $role->name }}</h2>
            <p class="text-muted mb-0 fs-13">Select the menu items this role can access</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('permissions.index') }}" class="btn btn-light rounded-pill shadow-sm py-2 px-3">
                <i class="ti ti-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <form action="{{ route('permissions.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="card-header bg-transparent border-bottom border-light pt-3 pb-2 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark">Assign Menus</h5>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" id="selectAll">Select All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" id="deselectAll">Deselect All</button>
                </div>
            </div>
            
            <div class="card-body p-4">
                <div class="row">
                    @foreach($menuItems as $menuItem)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="permission-card p-3 border rounded-3 bg-light-50 h-100">
                                <div class="form-check d-flex align-items-center mb-3">
                                    <input class="form-check-input parent-checkbox me-2" type="checkbox" 
                                           name="menu_items[]" value="{{ $menuItem->id }}" 
                                           id="menu_{{ $menuItem->id }}"
                                           {{ in_array($menuItem->id, $roleMenuItems) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-dark fs-15" for="menu_{{ $menuItem->id }}">
                                        @if($menuItem->icon) <i class="{{ $menuItem->icon }} me-1 text-primary"></i> @endif
                                        {{ $menuItem->name }}
                                        <span class="badge bg-light text-muted fw-normal ms-2 fs-11">{{ $menuItem->type }}</span>
                                    </label>
                                </div>
                                
                                <div class="ps-4 border-start ms-2">
                                    @if($menuItem->children->count() > 0)
                                        @foreach($menuItem->children as $child)
                                            <div class="form-check d-flex align-items-center mb-2">
                                                <input class="form-check-input child-checkbox me-2" type="checkbox" 
                                                       name="menu_items[]" value="{{ $child->id }}" 
                                                       id="menu_{{ $child->id }}"
                                                       data-parent="menu_{{ $menuItem->id }}"
                                                       {{ in_array($child->id, $roleMenuItems) ? 'checked' : '' }}>
                                                <label class="form-check-label text-muted fs-14" for="menu_{{ $child->id }}">
                                                    {{ $child->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-muted fs-12 mb-0 italic">No sub-menus</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="card-footer bg-transparent border-top border-light p-4 text-end">
                <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm py-2">
                    <i class="ti ti-device-floppy me-2"></i> Save Permissions
                </button>
            </div>
        </form>
    </div>

    <style>
        .permission-card {
            transition: all 0.2s ease;
        }
        .permission-card:hover {
            border-color: #f26522 !important;
            box-shadow: 0 4px 12px rgba(242, 101, 34, 0.05);
        }
        .bg-light-50 {
            background-color: #fcfcfd;
        }
        .form-check-input:checked {
            background-color: #f26522;
            border-color: #f26522;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to handle parent-child checkbox relationship
            const parents = document.querySelectorAll('.parent-checkbox');
            const children = document.querySelectorAll('.child-checkbox');
            
            parents.forEach(parent => {
                parent.addEventListener('change', function() {
                    const parentId = this.id;
                    const childrenOfParent = document.querySelectorAll(`[data-parent="${parentId}"]`);
                    childrenOfParent.forEach(child => {
                        child.checked = this.checked;
                    });
                });
            });
            
            children.forEach(child => {
                child.addEventListener('change', function() {
                    if (this.checked) {
                        const parentId = this.getAttribute('data-parent');
                        const parent = document.getElementById(parentId);
                        if (parent) parent.checked = true;
                    } else {
                        // If all siblings are unchecked, maybe uncheck parent? 
                        // Usually better to leave parent checked if one child was unchecked but others remain
                        // But if NO children are checked, parent could still be checked (e.g. for access to parent menu itself)
                    }
                });
            });
            
            // Select All / Deselect All
            document.getElementById('selectAll').addEventListener('click', () => {
                document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = true);
            });
            
            document.getElementById('deselectAll').addEventListener('click', () => {
                document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
            });
        });
    </script>

@endsection

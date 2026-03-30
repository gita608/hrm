@extends('layouts.app')

@section('title', 'Settings')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">System Settings</h2>
			<p class="text-muted mb-0 fs-13">Configure your application preferences and branding</p>
		</div>
		<div class="d-flex align-items-center gap-2">
			<a href="{{ route('dashboard') }}" class="btn btn-light rounded-pill border shadow-sm px-3">
				<i class="ti ti-smart-home me-2"></i>Dashboard
			</a>
		</div>
	</div>
	<!-- /Page Header -->

	<div class="row justify-content-center">
		<div class="col-xl-9 col-lg-11">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-4 alert-dismissible fade show mb-4 d-flex align-items-center" role="alert">
                    <i class="ti ti-circle-check-filled me-2 fs-20"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm rounded-4 alert-dismissible fade show mb-4 d-flex align-items-center" role="alert">
                    <i class="ti ti-alert-circle me-2 fs-20"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

			<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-header bg-white p-0 border-bottom">
					<ul class="nav nav-tabs nav-tabs-bottom border-bottom-0 mb-0" role="tablist">
						<li class="nav-item">
							<a class="nav-link active py-3 px-4 d-flex align-items-center fw-bold fs-14" data-bs-toggle="tab" href="#general" role="tab">
								<i class="ti ti-settings-automation me-2 fs-18"></i>General
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link py-3 px-4 d-flex align-items-center fw-bold fs-14" data-bs-toggle="tab" href="#branding" role="tab">
								<i class="ti ti-photo me-2 fs-18"></i>Branding
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link py-3 px-4 d-flex align-items-center fw-bold fs-14" data-bs-toggle="tab" href="#integrations" role="tab">
								<i class="ti ti-link me-2 fs-18"></i>Integrations
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link py-3 px-4 d-flex align-items-center fw-bold fs-14" data-bs-toggle="tab" href="#access-control" role="tab">
								<i class="ti ti-shield-lock me-2 fs-18"></i>Access Control
							</a>
						</li>
					</ul>
				</div>
				<div class="card-body p-0">
                    <form id="settings-form" action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="tab-content p-4 p-md-5">
                            <!-- General Settings Tab -->
                            <div class="tab-pane fade show active" id="general" role="tabpanel">
                                <div class="row g-4">
                                    <div class="col-12">
                                        <div class="form-group mb-0">
                                            <label class="form-label text-dark fw-bold fs-14 mb-2">
                                                Application Branding Name <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                                                <span class="input-group-text bg-white border-end-0 px-3">
                                                    <i class="ti ti-brand-abstract text-muted"></i>
                                                </span>
                                                <input type="text" class="form-control border-start-0 ps-0 @error('app_name') is-invalid @enderror" 
                                                       name="app_name" value="{{ old('app_name', $appName) }}" 
                                                       placeholder="e.g. SmartHR Solutions" required>
                                            </div>
                                            @error('app_name')
                                                <div class="text-danger fs-12 mt-1 px-1"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                                            @enderror
                                            <p class="text-muted fs-12 mt-2 mb-0 ms-1">
                                                <i class="ti ti-info-circle me-1"></i>This identity is used in emails, reports, and browser tabs.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Branding Tab -->
                            <div class="tab-pane fade" id="branding" role="tabpanel">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="p-4 bg-light rounded-4 border border-dashed border-light-subtle h-100">
                                            <label class="form-label text-dark fw-bold fs-14 mb-3">Main Banner Logo</label>
                                            <div class="d-flex align-items-center g-4">
                                                <div class="me-4">
                                                    <div class="avatar-preview shadow-sm rounded-4 border border-4 border-white overflow-hidden bg-white d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                                        @if($appLogo)
                                                            <img id="logo-preview" src="{{ asset('storage/' . $appLogo) }}" alt="Logo" class="img-fluid w-100 h-100 object-fit-contain p-2">
                                                        @else
                                                            <div id="logo-placeholder" class="text-center p-3">
                                                                <i class="ti ti-photo fs-30 text-muted opacity-50"></i>
                                                                <p class="mb-0" style="font-size: 8px; color: #999; font-weight: 700;">NO LOGO</p>
                                                            </div>
                                                            <img id="logo-preview" src="#" alt="Logo Preview" class="img-fluid w-100 h-100 object-fit-contain p-2 d-none">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="file" class="form-control form-control-sm @error('app_logo') is-invalid @enderror" 
                                                           name="app_logo" accept="image/*" onchange="previewImage(this, 'logo-preview', 'logo-placeholder')">
                                                    <p class="text-muted fs-11 mt-2 mb-0">Full logo used for sidebar headers and emails.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-4 bg-light rounded-4 border border-dashed border-light-subtle h-100">
                                            <label class="form-label text-dark fw-bold fs-14 mb-3">Small Icon Logo (Mini Sidebar)</label>
                                            <div class="d-flex align-items-center g-4">
                                                <div class="me-4">
                                                    <div class="avatar-preview shadow-sm rounded-4 border border-4 border-white overflow-hidden bg-white d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                                        @if($appLogoSmall)
                                                            <img id="small-logo-preview" src="{{ asset('storage/' . $appLogoSmall) }}" alt="Small Logo" class="img-fluid w-100 h-100 object-fit-contain p-2">
                                                        @else
                                                            <img id="small-logo-preview" src="{{ asset('assets/img/favicon.png') }}" alt="Small Logo" class="img-fluid w-100 h-100 object-fit-contain p-2">
                                                            <div id="small-logo-placeholder" class="text-center p-3 d-none">
                                                                <i class="ti ti-brand-abstract fs-30 text-muted opacity-50"></i>
                                                                <p class="mb-0" style="font-size: 8px; color: #999; font-weight: 700;">NO ICON</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="file" class="form-control form-control-sm @error('app_logo_small') is-invalid @enderror" 
                                                           name="app_logo_small" accept="image/*" onchange="previewImage(this, 'small-logo-preview', 'small-logo-placeholder')">
                                                    <p class="text-muted fs-11 mt-2 mb-0">Compact icon used when the sidebar is minimized.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Integrations Tab -->
                            <div class="tab-pane fade" id="integrations" role="tabpanel">
                                <div class="bg-success-transparent rounded-4 p-4 border border-success border-opacity-10 mb-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success rounded-3 p-2 me-3">
                                                <i class="ti ti-link text-white"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-bold text-dark">QuickBooks Online</h6>
                                                <p class="text-muted mb-0 fs-12">Synchronize your accounting data</p>
                                            </div>
                                        </div>
                                        @if($isQuickBooksConnected)
                                            <div class="d-flex align-items-center gap-3">
                                                <span class="badge bg-success-transparent text-success rounded-pill px-3 py-1">
                                                    <i class="ti ti-circle-check-filled me-1"></i>Connected
                                                </span>
                                                <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="document.getElementById('qb-disconnect-form').submit()">
                                                    <i class="ti ti-link-off me-1"></i>Disconnect
                                                </button>
                                            </div>
                                        @else
                                            <span class="badge bg-light text-muted rounded-pill px-3 py-1">
                                                <i class="ti ti-circle-x-filled me-1"></i>Not Connected
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label text-dark fw-bold fs-14 mb-2">QuickBooks Client ID</label>
                                            <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                                <span class="input-group-text bg-white border-end-0 px-3">
                                                    <i class="ti ti-key text-muted"></i>
                                                </span>
                                                <input type="text" class="form-control border-start-0 ps-0" 
                                                       name="quickbooks_client_id" value="{{ old('quickbooks_client_id', $quickbooksClientId) }}" 
                                                       placeholder="Enter Client ID">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label text-dark fw-bold fs-14 mb-2">QuickBooks Client Secret</label>
                                            <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                                <span class="input-group-text bg-white border-end-0 px-3">
                                                    <i class="ti ti-lock text-muted"></i>
                                                </span>
                                                <input type="password" class="form-control border-start-0 ps-0" 
                                                       name="quickbooks_client_secret" value="{{ old('quickbooks_client_secret', $quickbooksClientSecret) }}" 
                                                       placeholder="Enter Client Secret">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if(!$isQuickBooksConnected)
                                    <div class="mt-4 pt-3 border-top border-light-subtle d-flex align-items-center justify-content-between">
                                        <p class="text-muted fs-13 mb-0">
                                            <i class="ti ti-info-circle me-1"></i>Save credentials first, then click "Connect".
                                        </p>
                                        <a href="{{ route('quickbooks.connect') }}" class="btn btn-success rounded-pill px-4 @if(empty($quickbooksClientId) || empty($quickbooksClientSecret)) disabled @endif">
                                            <i class="ti ti-brand-linktree me-2"></i>Connect to QuickBooks
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <!-- Access Control Tab -->
                            <div class="tab-pane fade" id="access-control" role="tabpanel">
                                <div class="p-4 bg-warning-transparent rounded-4 border border-warning border-opacity-10">
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-warning rounded-3 p-2 me-3">
                                                <i class="ti ti-shield-lock text-white"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-bold text-dark">Menu & Access Management</h6>
                                                <p class="text-muted mb-0 fs-12">Configure role-based permissions and visibility</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('permissions.index') }}" class="btn btn-warning text-white rounded-pill px-4 shadow-sm">
                                            Go to Permissions
                                        </a>
                                    </div>
                                    <div class="text-muted fs-13">
                                        <p class="mb-0"><i class="ti ti-info-circle me-1"></i>Permissions allow you to restrict specific modules, features, or menu items based on user roles like Admin, HR Manager, or Employee.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Global Actions -->
						<div class="d-flex justify-content-end gap-3 p-4 border-top border-light bg-light-50">
							<a href="{{ route('dashboard') }}" class="btn btn-light rounded-pill px-4 py-2 border">
								Dismiss
							</a>
							<button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm">
								<i class="ti ti-device-floppy me-2"></i>Save All Settings
							</button>
						</div>
                    </form>
				</div>
			</div>
		</div>
	</div>

    @if($isQuickBooksConnected)
        <form id="qb-disconnect-form" action="{{ route('quickbooks.disconnect') }}" method="POST" class="d-none">
            @csrf
        </form>
    @endif

	<script>
		function previewImage(input, previewId, placeholderId) {
			const preview = document.getElementById(previewId);
			const placeholder = document.getElementById(placeholderId);
			
			if (input.files && input.files[0]) {
				const reader = new FileReader();
				reader.onload = function(e) {
					preview.src = e.target.result;
					preview.classList.remove('d-none');
					if (placeholder) placeholder.classList.add('d-none');
				}
				reader.readAsDataURL(input.files[0]);
			}
		}

        // Handle Active Tab after redirect (optional enrichment)
        document.addEventListener('DOMContentLoaded', function() {
            var hash = window.location.hash;
            if (hash) {
                var triggerEl = document.querySelector('ul.nav a[href="' + hash + '"]');
                if (triggerEl) {
                    bootstrap.Tab.getOrCreateInstance(triggerEl).show();
                }
            }

            // Update hash on tab change
            var tabEls = document.querySelectorAll('a[data-bs-toggle="tab"]');
            tabEls.forEach(function(el) {
                el.addEventListener('shown.bs.tab', function (event) {
                    history.replaceState(null, null, event.target.hash);
                });
            });
        });
	</script>

	<style>
		.input-group-text {
			color: #adb5bd;
		}
		.form-control:focus + .input-group-text {
			border-color: var(--bs-primary);
		}
		.bg-light-50 {
			background-color: #f8f9fa;
		}
		.border-dashed {
			border-style: dashed !important;
		}
        .nav-tabs-bottom .nav-link {
            border: none;
            border-bottom: 3px solid transparent;
            color: #6c757d;
            transition: all 0.2s ease;
        }
        .nav-tabs-bottom .nav-link.active {
            border-bottom: 3px solid #f26522; /* Matches project accent color seen in sidebar */
            color: #f26522 !important;
            background: transparent;
        }
        .nav-tabs-bottom .nav-link:hover:not(.active) {
            color: #3e3e3e;
            background: rgba(0,0,0,0.02);
            border-bottom-color: rgba(242, 101, 34, 0.2);
        }
	</style>

@endsection

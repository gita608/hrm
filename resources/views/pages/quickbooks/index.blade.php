@extends('layouts.app')

@section('title', 'QuickBooks Integration')

@section('content')

	<!-- Page Header -->
	<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
		<div class="my-auto">
			<h2 class="mb-1 text-dark fw-bold">QuickBooks Integration</h2>
			<p class="text-muted mb-0 fs-13">Manage your connection and synchronization with QuickBooks Online</p>
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
				<div class="card-header bg-white py-3 border-bottom border-light d-flex align-items-center">
					<div class="bg-success-transparent rounded-3 p-2 me-3">
						<i class="ti ti-link fs-20 text-success"></i>
					</div>
					<h5 class="mb-0 fw-bold text-dark">Connection Status</h5>
                    @if($isQuickBooksConnected)
                        <span class="badge bg-success-transparent text-success ms-auto rounded-pill px-3 py-1">
                            <i class="ti ti-circle-check-filled me-1"></i>Connected
                        </span>
                    @else
                        <span class="badge bg-light text-muted ms-auto rounded-pill px-3 py-1">
                            <i class="ti ti-circle-x-filled me-1"></i>Not Connected
                        </span>
                    @endif
				</div>
				<div class="card-body p-4 p-md-5">
                    <div class="text-center mb-5">
                        <div class="mb-4">
                            <i class="ti ti-brand-linktree fs-60 {{ $isQuickBooksConnected ? 'text-success' : 'text-muted' }} opacity-25"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">
                            {{ $isQuickBooksConnected ? 'Linked with QuickBooks Online' : 'QuickBooks Not Connected' }}
                        </h4>
                        <p class="text-muted mx-auto" style="max-width: 500px;">
                            @if($isQuickBooksConnected)
                                Your application is currently authorized to synchronize accounting data with QuickBooks Online.
                            @else
                                Connect your QuickBooks Online account to synchronize invoices, expenses, and payroll data automatically.
                            @endif
                        </p>
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <div class="p-4 bg-light rounded-4 border border-dashed border-light-subtle h-100">
                                <form id="settings-form" action="{{ route('settings.store') }}" method="POST">
                                    @csrf
                                    <h6 class="fw-bold text-dark mb-4">API Credentials</h6>
                                    <div class="form-group mb-3">
                                        <label class="form-label text-dark fw-bold fs-12 mb-2">Client ID</label>
                                        <input type="text" class="form-control" name="quickbooks_client_id" value="{{ old('quickbooks_client_id', $quickbooksClientId) }}" placeholder="Enter Client ID">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label class="form-label text-dark fw-bold fs-12 mb-2">Client Secret</label>
                                        <input type="password" class="form-control" name="quickbooks_client_secret" value="{{ old('quickbooks_client_secret', $quickbooksClientSecret) }}" placeholder="Enter Client Secret">
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 rounded-pill shadow-sm">
                                        <i class="ti ti-device-floppy me-2"></i>Save Credentials
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 bg-light rounded-4 border border-dashed border-light-subtle h-100 d-flex flex-column justify-content-center align-items-center text-center">
                                @if($isQuickBooksConnected)
                                    <div class="bg-success-transparent rounded-pill p-3 mb-3">
                                        <i class="ti ti-check fs-30 text-success"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-2">Connection Active</h6>
                                    <p class="text-muted fs-12 mb-4">Authorization tokens are managed automatically.</p>
                                    <form action="{{ route('quickbooks.disconnect') }}" method="POST" class="w-100">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger w-100 rounded-pill">
                                            <i class="ti ti-link-off me-2"></i>Disconnect Account
                                        </button>
                                    </form>
                                @else
                                    <div class="bg-light border rounded-pill p-3 mb-3">
                                        <i class="ti ti-unlink fs-30 text-muted"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-2">Authorize Application</h6>
                                    <p class="text-muted fs-12 mb-4">Redirect to Intuit for secure authorization.</p>
                                    <a href="{{ route('quickbooks.connect') }}" class="btn btn-success w-100 rounded-pill shadow-sm @if(empty($quickbooksClientId) || empty($quickbooksClientSecret)) disabled @endif">
                                        <i class="ti ti-power me-2"></i>Connect Now
                                    </a>
                                    @if(empty($quickbooksClientId) || empty($quickbooksClientSecret))
                                        <p class="text-danger fs-10 mt-2">Please save credentials first.</p>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="bg-primary-transparent rounded-4 p-4 border border-primary border-opacity-10">
                        <div class="d-flex align-items-start">
                            <div class="bg-primary rounded-3 p-2 me-3">
                                <i class="ti ti-info-circle text-white"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">Configuration Helper</h6>
                                <p class="text-muted fs-12 mb-0">
                                    Ensure your <strong>Redirect URI</strong> is set to <code>{{ config('quickbooks.redirect_uri') }}</code> in your Intuit Developer Portal settings under the <strong>Keys & Credentials</strong> tab.
                                </p>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>

@endsection

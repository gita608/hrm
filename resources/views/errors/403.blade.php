@extends('layouts.app')

@section('title', 'Access Denied')

@section('content')
<div class="container-fluid">
    <div class="row min-vh-100 align-items-center justify-content-center">
        <div class="col-md-8 col-lg-6 text-center">
            <div class="error-card p-5 border-0 shadow-lg rounded-4 bg-white">
                <div class="mb-4">
                    <span class="avatar avatar-xxl bg-danger-transparent text-danger rounded-circle shadow-sm">
                        <i class="ti ti-shield-x fs-60"></i>
                    </span>
                </div>
                
                <h1 class="display-4 fw-bold text-dark mb-3">403</h1>
                <h2 class="h3 fw-semibold text-dark mb-4">Access Restricted</h2>
                
                <p class="text-muted fs-16 mb-5 mx-auto" style="max-width: 450px;">
                    Sorry, you don't have the necessary permissions to access this page. 
                    Please contact your system administrator if you believe this is an error.
                </p>
                
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <a href="{{ url()->previous() }}" class="btn btn-light rounded-pill px-4 py-2 border shadow-sm">
                        <i class="ti ti-arrow-left me-2"></i>Go Back
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
                        <i class="ti ti-smart-home me-2"></i>Head to Dashboard
                    </a>
                </div>
            </div>
            
            <p class="text-muted mt-5 fs-13">
                &copy; {{ date('Y') }} {{ \App\Helpers\SettingsHelper::appName() }}. All rights reserved.
            </p>
        </div>
    </div>
</div>

<style>
    .error-card {
        transition: transform 0.3s ease;
    }
    .error-card:hover {
        transform: translateY(-5px);
    }
    .bg-danger-transparent {
        background-color: rgba(255, 62, 29, 0.1);
        width: 120px;
        height: 120px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .fs-60 {
        font-size: 60px !important;
    }
</style>
@endsection

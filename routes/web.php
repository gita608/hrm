<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AssetCategoryController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\HrLetterController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\InterviewFeedbackController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\OnboardingChecklistController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\OnboardingTemplateController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\Payroll\PayslipController;
use App\Http\Controllers\Payroll\PayrollItemController;
use App\Http\Controllers\Payroll\ProvidentFundController;
use App\Http\Controllers\Payroll\SalaryController;
use App\Http\Controllers\Payroll\TaxController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\ResignationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ShiftTypeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TerminationController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TrainingTypeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Employee Routes
    Route::prefix('employees')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/grid', [EmployeeController::class, 'grid'])->name('employees.grid');
        Route::get('/create', [EmployeeController::class, 'create'])->name('employees.create');
        Route::post('/', [EmployeeController::class, 'store'])->name('employees.store');
        Route::get('/details', [EmployeeController::class, 'show'])->name('employees.details');
        Route::get('/{id}', [EmployeeController::class, 'show'])->name('employees.show');
        Route::get('/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::put('/{id}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    });

    // Department Routes
    Route::resource('departments', DepartmentController::class);

    // Designation Routes
    Route::resource('designations', DesignationController::class);

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Settings Routes
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'store'])->name('settings.store');

    // Account Routes
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::put('/account/deactivate', [AccountController::class, 'deactivate'])->name('account.deactivate');
    Route::delete('/account/delete', [AccountController::class, 'delete'])->name('account.delete');

    // User Management Routes
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);

    // Asset Routes
    Route::prefix('assets')->group(function () {
        // Categories routes must come first to avoid conflicts with assets/{id} route
        Route::get('/categories', [AssetCategoryController::class, 'index'])->name('assets.categories.index');
        Route::get('/categories/create', [AssetCategoryController::class, 'create'])->name('assets.categories.create');
        Route::post('/categories', [AssetCategoryController::class, 'store'])->name('assets.categories.store');
        Route::get('/categories/{category}', [AssetCategoryController::class, 'show'])->name('assets.categories.show');
        Route::get('/categories/{category}/edit', [AssetCategoryController::class, 'edit'])->name('assets.categories.edit');
        Route::put('/categories/{category}', [AssetCategoryController::class, 'update'])->name('assets.categories.update');
        Route::delete('/categories/{category}', [AssetCategoryController::class, 'destroy'])->name('assets.categories.destroy');

        // Assets resource routes
        Route::get('/', [AssetController::class, 'index'])->name('assets.index');
        Route::get('/create', [AssetController::class, 'create'])->name('assets.create');
        Route::post('/', [AssetController::class, 'store'])->name('assets.store');
        Route::get('/{asset}', [AssetController::class, 'show'])->name('assets.show');
        Route::get('/{asset}/edit', [AssetController::class, 'edit'])->name('assets.edit');
        Route::put('/{asset}', [AssetController::class, 'update'])->name('assets.update');
        Route::delete('/{asset}', [AssetController::class, 'destroy'])->name('assets.destroy');
    });

    // Holiday Routes
    Route::resource('holidays', HolidayController::class);

    // Training Routes - Types routes must come first to avoid conflicts
    Route::prefix('training')->name('training.')->group(function () {
        Route::get('/types', [TrainingTypeController::class, 'index'])->name('types.index');
        Route::get('/types/create', [TrainingTypeController::class, 'create'])->name('types.create');
        Route::post('/types', [TrainingTypeController::class, 'store'])->name('types.store');
        Route::get('/types/{trainingType}', [TrainingTypeController::class, 'show'])->name('types.show');
        Route::get('/types/{trainingType}/edit', [TrainingTypeController::class, 'edit'])->name('types.edit');
        Route::put('/types/{trainingType}', [TrainingTypeController::class, 'update'])->name('types.update');
        Route::delete('/types/{trainingType}', [TrainingTypeController::class, 'destroy'])->name('types.destroy');
    });

    // Training resource routes (must come after types routes)
    Route::resource('training', TrainingController::class);
    Route::resource('trainers', TrainerController::class);

    // Interview Routes - Feedback routes must come first to avoid conflicts
    Route::prefix('interviews')->name('interviews.')->group(function () {
        Route::get('/feedback', [InterviewFeedbackController::class, 'index'])->name('feedback.index');
        Route::get('/feedback/create', [InterviewFeedbackController::class, 'create'])->name('feedback.create');
        Route::post('/feedback', [InterviewFeedbackController::class, 'store'])->name('feedback.store');
        Route::get('/feedback/{id}', [InterviewFeedbackController::class, 'show'])->name('feedback.show');
        Route::get('/feedback/{id}/edit', [InterviewFeedbackController::class, 'edit'])->name('feedback.edit');
        Route::put('/feedback/{id}', [InterviewFeedbackController::class, 'update'])->name('feedback.update');
        Route::delete('/feedback/{id}', [InterviewFeedbackController::class, 'destroy'])->name('feedback.destroy');
    });

    // Interview resource routes (must come after feedback routes)
    Route::resource('interviews', InterviewController::class);

    // Job Posting Routes
    Route::resource('jobs', JobPostingController::class);

    // Candidate Routes
    Route::resource('candidates', CandidateController::class);

    // Promotion Routes
    Route::resource('promotions', PromotionController::class);

    // Resignation Routes
    Route::resource('resignations', ResignationController::class);

    // Termination Routes
    Route::resource('terminations', TerminationController::class);

    // Onboarding Routes
    Route::prefix('onboarding')->name('onboarding.')->group(function () {
        Route::get('/', [OnboardingController::class, 'index'])->name('index');
        Route::get('/create', [OnboardingController::class, 'create'])->name('create');
        Route::post('/', [OnboardingController::class, 'store'])->name('store');
        Route::get('/{id}', [OnboardingController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [OnboardingController::class, 'edit'])->name('edit');
        Route::put('/{id}', [OnboardingController::class, 'update'])->name('update');
        Route::delete('/{id}', [OnboardingController::class, 'destroy'])->name('destroy');

        // Templates routes
        Route::get('/templates', [OnboardingTemplateController::class, 'index'])->name('templates.index');
        Route::get('/templates/create', [OnboardingTemplateController::class, 'create'])->name('templates.create');
        Route::post('/templates', [OnboardingTemplateController::class, 'store'])->name('templates.store');
        Route::get('/templates/{id}', [OnboardingTemplateController::class, 'show'])->name('templates.show');
        Route::get('/templates/{id}/edit', [OnboardingTemplateController::class, 'edit'])->name('templates.edit');
        Route::put('/templates/{id}', [OnboardingTemplateController::class, 'update'])->name('templates.update');
        Route::delete('/templates/{id}', [OnboardingTemplateController::class, 'destroy'])->name('templates.destroy');

        // Checklist routes
        Route::prefix('checklist')->name('checklist.')->group(function () {
            Route::get('/', [OnboardingChecklistController::class, 'index'])->name('index');
            Route::post('/{onboarding_id}', [OnboardingChecklistController::class, 'store'])->name('store');
            Route::put('/{id}', [OnboardingChecklistController::class, 'update'])->name('update');
            Route::put('/{id}/complete', [OnboardingChecklistController::class, 'complete'])->name('complete');
            Route::delete('/{id}', [OnboardingChecklistController::class, 'destroy'])->name('destroy');
        });
    });

    // Referral Routes
    Route::resource('referrals', ReferralController::class);

    // Attendance Routes
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/admin', [AttendanceController::class, 'adminIndex'])->name('admin');
        Route::get('/employee', [AttendanceController::class, 'employeeIndex'])->name('employee');
        Route::post('/', [AttendanceController::class, 'store'])->name('store');
        Route::put('/{id}', [AttendanceController::class, 'update'])->name('update');
        Route::post('/checkin', [AttendanceController::class, 'checkIn'])->name('checkin');
        Route::post('/checkout', [AttendanceController::class, 'checkOut'])->name('checkout');
    });

    // Leave Routes
    Route::prefix('leaves')->name('leaves.')->group(function () {
        Route::get('/', [LeaveController::class, 'index'])->name('index');
        Route::get('/employee', [LeaveController::class, 'employeeIndex'])->name('employee');
        Route::get('/create', [LeaveController::class, 'create'])->name('create');
        Route::post('/', [LeaveController::class, 'store'])->name('store');
        Route::post('/{id}/approve', [LeaveController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [LeaveController::class, 'reject'])->name('reject');
        Route::put('/{id}/cancel', [LeaveController::class, 'cancel'])->name('cancel');
        Route::get('/settings', [LeaveController::class, 'settings'])->name('settings');
    });

    // Leave Type Routes
    Route::resource('leave-types', LeaveTypeController::class)->except(['index', 'show']);

    // Overtime Routes
    Route::resource('overtime', OvertimeController::class);
    Route::post('/overtime/{id}/approve', [OvertimeController::class, 'approve'])->name('overtime.approve');
    Route::post('/overtime/{id}/reject', [OvertimeController::class, 'reject'])->name('overtime.reject');

    // Schedule Routes
    Route::resource('schedule', ScheduleController::class);
    
    // Shift Type Routes
    Route::resource('shift-types', ShiftTypeController::class);

    // Payroll Routes
    Route::prefix('payroll')->name('payroll.')->group(function () {
        Route::resource('salary', SalaryController::class);
        Route::resource('payslip', PayslipController::class);
        Route::post('/payslip/{id}/approve', [PayslipController::class, 'approve'])->name('payslip.approve');
        Route::resource('items', PayrollItemController::class);
        Route::resource('provident-fund', ProvidentFundController::class);
        Route::resource('tax', TaxController::class);
    });

    // Document Routes
    Route::resource('documents', DocumentController::class);

    // HR Letter Routes
    Route::resource('hr-letters', HrLetterController::class);

    // Certificate Routes
    Route::resource('certificates', CertificateController::class);
});
